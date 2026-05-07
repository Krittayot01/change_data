<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // ถ้าล็อกอินแล้ว และมีสิทธิ์เป็น admin ให้ผ่านได้
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }
        // ถ้าไม่ใช่ admin ให้เด้งกลับไปหน้าแรก
        return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
    }
}