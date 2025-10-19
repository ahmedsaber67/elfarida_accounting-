@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-blue-700">✏️ تعديل مصروف</h2>

    <form method="POST" action="{{ route('expenses.update', $expense) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-semibold">الوصف</label>
            <input type="text" name="description" value="{{ old('description', $expense->description) }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-semibold">المبلغ</label>
            <input type="number" name="amount" step="0.01" value="{{ old('amount', $expense->amount) }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-semibold">التاريخ</label>
            <input type="date" name="date" value="{{ old('date', $expense->date) }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-semibold">الفئة</label>
            <select name="category" class="w-full border rounded p-2" required>
                <option value="rent" {{ $expense->category == 'rent' ? 'selected' : '' }}>🏢 إيجار</option>
                <option value="salaries" {{ $expense->category == 'salaries' ? 'selected' : '' }}>👨‍💼 مرتبات</option>
                <option value="maintenance" {{ $expense->category == 'maintenance' ? 'selected' : '' }}>🛠️ صيانة</option>
                <option value="other" {{ $expense->category == 'other' ? 'selected' : '' }}>📌 أخرى</option>
            </select>
        </div>

        <div>
            <label class="block font-semibold">ملاحظات</label>
            <textarea name="notes" class="w-full border rounded p-2">{{ old('notes', $expense->notes) }}</textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            💾 تحديث
        </button>
    </form>
</div>
@endsection
