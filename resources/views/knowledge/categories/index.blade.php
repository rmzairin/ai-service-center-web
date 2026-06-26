<x-admin-layout :title="'Kategori'" :eyebrow="'Knowledge base'">

    <div class="category-shell">

        {{-- Form Tambah --}}
        <div class="surface" style="padding: 24px;">
            <p class="panel-eyebrow">Tambah baru</p>
            <p class="panel-title">Kategori Knowledge</p>

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div style="margin-bottom: 14px;">
                    <label class="field-label">Nama Kategori</label>
                    <input type="text" name="category_name" value="{{ old('category_name') }}"
                           placeholder="Contoh: Layanan Pelanggan"
                           required>
                    @error('category_name')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom: 18px;">
                    <label class="field-label">Deskripsi <span style="color: #6B7280; font-weight: 400;">(opsional)</span></label>
                    <textarea name="description" rows="3"
                              placeholder="Deskripsi singkat kategori ini...">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; justify-content: center;">
                    <svg aria-hidden="true" style="width: 15px; height: 15px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Simpan Kategori
                </button>
            </form>
        </div>

        {{-- Tabel Kategori --}}
        <div class="surface" style="padding: 4px 20px 16px;">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px 0 16px;">
                <div>
                    <p class="panel-eyebrow">Daftar</p>
                    <p class="panel-title" style="margin: 0;">Semua Kategori</p>
                </div>
                <span class="count-chip">
                    {{ $categories->count() }} kategori
                </span>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th style="width: 100px; text-align: right; padding-right: 20px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td style="font-weight: 500; color: #E8E9EC;">
                                {{ $category->category_name }}
                            </td>
                            <td style="color: #9CA3AF;">
                                {{ $category->description ?? '-' }}
                            </td>
                            <td>
                                <div class="action-cluster">
                                    <button type="button"
                                        onclick="toggleEdit({{ $category->id }})"
                                        class="icon-btn" title="Edit" aria-label="Edit">
                                        <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 15px; height: 15px;"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/></svg>
                                    </button>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                          method="POST" style="display: inline;"
                                          onsubmit="return confirm('Yakin hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-btn icon-btn--danger" title="Hapus" aria-label="Hapus">
                                            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 15px; height: 15px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Form Edit --}}
                        <tr id="edit-row-{{ $category->id }}" class="edit-row" style="display: none;">
                            <td colspan="3" style="padding: 16px 12px;">
                                <form action="{{ route('admin.categories.update', $category->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                                        <div>
                                            <label class="field-label">Nama Kategori</label>
                                            <input type="text" name="category_name"
                                                   value="{{ $category->category_name }}" required>
                                        </div>
                                        <div>
                                            <label class="field-label">Deskripsi</label>
                                            <input type="text" name="description"
                                                   value="{{ $category->description }}">
                                        </div>
                                    </div>
                                    <div style="display: flex; gap: 8px;">
                                        <button type="submit" class="btn-primary" style="padding: 7px 14px; font-size: 13px;">
                                            <svg aria-hidden="true" style="width: 14px; height: 14px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                            Simpan
                                        </button>
                                        <button type="button"
                                            onclick="toggleEdit({{ $category->id }})"
                                            class="btn-secondary"
                                            style="padding: 7px 14px; font-size: 13px;">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; color: #6B7280; padding: 40px 12px;">
                                <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="width: 30px; height: 30px; display: block; margin: 0 auto 10px; color: #4B5563;"><path d="M3 7v12a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9L8.5 4.6A2 2 0 0 0 6.83 3.7H5a2 2 0 0 0-2 2Z"/><line x1="3" y1="3" x2="21" y2="21"/></svg>
                                <p style="margin: 0 0 4px; color: #9CA3AF; font-weight: 500; font-size: 13.5px;">Belum ada kategori</p>
                                <p style="margin: 0; font-size: 12.5px;">Tambahkan kategori pertama di form sebelah kiri.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <script>
        function toggleEdit(id) {
            const row = document.getElementById('edit-row-' + id);
            row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
        }
    </script>

</x-admin-layout>