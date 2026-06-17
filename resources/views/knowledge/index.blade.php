<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Knowledge Base
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Header: Search, Filter, Tambah --}}
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <div class="flex flex-wrap justify-between items-center gap-4 mb-4">
                    <form method="GET" action="{{ route('knowledge.index') }}" class="flex gap-2 flex-1">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari pertanyaan/jawaban/keyword..." 
                               class="flex-1 border-gray-300 rounded-md shadow-sm text-sm">

                        <select name="category_id" class="border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->category_name }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                            Cari
                        </button>
                    </form>

                    <a href="{{ route('knowledge.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700 whitespace-nowrap">
                        + Tambah Knowledge
                    </a>
                </div>

                {{-- Tabel --}}
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-3 py-2">Pertanyaan</th>
                            <th class="px-3 py-2">Kategori</th>
                            <th class="px-3 py-2">Status</th>
                            <th class="px-3 py-2 w-48">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($knowledge as $item)
                            <tr class="border-b">
                                <td class="px-3 py-2">
                                    <a href="{{ route('knowledge.show', $item->id) }}" class="text-indigo-600 hover:underline">
                                        {{ Str::limit($item->question, 60) }}
                                    </a>
                                </td>
                                <td class="px-3 py-2">{{ $item->category->category_name ?? '-' }}</td>
                                <td class="px-3 py-2">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $item->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 space-x-2">
                                    <a href="{{ route('knowledge.edit', $item->id) }}" class="text-blue-600 hover:underline">Edit</a>

                                    <form action="{{ route('knowledge.toggle', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-yellow-600 hover:underline">
                                            {{ $item->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('knowledge.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-4 text-center text-gray-500">Belum ada data knowledge.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $knowledge->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>