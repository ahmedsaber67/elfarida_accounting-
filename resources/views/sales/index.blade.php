@extends('layouts.app')

@section('title', 'قائمة المبيعات')

@section('content')
<div class="bg-white shadow-lg rounded-2xl p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-blue-700">📋 قائمة المبيعات</h2>
        <a href="{{ route('sales.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition">
            ➕ إضافة عملية بيع
        </a>
    </div>

    {{-- رسائل نجاح --}}
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif


    <form method="GET" action="{{ route('sales.index') }}" class="mb-6 flex gap-3 items-center">
    <select name="search_type" class="border-gray-300 rounded-lg">
        <option value="client_name" {{ request('search_type')=='client_name' ? 'selected' : '' }}>🔍 بالعميل</option>
        <option value="client_phone" {{ request('search_type')=='client_phone' ? 'selected' : '' }}>📞 برقم الهاتف</option>
        <option value="unit" {{ request('search_type')=='unit' ? 'selected' : '' }}>🏠 بالوحدة</option>
    </select>

    <input type="text" name="search_value" value="{{ request('search_value') }}" 
           placeholder="ادخل كلمة البحث..." 
           class="border-gray-300 rounded-lg w-1/3">

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">بحث</button>
</form>


    <!-- الجدول -->
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="py-3 px-4 text-right">العميل</th>
                    <th class="py-3 px-4 text-right">الوحدة</th>
                    <th class="py-3 px-4 text-right">السعر الكلي</th>
                    <th class="py-3 px-4 text-right">المقدم</th>
                    <th class="py-3 px-4 text-right">المتبقي</th>
                    <th class="py-3 px-4 text-right"></th>
                    
                </tr>
            </thead>
             <tbody>
                @foreach($sales as $sale)
                    @php
                        // لو لسه فيه أقساط معلقة أو متأخرة
                        $hasPending = $sale->installments->whereIn('status', ['pending','overdue'])->count() > 0;
                        $rowClass = $hasPending ? 'bg-yellow-100' : 'bg-green-100';
                    @endphp

                    <tr class="{{ $rowClass }} text-lg">
                        <td class="px-4 py-3">{{ $sale->client->name }}</td>
                        <td class="px-4 py-3">{{ $sale->unit->name }}</td>
                        <td class="px-4 py-3">{{ number_format($sale->total_price) }} ج.م</td>
                        <td class="px-4 py-3">{{ number_format($sale->down_payment) }} ج.م</td>
                        <td class="px-4 py-3">{{ number_format($sale->remaining_amount) }} ج.م</td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('sales.show', $sale->id) }}" 
                               class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                                عرض
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $sales->links() }}
    </div>
</div>
@endsection
