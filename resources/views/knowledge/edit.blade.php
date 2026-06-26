<x-admin-layout :title="'Edit Knowledge'" :eyebrow="'Knowledge base'">

    <x-slot name="topbarAction">
        <a href="{{ route('admin.knowledge.index') }}" class="btn-secondary">
            <svg aria-hidden="true" style="width: 15px; height: 15px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Daftar
        </a>
    </x-slot>

    <div class="form-shell">
        <div class="surface form-card">

            <div class="form-card-head">
                <p class="form-eyebrow">Edit entri</p>
                <h3 class="form-title">{{ Str::limit($item->question, 70) }}</h3>
                <p class="form-sub">Perbarui detail pertanyaan & jawaban ini agar tetap akurat untuk pengguna.</p>
            </div>

            <form action="{{ route('admin.knowledge.update', $item->id) }}" method="POST" class="form-grid">
                @csrf
                @method('PUT')

                <div class="form-field">
                    <label class="field-label">Kategori</label>
                    <select name="category_id" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $item->category_id == $cat->id ? 'selected' : '' }}>
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
                    <textarea name="question" rows="2" required>{{ old('question', $item->question) }}</textarea>
                    @error('question')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label class="field-label">Jawaban</label>
                    <textarea name="answer" rows="5" required>{{ old('answer', $item->answer) }}</textarea>
                    @error('answer')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label class="field-label">
                        Keywords
                        <span class="field-hint">pisahkan dengan koma</span>
                    </label>
                    <input type="text" name="keywords" value="{{ old('keywords', $item->keywords) }}" placeholder="contoh: login, password, akun">
                    @error('keywords')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label class="field-label">Status</label>
                    <div class="status-pick">
                        <label class="status-option">
                            <input type="radio" name="status" value="active" {{ old('status', $item->status) === 'active' ? 'checked' : '' }}>
                            <span class="status-pill status-pill--active">
                                <span class="badge-dot"></span> Aktif
                            </span>
                        </label>
                        <label class="status-option">
                            <input type="radio" name="status" value="inactive" {{ old('status', $item->status) === 'inactive' ? 'checked' : '' }}>
                            <span class="status-pill status-pill--inactive">
                                <span class="badge-dot badge-dot--off"></span> Nonaktif
                            </span>
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.knowledge.index') }}" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">
                        <svg aria-hidden="true" style="width: 15px; height: 15px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Update Knowledge
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>

    </style>

</x-admin-layout>