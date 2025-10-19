@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-blue-700">➕ إضافة مصروف جديد</h2>

    <form method="POST" action="{{ route('expenses.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block font-semibold">الوصف</label>
            <input type="text" name="description" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-semibold">المبلغ</label>
            <input type="number" name="amount" step="any" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-semibold">التاريخ</label>
            <input type="date" name="date" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-semibold">الفئة</label>
            <select name="category" class="w-full border rounded p-2" required>
                <option value="rent">🏢 إيجار</option>
                <option value="salaries">👨‍💼 مرتبات</option>
                <option value="maintenance">🛠️ صيانة</option>
                <option value="other">📌 أخرى</option>
            </select>
        </div>

        <div>
            <label class="block font-semibold">ملاحظات</label>
            <textarea name="notes" class="w-full border rounded p-2"></textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            💾 حفظ
        </button>
    </form>
</div>
@endsection
