<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * สร้างตารางจัดเก็บข้อมูล
     */
    public function up(): void
    {
        Schema::create('change_requests', function (Blueprint $table) {
            $table->id();
            $table->string('written_at'); // เขียนที่
            $table->date('req_date'); // วันที่
            $table->string('full_name'); // ชื่อ-สกุล
            $table->string('member_id', 50); // เลขทะเบียน
            $table->string('department'); // สังกัด
            $table->string('phone', 20); // โทรศัพท์
            
            // เก็บบันทึกตัวเลือกย่อยทั้งหมดในรูปแบบ JSON ป้องกันการสร้าง Column ยิบย่อยเกินไป
            $table->json('options_data')->nullable(); 
            
            $table->timestamps();
            $table->string('status')->default('pending')->comment('pending, processing, completed');
        });
    }

    /**
     * ลบตาราง
     */
    public function down(): void
    {
        Schema::dropIfExists('change_requests');
    }
};