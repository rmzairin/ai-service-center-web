<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Knowledge
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">

                <form action="{{ route('knowledge.update', $item->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $item->category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                        <textarea name="question" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ $item->question }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jawaban</label>
                        <textarea name="answer" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ $item->answer }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Keywords (pisahkan dengan koma)</label>
                        <input type="text" name="keywords" value="{{ $item->keywords }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="active" {{ $item->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $item->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Update
                        </button>
                        <a href="{{ route('knowledge.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>