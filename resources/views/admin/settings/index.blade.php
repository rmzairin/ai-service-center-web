<x-admin-layout :title="'Pengaturan'" :eyebrow="'Konfigurasi sistem'">

    <div style="max-width: 640px;">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf

            {{-- Chatbot --}}
            <div class="surface" style="padding: 24px; margin-bottom: 16px;">
                <p style="color: #9CA3AF; font-size: 11px; margin: 0 0 4px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em;">Chatbot</p>
                <p style="color: #FAFBFC; font-size: 15px; font-weight: 600; margin: 0 0 20px;">Identitas & Pesan</p>

                <div style="margin-bottom: 16px;">
                    <label class="field-label">Nama Chatbot</label>
                    <input type="text" name="bot_name" value="{{ $settings['bot_name'] ?? '' }}" placeholder="Contoh: AI Service Center" required>
                    @error('bot_name')
                        <p style="color: #F0A8A8; font-size: 12px; margin-top: 5px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="field-label">Pesan Sambutan</label>
                    <textarea name="welcome_message" rows="3" placeholder="Pesan yang muncul saat user pertama kali buka chat...">{{ $settings['welcome_message'] ?? '' }}</textarea>
                    @error('welcome_message')
                        <p style="color: #F0A8A8; font-size: 12px; margin-top: 5px;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="field-label">Model AI</label>
                    <select name="ai_model">
                        <option value="rag-keyword-v1" {{ ($settings['ai_model'] ?? '') === 'rag-keyword-v1' ? 'selected' : '' }}>
                            RAG Keyword Matching v1
                        </option>
                        <option value="rag-keyword-kb-v1" {{ ($settings['ai_model'] ?? '') === 'rag-keyword-kb-v1' ? 'selected' : '' }}>
                            RAG Knowledge Base v1
                        </option>
                    </select>
                </div>
            </div>

            {{-- Session --}}
            <div class="surface" style="padding: 24px; margin-bottom: 16px;">
                <p style="color: #9CA3AF; font-size: 11px; margin: 0 0 4px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em;">Sesi</p>
                <p style="color: #FAFBFC; font-size: 15px; font-weight: 600; margin: 0 0 20px;">Batas & Durasi</p>

                <div>
                    <label class="field-label">Maksimal Sesi Aktif per User</label>
                    <input type="number" name="max_session" value="{{ $settings['max_session'] ?? 10 }}" min="1" max="100" required>
                    <p style="color: #6B7280; font-size: 12px; margin-top: 5px;">Jumlah maksimal sesi chat aktif yang diizinkan per user.</p>
                </div>
            </div>

            {{-- Kontak --}}
            <div class="surface" style="padding: 24px; margin-bottom: 20px;">
                <p style="color: #9CA3AF; font-size: 11px; margin: 0 0 4px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em;">Kontak</p>
                <p style="color: #FAFBFC; font-size: 15px; font-weight: 600; margin: 0 0 20px;">Info Tim</p>

                <div style="margin-bottom: 16px;">
                    <label class="field-label">Email Kontak</label>
                    <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" placeholder="admin@example.com">
                </div>

                <div>
                    <label class="field-label">Nomor Telepon</label>
                    <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" placeholder="08123456789">
                </div>
            </div>

            <button type="submit" class="btn-primary">
                <i class="ti ti-device-floppy"></i>
                Simpan Pengaturan
            </button>
        </form>
    </div>

</x-admin-layout>