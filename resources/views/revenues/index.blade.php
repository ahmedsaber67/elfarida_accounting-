@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto bg-white shadow-xl rounded-2xl p-6 animate-fadeIn">
    {{-- العنوان وزرار الإضافة --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-extrabold text-blue-700 tracking-wide">📊 قائمة الإيرادات</h2>
        <a href="{{ route('revenues.create') }}"
           class="bg-green-700 hover:bg-green-700 transition-all duration-200 text-white px-5 py-2.5 rounded-xl shadow-lg font-semibold transform hover:scale-105">
            ➕ إضافة إيراد جديد
        </a>
    </div>

    {{-- رسائل النجاح --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow-sm animate-bounce">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- فورم الفلترة --}}
    <div class="bg-blue-50 shadow-md rounded-xl p-5 mb-6">
        <form method="GET" action="{{ route('revenues.index') }}" class="flex flex-wrap items-end gap-4">
            {{-- كلمة بحث --}}
            <div>
                <label for="search" class="block text-blue-800 font-semibold mb-1">🔎 بحث</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       class="border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 w-64"
                       placeholder="ابحث بالوصف، الملاحظات أو المبلغ">
            </div>

            {{-- الشهر --}}
            <div>
                <label for="month" class="block text-blue-800 font-semibold mb-1">📅 الشهر</label>
                <select name="month" id="month" class="border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500">
                    <option value="">-- الكل --</option>
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            {{-- السنة --}}
            <div>
                <label for="year" class="block text-blue-800 font-semibold mb-1">🗓️ السنة</label>
                <select name="year" id="year" class="border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500">
                    <option value="">-- الكل --</option>
                    @for ($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            {{-- أزرار --}}
            <div class="flex gap-2">
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 transition-all duration-200 text-white font-bold py-2.5 px-4 rounded-lg shadow-md transform hover:scale-105">
                    🔍 تطبيق الفلترة
                </button>
                <a href="{{ route('revenues.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 transition-all duration-200 text-white font-bold py-2.5 px-4 rounded-lg shadow-md transform hover:scale-105">
                    ♻️ إعادة تعيين
                </a>
            </div>
        </form>
    </div>

    {{-- جدول الإيرادات --}}
    <div class="overflow-x-auto rounded-xl shadow-md">
        <table class="w-full border border-gray-200 text-center">
            <thead class="bg-blue-700 text-white">
                <tr>
                    <th class="px-4 py-3">الوصف</th>
                    <th class="px-4 py-3">المبلغ</th>
                    <th class="px-4 py-3">التاريخ</th>
                    <th class="px-4 py-3">النوع</th>
                    <th class="px-4 py-3">ملاحظات</th>
                    <th class="px-4 py-3">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($revenues as $revenue)
                    <tr class="border-b hover:bg-blue-50 transition duration-150">
                        <td class="px-4 py-3">{{ $revenue->description }}</td>
                        <td class="px-4 py-3 font-bold text-green-600">{{ number_format($revenue->amount) }} ج.م</td>
                        <td class="px-4 py-3">{{ $revenue->date->format('Y-m-d') }}</td>
                        <td class="px-4 py-3">
                            @if($revenue->source_type === 'installment')
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">💳 قسط</span>
                            @elseif($revenue->source_type === 'sale')
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">🏠 مقدم</span>
                            @else
                                <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-semibold">➕ أخرى</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $revenue->notes ?? '-' }}</td>
                        <td>
                            <a href="{{ route('revenues.edit', $revenue->id) }}"
                               class="bg-yellow-400 hover:bg-yellow-700 transition duration-200 text-white px-3 py-1 rounded-lg shadow-sm transform hover:scale-105">
                                ✏️ تعديل
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-gray-500">🚫 لا توجد إيرادات مسجلة</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- الباجيناشن --}}
    <div class="mt-6">
        {{ $revenues->links() }}
    </div>
</div>
@endsection
