<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                รายละเอียดคำร้องขอเปลี่ยนแปลงข้อมูล
            </h2>
            <a href="{{ route('admin.change-requests.index') }}" class="text-sm text-blue-600 hover:text-blue-800 hover:underline font-medium">
                &larr; กลับหน้ารายการ
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-200">
            
            <!-- ส่วนหัวรายละเอียด -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">คำร้อง ID: #{{ $changeRequest->id }}</h1>
                    <span class="text-sm text-gray-500">รับเรื่องเมื่อ: {{ $changeRequest->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="mt-4 sm:mt-0">
                    <!-- แสดงสถานะของคำร้อง -->
                    <span class="px-4 py-1.5 rounded-full text-sm font-semibold
                        @if($changeRequest->status == 'completed') bg-green-100 text-green-700
                        @elseif($changeRequest->status == 'processing') bg-blue-100 text-blue-700
                        @else bg-yellow-100 text-yellow-700 @endif">
                        @if($changeRequest->status == 'completed') ดำเนินการเรียบร้อย
                        @elseif($changeRequest->status == 'processing') กำลังดำเนินการ
                        @else รอดำเนินการ @endif
                    </span>
                </div>
            </div>

            <!-- ข้อมูลผู้ยื่น -->
            <div class="bg-blue-50 p-5 rounded-lg border border-blue-100 mb-8">
                <h2 class="text-lg font-semibold text-blue-800 mb-4">ข้อมูลผู้ยื่นความประสงค์</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm">
                    <div><span class="text-gray-500 block">ข้าพเจ้า (ยศ ชื่อ-สกุล)</span> <span class="font-medium text-lg">{{ $changeRequest->full_name }}</span></div>
                    <div><span class="text-gray-500 block">สมาชิกเลขทะเบียนที่</span> <span class="font-medium text-lg">{{ $changeRequest->member_id }}</span></div>
                    <div><span class="text-gray-500 block">สังกัด</span> <span class="font-medium">{{ $changeRequest->department }}</span></div>
                    <div><span class="text-gray-500 block">โทรศัพท์</span> <span class="font-medium">{{ $changeRequest->phone }}</span></div>
                    <div><span class="text-gray-500 block">เขียนที่</span> <span class="font-medium">{{ $changeRequest->written_at }}</span></div>
                    <div><span class="text-gray-500 block">วันที่ระบุในฟอร์ม</span> <span class="font-medium">{{ $changeRequest->req_date->format('d/m/Y') }}</span></div>
                </div>
            </div>

            <!-- สิ่งที่ต้องการเปลี่ยนแปลง -->
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">รายการที่ต้องการเปลี่ยนแปลง</h2>
            <div class="space-y-4">
                
                @if(isset($options['opt1_checked']))
                <div class="p-4 border rounded bg-gray-50">
                    <h3 class="font-bold text-blue-700">1. เกี่ยวกับค่าหุ้นรายเดือน</h3>
                    <p class="mt-2 text-sm">
                        <strong>ความประสงค์:</strong> 
                        {{ isset($options['opt1_type']) ? ($options['opt1_type'] === 'increase' ? 'เพิ่มส่งค่าหุ้น' : ($options['opt1_type'] === 'decrease' ? 'ลดส่งค่าหุ้น' : 'งดส่งค่าหุ้น')) : '-' }} <br>
                        <strong>จาก:</strong> {{ $options['opt1_from'] ?? '-' }} บาท 
                        <strong>เป็น:</strong> {{ $options['opt1_to'] ?? '-' }} บาท
                    </p>
                </div>
                @endif

                @if(isset($options['opt2_checked']))
                <div class="p-4 border rounded bg-gray-50">
                    <h3 class="font-bold text-blue-700">2. เกี่ยวกับเงินฝากรายเดือน</h3>
                    <p class="mt-2 text-sm">
                        <strong>ความประสงค์:</strong> {{ isset($options['opt2_type']) ? ($options['opt2_type'] === 'increase' ? 'เพิ่มส่งเงินฝาก' : 'ลดส่งเงินฝาก') : '-' }} <br>
                        <strong>บัญชีเลขที่:</strong> {{ $options['opt2_acc_no'] ?? '-' }} 
                        <strong>ชื่อบัญชี:</strong> {{ $options['opt2_acc_name'] ?? '-' }} <br>
                        <strong>จาก:</strong> {{ $options['opt2_from'] ?? '-' }} บาท 
                        <strong>เป็น:</strong> {{ $options['opt2_to'] ?? '-' }} บาท
                    </p>
                </div>
                @endif

                @if(isset($options['opt3_checked']))
                <div class="p-4 border rounded bg-gray-50">
                    <h3 class="font-bold text-blue-700">3. ขอเปลี่ยนผู้มีสิทธิ์สั่งจ่าย</h3>
                    <p class="mt-2 text-sm">
                        <strong>บัญชีเลขที่:</strong> {{ $options['opt3_acc_no'] ?? '-' }} <br>
                        <strong>ชื่อบัญชี:</strong> {{ $options['opt3_acc_name'] ?? '-' }}
                    </p>
                </div>
                @endif

                @if(isset($options['opt4_checked']))
                <div class="p-4 border rounded bg-gray-50">
                    <h3 class="font-bold text-blue-700">4. ขอเปลี่ยนชื่อบัญชีเงินฝาก</h3>
                    <p class="mt-2 text-sm">
                        <strong>บัญชีเลขที่:</strong> {{ $options['opt4_acc_no'] ?? '-' }} <br>
                        <strong>จากชื่อบัญชี:</strong> {{ $options['opt4_from_name'] ?? '-' }} <br>
                        <strong>เป็นชื่อบัญชี:</strong> {{ $options['opt4_to_name'] ?? '-' }}
                    </p>
                </div>
                @endif

                @if(isset($options['opt5_checked']))
                <div class="p-4 border rounded bg-gray-50">
                    <h3 class="font-bold text-blue-700">5. ขอเปลี่ยนตัวอย่างลายมือชื่อผู้มีสิทธิ์สั่งจ่ายเงินฝาก</h3>
                    <p class="mt-2 text-sm">
                        <strong>บัญชีเลขที่:</strong> {{ $options['opt5_acc_no'] ?? '-' }} <br>
                        <strong>ชื่อบัญชี:</strong> {{ $options['opt5_acc_name'] ?? '-' }}
                    </p>
                </div>
                @endif

                @if(isset($options['opt6_checked']))
                <div class="p-4 border rounded bg-gray-50">
                    <h3 class="font-bold text-blue-700">6. ขอออกสมุดเงินฝากทดแทนเล่มเก่า</h3>
                    <p class="mt-2 text-sm">
                        <strong>สาเหตุ:</strong> {{ $options['opt6_reason'] ?? '-' }} <br>
                        <strong>บัญชีเลขที่:</strong> {{ $options['opt6_acc_no'] ?? '-' }} <br>
                        <strong>ชื่อบัญชี:</strong> {{ $options['opt6_acc_name'] ?? '-' }}
                    </p>
                </div>
                @endif

                @if(isset($options['opt7_checked']))
                <div class="p-4 border rounded bg-gray-50">
                    <h3 class="font-bold text-blue-700">7. ขอให้หักเงินฝากเพื่อชำระค่าหุ้น/หนี้ประจำเดือน</h3>
                    <p class="mt-2 text-sm">
                        <strong>หักจากบัญชีเลขที่:</strong> {{ $options['opt7_acc_no'] ?? '-' }} <br>
                        <strong>ชื่อบัญชี:</strong> {{ $options['opt7_acc_name'] ?? '-' }} <br>
                        <strong>เพื่อชำระให้ชื่อสมาชิก:</strong> {{ $options['opt7_member_name'] ?? '-' }} <br>
                        <strong>สมาชิกเลขทะเบียนที่:</strong> {{ $options['opt7_member_id'] ?? '-' }}
                    </p>
                </div>
                @endif

                @if(isset($options['opt8_checked']))
                <div class="p-4 border rounded bg-gray-50">
                    <h3 class="font-bold text-blue-700">8. ขอให้ออกใบแสดงรายการบัญชีเงินฝาก (Statement)</h3>
                    <p class="mt-2 text-sm">
                        <strong>บัญชีเลขที่:</strong> {{ $options['opt8_acc_no'] ?? '-' }} <br>
                        <strong>ชื่อบัญชี:</strong> {{ $options['opt8_acc_name'] ?? '-' }} <br>
                        <strong>ระหว่างวันที่:</strong> {{ $options['opt8_start'] ?? '-' }} <strong>ถึงวันที่:</strong> {{ $options['opt8_end'] ?? '-' }}
                    </p>
                </div>
                @endif

                @if(isset($options['opt9_checked']))
                <div class="p-4 border rounded bg-gray-50">
                    <h3 class="font-bold text-blue-700">9. ขอเปลี่ยนข้อมูลส่วนตัว</h3>
                    <p class="mt-2 text-sm">
                        <strong>ข้อมูลที่ต้องการเปลี่ยน:</strong> 
                        @if(isset($options['opt9_fields']) && is_array($options['opt9_fields']))
                            {{ implode(', ', $options['opt9_fields']) }}
                        @endif
                        <br>
                        <strong>จาก:</strong> {{ $options['opt9_from'] ?? '-' }} <br>
                        <strong>เป็น:</strong> {{ $options['opt9_to'] ?? '-' }}
                    </p>
                </div>
                @endif

                @if(isset($options['opt10_checked']))
                <div class="p-4 border rounded bg-gray-50">
                    <h3 class="font-bold text-blue-700">10. เกี่ยวกับใบเสร็จรับเงินประจำเดือน</h3>
                    <p class="mt-2 text-sm">
                        <strong>ความประสงค์:</strong> {{ $options['opt10_action'] ?? '-' }}
                    </p>
                </div>
                @endif

                @if(isset($options['opt11_checked']))
                <div class="p-4 border rounded bg-gray-50">
                    <h3 class="font-bold text-blue-700">11. ขอเพิ่มส่งต้นเงินกู้</h3>
                    <p class="mt-2 text-sm">
                        <strong>สัญญาเลขที่:</strong> {{ $options['opt11_contract'] ?? '-' }} <br>
                        <strong>จาก:</strong> {{ $options['opt11_from'] ?? '-' }} บาท 
                        <strong>เป็น:</strong> {{ $options['opt11_to'] ?? '-' }} บาท
                    </p>
                </div>
                @endif

                @if(isset($options['opt12_checked']))
                <div class="p-4 border rounded bg-gray-50">
                    <h3 class="font-bold text-blue-700">12. อื่น ๆ</h3>
                    <p class="mt-2 text-sm whitespace-pre-line">{{ $options['opt12_details'] ?? '-' }}</p>
                </div>
                @endif

                <!-- เช็คกรณีไม่มีการเลือกรายการใดๆ เลย -->
                @if(empty($options) || count(preg_grep('/_checked$/', array_keys($options))) == 0)
                    <div class="p-4 text-center text-gray-500 bg-gray-50 rounded border">ไม่มีการระบุตัวเลือกเพิ่มเติม</div>
                @endif

            </div>

            <!-- ปุ่มจัดการด้านล่าง -->
            <div class="mt-8 pt-6 border-t flex flex-col sm:flex-row justify-between items-center gap-4">
                <button onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-6 rounded shadow flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    พิมพ์เอกสาร
                </button>

                <!-- ตรงนี้ในอนาคตคุณสามารถทำฟอร์ม <form> เพื่อส่งค่าไปอัปเดตสถานะของใบคำร้องได้ครับ -->
                <!-- <div class="flex gap-2">
                    <button class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded shadow">กดเปลี่ยนเป็น ดำเนินการแล้ว</button>
                </div> -->
            </div>
        </div>
    </div>
</x-app-layout>