@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl p-6">
    <h2 class="text-2xl font-bold text-blue-700 mb-6">📝 تسجيل عملية بيع جديدة</h2>

    {{-- رسائل الأخطاء --}}
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sales.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- اختيار العميل --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">👤 العميل</label>
            <select id="clientSelect" name="client_id" class="w-full">
                <option value="">-- اختر العميل --</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }} - {{ $client->phone }}</option>
                @endforeach
            </select>
        </div>

        {{-- اختيار الوحدة --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">🏠 الوحدة</label>
            <select id="unitSelect" name="unit_id" class="w-full">
                <option value="">-- اختر الوحدة --</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }} ({{ number_format($unit->total_price) }} ج)</option>
                @endforeach
            </select>
        </div>

        {{-- المقدم --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">💵 المقدم</label>
            <input type="number" name="down_payment" step="1000"  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- عدد الأقساط --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">📅 عدد الأقساط</label>
            <input type="number" id="installments_count" name="installments_count" min="1" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        {{-- اختيار تواريخ الأقساط --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">🗓️ تواريخ الأقساط</label>
            <div id="installments_dates_container" class="space-y-2"></div>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-md transition">
            ✅ حفظ عملية البيع
        </button>
    </form>
</div>

{{-- Script لتوليد حقول التواريخ --}}
<script>
    document.getElementById('installments_count').addEventListener('input', function () {
        let count = this.value;
        let container = document.getElementById('installments_dates_container');
        container.innerHTML = '';

        for (let i = 1; i <= count; i++) {
            let input = document.createElement('input');
            input.type = 'date';
            input.name = 'installment_dates[]';
            input.className = 'w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500';
            container.appendChild(input);
        }
    });
</script>

{{-- TomSelect --}}
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect("#clientSelect", { create: false, sortField: {field: "text"} });
    new TomSelect("#unitSelect", { create: false, sortField: {field: "text"} });
</script>
@endsection
