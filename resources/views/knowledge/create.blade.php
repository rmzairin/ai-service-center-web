<x-admin-layout :title="'Tambah Knowledge'" :eyebrow="'Knowledge base'">

    <x-slot name="topbarAction">
        <a href="{{ route('admin.knowledge.index') }}" class="btn-secondary">
            <svg aria-hidden="true" style="width: 15px; height: 15px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Daftar
        </a>
    </x-slot>

    <div class="form-shell">
        <div class="surface form-card">

            <div class="form-card-head">
                <p class="form-eyebrow">Knowledge baru</p>
                <h3 class="form-title">Detail pertanyaan & jawaban</h3>
                <p class="form-sub">Entri ini akan digunakan AI Service Center untuk menjawab pertanyaan pengguna secara otomatis.</p>
            </div>

            <form action="{{ route('admin.knowledge.store') }}" method="POST" class="form-grid">
                @csrf

                <div class="form-field">
                    <label class="field-label">Kategori</label>
                    <select name="category_id" required>
                        <option value="">— Pilih Kategori —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label class="field-label">Pertanyaan</label>
                    <textarea name="question" rows="2" placeholder="Tulis pertanyaan yang sering ditanyakan pengguna..." required>{{ old('question') }}</textarea>
                    @error('question')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label class="field-label">Jawaban</label>
                    <textarea name="answer" rows="5" placeholder="Tulis jawaban yang akan ditampilkan ke pengguna..." required>{{ old('answer') }}</textarea>
                    @error('answer')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label class="field-label">
                        Keywords
                        <span class="field-hint">pisahkan dengan koma</span>
                    </label>
                    <input type="text" name="keywords" value="{{ old('keywords') }}" placeholder="contoh: login, password, akun">
                    @error('keywords')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label class="field-label">Status</label>
                    <div class="status-pick">
                        <label class="status-option">
                            <input type="radio" name="status" value="active" checked>
                            <span class="status-pill status-pill--active">
                                <span class="badge-dot"></span> Aktif
                            </span>
                        </label>
                        <label class="status-option">
                            <input type="radio" name="status" value="inactive">
                            <span class="status-pill status-pill--inactive">
                                <span class="badge-dot badge-dot--off"></span> Nonaktif
                            </span>
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.knowledge.index') }}" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">
                        <svg aria-hidden="true" style="width: 15px; height: 15px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Simpan Knowledge
                    </button>
                </div>
            </form>
        </div>
    </div>


</x-admin-layout>