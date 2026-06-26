<x-admin-layout :title="'Upload Dokumen'" :eyebrow="'Knowledge dari PDF'">

    <div class="surface" style="padding: 28px; max-width: 560px;">

        <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom: 18px;">
                <label class="field-label">Judul Dokumen</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: SOP Layanan Pelanggan 2026" required>
                @error('title')
                    <p style="color: #F0A8A8; font-size: 12.5px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 22px;">
                <label class="field-label">File PDF (maks. 10MB)</label>
                <input type="file" name="file" accept="application/pdf" required
                       style="background: #1C212B; border: 1px solid #3A4250; border-radius: 8px; padding: 10px 12px; color: #EDEFF2; width: 100%;">
                @error('file')
                    <p style="color: #F0A8A8; font-size: 12.5px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn-primary">
                    <i class="ti ti-upload" aria-hidden="true"></i>
                    Upload
                </button>
                <a href="{{ route('admin.documents.index') }}" class="btn-primary" style="background: #2A323E; color: #D7DAE0;">
                    Batal
                </a>
            </div>
        </form>

    </div>

</x-admin-layout>