<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Notifications\PromotionNotification;

class NotificationController extends Controller
{
    public function index()
    {
        // Load sent notifications from DB — group by data content (title+message)
        // Laravel stores notifications in the `notifications` table
        $notifications = DB::table('notifications')
            ->select(
                DB::raw('MIN(id) as id'),
                'type',
                'data',
                DB::raw('COUNT(*) as recipient_count'),
                DB::raw('MIN(created_at) as created_at')
            )
            ->where('type', 'App\\Notifications\\PromotionNotification')
            ->groupBy('type', 'data')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
            'url'     => 'nullable',
        ]);

        $users = User::all();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('notifications', 'public');
        }

        foreach ($users as $user) {
            $user->notify(new PromotionNotification(
                $request->title,
                $request->message,
                $request->url,
                $imagePath
            ));
        }

        return redirect()->back()->with('success', 'ส่งแจ้งเตือนโปรโมชันถึงลูกค้าทุกคนเรียบร้อยแล้ว');
    }

    /**
     * Delete all notification records that share the same data payload (title+message)
     */
    public function destroy(Request $request)
    {
        $title = $request->input('title');
        $message = $request->input('message');
        $dataStr = $request->input('data');

        // Attempt base64 decode if data parameter is provided
        if ($dataStr) {
            $decodedBase64 = base64_decode($dataStr, true);
            if ($decodedBase64 !== false && str_starts_with(trim($decodedBase64), '{')) {
                $dataStr = $decodedBase64;
            }
            $dataStr = htmlspecialchars_decode(htmlspecialchars_decode($dataStr, ENT_QUOTES), ENT_QUOTES);
        }

        // If title and message are passed directly
        if ($title || $message) {
            $query = DB::table('notifications')
                ->where('type', 'App\\Notifications\\PromotionNotification');

            if ($title) {
                $query->where('data->title', $title);
            }
            if ($message) {
                $query->where('data->message', $message);
            }

            $deleted = $query->delete();

            if ($deleted > 0) {
                return redirect()->back()->with('success', "ลบแจ้งเตือนออกจากระบบแล้ว ({$deleted} รายการ)");
            }
        }

        // Fallback using raw data string matching or decoded JSON payload
        if (!empty($dataStr)) {
            $deleted = DB::table('notifications')
                ->where('type', 'App\\Notifications\\PromotionNotification')
                ->where('data', $dataStr)
                ->delete();

            if ($deleted === 0) {
                $decoded = json_decode($dataStr, true);
                if ($decoded && is_array($decoded)) {
                    $query = DB::table('notifications')
                        ->where('type', 'App\\Notifications\\PromotionNotification');

                    if (!empty($decoded['title'])) {
                        $query->where('data->title', $decoded['title']);
                    }
                    if (!empty($decoded['message'])) {
                        $query->where('data->message', $decoded['message']);
                    }

                    $deleted = $query->delete();
                }
            }

            if ($deleted > 0) {
                return redirect()->back()->with('success', "ลบแจ้งเตือนออกจากระบบแล้ว ({$deleted} รายการ)");
            }
        }

        return redirect()->back()->with('error', 'ไม่พบข้อมูลแจ้งเตือนที่ต้องการลบ');
    }
}
