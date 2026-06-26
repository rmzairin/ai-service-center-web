<x-admin-layout :title="'Knowledge Base'" :eyebrow="'Pertanyaan & jawaban'">

    <x-slot name="topbarAction">
        <a href="{{ route('admin.knowledge.create') }}" class="btn-primary">
            <svg aria-hidden="true" style="width: 15px; height: 15px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Knowledge
        </a>
    </x-slot>

    @if ($errors->any())
        <div class="alert-error">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Toolbar: Search & Filter --}}
    <div class="surface" style="padding: 16px 20px; margin-bottom: 24px; box-shadow: 0 1px 0 rgba(0,0,0,0.15);">
        <form method="GET" action="{{ route('admin.knowledge.index') }}" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-end;">
            <div style="flex: 1; min-width: 240px;">
                <label class="field-label">Cari</label>
                <div style="position: relative;">
                    <svg aria-hidden="true" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #9CA3AF;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari pertanyaan, jawaban, atau keyword..." style="padding-left: 34px;">
                </div>
            </div>

            <div style="min-width: 200px;">
                <label class="field-label">Kategori</label>
                <select name="category_id">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                            {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-primary" style="height: 39px;">
                <svg aria-hidden="true" style="width: 15px; height: 15px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                Cari
            </button>

            @if($search || $categoryId)
                <a href="{{ route('admin.knowledge.index') }}" class="link-action" style="padding-bottom: 10px;">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Tabel --}}
    <div class="surface" style="overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Pertanyaan</th>
                        <th style="width: 160px;">Kategori</th>
                        <th style="width: 110px;">Status</th>
                        <th style="width: 130px; text-align: right; padding-right: 20px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($knowledge as $item)
                        <tr>
                            <td>
                                <a href="{{ route('admin.knowledge.show', $item->id) }}" class="row-title">
                                    {{ Str::limit($item->question, 60) }}
                                </a>
                            </td>
                            <td>
                                <span class="badge badge-inactive">{{ $item->category->category_name ?? '-' }}</span>
                            </td>
                            <td>
                                @if($item->status === 'active')
                                    <span class="badge badge-active"><span class="badge-dot"></span>Aktif</span>
                                @else
                                    <span class="badge badge-inactive"><span class="badge-dot badge-dot--off"></span>Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-cluster">
                                    <a href="{{ route('admin.knowledge.edit', $item->id) }}" class="icon-btn" title="Edit" aria-label="Edit">
                                        <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 15px; height: 15px;"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/></svg>
                                    </a>

                                    <form action="{{ route('admin.knowledge.toggle', $item->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="icon-btn icon-btn--amber"
                                                title="{{ $item->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                aria-label="{{ $item->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 15px; height: 15px;"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/></svg>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.knowledge.destroy', $item->id) }}" method="POST" id="delete-form-{{ $item->id }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="icon-btn icon-btn--danger icon-btn--danger-solid" title="Hapus" aria-label="Hapus"
                                                onclick="openDeleteModal('delete-form-{{ $item->id }}', {{ Js::from(Str::limit($item->question, 70)) }})">
                                            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 15px; height: 15px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 48px 12px; color: #6B7280;">
                                <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="width: 28px; height: 28px; display: block; margin: 0 auto 10px; color: #4B5563;"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14a9 3 0 0 0 18 0V5"/><path d="M3 12a9 3 0 0 0 18 0"/><line x1="4" y1="4" x2="20" y2="20" stroke="#4B5563"/></svg>
                                <p style="margin: 0 0 4px; color: #9CA3AF; font-weight: 500; font-size: 13.5px;">Belum ada data knowledge</p>
                                <p style="margin: 0; font-size: 12.5px;">Tambahkan entri baru untuk mulai mengisi knowledge base.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($knowledge->hasPages())
            <div class="pager-bar">
                <p class="pager-info">
                    Menampilkan <b>{{ $knowledge->firstItem() }}</b>–<b>{{ $knowledge->lastItem() }}</b> dari <b>{{ $knowledge->total() }}</b> entri
                </p>
                <div class="pager-nav">
                    @if ($knowledge->onFirstPage())
                        <span class="pg-btn pg-btn--disabled">‹ Sebelumnya</span>
                    @else
                        <a href="{{ $knowledge->previousPageUrl() }}" class="pg-btn">‹ Sebelumnya</a>
                    @endif

                    @foreach ($knowledge->getUrlRange(max(1, $knowledge->currentPage() - 2), min($knowledge->lastPage(), $knowledge->currentPage() + 2)) as $page => $url)
                        @if ($page == $knowledge->currentPage())
                            <span class="pg-btn pg-btn--active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pg-btn">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($knowledge->hasMorePages())
                        <a href="{{ $knowledge->nextPageUrl() }}" class="pg-btn">Selanjutnya ›</a>
                    @else
                        <span class="pg-btn pg-btn--disabled">Selanjutnya ›</span>
                    @endif
                </div>
            </div>
        @endif
    </div>

    {{-- Modal konfirmasi hapus (kustom, menggantikan confirm() bawaan browser) --}}
    <div id="delete-modal-backdrop" class="modal-backdrop" hidden>
        <div class="modal-card" role="alertdialog" aria-modal="true" aria-labelledby="delete-modal-title">
            <div class="modal-icon">
                <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px;"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <p id="delete-modal-title" class="modal-title">Hapus knowledge ini?</p>
            <p class="modal-text" id="delete-modal-text"></p>
            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="closeDeleteModal()">Batal</button>
                <button type="button" class="btn-danger" id="delete-modal-confirm">Hapus</button>
            </div>
        </div>
    </div>

    <script>
        let activeDeleteForm = null;

        function openDeleteModal(formId, label) {
            activeDeleteForm = document.getElementById(formId);
            document.getElementById('delete-modal-text').textContent = label
                ? '"' + label + '" akan dihapus permanen dan tidak dapat dikembalikan.'
                : 'Data ini akan dihapus permanen dan tidak dapat dikembalikan.';
            document.getElementById('delete-modal-backdrop').hidden = false;
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal-backdrop').hidden = true;
            activeDeleteForm = null;
        }

        document.getElementById('delete-modal-confirm').addEventListener('click', function () {
            if (activeDeleteForm) {
                activeDeleteForm.submit();
            }
        });

        document.getElementById('delete-modal-backdrop').addEventListener('click', function (e) {
            if (e.target === this) closeDeleteModal();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeDeleteModal();
        });
    </script>

</x-admin-layout>