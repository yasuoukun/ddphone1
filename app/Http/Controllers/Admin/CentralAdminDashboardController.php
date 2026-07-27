<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;

class CentralAdminDashboardController extends Controller
{
    public function index()
    {
        $productCount = Product::count();
        $categoryCount = Category::count();
        $brandCount = Brand::count();
        $orderCount = Order::count();
        
        $pendingOrders = Order::where('status', 'pending_verification')->count();
        $unreadChats = \App\Models\Message::whereNull('receiver_id')->where('is_read', false)->count();

        // Financial stats
        $totalRevenue = Order::whereIn('status', ['confirmed', 'shipped', 'delivered'])->sum('total_amount');
        
        // Today vs Yesterday Revenue
        $todayRevenue = Order::whereIn('status', ['confirmed', 'shipped', 'delivered'])
            ->whereDate('created_at', now()->today())
            ->sum('total_amount');
        $yesterdayRevenue = Order::whereIn('status', ['confirmed', 'shipped', 'delivered'])
            ->whereDate('created_at', now()->yesterday())
            ->sum('total_amount');
        $dailyGrowth = $yesterdayRevenue > 0 
            ? round((($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100, 1) 
            : ($todayRevenue > 0 ? 100 : 0);

        // This Month vs Last Month Revenue
        $monthlyRevenue = Order::whereIn('status', ['confirmed', 'shipped', 'delivered'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');
        $lastMonthRevenue = Order::whereIn('status', ['confirmed', 'shipped', 'delivered'])
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total_amount');
        $monthlyGrowth = $lastMonthRevenue > 0 
            ? round((($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1) 
            : ($monthlyRevenue > 0 ? 100 : 0);

        // This Week vs Last Week Revenue
        $thisWeekRevenue = Order::whereIn('status', ['confirmed', 'shipped', 'delivered'])
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('total_amount');
        $lastWeekRevenue = Order::whereIn('status', ['confirmed', 'shipped', 'delivered'])
            ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->sum('total_amount');
        $weeklyGrowth = $lastWeekRevenue > 0 
            ? round((($thisWeekRevenue - $lastWeekRevenue) / $lastWeekRevenue) * 100, 1) 
            : ($thisWeekRevenue > 0 ? 100 : 0);

        // Sales last 7 days for line chart
        $salesLast7Days = [];
        $labelsLast7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $sum = Order::whereIn('status', ['confirmed', 'shipped', 'delivered'])
                ->whereDate('created_at', $date)
                ->sum('total_amount');
            $salesLast7Days[] = (float)$sum;
            $labelsLast7Days[] = now()->subDays($i)->locale('th')->translatedFormat('j M');
        }

        // Order statuses for pie chart
        $orderStatuses = [
            'รอดำเนินการ' => Order::where('status', 'pending')->count(),
            'รอตรวจสอบสลิป' => Order::where('status', 'pending_verification')->count(),
            'ชำระเงินแล้ว' => Order::where('status', 'confirmed')->count(),
            'จัดส่งแล้ว' => Order::where('status', 'shipped')->count(),
            'สำเร็จแล้ว' => Order::where('status', 'delivered')->count(),
            'ยกเลิกแล้ว' => Order::where('status', 'cancelled')->count(),
        ];

        // 1. Top Selling Products
        $topSellingProducts = \App\Models\OrderItem::select('product_id', \Illuminate\Support\Facades\DB::raw('SUM(quantity) as total_quantity'), \Illuminate\Support\Facades\DB::raw('SUM(price * quantity) as total_sales'))
            ->whereHas('order', function($q) {
                $q->whereIn('status', ['confirmed', 'shipped', 'delivered']);
            })
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->with('product.images')
            ->take(5)
            ->get();

        // 2. Most Wishlisted Products
        $mostWishlistedProducts = \App\Models\Wishlist::select('product_id', \Illuminate\Support\Facades\DB::raw('COUNT(*) as wishlist_count'))
            ->groupBy('product_id')
            ->orderBy('wishlist_count', 'desc')
            ->with('product.images')
            ->take(5)
            ->get();

        // 3. Highest Rated Products
        $topRatedProducts = Product::withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->with('images')
            ->having('reviews_count', '>', 0)
            ->orderBy('reviews_avg_rating', 'desc')
            ->take(5)
            ->get();

        if ($topRatedProducts->isEmpty()) {
            $topRatedProducts = Product::with('images')->where('is_popular', true)->take(5)->get();
        }

        // 4. Low Stock Alert Products
        $lowStockProducts = Product::with('images')
            ->where('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        $totalWishlistsCount = \App\Models\Wishlist::count();
        $totalReviewsCount = \App\Models\Review::count();
        $avgRating = round(\App\Models\Review::avg('rating') ?: 5.0, 1);

        return view('central_admin.dashboard', compact(
            'productCount', 'categoryCount', 'brandCount', 'orderCount', 'pendingOrders', 'unreadChats',
            'totalRevenue', 'monthlyRevenue', 'todayRevenue', 'thisWeekRevenue', 'dailyGrowth', 'weeklyGrowth', 'monthlyGrowth',
            'salesLast7Days', 'labelsLast7Days', 'orderStatuses',
            'topSellingProducts', 'mostWishlistedProducts', 'topRatedProducts', 'lowStockProducts',
            'totalWishlistsCount', 'totalReviewsCount', 'avgRating'
        ));
    }

    public function getSalesChartData(Request $request)
    {
        $period = $request->query('period', 'day'); // day, week, month, year
        $labels = [];
        $data = [];

        if ($period === 'day') {
            // Last 7 days
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $sum = Order::whereIn('status', ['confirmed', 'shipped', 'delivered'])
                    ->whereDate('created_at', $date)
                    ->sum('total_amount');
                $data[] = (float)$sum;
                $labels[] = now()->subDays($i)->locale('th')->translatedFormat('j M');
            }
        } elseif ($period === 'week') {
            // Last 8 weeks
            for ($i = 7; $i >= 0; $i--) {
                $startOfWeek = now()->subWeeks($i)->startOfWeek();
                $endOfWeek = now()->subWeeks($i)->endOfWeek();
                $sum = Order::whereIn('status', ['confirmed', 'shipped', 'delivered'])
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->sum('total_amount');
                $data[] = (float)$sum;
                $labels[] = $startOfWeek->locale('th')->translatedFormat('j M') . ' - ' . $endOfWeek->locale('th')->translatedFormat('j M');
            }
        } elseif ($period === 'month') {
            // Last 12 months
            for ($i = 11; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $sum = Order::whereIn('status', ['confirmed', 'shipped', 'delivered'])
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->sum('total_amount');
                $data[] = (float)$sum;
                $labels[] = $date->locale('th')->translatedFormat('M Y');
            }
        } elseif ($period === 'year') {
            // Last 5 years
            for ($i = 4; $i >= 0; $i--) {
                $year = now()->subYears($i)->year;
                $sum = Order::whereIn('status', ['confirmed', 'shipped', 'delivered'])
                    ->whereYear('created_at', $year)
                    ->sum('total_amount');
                $data[] = (float)$sum;
                $labels[] = (string)($year + 543); // พ.ศ.
            }
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }
}
