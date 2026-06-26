<x-admin-layout :title="'Detail Dokumen'" :eyebrow="'Knowledge dari PDF'">

    <div class="surface" style="padding: 24px; max-width: 600px;">

        <div style="margin-bottom: 16px;">
            <p class="field-label">Judul</p>
            <p style="color: #EDEFF2; font-weight: 500; margin: 0;">{{ $document->title }}</p>
        </div>

        <div style="margin-bottom: 16px;">
            <p class="field-label">Nama File Asli</p>
            <p style="color: #D7DAE0; margin: 0;">{{ $document->file_name }}</p>
        </div>

        <div style="margin-bottom: 16px;">
            <p class="field-label">Tipe File</p>
            <p style="color: #D7DAE0; margin: 0;">{{ strtoupper($document->file_type) }}</p>
        </div>

        <div style="margin-bottom: 16px;">
            <p class="field-label">Total Halaman</p>
            <p style="color: #D7DAE0; margin: 0;">{{ $document->total_pages ?? 'Belum diproses' }}</p>
        </div>

        <div style="margin-bottom: 16px;">
            <p class="field-label">Status</p>
            <span class="badge {{ $document->status === 'processed' ? 'badge-active' : 'badge-inactive' }}">
                {{ $document->status }}
            </span>
        </div>

        <div style="margin-bottom: 22px;">
            <p class="field-label">Diupload Oleh</p>
            <p style="color: #D7DAE0; margin: 0;">{{ $document->uploader->nama ?? '-' }}</p>
        </div>

        <div style="display: flex; gap: 10px;">
            <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="btn-primary">
                <i class="ti ti-file-text" aria-hidden="true"></i>
                Lihat PDF
            </a>
            <a href="{{ route('admin.documents.index') }}" class="btn-primary" style="background: #2A323E; color: #D7DAE0;">
                Kembali
            </a>
        </div>

    </div>

</x-admin-layout>