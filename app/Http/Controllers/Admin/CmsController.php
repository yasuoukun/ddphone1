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
        ];

        $banners = PromotionalBanner::orderBy('sort_order')->get();

        return view('admin.cms.index', compact('settings', 'banners'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'slogan_badge' => 'nullable|string|max:100',
            'slogan_title' => 'required|string|max:200',
            'slogan_description' => 'nullable|string|max:1000',
        ]);

        foreach ($validated as $key => $val) {
            HomepageSetting::set($key, $val);
        }

        return redirect()->back()->with('success', 'บันทึกการตั้งค่าคำโฆษณา Slogan เรียบร้อยแล้ว');
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
