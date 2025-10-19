@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-lg rounded-2xl p-6">
    <h2 class="text-2xl font-bold text-blue-700 mb-6">👥 قائمة العملاء</h2>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('clients.create') }}" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
        ➕ إضافة عميل جديد
    </a>

    <form method="GET" action="{{ route('clients.index') }}" class="mb-4 flex gap-2">
    <input type="text" name="search" value="{{ request('search') }}" 
           placeholder="🔍 ابحث بالاسم أو الهاتف" 
           class="w-full border rounded-lg p-2">
    <button class="bg-blue-600 text-white px-4 rounded hover:bg-blue-700">بحث</button>
</form>

    <table class="w-full border-collapse">
    <thead>
        <tr class="bg-blue-100 text-blue-800 text-center">
            <th class="px-4 py-3 border">#</th>
            <th class="px-4 py-3 border">👤 الاسم</th>
            <th class="px-4 py-3 border">📞 الهاتف</th>
            <th class="px-4 py-3 border">🏠 العنوان</th>
            <th class="px-4 py-3 border">✏️ تعديل</th>
            <th class="px-4 py-3 border">عرض</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clients as $i => $client)
            <tr class="border-b text-center hover:bg-gray-50">
                <td class="px-4 py-3 border">{{ $i+1 }}</td>
                <td class="px-4 py-3 border font-bold whitespace-nowrap">{{ $client->name }}</td>
                <td class="px-4 py-3 border whitespace-nowrap">{{ $client->phone }}</td>
                <td class="px-4 py-3 border">{{ $client->address }}</td>
                <td class="px-4 py-3 border">
                    <a href="{{ route('clients.edit', $client) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                        ✏️ تعديل
                    </a>
                </td>
                 <td class="px-4 py-3 border">
                    <a href="{{ route('clients.show', $client) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                        عرض 
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

    <div class="mt-4">
        {{ $clients->links() }}
    </div>
</div>
@endsection
