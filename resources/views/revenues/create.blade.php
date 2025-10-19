@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-xl p-6">
    <h2 class="text-2xl font-bold text-blue-700 mb-6">➕ إضافة إيراد جديد</h2>

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

    <form action="{{ route('revenues.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-gray-700 font-semibold mb-2">💰 المبلغ</label>
            <input type="number" name="amount" step="0.01" class="w-full border-gray-300 rounded-lg" required>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">📅 التاريخ</label>
            <input type="date" name="date" class="w-full border-gray-300 rounded-lg" required>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">📝 الملاحظات</label>
            <textarea name="notes" rows="3" class="w-full border-gray-300 rounded-lg"></textarea>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl">
            ✅ حفظ الإيراد
        </button>
    </form>
</div>
@endsection
