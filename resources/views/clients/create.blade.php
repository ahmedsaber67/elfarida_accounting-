@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-blue-700">➕ إضافة عميل جديد</h2>

    <form method="POST" action="{{ route('clients.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block font-semibold">👤 الاسم</label>
            <input type="text" name="name" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-semibold">📞 الهاتف</label>
            <input type="text" name="phone" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-semibold">🏠 العنوان</label>
            <input type="text" name="address" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-semibold">📝 ملاحظات</label>
            <textarea name="notes" class="w-full border rounded p-2"></textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">💾 حفظ</button>
    </form>
</div>
@endsection
