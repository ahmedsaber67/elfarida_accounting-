@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-lg rounded-2xl p-6">
    <h2 class="text-2xl font-bold text-blue-700 mb-6">🔎 تفاصيل عملية البيع</h2>

    {{-- تفاصيل البيع --}}
    <div class="grid grid-cols-2 gap-6 mb-8">
        <div class="bg-blue-50 p-4 rounded-xl shadow">
            <p class="text-gray-600">👤 العميل</p>
            <p class="text-lg font-bold">{{ $sale->client->name }}</p>
        </div>

        <div class="bg-blue-50 p-4 rounded-xl shadow">
            <p class="text-gray-600">🏠 الوحدة</p>
            <p class="text-lg font-bold">{{ $sale->unit->name }}</p>
        </div>

        <div class="bg-blue-50 p-4 rounded-xl shadow">
            <p class="text-gray-600">💰 السعر الكلي</p>
            <p class="text-lg font-bold">{{ number_format($sale->total_price) }} ج.م</p>
        </div>

        <div class="bg-blue-50 p-4 rounded-xl shadow">
            <p class="text-gray-600">💵 المقدم</p>
            <p class="text-lg font-bold">{{ number_format($sale->down_payment) }} ج.م</p>
        </div>

        <div class="bg-blue-50 p-4 rounded-xl shadow">
            <p class="text-gray-600">📉 المتبقي</p>
            <p class="text-lg font-bold">{{ number_format($sale->remaining_amount) }} ج.م</p>
        </div>

        <div class="bg-blue-50 p-4 rounded-xl shadow">
            <p class="text-gray-600">📅 تاريخ البيع</p>
            <p class="text-lg font-bold">{{ $sale->sale_date->format('Y-m-d') }}</p>
        </div>
    </div>

   <h3 class="text-xl font-bold text-red-600 mb-4">📑 جدول الأقساط</h3>
<div class="overflow-x-auto">
    <table class="w-full border-collapse table-fixed">
        <thead>
            <tr class="bg-gray-200 text-gray-700 text-lg text-center">
                <th class="px-4 py-3 w-16">#</th>
                <th class="px-4 py-3 w-32">💵 المبلغ</th>
                <th class="px-4 py-3 w-40">📅 تاريخ الاستحقاق</th>
                <th class="px-4 py-3 w-32">📌 الحالة</th>
                <th class="px-4 py-3 w-64">📝 الملاحظات</th>
                <th class="px-4 py-3 w-32">✏️ تعديل</th>
                <th class="px-4 py-3 w-32">تأكيد الدفع</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->installments as $index => $installment)
                @php
                    $statusClass = match($installment->status) {
                        'pending' => 'bg-yellow-100 text-yellow-700',
                        'paid'    => 'bg-green-100 text-green-700',
                        'overdue' => 'bg-red-100 text-red-700',
                        default   => 'bg-gray-100 text-gray-700',
                    };
                @endphp
                <tr class="text-lg text-center {{ $statusClass }}" data-id="{{ $installment->id }}">
                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                    <td class="px-4 py-3">{{ number_format($installment->amount) }} ج.م</td>
                    <td class="px-4 py-3">{{ $installment->due_date->format('Y-m-d') }}</td>
                    <td class="px-4 py-3 font-bold">{{ strtoupper($installment->status) }}</td>

                    {{-- الملاحظات + input مخفي --}}
                    <td class="px-4 py-3">
                        <span class="note-text">{{ $installment->notes ?? '-' }}</span>
                        <input type="text" class="note-input hidden w-full border rounded px-2 py-1"
                               value="{{ $installment->notes }}">
                    </td>

                    {{-- زر تعديل --}}
                    <td class="px-4 py-3">
                        <button class="edit-btn px-3 py-1 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                            ✏️
                        </button>
                        <button class="save-btn hidden px-3 py-1 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                            💾
                        </button>
                    </td>
                    <!-- زر تم الدفع  -->
                              <td>
                            @if(in_array($installment->computed_status, ['due', 'overdue']))
                                <form action="{{ route('installments.pay', $installment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                        💵 تم الدفع
                                    </button>
                                </form>
                            @elseif($installment->status === 'paid')
                                <span class="text-green-600 font-bold">✔️ مدفوع</span>
                            @else
                                <span class="text-gray-600">⏳لسا معاده</span>
                            @endif
                        </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Ajax Script --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            let row = this.closest('tr');
            row.querySelector('.note-text').classList.add('hidden');
            row.querySelector('.note-input').classList.remove('hidden');
            row.querySelector('.save-btn').classList.remove('hidden');
            this.classList.add('hidden');
        });
    });

    document.querySelectorAll('.save-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            let row = this.closest('tr');
            let id = row.getAttribute('data-id');
            let newNote = row.querySelector('.note-input').value;

            fetch(`/installments/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ notes: newNote })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    row.querySelector('.note-text').innerText = newNote || '-';
                    row.querySelector('.note-text').classList.remove('hidden');
                    row.querySelector('.note-input').classList.add('hidden');
                    row.querySelector('.save-btn').classList.add('hidden');
                    row.querySelector('.edit-btn').classList.remove('hidden');
                } else {
                    alert('❌ حصل خطأ أثناء الحفظ');
                }
            });
        });
    });
});
</script>
@endsection
