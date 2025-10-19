@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl p-6">
    <h2 class="text-2xl font-bold text-blue-700 mb-6">👤 تفاصيل العميل</h2>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="font-semibold">الاسم:</p>
            <p class="text-gray-700">{{ $client->name }}</p>
        </div>
        <div>
            <p class="font-semibold">📞 الهاتف:</p>
            <p class="text-gray-700">{{ $client->phone }}</p>
        </div>
        <div>
            <p class="font-semibold">🏠 العنوان:</p>
            <p class="text-gray-700">{{ $client->address }}</p>
        </div>
        <div class="col-span-2">
            <p class="font-semibold">📝 ملاحظات:</p>
            <p class="text-gray-700">{{ $client->notes ?? 'لا يوجد' }}</p>
        </div>
    </div>

    <h3 class="text-xl font-bold text-green-700 mt-6 mb-3">📑 المبيعات المرتبطة</h3>
    @if($client->sales->count())
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 text-center">
                    <th class="px-4 py-2 border">الوحدة</th>
                    <th class="px-4 py-2 border">السعر الكلي</th>
                    <th class="px-4 py-2 border">المقدم</th>
                    <th class="px-4 py-2 border">المتبقي</th>
                    <th class="px-4 py-2 border">تاريخ البيع</th>
                </tr>
            </thead>
            <tbody>
                @foreach($client->sales as $sale)
                <tr class="text-center hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ $sale->unit->name ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ number_format($sale->total_price) }} ج.م</td>
                    <td class="px-4 py-2 border">{{ number_format($sale->down_payment) }} ج.م</td>
                    <td class="px-4 py-2 border">{{ number_format($sale->remaining_amount) }} ج.م</td>
                    <td class="px-4 py-2 border">{{ $sale->sale_date->format('Y-m-d') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-600">❌ لا يوجد مبيعات لهذا العميل</p>
    @endif

    <div class="mt-6">
        <a href="{{ route('clients.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">⬅️ رجوع</a>
    </div>
</div>
@endsection
