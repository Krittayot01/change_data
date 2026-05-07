<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChangeRequest; // นำเข้า Model เมื่อต้องการบันทึกฐานข้อมูลจริง

class ChangeRequestController extends Controller
{
    /**
     * แสดงหน้าแบบฟอร์ม
     */
    public function index()
    {
        return view('change_request');
    }

    /**
     * รับข้อมูลจากฟอร์มและประมวลผล
     */
    public function store(Request $request)
    {
        // 1. ตรวจสอบความถูกต้องของข้อมูล (Validation)
        $validated = $request->validate([
            'written_at' => 'required|string|max:255',
            'req_date'   => 'required|date',
            'full_name'  => 'required|string|max:255',
            'member_id'  => 'required|string|max:50',
            'department' => 'required|string|max:255',
            'phone'      => 'required|string|max:20',
        ]);

        // 2. จัดการข้อมูลตัวเลือก (Options) ที่ผู้ใช้กรอกเข้ามา
        // ในที่นี้เราจะรวบรวมข้อมูลส่วนตัวเลือก (ข้อ 1-12) เป็น JSON เพื่อความยืดหยุ่นในการจัดเก็บ
        $optionsData = $request->except(['_token', 'written_at', 'req_date', 'full_name', 'member_id', 'department', 'phone']);

        // 3. ตัวอย่างการบันทึกลง Database (นำคอมเมนต์ออกเมื่อสร้าง Model แล้ว)
        
        ChangeRequest::create([
            'written_at'   => $validated['written_at'],
            'req_date'     => $validated['req_date'],
            'full_name'    => $validated['full_name'],
            'member_id'    => $validated['member_id'],
            'department'   => $validated['department'],
            'phone'        => $validated['phone'],
            'options_data' => json_encode($optionsData)
        ]);
        

        // 4. ส่งกลับไปหน้าเดิมพร้อมข้อความสำเร็จ (Session Flash)
        return back()->with('success', 'ระบบได้รับข้อมูลการขอเปลี่ยนแปลงข้อมูลของ คุณ ' . $validated['full_name'] . ' เรียบร้อยแล้ว');
    }
}