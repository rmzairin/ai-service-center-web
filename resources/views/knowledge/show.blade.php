<x-admin-layout :title="'Detail Knowledge'" :eyebrow="'Knowledge base'">

    <x-slot name="topbarAction">
        <a href="{{ route('admin.knowledge.index') }}" class="btn-secondary">
            <svg aria-hidden="true" style="width: 15px; height: 15px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Daftar
        </a>
    </x-slot>

    <div class="form-shell">
        <div class="surface form-card">

            <div class="form-card-head detail-head">
                <div>
                    <p class="form-eyebrow">{{ $item->category->category_name ?? 'Tanpa kategori' }}</p>
                    <h3 class="form-title">{{ $item->question }}</h3>
                </div>
                @if($item->status === 'active')
                    <span class="badge badge-active"><span class="badge-dot"></span>Aktif</span>
                @else
                    <span class="badge badge-inactive"><span class="badge-dot badge-dot--off"></span>Nonaktif</span>
                @endif
            </div>

            <div class="detail-body">
                <div class="detail-field">
                    <p class="detail-label">Jawaban</p>
                    <p class="detail-value detail-value--block">{{ $item->answer }}</p>
                </div>

                <div class="detail-field">
                    <p class="detail-label">Keywords</p>
                    @if($item->keywords)
                        <div class="keyword-list">
                            @foreach(explode(',', $item->keywords) as $kw)
                                <span class="keyword-chip">{{ trim($kw) }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="detail-value detail-value--muted">Belum ada keyword.</p>
                    @endif
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.knowledge.index') }}" class="btn-secondary">Kembali</a>
                <a href="{{ route('admin.knowledge.edit', $item->id) }}" class="btn-primary">
                    <svg aria-hidden="true" style="width: 15px; height: 15px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/></svg>
                    Edit Knowledge
                </a>
            </div>
        </div>
    </div>

    <style>
        .form-shell { max-width: 720px; }

        .form-card { padding: 0; overflow: hidden; }
        .form-card-head {
            padding: 22px 26px 18px;
            border-bottom: 1px solid #3D424C;
        }
        .detail-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 14px;
        }
        .form-eyebrow {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #4FE6AB;
            margin: 0 0 6px;
        }
        .form-title {
            font-size: 17px;
            font-weight: 600;
            color: #F5F6F8;
            margin: 0;
            line-height: 1.4;
        }

        .detail-body {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 22px 26px;
        }
        .detail-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #8B92A0;
            margin: 0 0 8px;
        }
        .detail-value {
            font-size: 14px;
            color: #D7DAE0;
            margin: 0;
            line-height: 1.6;
        }
        .detail-value--block {
            white-space: pre-line;
            background: #2B2F38;
            border: 1px solid #3D424C;
            border-radius: 8px;
            padding: 14px 16px;
        }
        .detail-value--muted { color: #6B7280; }

        .keyword-list {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }
        .keyword-chip {
            background: rgba(139, 146, 160, 0.16);
            color: #C4C9D2;
            font-size: 12px;
            font-weight: 500;
            padding: 4px 11px;
            border-radius: 20px;
            font-family: 'JetBrains Mono', monospace;
        }

        .badge-dot {
            width: 5px; height: 5px; border-radius: 50%;
            background: #4FE6AB; margin-right: 6px;
            box-shadow: 0 0 6px rgba(61, 220, 156, 0.7);
            display: inline-block;
        }
        .badge-dot--off { background: #8B92A0; box-shadow: none; }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            border-top: 1px solid #3D424C;
            padding: 18px 26px;
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #3A3F49;
            border: 1px solid #454A54;
            color: #C4C9D2;
            border-radius: 8px;
            padding: 9px 16px;
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            transition: background 0.12s ease, color 0.12s ease, border-color 0.12s ease;
        }
        .btn-secondary:hover { background: #3D424C; color: #F5F6F8; border-color: #565C68; }

        @media (max-width: 600px) {
            .detail-head { flex-direction: column; }
            .form-actions { flex-direction: column-reverse; }
            .form-actions .btn-primary, .form-actions .btn-secondary { justify-content: center; }
        }
    </style>

</x-admin-layout>