<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kategori Knowledge
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Notifikasi --}}
            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Form Tambah Kategori --}}
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="font-semibold mb-4">Tambah Kategori Baru</h3>

                <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" name="category_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        @error('category_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Simpan
                    </button>
                </form>
            </div>

            {{-- Tabel Kategori --}}
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="font-semibold mb-4">Daftar Kategori</h3>

                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-3 py-2">Nama Kategori</th>
                            <th class="px-3 py-2">Deskripsi</th>
                            <th class="px-3 py-2 w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr class="border-b">
                                <td class="px-3 py-2">{{ $category->category_name }}</td>
                                <td class="px-3 py-2">{{ $category->description ?? '-' }}</td>
                                <td class="px-3 py-2 space-x-2">
                                    {{-- Tombol Edit --}}
                                    <button type="button"
                                        onclick="document.getElementById('edit-form-{{ $category->id }}').classList.toggle('hidden')"
                                        class="text-blue-600 hover:underline">
                                        Edit
                                    </button>

                                    {{-- Form Hapus --}}
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Form Edit (hidden, toggle dengan JS) --}}
                            <tr id="edit-form-{{ $category->id }}" class="hidden border-b bg-gray-50">
                                <td colspan="3" class="px-3 py-3">
                                    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="category_name" value="{{ $category->category_name }}" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                                        <textarea name="description" rows="2" class="block w-full border-gray-300 rounded-md shadow-sm">{{ $category->description }}</textarea>
                                        <button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded-md text-sm">Update</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-3 py-4 text-center text-gray-500">Belum ada kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>