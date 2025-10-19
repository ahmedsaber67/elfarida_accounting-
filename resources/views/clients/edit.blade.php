@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-yellow-700">✏️ تعديل بيانات العميل</h2>

    <form method="POST" action="{{ route('clients.update', $client) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-semibold">👤 الاسم</label>
            <input type="text" name="name" class="w-full border rounded p-2" value="{{ $client->name }}" required>
        </div>

        <div>
            <label class="block font-semibold">📞 الهاتف</label>
            <input type="text" name="phone" class="w-full border rounded p-2" value="{{ $client->phone }}">
        </div>

        <div>
            <label class="block font-semibold">🏠 العنوان</label>
            <input type="text" name="address" class="w-full border rounded p-2" value="{{ $client->address }}">
        </div>

        <div>
            <label class="block font-semibold">📝 ملاحظات</label>
            <textarea name="notes" class="w-full border rounded p-2">{{ $client->notes }}</textarea>
        </div>

        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">💾 تحديث</button>
    </form>
</div>
@endsection
