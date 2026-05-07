<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ฟอร์มขอเปลี่ยนแปลงข้อมูล
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h1>สวัสดี นี่คือเนื้อหาของฉัน</h1>

            </div>
        </div>
    </div>
</x-app-layout>
<body class="py-8 px-4 sm:px-6 lg:px-8">

    <div class="max-w-4xl mx-auto bg-white p-6 md:p-10 rounded-xl shadow-lg">
        
        {{-- ตรวจสอบ Session เมื่อบันทึกสำเร็จ --}}
        @if (session('success'))
        <div class="mb-8 p-4 bg-green-100 border border-green-400 text-green-700 rounded relative" role="alert">
            <strong class="font-bold">สำเร็จ!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <div class="mt-4">
                <a href="{{ route('change-request.form') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm transition inline-block">
                    กลับไปหน้าแบบฟอร์ม
                </a>
            </div>
        </div>
        @else

        {{-- แสดง Error จาก Validation ถ้ามี --}}
        @if ($errors->any())
            <div class="mb-8 p-4 bg-red-100 border border-red-400 text-red-700 rounded relative">
                <strong class="font-bold">พบข้อผิดพลาด!</strong>
                <ul class="list-disc pl-5 mt-2 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="text-center mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">หนังสือขอเปลี่ยนแปลงข้อมูล</h1>
            <p class="text-gray-500">กรุณากรอกข้อมูลให้ครบถ้วนและทำเครื่องหมาย ✓ ในช่องที่ต้องการ</p>
        </div>

        <form action="{{ route('change-request.store') }}" method="POST" id="changeForm">
            @csrf {{-- ป้องกัน CSRF Attack ใน Laravel --}}
            
            <!-- ส่วนที่ 1: ข้อมูลส่วนตัว -->
            <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 mb-8">
                <h2 class="text-lg font-semibold text-blue-800 mb-4 border-b border-blue-200 pb-2">ข้อมูลผู้ยื่นความประสงค์</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">เขียนที่</label>
                        <input type="text" name="written_at" value="{{ old('written_at') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">วันที่</label>
                        <input type="date" name="req_date" value="{{ old('req_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">ข้าพเจ้า (ยศ ชื่อ-สกุล)</label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">สมาชิกเลขทะเบียนที่</label>
                        <input type="text" name="member_id" value="{{ old('member_id') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">สังกัด</label>
                        <input type="text" name="department" value="{{ old('department') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">โทรศัพท์</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2" required>
                    </div>
                </div>
            </div>

            <h2 class="text-xl font-semibold text-gray-800 mb-4">มีความประสงค์ขอเปลี่ยนแปลงข้อมูลดังนี้</h2>

            <!-- ข้อ 1 -->
            <div class="mb-4 border rounded-lg overflow-hidden">
                <div class="bg-gray-100 p-3 flex items-center gap-3 border-b">
                    <input type="checkbox" id="chk_opt1" name="opt1_checked" class="w-5 h-5 text-blue-600 rounded" onchange="toggleSection('sec_opt1', this.checked)">
                    <label for="chk_opt1" class="font-medium text-gray-800 cursor-pointer">1. เกี่ยวกับค่าหุ้นรายเดือน</label>
                </div>
                <div id="sec_opt1" class="p-4 form-section disabled-section">
                    <div class="flex flex-wrap gap-4 mb-3">
                        <label class="inline-flex items-center"><input type="radio" name="opt1_type" value="increase" class="text-blue-600"> <span class="ml-2">เพิ่มส่งค่าหุ้นรายเดือน</span></label>
                        <label class="inline-flex items-center"><input type="radio" name="opt1_type" value="decrease" class="text-blue-600"> <span class="ml-2">ลดส่งค่าหุ้นรายเดือน</span></label>
                        <label class="inline-flex items-center"><input type="radio" name="opt1_type" value="suspend" class="text-blue-600"> <span class="ml-2">งดส่งค่าหุ้นรายเดือน</span></label>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                        <div class="flex items-center gap-2"><span>จาก</span><input type="number" name="opt1_from" class="border p-1 rounded w-full" placeholder="จำนวนเงิน"><span>บาท</span></div>
                        <div class="flex items-center gap-2"><span>เป็น</span><input type="number" name="opt1_to" class="border p-1 rounded w-full" placeholder="จำนวนเงิน"><span>บาท</span></div>
                    </div>
                </div>
            </div>

            <!-- ข้อ 2 -->
            <div class="mb-4 border rounded-lg overflow-hidden">
                <div class="bg-gray-100 p-3 flex items-center gap-3 border-b">
                    <input type="checkbox" id="chk_opt2" name="opt2_checked" class="w-5 h-5 text-blue-600 rounded" onchange="toggleSection('sec_opt2', this.checked)">
                    <label for="chk_opt2" class="font-medium text-gray-800 cursor-pointer">2. เกี่ยวกับเงินฝากรายเดือน</label>
                </div>
                <div id="sec_opt2" class="p-4 form-section disabled-section">
                    <div class="flex flex-wrap gap-4 mb-3">
                        <label class="inline-flex items-center"><input type="radio" name="opt2_type" value="increase" class="text-blue-600"> <span class="ml-2">เพิ่มส่งเงินฝากรายเดือน</span></label>
                        <label class="inline-flex items-center"><input type="radio" name="opt2_type" value="decrease" class="text-blue-600"> <span class="ml-2">ลดส่งเงินฝากรายเดือน</span></label>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3">
                        <div><input type="text" name="opt2_acc_no" class="border p-2 rounded w-full" placeholder="บัญชีเลขที่"></div>
                        <div><input type="text" name="opt2_acc_name" class="border p-2 rounded w-full" placeholder="ชื่อบัญชี"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                        <div class="flex items-center gap-2"><span>จาก</span><input type="number" name="opt2_from" class="border p-1 rounded w-full" placeholder="จำนวนเงิน"><span>บาท</span></div>
                        <div class="flex items-center gap-2"><span>เป็น</span><input type="number" name="opt2_to" class="border p-1 rounded w-full" placeholder="จำนวนเงิน"><span>บาท</span></div>
                    </div>
                </div>
            </div>

            <!-- ข้อ 3 -->
            <div class="mb-4 border rounded-lg overflow-hidden">
                <div class="bg-gray-100 p-3 flex items-center gap-3 border-b">
                    <input type="checkbox" id="chk_opt3" name="opt3_checked" class="w-5 h-5 text-blue-600 rounded" onchange="toggleSection('sec_opt3', this.checked)">
                    <label for="chk_opt3" class="font-medium text-gray-800 cursor-pointer">3. ขอเปลี่ยนผู้มีสิทธิ์สั่งจ่าย</label>
                </div>
                <div id="sec_opt3" class="p-4 form-section disabled-section grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div><input type="text" name="opt3_acc_no" class="border p-2 rounded w-full" placeholder="บัญชีเลขที่"></div>
                    <div><input type="text" name="opt3_acc_name" class="border p-2 rounded w-full" placeholder="ชื่อบัญชี"></div>
                </div>
            </div>

            <!-- ข้อ 4 -->
            <div class="mb-4 border rounded-lg overflow-hidden">
                <div class="bg-gray-100 p-3 flex items-center gap-3 border-b">
                    <input type="checkbox" id="chk_opt4" name="opt4_checked" class="w-5 h-5 text-blue-600 rounded" onchange="toggleSection('sec_opt4', this.checked)">
                    <label for="chk_opt4" class="font-medium text-gray-800 cursor-pointer">4. ขอเปลี่ยนชื่อบัญชีเงินฝาก</label>
                </div>
                <div id="sec_opt4" class="p-4 form-section disabled-section">
                    <div class="mb-3"><input type="text" name="opt4_acc_no" class="border p-2 rounded w-full sm:w-1/2" placeholder="บัญชีเลขที่"></div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex items-center gap-2"><span>จากชื่อบัญชี</span><input type="text" name="opt4_from_name" class="border p-2 rounded w-full"></div>
                        <div class="flex items-center gap-2"><span>เป็นชื่อบัญชี</span><input type="text" name="opt4_to_name" class="border p-2 rounded w-full"></div>
                    </div>
                </div>
            </div>

            <!-- ข้อ 5 -->
            <div class="mb-4 border rounded-lg overflow-hidden">
                <div class="bg-gray-100 p-3 flex items-center gap-3 border-b">
                    <input type="checkbox" id="chk_opt5" name="opt5_checked" class="w-5 h-5 text-blue-600 rounded" onchange="toggleSection('sec_opt5', this.checked)">
                    <label for="chk_opt5" class="font-medium text-gray-800 cursor-pointer">5. ขอเปลี่ยนตัวอย่างลายมือชื่อผู้มีสิทธิ์สั่งจ่ายเงินฝาก</label>
                </div>
                <div id="sec_opt5" class="p-4 form-section disabled-section grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div><input type="text" name="opt5_acc_no" class="border p-2 rounded w-full" placeholder="บัญชีเลขที่"></div>
                    <div><input type="text" name="opt5_acc_name" class="border p-2 rounded w-full" placeholder="ชื่อบัญชี"></div>
                </div>
            </div>

            <!-- ข้อ 6 -->
            <div class="mb-4 border rounded-lg overflow-hidden">
                <div class="bg-gray-100 p-3 flex items-center gap-3 border-b">
                    <input type="checkbox" id="chk_opt6" name="opt6_checked" class="w-5 h-5 text-blue-600 rounded" onchange="toggleSection('sec_opt6', this.checked)">
                    <label for="chk_opt6" class="font-medium text-gray-800 cursor-pointer">6. ขอออกสมุดเงินฝากทดแทนเล่มเก่า</label>
                </div>
                <div id="sec_opt6" class="p-4 form-section disabled-section">
                    <div class="flex flex-wrap gap-4 mb-3">
                        <label class="inline-flex items-center"><input type="radio" name="opt6_reason" value="ชำรุด" class="text-blue-600"> <span class="ml-2">ชำรุด</span></label>
                        <label class="inline-flex items-center"><input type="radio" name="opt6_reason" value="สูญหาย" class="text-blue-600"> <span class="ml-2">สูญหาย</span></label>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><input type="text" name="opt6_acc_no" class="border p-2 rounded w-full" placeholder="บัญชีเลขที่"></div>
                        <div><input type="text" name="opt6_acc_name" class="border p-2 rounded w-full" placeholder="ชื่อบัญชี"></div>
                    </div>
                </div>
            </div>

            <!-- ข้อ 7 -->
            <div class="mb-4 border rounded-lg overflow-hidden">
                <div class="bg-gray-100 p-3 flex items-center gap-3 border-b">
                    <input type="checkbox" id="chk_opt7" name="opt7_checked" class="w-5 h-5 text-blue-600 rounded" onchange="toggleSection('sec_opt7', this.checked)">
                    <label for="chk_opt7" class="font-medium text-gray-800 cursor-pointer">7. ขอให้หักเงินฝากเพื่อชำระค่าหุ้น/หนี้ประจำเดือน</label>
                </div>
                <div id="sec_opt7" class="p-4 form-section disabled-section">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3">
                        <div><input type="text" name="opt7_acc_no" class="border p-2 rounded w-full" placeholder="หักจากบัญชีเลขที่"></div>
                        <div><input type="text" name="opt7_acc_name" class="border p-2 rounded w-full" placeholder="ชื่อบัญชี"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><input type="text" name="opt7_member_name" class="border p-2 rounded w-full" placeholder="เพื่อชำระให้ชื่อสมาชิก"></div>
                        <div><input type="text" name="opt7_member_id" class="border p-2 rounded w-full" placeholder="สมาชิกเลขทะเบียนที่"></div>
                    </div>
                </div>
            </div>

            <!-- ข้อ 8 -->
            <div class="mb-4 border rounded-lg overflow-hidden">
                <div class="bg-gray-100 p-3 flex items-center gap-3 border-b">
                    <input type="checkbox" id="chk_opt8" name="opt8_checked" class="w-5 h-5 text-blue-600 rounded" onchange="toggleSection('sec_opt8', this.checked)">
                    <label for="chk_opt8" class="font-medium text-gray-800 cursor-pointer">8. ขอให้ออกใบแสดงรายการบัญชีเงินฝาก (Statement)</label>
                </div>
                <div id="sec_opt8" class="p-4 form-section disabled-section">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3">
                        <div><input type="text" name="opt8_acc_no" class="border p-2 rounded w-full" placeholder="บัญชีเลขที่"></div>
                        <div><input type="text" name="opt8_acc_name" class="border p-2 rounded w-full" placeholder="ชื่อบัญชี"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                        <div class="flex items-center gap-2"><span>ระหว่างวันที่</span><input type="date" name="opt8_start" class="border p-2 rounded w-full"></div>
                        <div class="flex items-center gap-2"><span>ถึงวันที่</span><input type="date" name="opt8_end" class="border p-2 rounded w-full"></div>
                    </div>
                </div>
            </div>

            <!-- ข้อ 9 -->
            <div class="mb-4 border rounded-lg overflow-hidden">
                <div class="bg-gray-100 p-3 flex items-center gap-3 border-b">
                    <input type="checkbox" id="chk_opt9" name="opt9_checked" class="w-5 h-5 text-blue-600 rounded" onchange="toggleSection('sec_opt9', this.checked)">
                    <label for="chk_opt9" class="font-medium text-gray-800 cursor-pointer">9. ขอเปลี่ยนข้อมูลส่วนตัว</label>
                </div>
                <div id="sec_opt9" class="p-4 form-section disabled-section">
                    <div class="flex flex-wrap gap-4 mb-3">
                        <label class="inline-flex items-center"><input type="checkbox" name="opt9_fields[]" value="ยศ" class="text-blue-600 rounded"> <span class="ml-2">ยศ</span></label>
                        <label class="inline-flex items-center"><input type="checkbox" name="opt9_fields[]" value="ชื่อ" class="text-blue-600 rounded"> <span class="ml-2">ชื่อ</span></label>
                        <label class="inline-flex items-center"><input type="checkbox" name="opt9_fields[]" value="สกุล" class="text-blue-600 rounded"> <span class="ml-2">สกุล</span></label>
                        <label class="inline-flex items-center"><input type="checkbox" name="opt9_fields[]" value="ที่อยู่" class="text-blue-600 rounded"> <span class="ml-2">ที่อยู่</span></label>
                        <label class="inline-flex items-center"><input type="checkbox" name="opt9_fields[]" value="สถานภาพ" class="text-blue-600 rounded"> <span class="ml-2">สถานภาพ</span></label>
                        <label class="inline-flex items-center"><input type="checkbox" name="opt9_fields[]" value="สถานที่ปฏิบัติงาน" class="text-blue-600 rounded"> <span class="ml-2">สถานที่ปฏิบัติงาน</span></label>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex items-center gap-2"><span>จาก</span><input type="text" name="opt9_from" class="border p-2 rounded w-full"></div>
                        <div class="flex items-center gap-2"><span>เป็น</span><input type="text" name="opt9_to" class="border p-2 rounded w-full"></div>
                    </div>
                </div>
            </div>

            <!-- ข้อ 10 -->
            <div class="mb-4 border rounded-lg overflow-hidden">
                <div class="bg-gray-100 p-3 flex items-center gap-3 border-b">
                    <input type="checkbox" id="chk_opt10" name="opt10_checked" class="w-5 h-5 text-blue-600 rounded" onchange="toggleSection('sec_opt10', this.checked)">
                    <label for="chk_opt10" class="font-medium text-gray-800 cursor-pointer">10. เกี่ยวกับใบเสร็จรับเงินประจำเดือน</label>
                </div>
                <div id="sec_opt10" class="p-4 form-section disabled-section">
                    <div class="flex flex-wrap gap-4">
                        <label class="inline-flex items-center"><input type="radio" name="opt10_action" value="รับ" class="text-blue-600"> <span class="ml-2">รับใบเสร็จรับเงินประจำเดือน</span></label>
                        <label class="inline-flex items-center"><input type="radio" name="opt10_action" value="ยกเลิก" class="text-blue-600"> <span class="ml-2">ยกเลิกรับใบเสร็จรับเงินประจำเดือน</span></label>
                    </div>
                </div>
            </div>

            <!-- ข้อ 11 -->
            <div class="mb-4 border rounded-lg overflow-hidden">
                <div class="bg-gray-100 p-3 flex items-center gap-3 border-b">
                    <input type="checkbox" id="chk_opt11" name="opt11_checked" class="w-5 h-5 text-blue-600 rounded" onchange="toggleSection('sec_opt11', this.checked)">
                    <label for="chk_opt11" class="font-medium text-gray-800 cursor-pointer">11. ขอเพิ่มส่งต้นเงินกู้</label>
                </div>
                <div id="sec_opt11" class="p-4 form-section disabled-section">
                    <div class="mb-3"><input type="text" name="opt11_contract" class="border p-2 rounded w-full sm:w-1/2" placeholder="สัญญาเลขที่"></div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                        <div class="flex items-center gap-2"><span>จาก</span><input type="number" name="opt11_from" class="border p-1 rounded w-full" placeholder="จำนวนเงิน"><span>บาท</span></div>
                        <div class="flex items-center gap-2"><span>เป็น</span><input type="number" name="opt11_to" class="border p-1 rounded w-full" placeholder="จำนวนเงิน"><span>บาท</span></div>
                    </div>
                </div>
            </div>

            <!-- ข้อ 12 -->
            <div class="mb-6 border rounded-lg overflow-hidden">
                <div class="bg-gray-100 p-3 flex items-center gap-3 border-b">
                    <input type="checkbox" id="chk_opt12" name="opt12_checked" class="w-5 h-5 text-blue-600 rounded" onchange="toggleSection('sec_opt12', this.checked)">
                    <label for="chk_opt12" class="font-medium text-gray-800 cursor-pointer">12. อื่น ๆ</label>
                </div>
                <div id="sec_opt12" class="p-4 form-section disabled-section">
                    <textarea name="opt12_details" rows="3" class="border p-2 rounded w-full" placeholder="ระบุรายละเอียดเพิ่มเติม..."></textarea>
                </div>
            </div>

            <!-- ส่วนท้าย -->
            <div class="mt-8 flex flex-col items-center justify-center space-y-4">
                <p class="text-sm text-red-500 mb-4">* หมายเหตุ: การเปลี่ยนแปลงข้อมูลดังกล่าวข้างต้น สหกรณ์จะเปลี่ยนแปลงในกรณีที่ไม่ขัดต่อมติ คำสั่ง ประกาศ ระเบียบ ข้อบังคับ และกฎหมายที่เกี่ยวข้อง</p>
                <!-- <div class="w-64 text-center">
                    <div class="border-b border-gray-400 mb-2 h-8"></div>
                    <p class="text-gray-700">(ผู้ยื่นความประสงค์)</p>
                </div> -->
            </div>

            <div class="mt-10 border-t pt-6 flex justify-center">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-10 rounded-lg shadow-md transition duration-300 text-lg">
                    บันทึกข้อมูลและส่งคำร้อง
                </button>
            </div>
        </form>
        @endif
    </div>

    <script>
        // ฟังก์ชันจัดการ Disabled state เหมือนเดิม
        function toggleSection(sectionId, isChecked) {
            const section = document.getElementById(sectionId);
            const inputs = section.querySelectorAll('input, textarea');
            
            if (isChecked) {
                section.classList.remove('disabled-section');
                inputs.forEach(input => input.disabled = false);
            } else {
                section.classList.add('disabled-section');
                inputs.forEach(input => {
                    input.disabled = true;
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                });
            }
        }

        window.onload = function() {
            const sections = ['sec_opt1', 'sec_opt2', 'sec_opt3', 'sec_opt4', 'sec_opt5', 'sec_opt6', 'sec_opt7', 'sec_opt8', 'sec_opt9', 'sec_opt10', 'sec_opt11', 'sec_opt12'];
            sections.forEach(id => {
                const section = document.getElementById(id);
                // ตรวจสอบว่า Checkbox หลักถูกเลือกไว้หรือไม่ (ป้องกันข้อมูลหายตอน Return back error)
                const checkbox = document.getElementById(id.replace('sec_', 'chk_'));
                
                if (section && (!checkbox || !checkbox.checked)) {
                    const inputs = section.querySelectorAll('input, textarea');
                    inputs.forEach(input => input.disabled = true);
                } else if(section) {
                    section.classList.remove('disabled-section');
                }
            });
        };
    </script>
</body>
</html>