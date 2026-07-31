<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomepageSetting;
use App\Models\PromotionalBanner;
use Illuminate\Support\Facades\Storage;

class CmsController extends Controller
{
    public function index()
    {
        $settings = [
            'slogan_badge' => HomepageSetting::get('slogan_badge', '🔥 โปรโมชันพิเศษ ลดสูงสุด 50%'),
            'slogan_title' => HomepageSetting::get('slogan_title', 'dd.it.com จัดเต็มโปรโมชัน!'),
            'slogan_description' => HomepageSetting::get('slogan_description', "สมาร์ทโฟน แก็ดเจ็ต และบริการซ่อมมือถือครบวงจร\nพร้อมประกันศูนย์และบริการหลังการขายระดับพรีเมียม"),
            
            // Showcase Banner 2 settings
            'showcase_badge' => HomepageSetting::get('showcase_badge', '📱 DDPHONE 3D SHOWCASE'),
            'showcase_title' => HomepageSetting::get('showcase_title', "สมาร์ทโฟนมือสองเกรด A+\nสวยกริ๊บ ไร้รอย สภาพ 99%"),
            'showcase_description' => HomepageSetting::get('showcase_description', 'คัดสรรไอโฟนและสมาร์ทโฟนแท้ 100% แบตอึด สแกนนิ้ว/กล้องเพอร์เฟกต์ การันตีประกันร้าน 30 วัน พร้อมบริการจัดส่งฟรีทั่วประเทศ'),
            'showcase_button_text' => HomepageSetting::get('showcase_button_text', 'ช้อปมือถือโปรเด็ด ➔'),
            'showcase_button_url' => HomepageSetting::get('showcase_button_url', '/products'),
            'showcase_image' => HomepageSetting::get('showcase_image', ''),

            // Popular Products CMS Settings
            'popular_products_mode' => HomepageSetting::get('popular_products_mode', 'hybrid'),
            'popular_product_ids'   => json_decode(HomepageSetting::get('popular_product_ids', '[]'), true) ?: [],
        ];

        $banners = PromotionalBanner::orderBy('sort_order')->get();
        $allProducts = \App\Models\Product::select('id', 'name', 'price', 'discount_price')->orderBy('name')->get();

        return view('admin.cms.index', compact('settings', 'banners', 'allProducts'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'slogan_badge' => 'nullable|string|max:100',
            'slogan_title' => 'required|string|max:200',
            'slogan_description' => 'nullable|string|max:1000',
            
            'showcase_badge' => 'nullable|string|max:100',
            'showcase_title' => 'nullable|string|max:200',
            'showcase_description' => 'nullable|string|max:1000',
            'showcase_button_text' => 'nullable|string|max:100',
            'showcase_button_url' => 'nullable|string|max:255',
            'showcase_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:51200',

            'popular_products_mode' => 'required|string|in:auto,custom,hybrid',
            'popular_product_ids'   => 'nullable|array',
            'popular_product_ids.*' => 'integer|exists:products,id',
        ]);

        if ($request->hasFile('showcase_image_file')) {
            $path = $request->file('showcase_image_file')->store('showcase', 'public');
            @mkdir(dirname(public_path('storage/' . $path)), 0777, true);
            @copy(storage_path('app/public/' . $path), public_path('storage/' . $path));
            HomepageSetting::set('showcase_image', $path);
        }

        unset($validated['showcase_image_file']);

        // Store popular products configuration
        HomepageSetting::set('popular_products_mode', $request->input('popular_products_mode', 'hybrid'));
        $selectedIds = array_map('intval', $request->input('popular_product_ids', []));
        HomepageSetting::set('popular_product_ids', json_encode($selectedIds));

        unset($validated['popular_products_mode'], $validated['popular_product_ids']);

        foreach ($validated as $key => $val) {
            if ($val !== null) {
                HomepageSetting::set($key, $val);
            }
        }

        return redirect()->back()->with('success', 'บันทึกการตั้งค่าคำโฆษณา แบนเนอร์ และสินค้ายอดนิยมเรียบร้อยแล้ว');
    }

    public function storeBanner(Request $request)
    {
        $request->validate([
            'cropped_image_data' => 'nullable|string',
            'image_url'          => 'nullable|url|max:1000',
            'link_url'           => 'nullable|url|max:255',
            'sort_order'         => 'required|integer|min:0',
        ], [
            'image_url.url'  => 'ลิงก์รูปภาพออนไลน์ต้องเป็นรูปแบบ URL ที่ถูกต้อง (เช่น https://...)',
            'link_url.url'   => 'ลิงก์เชื่อมโยงต้องเป็นรูปแบบ URL ที่ถูกต้อง (เช่น https://...)',
        ]);

        $croppedData = $request->input('cropped_image_data');
        $imageUrl    = $request->input('image_url');

        if (empty($croppedData) && empty($imageUrl)) {
            return redirect()->back()->withErrors(['banner' => 'กรุณาเลือกรูปภาพ หรือกรอก URL รูปภาพอย่างใดอย่างหนึ่ง'])->withInput();
        }

        $imagePath = '';

        // 1. Handle base64 cropped image data (highest priority)
        if (!empty($croppedData)) {
            // Parse data:image/jpeg;base64,...
            if (preg_match('/^data:image\/(\w+);base64,/', $croppedData, $type)) {
                $extension = strtolower($type[1]);
                // Support jpeg/png/webp
                if (!in_array($extension, ['jpeg', 'jpg', 'png', 'webp', 'gif'])) {
                    $extension = 'jpg';
                }
                $imageData = substr($croppedData, strpos($croppedData, ',') + 1);
                $imageData = base64_decode($imageData);

                if ($imageData === false) {
                    return redirect()->back()->withErrors(['banner' => 'ข้อมูลรูปภาพ Cropped ไม่ถูกต้อง กรุณาลองใหม่'])->withInput();
                }

                $filename = 'banners/' . uniqid('banner_', true) . '.' . $extension;
                Storage::disk('public')->put($filename, $imageData);
                $imagePath = $filename;
            } else {
                return redirect()->back()->withErrors(['banner' => 'รูปแบบข้อมูลรูปภาพไม่ถูกต้อง'])->withInput();
            }
        }
        // 2. Fallback: use image URL directly (no crop)
        elseif (!empty($imageUrl)) {
            $imagePath = $imageUrl;
        }

        PromotionalBanner::create([
            'image_path' => $imagePath,
            'link_url'   => $request->link_url,
            'sort_order' => $request->sort_order,
            'is_active'  => true,
        ]);

        return redirect()->back()->with('success', 'เพิ่มสไลด์แบนเนอร์ใหม่เรียบร้อยแล้ว (ขนาด 1200×400px ครอปแล้ว)');
    }

    public function deleteBanner(PromotionalBanner $banner)
    {
        // Delete image file from storage if it is a local file path
        if (!str_starts_with($banner->image_path, 'http') && Storage::disk('public')->exists($banner->image_path)) {
            Storage::disk('public')->delete($banner->image_path);
        }

        $banner->delete();

        return redirect()->back()->with('success', 'ลบสไลด์แบนเนอร์ออกเรียบร้อยแล้ว');
    }
}
