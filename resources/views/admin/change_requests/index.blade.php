<x-app-layout>
    <!-- นำไลบรารี Chart.js เข้ามาใช้งาน -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        /* กำหนดโทนสีพื้นหลังหลักให้เหมือนในรูปภาพ */
        body { background-color: #f4f7fe; }
        .bg-brand-purple { background-color: #5b32ea; }
        .text-brand-dark { color: #2b3674; }
        .text-brand-gray { color: #a3aed1; }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-brand-dark">Overview</h2>
                <div class="flex items-center space-x-2 text-sm text-brand-gray bg-white px-4 py-2 rounded-full shadow-sm">
                    <span>ข้อมูล ณ วันที่ {{ date('d M Y') }}</span>
                </div>
            </div>

            <!-- 1. ส่วนสรุปข้อมูล (Top Cards) 4 ใบ -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- การ์ด 1: ทั้งหมด -->
                <div class="bg-white rounded-3xl p-5 flex items-center shadow-sm">
                    <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 mr-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-brand-dark">{{ $stats['total'] ?? 0 }}</p>
                        <p class="text-sm font-medium text-brand-gray">คำร้องทั้งหมด</p>
                    </div>
                </div>

                <!-- การ์ด 2: ดำเนินการแล้ว -->
                <div class="bg-white rounded-3xl p-5 flex items-center shadow-sm">
                    <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center text-green-500 mr-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-brand-dark">{{ $stats['completed'] ?? 0 }}</p>
                        <p class="text-sm font-medium text-brand-gray">ดำเนินการแล้ว</p>
                    </div>
                </div>

                <!-- การ์ด 3: รอดำเนินการ -->
                <div class="bg-white rounded-3xl p-5 flex items-center shadow-sm">
                    <div class="w-14 h-14 rounded-full bg-orange-100 flex items-center justify-center text-orange-500 mr-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-brand-dark">{{ $stats['pending'] ?? 0 }}</p>
                        <p class="text-sm font-medium text-brand-gray">เหลือดำเนินการ</p>
                    </div>
                </div>

                <!-- การ์ด 4: อัตราความสำเร็จ (คำนวณจากที่มี) -->
                @php
                    $successRate = ($stats['total'] ?? 0) > 0 ? round((($stats['completed'] ?? 0) / $stats['total']) * 100) : 0;
                @endphp
                <div class="bg-white rounded-3xl p-5 flex items-center shadow-sm">
                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 mr-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-brand-dark">{{ $successRate }}%</p>
                        <p class="text-sm font-medium text-brand-gray">อัตราความสำเร็จ</p>
                    </div>
                </div>
            </div>

            <!-- 2. ส่วนกราฟ (Charts Row) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Bar Chart -->
                <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-brand-dark">สถิติคำร้องรายเดือน (Trend)</h3>
                        <select class="border-none text-brand-gray text-sm focus:ring-0 cursor-pointer bg-transparent">
                            <option>Show by months</option>
                            <option>Show by weeks</option>
                        </select>
                    </div>
                    <div class="relative h-64">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>

                <!-- Donut Chart -->
                <div class="bg-white rounded-3xl p-6 shadow-sm flex flex-col">
                    <h3 class="text-lg font-bold text-brand-dark mb-2">สัดส่วนสถานะ</h3>
                    <div class="relative flex-grow flex items-center justify-center">
                        <canvas id="genderChart"></canvas>
                        <!-- ข้อความตรงกลางโดนัท -->
                        <div class="absolute flex flex-col items-center justify-center">
                            <span class="text-2xl font-bold text-brand-dark">{{ $successRate }}%</span>
                            <span class="text-xs text-brand-gray">สำเร็จ</span>
                        </div>
                    </div>
                    <div class="flex justify-center space-x-6 mt-4">
                        <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#00e396] mr-2"></span><span class="text-sm text-brand-gray">เรียบร้อย</span></div>
                        <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#feb019] mr-2"></span><span class="text-sm text-brand-gray">รอ/กำลังทำ</span></div>
                    </div>
                </div>
            </div>

            <!-- 3. ส่วนตาราง & การ์ดสีม่วง (Bottom Row) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Table -->
                <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-sm overflow-hidden flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-brand-dark">รายการคำร้องล่าสุด</h3>
                        <a href="#" class="text-sm text-brand-gray hover:text-[#5b32ea]">ดูทั้งหมด &rarr;</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-brand-gray text-xs uppercase tracking-wider border-b border-gray-100">
                                    <th class="pb-3 font-semibold w-16">รหัส</th>
                                    <th class="pb-3 font-semibold">ชื่อ-สกุล</th>
                                    <th class="pb-3 font-semibold">แผนก/สังกัด</th>
                                    <th class="pb-3 font-semibold text-center">สถานะ</th>
                                    <th class="pb-3 font-semibold text-right">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse($requests->take(6) as $request)
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                                    <td class="py-4 text-brand-dark font-medium">#{{ str_pad($request->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td class="py-4 text-brand-dark font-bold">{{ $request->full_name }}</td>
                                    <td class="py-4 text-brand-gray">{{ $request->department }}</td>
                                    <td class="py-4 text-center">
                                        @if(isset($request->status) && $request->status == 'completed') 
                                            <span class="text-[#00e396] bg-[#00e396]/10 px-3 py-1 rounded-full text-xs font-bold">สำเร็จ</span>
                                        @elseif(isset($request->status) && $request->status == 'processing')
                                            <span class="text-[#5b32ea] bg-[#5b32ea]/10 px-3 py-1 rounded-full text-xs font-bold">กำลังทำ</span>
                                        @else 
                                            <span class="text-[#feb019] bg-[#feb019]/10 px-3 py-1 rounded-full text-xs font-bold">รอดำเนินการ</span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-right">
                                        <a href="{{ route('admin.change-requests.show', ['id' => $request->id]) }}" class="text-brand-gray hover:text-[#5b32ea] p-2">
                                            <!-- ไอคอน 3 จุด (More) -->
                                            <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 20 20"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-brand-gray">ยังไม่มีข้อมูลคำร้อง</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Purple Card -->
                <div class="bg-brand-purple rounded-3xl p-8 shadow-md text-white flex flex-col justify-between relative overflow-hidden h-full min-h-[250px]">
                    <div class="relative z-10">
                        <!-- ตัวเลขดึงจากทั้งหมด หรือคุณสามารถไปเขียนโค้ดใน Controller ให้นับเฉพาะเดือนนี้ก็ได้ครับ -->
                        <h2 class="text-5xl font-bold mb-2">{{ $stats['total'] ?? 0 }}</h2>
                        <p class="text-purple-200 font-medium text-lg">คำร้องในระบบทั้งหมด</p>
                    </div>
                    
                    <div class="relative z-10 flex justify-between items-end mt-8">
                        <div class="text-sm">
                            <p class="text-purple-300 mb-1">รอดำเนินการ</p>
                            <p class="font-bold text-xl">{{ $stats['pending'] ?? 0 }}</p>
                        </div>
                        <div class="text-sm">
                            <p class="text-purple-300 mb-1">สำเร็จแล้ว</p>
                            <p class="font-bold text-xl">{{ $stats['completed'] ?? 0 }}</p>
                        </div>
                    </div>

                    <!-- กราฟเส้นตกแต่งพื้นหลัง (SVG Wave) -->
                    <svg class="absolute bottom-0 left-0 w-full opacity-30 z-0" viewBox="0 0 1440 320" preserveAspectRatio="none">
                        <path fill="#ffffff" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,213.3C672,224,768,224,864,202.7C960,181,1056,139,1152,144C1248,149,1344,203,1392,229.3L1440,256L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                    </svg>
                </div>

            </div>
            
            <!-- Pagination แยกออกมาด้านล่างเผื่อดูย้อนหลัง -->
            @if($requests->hasPages())
            <div class="mt-6">
                {{ $requests->links('pagination::tailwind') }}
            </div>
            @endif

        </div>
    </div>

    <!-- Script สำหรับวาดกราฟ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- 1. กราฟแท่ง (Trend Chart) ---
            const trendCtx = document.getElementById('trendChart').getContext('2d');
            new Chart(trendCtx, {
                type: 'bar',
                data: {
                    labels: ['ต.ค.', 'พ.ย.', 'ธ.ค.', 'ม.ค.', 'ก.พ.', 'มี.ค.'],
                    datasets: [
                        {
                            label: 'คำร้องใหม่',
                            data: [15, 25, 40, 22, 28, 35], // *ตรงนี้สามารถใส่ตัวแปรจาก PHP ได้ในอนาคต*
                            backgroundColor: '#5b32ea', // สีม่วง
                            borderRadius: 4,
                            barPercentage: 0.5,
                            categoryPercentage: 0.5
                        },
                        {
                            label: 'ดำเนินการแล้ว',
                            data: [10, 18, 12, 15, 20, 18],
                            backgroundColor: '#00e396', // สีเขียว
                            borderRadius: 4,
                            barPercentage: 0.5,
                            categoryPercentage: 0.5
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false } // ซ่อน Legend ให้คลีนเหมือนต้นฉบับ
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [5, 5], color: '#e2e8f0', drawBorder: false },
                            ticks: { color: '#a3aed1', font: {family: 'Sarabun'} }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { color: '#a3aed1', font: {family: 'Sarabun'} }
                        }
                    }
                }
            });

            // --- 2. กราฟโดนัท (Donut Chart) ---
            const genderCtx = document.getElementById('genderChart').getContext('2d');
            new Chart(genderCtx, {
                type: 'doughnut',
                data: {
                    labels: ['ดำเนินการเรียบร้อย', 'รอดำเนินการ'],
                    datasets: [{
                        // ดึงข้อมูลจริงจาก $stats มาแสดง
                        data: [{{ $stats['completed'] ?? 0 }}, {{ $stats['pending'] ?? 0 }}],
                        backgroundColor: ['#00e396', '#feb019'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '80%', // ทำให้โดนัทมีรูตรงกลางกว้างขึ้น
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });
    </script>
</x-app-layout>