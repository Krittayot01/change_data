<?php

namespace App\Http\Controllers;

use App\Models\ChangeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminChangeRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * แสดงหน้า Dashboard และรายการคำร้องทั้งหมด
     */
    public function index()
    {
        // 1. สรุปข้อมูลสถิติ
        $stats = [
            'total'      => ChangeRequest::count(),
            'pending'    => ChangeRequest::whereIn('status', ['pending', 'processing'])->count(),
            'completed'  => ChangeRequest::where('status', 'completed')->count(),
        ];

        // 2. ดึงรายการคำร้องทั้งหมด
        $requests = ChangeRequest::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.change_requests.index', compact('requests', 'stats'));
    }

    /**
     * แสดงหน้าดูรายละเอียดคำร้อง
     */
    public function show(Request $request)
    {
        $id = $request->query('id');
        if (!$id) return redirect()->route('admin.change-requests.index');

        $changeRequest = ChangeRequest::findOrFail($id);
        $options = is_string($changeRequest->options_data)
            ? json_decode($changeRequest->options_data, true)
            : $changeRequest->options_data;

        return view('admin.change_requests.show', compact('changeRequest', 'options'));
    }
}
