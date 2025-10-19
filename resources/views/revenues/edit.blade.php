@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-xl p-6">
    <h2 class="text-2xl font-bold text-yellow-600 mb-6">✏️ تعديل الإيراد</h2>

    <form action="{{ route('revenues.update', $revenue) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700 font-semibold mb-2">💰 المبلغ</label>
            <input type="number" name="amount" step="0.01" value="{{ $revenue->amount }}" class="w-full border-gray-300 rounded-lg" required>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">📅 التاريخ</label>
            <input type="date" name="date" value="{{ $revenue->date->format('Y-m-d') }}" class="w-full border-gray-300 rounded-lg" required>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">📝 الملاحظات</label>
            <textarea name="notes" rows="3" class="w-full border-gray-300 rounded-lg">{{ $revenue->notes }}</textarea>
        </div>

        <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 rounded-xl">
            💾 تحديث الإيراد
        </button>
    </form>
</div>
@endsection
