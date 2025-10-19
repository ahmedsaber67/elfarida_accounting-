@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-blue-700">💸 قائمة المصروفات</h2>

    {{-- رسالة نجاح --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- زر إضافة --}}
    <a href="{{ route('expenses.create') }}" 
       class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
       ➕ إضافة مصروف جديد
    </a>
<div class="mb-4">
    <form method="GET" action="{{ route('expenses.index') }}" class="flex space-x-2">
        <select name="month" class="border rounded p-2">
            <option value="">اختر الشهر</option>
            @for ($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                </option>
            @endfor
        </select>

        <select name="year" class="border rounded p-2">
            <option value="">اختر السنة</option>
            @for ($y = now()->year; $y >= now()->year - 5; $y--)
                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                    {{ $y }}
                </option>
            @endfor
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            🔍 عرض
        </button>
    </form>
</div>

{{-- الإجمالي --}}
<div class="mb-4 bg-gray-100 p-4 rounded shadow">
    <strong>إجمالي الشهر الحالي:</strong> {{ number_format($monthlyTotal) }} جنيه
</div>


    {{-- جدول المصروفات --}}
    <table class="w-full border-collapse border border-gray-200 text-center">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-3">#</th>
                <th class="border p-3">الوصف</th>
                <th class="border p-3">المبلغ</th>
                <th class="border p-3">التاريخ</th>
                <th class="border p-3">الفئة</th>
                <th class="border p-3">المستخدم</th>
                <th class="border p-3">ملاحظات</th>
                <th class="border p-3">التحكم</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($expenses as $expense)
                <tr class="hover:bg-gray-50">
                    <td class="border p-2">{{ $expense->id }}</td>
                    <td class="border p-2 font-semibold">{{ $expense->description }}</td>
                    <td class="border p-2 text-red-600">{{ number_format($expense->amount) }} ج.م</td>
                    <td class="border p-2">{{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}</td>
                    <td class="border p-2">
                        @switch($expense->category)
                            @case('rent') 🏢 إيجار @break
                            @case('salaries') 👨‍💼 مرتبات @break
                            @case('maintenance') 🛠️ صيانة @break
                            @default 📌 أخرى
                        @endswitch
                    </td>
                    <td class="border p-2">{{ $expense->user->name ?? ' admin' }}</td>
                    <td class="border p-2">{{ $expense->notes }}</td>
                    <td class="border p-2">
                        <a href="{{ route('expenses.edit', $expense) }}" 
                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                        ✏️ تعديل
                        </a>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="8" class="p-4 text-gray-500">لا توجد مصروفات مسجلة.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $expenses->links() }}
    </div>
</div>
@endsection
