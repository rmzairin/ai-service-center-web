<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Knowledge
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg space-y-4">

                <div>
                    <span class="text-xs text-gray-500">Kategori</span>
                    <p class="font-medium">{{ $item->category->category_name ?? '-' }}</p>
                </div>

                <div>
                    <span class="text-xs text-gray-500">Pertanyaan</span>
                    <p class="font-medium">{{ $item->question }}</p>
                </div>

                <div>
                    <span class="text-xs text-gray-500">Jawaban</span>
                    <p class="whitespace-pre-line">{{ $item->answer }}</p>
                </div>

                <div>
                    <span class="text-xs text-gray-500">Keywords</span>
                    <p>{{ $item->keywords ?? '-' }}</p>
                </div>

                <div>
                    <span class="text-xs text-gray-500">Status</span>
                    <p>
                        <span class="px-2 py-1 text-xs rounded-full {{ $item->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ $item->status }}
                        </span>
                    </p>
                </div>

                <div class="pt-4">
                    <a href="{{ route('knowledge.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>