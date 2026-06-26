<x-admin-layout :title="'Dokumen'" :eyebrow="'Knowledge dari PDF'">

    <div class="surface" style="padding: 20px; margin-bottom: 20px;">
        <div style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center; justify-content: space-between;">
            <form method="GET" action="{{ route('admin.documents.index') }}" style="display: flex; gap: 8px; flex: 1; min-width: 240px;">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul dokumen..." style="flex: 1;">
                <button type="submit" class="btn-primary" style="background: #2A323E; color: #D7DAE0;">
                    <i class="ti ti-search" aria-hidden="true"></i>
                    Cari
                </button>
            </form>

            <a href="{{ route('admin.documents.create') }}" class="btn-primary">
                <i class="ti ti-upload" aria-hidden="true"></i>
                Upload dokumen
            </a>
        </div>
    </div>

    <div class="surface" style="padding: 4px 20px 12px; overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Nama File</th>
                    <th>Diupload Oleh</th>
                    <th>Status</th>
                    <th style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $doc)
                    <tr>
                        <td>
                            <a href="{{ route('admin.documents.show', $doc->id) }}" style="color: #EDEFF2; text-decoration: none; font-weight: 500;">
                                {{ $doc->title }}
                            </a>
                        </td>
                        <td style="color: #9CA3AF;">{{ $doc->file_name }}</td>
                        <td>{{ $doc->uploader->nama ?? '-' }}</td>
                        <td>
                            @php
                                $badgeClass = match($doc->status) {
                                    'processed' => 'badge-active',
                                    'failed'    => 'badge-inactive',
                                    default     => 'badge-inactive',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $doc->status }}</span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 12px; align-items: center;">
                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="link-action">Lihat</a>

                                <form action="{{ route('admin.documents.destroy', $doc->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin hapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="link-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #6B7280; padding: 32px 12px;">
                            Belum ada dokumen yang diupload.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 16px;">
        {{ $documents->links() }}
    </div>

</x-admin-layout>