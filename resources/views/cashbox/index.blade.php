@extends('layouts.app')

@section('title', 'الخزنة')

@section('content')
<div class="max-w-7xl mx-auto">
    
    {{-- فلاتر اختيار الشهر والسنة --}}
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <form method="GET" action="{{ route('cashbox.index') }}" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="font-semibold">📅 الشهر</label>
                <select name="month" class="border rounded px-3 py-2">
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="font-semibold">🗓️ السنة</label>
                <select name="year" class="border rounded px-3 py-2">
                    @for ($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                🔍 عرض
            </button>
        </form>
    </div>

    {{-- 🔔 التنبيهات --}}
<div class="bg-white shadow rounded-lg p-4 mb-6">
    <h2 class="text-xl font-bold text-blue-700 mb-3">🔔 تنبيهات الأقساط</h2>

   {{-- أقساط متأخرة --}}
@if($overdueInstallments->count())
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        ⚠️ أقساط متأخرة: {{ $overdueInstallments->count() }}
        <button onclick="toggleTable('overdueTable')" 
            class="ml-3 bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow">
            عرض التفاصيل
        </button>
        <div id="overdueTable" class="hidden mt-3 overflow-x-auto">
            <table class="w-full table-fixed border border-gray-300 text-sm text-center">
                <thead class="bg-red-600 text-white">
                    <tr>
                        <th class="w-1/4 px-3 py-2">العميل</th>
                        <th class="w-1/4 px-3 py-2">الوحدة</th>
                        <th class="w-1/4 px-3 py-2">المبلغ</th>
                        <th class="w-1/4 px-3 py-2">تاريخ الاستحقاق</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($overdueInstallments as $inst)
                        <tr class="border-b hover:bg-red-50">
                            <td class="px-3 py-2 truncate">{{ $inst->sale->client->name }}</td>
                            <td class="px-3 py-2 truncate">{{ $inst->sale->unit->name }}</td>
                            <td class="px-3 py-2 text-red-600 font-bold">{{ number_format($inst->amount) }} ج.م</td>
                            <td class="px-3 py-2">{{ $inst->due_date->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

{{-- أقساط اليوم --}}
@if($todayInstallments->count())
    <div class="mb-4 p-3 bg-yellow-100 text-yellow-700 rounded">
        ⏳ أقساط مستحقة اليوم: {{ $todayInstallments->count() }}
        <button onclick="toggleTable('todayTable')" 
            class="ml-3 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded shadow">
            عرض التفاصيل
        </button>
        <div id="todayTable" class="hidden mt-3 overflow-x-auto">
            <table class="w-full table-fixed border border-gray-300 text-sm text-center">
                <thead class="bg-yellow-500 text-white">
                    <tr>
                        <th class="w-1/4 px-3 py-2">العميل</th>
                        <th class="w-1/4 px-3 py-2">الوحدة</th>
                        <th class="w-1/4 px-3 py-2">المبلغ</th>
                        <th class="w-1/4 px-3 py-2">تاريخ الاستحقاق</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($todayInstallments as $inst)
                        <tr class="border-b hover:bg-yellow-50">
                            <td class="px-3 py-2 truncate">{{ $inst->sale->client->name }}</td>
                            <td class="px-3 py-2 truncate">{{ $inst->sale->unit->name }}</td>
                            <td class="px-3 py-2 text-yellow-700 font-bold">{{ number_format($inst->amount) }} ج.م</td>
                            <td class="px-3 py-2">{{ $inst->due_date->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

{{-- أقساط خلال أسبوع --}}
@if($upcomingInstallments->count())
    <div class="p-3 bg-blue-100 text-blue-700 rounded">
        📅 أقساط خلال أسبوع: {{ $upcomingInstallments->count() }}
        <button onclick="toggleTable('upcomingTable')" 
            class="ml-3 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded shadow">
            عرض التفاصيل
        </button>
        <div id="upcomingTable" class="hidden mt-3 overflow-x-auto">
            <table class="w-full table-fixed border border-gray-300 text-sm text-center">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="w-1/4 px-3 py-2">العميل</th>
                        <th class="w-1/4 px-3 py-2">الوحدة</th>
                        <th class="w-1/4 px-3 py-2">المبلغ</th>
                        <th class="w-1/4 px-3 py-2">تاريخ الاستحقاق</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($upcomingInstallments as $inst)
                        <tr class="border-b hover:bg-blue-50">
                            <td class="px-3 py-2 truncate">{{ $inst->sale->client->name }}</td>
                            <td class="px-3 py-2 truncate">{{ $inst->sale->unit->name }}</td>
                            <td class="px-3 py-2 text-blue-700 font-bold">{{ number_format($inst->amount) }} ج.م</td>
                            <td class="px-3 py-2">{{ $inst->due_date->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

{{-- لا توجد تنبيهات --}}
@if(!$overdueInstallments->count() && !$todayInstallments->count() && !$upcomingInstallments->count())
    <p class="text-gray-500">✅ لا توجد تنبيهات حالياً</p>
@endif

<script>
    function toggleTable(id) {
        document.getElementById(id).classList.toggle('hidden');
    }
</script>
</div>

    {{-- الكروت --}}
    <div class="grid md:grid-cols-4 gap-6 mb-6">
        <div class="bg-green-100 p-6 rounded-xl shadow">
            <h3 class="text-lg font-bold text-green-700">إجمالي الإيرادات</h3>
            <p class="text-2xl font-extrabold">{{ number_format($totalRevenues) }} ج.م</p>
        </div>
        <div class="bg-red-100 p-6 rounded-xl shadow">
            <h3 class="text-lg font-bold text-red-700">إجمالي المصروفات</h3>
            <p class="text-2xl font-extrabold">{{ number_format($totalExpenses) }} ج.م</p>
        </div>
        <div class="bg-blue-100 p-6 rounded-xl shadow">
            <h3 class="text-lg font-bold text-blue-700">صافي الرصيد</h3>
            <p class="text-2xl font-extrabold">{{ number_format($balance) }} ج.م</p>
        </div>
        <div class="bg-yellow-100 p-6 rounded-xl shadow">
            <h3 class="text-lg font-bold text-yellow-700">إيرادات متوقعة</h3>
            <p class="text-2xl font-extrabold">{{ number_format($expectedInstallments) }} ج.م</p>
        </div>
    </div>

    {{-- جدول الحركات --}}
    <div class="bg-white shadow rounded-lg p-4">
        <h2 class="text-xl font-bold text-blue-700 mb-4">💰 الحركات المالية</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-center border">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-4 py-3">التاريخ</th>
                        <th class="px-4 py-3">الوصف</th>
                        <th class="px-4 py-3">المبلغ</th>
                        <th class="px-4 py-3">الملاحظات</th>
                        <th class="px-4 py-3">النوع</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($t['date'])->format('Y-m-d') }}</td>
                        <td class="px-4 py-3">{{ $t['description'] }}</td>
                        <td class="px-4 py-3 font-bold {{ $t['transaction_type'] === 'revenue' ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format($t['amount']) }} ج.م
                        </td>
                        <td class="px-4 py-3">{{ $t['notes'] ?? '-' }}</td>
                        
                        <td class="px-4 py-3">
                            @if($t['transaction_type'] === 'revenue')
                                <span class="bg-green-200 text-green-800 px-2 py-1 rounded">إيراد</span>
                            @else
                                <span class="bg-red-200 text-red-800 px-2 py-1 rounded">مصروف</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-6 text-gray-500">🚫 لا توجد حركات مالية</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
