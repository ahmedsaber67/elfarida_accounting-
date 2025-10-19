@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl p-6">
    <h2 class="text-2xl font-bold text-yellow-700 mb-6">✏️ تعديل الوحدة</h2>

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

    <form action="{{ route('units.update', $unit) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- اسم الوحدة --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">اسم الوحدة</label>
            <input type="text" name="name" value="{{ old('name', $unit->name) }}" 
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        {{-- السعر --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">السعر الكلي</label>
            <input type="number" step="0.01" name="total_price" value="{{ old('total_price', $unit->total_price) }}" 
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        {{-- الحالة --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">الحالة</label>
            <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="idle" {{ $unit->status == 'idle' ? 'selected' : '' }}>متاحة</option>
                <option value="reserved" {{ $unit->status == 'reserved' ? 'selected' : '' }}>محجوزة</option>
                <option value="reserved_with_deposit" {{ $unit->status == 'reserved_with_deposit' ? 'selected' : '' }}>محجوزة بدفعة</option>
                <option value="sold" {{ $unit->status == 'sold' ? 'selected' : '' }}>مباعة</option>
            </select>
        </div>

        <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 rounded-xl shadow-md transition">
            💾 تحديث الوحدة
        </button>
    </form>
</div>
@endsection
