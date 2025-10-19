@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-blue-700 mb-6">💰 إدارة العُهد</h2>

    {{-- رسائل نجاح --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- إضافة عهدة جديدة --}}
    <form action="{{ route('advances.store') }}" method="POST" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        @csrf
        <input type="text" name="title" placeholder="وصف العهدة" required class="border rounded-lg p-2 w-full">
        <input type="number" step="0.01" name="amount" placeholder="المبلغ" required class="border rounded-lg p-2 w-full">
        <input type="text" name="recipient" placeholder="المستلم" class="border rounded-lg p-2 w-full">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
            ➕ إضافة
        </button>
    </form>
<div class="overflow-x-auto">
    <table class="table-fixed w-full border border-gray-600 rounded-lg overflow-hidden">
        <thead class="bg-blue-700 text-white text-sm">
            <tr>
                <th class="w-2/12 px-3 py-2 text-center">الوصف</th>
                <th class="w-2/12 px-3 py-2 text-center">المبلغ</th>
                <th class="w-2/12 px-3 py-2 text-center">المستلم</th>
                <th class="w-2/12 px-3 py-2 text-center">الحالة</th>
                <th class="w-3/12 px-3 py-2 text-center">إدخال البيانات</th>
                <th class="w-1/12 px-3 py-2 text-center">إجراءات</th>
            </tr>
        </thead>
        <tbody class="text-sm">
            @forelse($advances as $adv)
                <tr class="border-b hover:bg-gray-50 transition">
                    {{-- الوصف --}}
                    <td class="px-3 py-2 truncate max-w-[150px]" title="{{ $adv->title }}">
                        {{ $adv->title }}
                    </td>

                    {{-- المبلغ --}}
                    <td class="px-3 py-2 font-bold text-blue-700">
                        {{ number_format($adv->amount, 2) }} ج.م
                    </td>

                    {{-- المستلم --}}
                    <td class="px-3 py-2 truncate max-w-[120px]" title="{{ $adv->recipient }}">
                        {{ $adv->recipient ?? '-' }}
                    </td>

                    {{-- الحالة --}}
                    <td class="px-3 py-2">
                        @if($adv->status === 'open')
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold">
                                🔴 مفتوحة
                            </span>
                        @else
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">
                                🟢 مغلقة
                            </span>
                        @endif
                    </td>

                    {{-- إدخال البيانات (تكلفة + دفعة إضافية) --}}
                    <td class="px-3 py-2">
                        @if($adv->status === 'open')
                            <form action="{{ route('advances.close', $adv->id) }}" method="POST" class="flex gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="total_cost" placeholder="💰 التكلفة"
                                       class="border rounded-lg px-2 py-1 text-xs w-1/2" required>
                                <input type="number" name="extra_payment" placeholder="➕ دفعة"
                                       class="border rounded-lg px-2 py-1 text-xs w-1/2">
                        @else
                            <span class="text-gray-400 text-xs">لا يوجد</span>
                        @endif
                    </td>

                    {{-- زر التأكيد --}}
                    <td class="px-3 py-2">
                        @if($adv->status === 'open')
                                <button type="submit"
                                        class="bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1 rounded shadow">
                                    ✅
                                </button>
                            </form>
                        @else
                            <span class="text-gray-500 text-xs">✔️ مكتملة</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-3 py-6 text-gray-500 text-center">
                        🚫 لا توجد عُهد مسجلة
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>



    {{-- الباجيناشن --}}
    <div class="mt-6">
        {{ $advances->links() }}
    </div>
</div>
@endsection