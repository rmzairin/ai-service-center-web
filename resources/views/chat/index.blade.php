<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Chat
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">

                <div class="chat-box border rounded p-3 mb-4" style="height: 400px; overflow-y: auto;" id="chat-box">
                    @foreach($messages as $msg)
                        <div class="mb-2 {{ $msg->sender_type === 'user' ? 'text-right' : 'text-left' }}">
                            <span class="text-xs font-semibold px-2 py-1 rounded
                                {{ $msg->sender_type === 'user' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $msg->sender_type }}
                            </span>
                            <p class="mt-1">{{ $msg->message }}</p>
                        </div>
                    @endforeach
                </div>

                <form id="chat-form" class="flex gap-2">
                    @csrf
                    <input type="hidden" name="session_id" value="{{ $session->id }}">
                    <input type="text" name="message" id="message" 
                           class="flex-1 border-gray-300 rounded-md shadow-sm" 
                           placeholder="Ketik pesan..." required>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Kirim
                    </button>
                </form>

            </div>
        </div>
    </div>

    <script>
    document.getElementById('chat-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const message = document.getElementById('message').value;
        const sessionId = document.querySelector('[name="session_id"]').value;
        const chatBox = document.getElementById('chat-box');

        fetch('{{ route("chat.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
            },
            body: JSON.stringify({ session_id: sessionId, message: message })
        })
        .then(res => res.json())
        .then(data => {
            chatBox.innerHTML += `
                <div class="mb-2 text-right">
                    <span class="text-xs font-semibold px-2 py-1 rounded bg-blue-100 text-blue-800">user</span>
                    <p class="mt-1">${data.user_message.message}</p>
                </div>
                <div class="mb-2 text-left">
                    <span class="text-xs font-semibold px-2 py-1 rounded bg-gray-100 text-gray-800">bot</span>
                    <p class="mt-1">${data.bot_message.message}</p>
                </div>
            `;
            chatBox.scrollTop = chatBox.scrollHeight;
            document.getElementById('message').value = '';
        });
    });
    </script>
</x-app-layout>