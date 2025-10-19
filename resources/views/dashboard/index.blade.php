@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- العنوان --}}
    <h1 class="text-3xl font-bold text-blue-800 mb-6">📊 لوحة التحكم</h1>

    {{-- الكروت --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow-lg rounded-xl p-6 border-r-4 border-green-500">
            <h2 class="text-gray-600">إجمالي الإيرادات (هذا الشهر)</h2>
            <p class="text-2xl font-bold text-green-600">{{ number_format($monthlyRevenues) }} ج.م</p>
        </div>
        <div class="bg-white shadow-lg rounded-xl p-6 border-r-4 border-red-500">
            <h2 class="text-gray-600">إجمالي المصروفات (هذا الشهر)</h2>
            <p class="text-2xl font-bold text-red-600">{{ number_format($monthlyExpenses) }} ج.م</p>
        </div>
        <div class="bg-white shadow-lg rounded-xl p-6 border-r-4 border-blue-500">
            <h2 class="text-gray-600">رصيد الخزنة</h2>
            <p class="text-2xl font-bold text-blue-600">{{ number_format($cashbox) }} ج.م</p>
        </div>
    </div>

    {{-- إحصائيات الوحدات --}}
    <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-10">
        {{-- إجمالي الوحدات المتاحة --}}
        <div class="grid grid-cols-4 md:grid-cols-2 gap-6 mb-6">
         <div class="bg-blue-100 p-6 rounded-lg shadow hover:shadow-lg transition">
        <h3 class="text-lg font-bold text-blue-800">🏠 إجمالي الوحدات المتاحة </h3>
        <p class="text-3xl font-extrabold text-blue-600 mt-2">{{ $unitsStats['idle'] }}</p>
    </div>
    {{-- إجمالي الوحدات المحجوزة --}}
        
             <div class="bg-yellow-100 p-6 rounded-lg shadow hover:shadow-lg transition">
        <h3 class="text-lg font-bold text-yellow-800">🏠 إجمالي الوحدات المحجوزة</h3>
        <p class="text-3xl font-extrabold text-yellow-600 mt-2">{{ $unitsStats['reserved'] }}</p>
    </div>
    {{-- إجمالي الوحدات المباعة --}}
    <div class="bg-red-100 p-6 rounded-lg shadow hover:shadow-lg transition">
        <h3 class="text-lg font-bold text-red-800">🏠 إجمالي الوحدات المباعة</h3>
        <p class="text-3xl font-extrabold text-red-600 mt-2">{{ $soldUnitsTotal }}</p>
    </div>

    {{-- الوحدات المباعة هذا الشهر --}}
    <div class="bg-green-100 p-6 rounded-lg shadow hover:shadow-lg transition">
        <h3 class="text-lg font-bold text-green-800">📅 الوحدات المباعة هذا الشهر</h3>
        <p class="text-3xl font-extrabold text-green-600 mt-2">{{ $soldUnitsMonth }}</p>
    </div>
</div>

    </div>

    {{-- التنبيهات --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        {{-- أقساط متأخرة --}}
        <div class="bg-white shadow-lg rounded-xl p-6">
            <h3 class="text-lg font-bold text-red-600 mb-4">⚠️ أقساط متأخرة</h3>
            @if($overdueInstallments->count())
                <ul class="space-y-2">
                    @foreach($overdueInstallments as $inst)
                        <li class="p-3 bg-red-50 rounded-lg flex justify-between">
                            <span>قسط #{{ $inst->id }} - {{ number_format($inst->amount) }} ج.م</span>
                            <span class="text-sm text-gray-500">موعده: {{ $inst->due_date->format('Y-m-d') }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">لا توجد أقساط متأخرة ✅</p>
            @endif
        </div>

        {{-- أقساط مستحقة قريباً --}}
        <div class="bg-white shadow-lg rounded-xl p-6">
            <h3 class="text-lg font-bold text-yellow-600 mb-4">⏳ أقساط مستحقة قريباً</h3>
            @if($upcomingInstallments->count())
                <ul class="space-y-2">
                    @foreach($upcomingInstallments as $inst)
                        <li class="p-3 bg-yellow-50 rounded-lg flex justify-between">
                            <span>قسط #{{ $inst->id }} - {{ number_format($inst->amount) }} ج.م</span>
                            <span class="text-sm text-gray-500">موعده: {{ $inst->due_date->format('Y-m-d') }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">لا توجد أقساط مستحقة قريباً ✅</p>
            @endif
        </div>
    </div>

    {{-- الرسم البياني --}}
    <div class="bg-white shadow-lg rounded-xl p-6">
        <h3 class="text-lg font-bold text-blue-600 mb-4">📈 الإيرادات والمصروفات خلال الشهور</h3>
        <canvas id="revenuesExpensesChart" height="120"></canvas>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection
