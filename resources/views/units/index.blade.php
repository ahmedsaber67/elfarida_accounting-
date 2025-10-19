@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-lg rounded-2xl p-6">
    <h2 class="text-2xl font-bold text-blue-700 mb-6">🏠 قائمة الوحدات</h2>

    <a href="{{ route('units.create') }}" class="mb-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
        ➕ إضافة وحدة جديدة
    </a>

    {{-- 🔎 البحث + الفلتر --}}
    <form method="GET" action="{{ route('units.index') }}" class="mb-6 flex gap-3 items-center flex-wrap">
        {{-- البحث --}}
        <input type="text" name="search" value="{{ request('search') }}" 
               placeholder="ابحث باسم الوحدة..."
               class="border-gray-300 rounded-lg w-1/3 px-3 py-2">

        {{-- الفلتر بالحالة --}}
        <select name="status" class="border-gray-300 rounded-lg px-3 py-2">
            <option value="">-- كل الحالات --</option>
            <option value="idle" {{ request('status') == 'idle' ? 'selected' : '' }}>متاحة</option>
            <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>محجوزة</option>
            <option value="reserved_with_deposit" {{ request('status') == 'reserved_with_deposit' ? 'selected' : '' }}>محجوزة بدفعة</option>
            <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>مباعة</option>
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
            🔍 بحث
        </button>
    </form>

    <!-- الجدول -->
    <table class="w-full border-collapse table-fixed">
        <thead>
            <tr class="bg-gray-200 text-gray-700 text-lg text-center">
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">اسم الوحدة</th>
                <th class="px-4 py-3">السعر الكلي</th>
                <th class="px-4 py-3">الحالة</th>
                <th class="px-4 py-3">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($units as $index => $unit)
                @php
                    $statusColors = [
                        'reserved_with_deposit' => 'bg-yellow-100 text-yellow-800',
                        'reserved' => 'bg-orange-100 text-orange-800',
                        'idle' => 'bg-blue-100 text-blue-800',
                        'sold' => 'bg-green-100 text-green-800',
                    ];

                    $statusLabels = [
                        'idle' => 'متاحة',
                        'reserved' => 'محجوزة',
                        'reserved_with_deposit' => 'محجوزة بدفعة',
                        'sold' => 'مباعة',
                    ];
                @endphp
                <tr class="text-center text-lg {{ $statusColors[$unit->status] ?? '' }}">
                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                    <td class="px-4 py-3">{{ $unit->name }}</td>
                    <td class="px-4 py-3">{{ number_format($unit->total_price) }} ج.م</td>
                    <td class="px-4 py-3 font-bold">
                        {{ $statusLabels[$unit->status] ?? $unit->status }}
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('units.edit', $unit) }}" class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                            ✏️ تعديل
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $units->links() }}
    </div>
</div>
@endsection
