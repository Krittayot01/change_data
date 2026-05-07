<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeRequest extends Model
{
    use HasFactory;

    // ระบุชื่อตารางให้ตรงกับในฐานข้อมูล
    protected $table = 'change_requests';

    // กำหนดฟิลด์ที่อนุญาตให้บันทึกข้อมูลได้ (Mass Assignment)
    protected $fillable = [
        'written_at',
        'req_date',
        'full_name',
        'member_id',
        'department',
        'phone',
        'options_data',
    ];

    // แปลงข้อมูลระหว่าง Array กับ JSON อัตโนมัติ
    protected $casts = [
        'options_data' => 'array',
        'req_date' => 'date',
    ];
}