<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin' }} · AI Service Center</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/@tabler/icons-webfont/3.31.0/tabler-icons.min.css">
    @vite('resources/css/app.css')
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #1C212B;
            color: #EDEFF2;
        }
        .shell {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 252px;
            flex-shrink: 0;
            background: #20262F;
            border-right: 1px solid #323A47;
            display: flex;
            flex-direction: column;
            padding: 22px 16px;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 0 8px 22px;
            margin-bottom: 18px;
            border-bottom: 1px solid #323A47;
        }
        .brand-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #3DDC9C;
            box-shadow: 0 0 0 0 rgba(61, 220, 156, 0.5);
            animation: pulse 2.2s ease-out infinite;
            flex-shrink: 0;
        }
        @keyframes pulse {
            0%   { box-shadow: 0 0 0 0 rgba(61, 220, 156, 0.45); }
            70%  { box-shadow: 0 0 0 7px rgba(61, 220, 156, 0); }
            100% { box-shadow: 0 0 0 0 rgba(61, 220, 156, 0); }
        }
        .brand-text {
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            color: #B8BFCB;
            letter-spacing: 0.01em;
        }
        .brand-text b { color: #FAFBFC; font-weight: 500; }

        .nav-group { margin-bottom: 20px; }
        .nav-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10.5px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #6B7280;
            padding: 0 10px;
            margin: 0 0 8px;
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 9px 10px;
            border-radius: 8px;
            color: #B8BFCB;
            font-size: 13.5px;
            font-weight: 500;
            text-decoration: none;
            margin-bottom: 2px;
            transition: background 0.12s ease, color 0.12s ease;
        }
        .nav-link i { font-size: 17px; flex-shrink: 0; }
        .nav-link:hover {
            background: #2A323E;
            color: #FAFBFC;
        }
        .nav-link.active {
            background: rgba(61, 220, 156, 0.14);
            color: #4FE6AB;
        }
        .nav-link.active i { color: #4FE6AB; }

        .sidebar-foot {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid #323A47;
        }
        .admin-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 8px;
            margin-bottom: 8px;
        }
        .admin-avatar {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: #213830;
            color: #4FE6AB;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12.5px;
            font-weight: 600;
            font-family: 'JetBrains Mono', monospace;
            flex-shrink: 0;
        }
        .admin-meta p { margin: 0; line-height: 1.35; }
        .admin-name { font-size: 13px; font-weight: 500; color: #EDEFF2; }
        .admin-role {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10.5px;
            color: #7C8492;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .logout-btn {
            width: 100%;
            background: transparent;
            border: 1px solid #3A4250;
            color: #B8BFCB;
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: border-color 0.12s ease, color 0.12s ease;
        }
        .logout-btn:hover { border-color: #D95959; color: #F0A8A8; }

        .main {
            flex: 1;
            min-width: 0;
            background: #1C212B;
        }
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 32px;
            border-bottom: 1px solid #2B3340;
            background: #20262F;
        }
        .topbar-eyebrow {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #6B7280;
            margin: 0 0 4px;
        }
        .topbar h1 {
            font-size: 19px;
            font-weight: 600;
            margin: 0;
            color: #FAFBFC;
            letter-spacing: -0.01em;
        }
        .content { padding: 28px 32px 48px; }

        .surface {
            background: #242B36;
            border: 1px solid #323A47;
            border-radius: 12px;
        }
        .btn-primary {
            background: #3DDC9C;
            color: #0B2C20;
            border: none;
            border-radius: 8px;
            padding: 9px 16px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background 0.15s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-primary:hover { background: #4FE6AB; }

        label.field-label {
            display: block;
            font-size: 12.5px;
            font-weight: 500;
            color: #9CA3AF;
            margin-bottom: 7px;
        }
        input[type="text"], input[type="email"], input[type="password"], textarea, select {
            width: 100%;
            background: #1C212B;
            border: 1px solid #3A4250;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            color: #EDEFF2;
            font-family: 'Inter', sans-serif;
        }
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #3DDC9C;
            box-shadow: 0 0 0 3px rgba(61, 220, 156, 0.12);
        }

        table.data-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
        table.data-table th {
            text-align: left;
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #7C8492;
            padding: 10px 12px;
            border-bottom: 1px solid #323A47;
        }
        table.data-table td {
            padding: 12px;
            border-bottom: 1px solid #2A323E;
            color: #D7DAE0;
        }
        table.data-table tr:last-child td { border-bottom: none; }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 500;
        }
        .badge-active { background: rgba(61, 220, 156, 0.14); color: #4FE6AB; }
        .badge-inactive { background: rgba(124, 132, 146, 0.16); color: #9CA3AF; }

        .alert-success {
            background: rgba(61, 220, 156, 0.1);
            border: 1px solid rgba(61, 220, 156, 0.3);
            border-radius: 8px;
            padding: 11px 14px;
            color: #4FE6AB;
            font-size: 13.5px;
            margin-bottom: 20px;
        }
        .alert-error {
            background: rgba(217, 89, 89, 0.1);
            border: 1px solid rgba(217, 89, 89, 0.3);
            border-radius: 8px;
            padding: 11px 14px;
            color: #F0A8A8;
            font-size: 13px;
            margin-bottom: 16px;
        }
        a.link-action { color: #5FA8E8; text-decoration: none; font-size: 13px; font-weight: 500; }
        a.link-action:hover { text-decoration: underline; }
        a.link-danger { color: #E08585; text-decoration: none; font-size: 13px; font-weight: 500; }
        a.link-danger:hover { text-decoration: underline; }
        button.link-danger { background: none; border: none; cursor: pointer; padding: 0; }


                        /* ---------- Table refinements ---------- */
        .row-title {
            color: #E8E9EC;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.12s ease;
        }
        .row-title:hover { color: #4FE6AB; }

        .badge-dot {
            width: 5px; height: 5px; border-radius: 50%;
            background: #4FE6AB; margin-right: 6px;
            box-shadow: 0 0 6px rgba(61, 220, 156, 0.7);
        }
        .badge-dot--off { background: #8B92A0; box-shadow: none; }

        /* ---------- Icon action buttons ---------- */
        .action-cluster {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
        }
        .icon-btn {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #3A3F49;
            border: 1px solid #454A54;
            color: #ABB1BD;
            cursor: pointer;
            text-decoration: none;
            font-size: 14.5px;
            transition: background 0.12s ease, color 0.12s ease, border-color 0.12s ease, box-shadow 0.12s ease;
            padding: 0;
        }
        .icon-btn:hover {
            background: #3D424C;
            color: #F5F6F8;
            border-color: #565C68;
        }
        .icon-btn--amber:hover {
            color: #F0C285;
            border-color: rgba(240, 194, 133, 0.4);
            box-shadow: 0 0 0 3px rgba(240, 194, 133, 0.08);
        }
        .icon-btn--danger:hover {
            color: #F0A8A8;
            border-color: rgba(217, 89, 89, 0.4);
            box-shadow: 0 0 0 3px rgba(217, 89, 89, 0.08);
        }

        /* ---------- Pagination bar ---------- */
        .pager-bar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 20px;
            border-top: 1px solid #3D424C;
        }
        .pager-info {
            margin: 0;
            font-size: 12.5px;
            color: #8B92A0;
        }
        .pager-info b { color: #D7DAE0; font-weight: 600; }

        .pager-nav {
            display: flex;
            align-items: center;
            gap: 4px;
            flex-wrap: wrap;
        }
        .pg-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 10px;
            border-radius: 8px;
            background: #3A3F49;
            border: 1px solid #454A54;
            color: #ABB1BD;
            font-family: 'JetBrains Mono', monospace;
            font-size: 12.5px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.12s ease, color 0.12s ease, border-color 0.12s ease;
        }
        a.pg-btn:hover {
            background: #3D424C;
            color: #F5F6F8;
            border-color: #565C68;
        }
        .pg-btn--active {
            background: #3DDC9C;
            border-color: #3DDC9C;
            color: #0B2C20;
            font-weight: 600;
        }
        .pg-btn--disabled {
            opacity: 0.35;
            cursor: default;
        }

        @media (max-width: 560px) {
            .pager-bar { flex-direction: column; align-items: flex-start; }
            .pager-nav { justify-content: flex-start; }
        }


                .form-shell { max-width: 720px; }

        .form-card { padding: 0; overflow: hidden; }
        .form-card-head {
            padding: 22px 26px 18px;
            border-bottom: 1px solid #3D424C;
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
            margin: 0 0 6px;
        }
        .form-sub {
            font-size: 12.5px;
            color: #8B92A0;
            margin: 0;
            line-height: 1.5;
        }

        .form-grid {
            display: flex;
            flex-direction: column;
            gap: 18px;
            padding: 22px 26px 26px;
        }
        .form-field { display: flex; flex-direction: column; }
        .field-hint {
            font-weight: 400;
            color: #6B7280;
            text-transform: none;
            letter-spacing: 0;
            font-size: 12px;
            margin-left: 6px;
        }
        textarea { resize: vertical; font-family: 'Inter', sans-serif; line-height: 1.5; }
        .field-error {
            margin: 6px 0 0;
            font-size: 12.5px;
            color: #F0A8A8;
        }

        .status-pick { display: flex; gap: 10px; }
        .status-option input { position: absolute; opacity: 0; pointer-events: none; }
        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 7px 14px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 500;
            border: 1px solid #454A54;
            background: #3A3F49;
            color: #8B92A0;
            cursor: pointer;
            transition: border-color 0.12s ease, color 0.12s ease, box-shadow 0.12s ease, background 0.12s ease;
        }
        .status-option input:checked + .status-pill--active {
            background: rgba(61, 220, 156, 0.14);
            border-color: rgba(61, 220, 156, 0.5);
            color: #4FE6AB;
            box-shadow: 0 0 0 3px rgba(61, 220, 156, 0.1);
        }
        .status-option input:checked + .status-pill--inactive {
            background: rgba(139, 146, 160, 0.16);
            border-color: #6B7280;
            color: #D7DAE0;
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
            padding-top: 6px;
            border-top: 1px solid #3D424C;
            margin-top: 4px;
            padding-top: 18px;
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
            .status-pick { flex-wrap: wrap; }
            .form-actions { flex-direction: column-reverse; }
            .form-actions .btn-primary, .form-actions .btn-secondary { justify-content: center; }
        }

                .category-shell {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 20px;
            align-items: start;
        }
        @media (max-width: 860px) {
            .category-shell { grid-template-columns: 1fr; }
        }

        .panel-eyebrow {
            color: #8B92A0;
            font-size: 11px;
            margin: 0 0 4px;
            font-family: 'JetBrains Mono', monospace;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .panel-title {
            color: #F5F6F8;
            font-size: 15px;
            font-weight: 600;
            margin: 0 0 20px;
        }

        .field-error {
            color: #F0A8A8;
            font-size: 12px;
            margin-top: 5px;
        }

        .count-chip {
            background: rgba(61, 220, 156, 0.14);
            color: #4FE6AB;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            font-family: 'JetBrains Mono', monospace;
        }

        .edit-row td { background: #2B2F38; border-bottom: 1px solid #3D424C; }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #3A3F49;
            border: 1px solid #454A54;
            color: #C4C9D2;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.12s ease, color 0.12s ease, border-color 0.12s ease;
        }
        .btn-secondary:hover { background: #3D424C; color: #F5F6F8; border-color: #565C68; }

        .action-cluster {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
        }
        .icon-btn {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #3A3F49;
            border: 1px solid #454A54;
            color: #ABB1BD;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.12s ease, color 0.12s ease, border-color 0.12s ease, box-shadow 0.12s ease;
            padding: 0;
        }
        .icon-btn:hover {
            background: #3D424C;
            color: #F5F6F8;
            border-color: #565C68;
        }
        .icon-btn--danger:hover {
            color: #F0A8A8;
            border-color: rgba(217, 89, 89, 0.4);
            box-shadow: 0 0 0 3px rgba(217, 89, 89, 0.08);
        }

                .form-shell { max-width: 720px; }

        .form-card { padding: 0; overflow: hidden; }
        .form-card-head {
            padding: 22px 26px 18px;
            border-bottom: 1px solid #3D424C;
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
            margin: 0 0 6px;
        }
        .form-sub {
            font-size: 12.5px;
            color: #8B92A0;
            margin: 0;
            line-height: 1.5;
        }

        .form-grid {
            display: flex;
            flex-direction: column;
            gap: 18px;
            padding: 22px 26px 26px;
        }
        .form-field { display: flex; flex-direction: column; }
        .field-hint {
            font-weight: 400;
            color: #6B7280;
            text-transform: none;
            letter-spacing: 0;
            font-size: 12px;
            margin-left: 6px;
        }
        textarea { resize: vertical; font-family: 'Inter', sans-serif; line-height: 1.5; }
        .field-error {
            margin: 6px 0 0;
            font-size: 12.5px;
            color: #F0A8A8;
        }

        .status-pick { display: flex; gap: 10px; }
        .status-option input { position: absolute; opacity: 0; pointer-events: none; }
        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 7px 14px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 500;
            border: 1px solid #454A54;
            background: #3A3F49;
            color: #8B92A0;
            cursor: pointer;
            transition: border-color 0.12s ease, color 0.12s ease, box-shadow 0.12s ease, background 0.12s ease;
        }
        .status-option input:checked + .status-pill--active {
            background: rgba(61, 220, 156, 0.14);
            border-color: rgba(61, 220, 156, 0.5);
            color: #4FE6AB;
            box-shadow: 0 0 0 3px rgba(61, 220, 156, 0.1);
        }
        .status-option input:checked + .status-pill--inactive {
            background: rgba(139, 146, 160, 0.16);
            border-color: #6B7280;
            color: #D7DAE0;
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
            margin-top: 4px;
            padding-top: 18px;
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
            .status-pick { flex-wrap: wrap; }
            .form-actions { flex-direction: column-reverse; }
            .form-actions .btn-primary, .form-actions .btn-secondary { justify-content: center; }
        }

                /* Tambahan khusus: bikin tombol Hapus menonjol di kondisi default, */
        /* bukan cuma berubah warna saat hover seperti icon-btn lain. */
        /* Class baru, tidak menimpa .icon-btn--danger yang sudah ada di layout. */
        .icon-btn--danger-solid {
            background: rgba(217, 89, 89, 0.12);
            border-color: rgba(217, 89, 89, 0.35);
            color: #E8908F;
        }
        .icon-btn--danger-solid:hover {
            background: #D95959;
            border-color: #D95959;
            color: #FFFFFF;
            box-shadow: 0 0 0 3px rgba(217, 89, 89, 0.18);
        }

        /* ---------- Modal konfirmasi hapus ---------- */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(10, 12, 16, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 1000;
        }
        .modal-backdrop[hidden] {
            display: none;
        }
        .modal-card {
            background: #33373F;
            border: 1px solid #454A54;
            border-radius: 14px;
            padding: 24px;
            max-width: 380px;
            width: 100%;
            box-shadow: 0 20px 50px rgba(0,0,0,0.4);
        }
        .modal-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(217, 89, 89, 0.14);
            color: #E8908F;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }
        .modal-title {
            font-size: 15px;
            font-weight: 600;
            color: #F5F6F8;
            margin: 0 0 6px;
        }
        .modal-text {
            font-size: 13px;
            color: #ABB1BD;
            margin: 0 0 20px;
            line-height: 1.5;
        }
        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
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
            transition: background 0.12s ease, color 0.12s ease, border-color 0.12s ease;
        }
        .btn-secondary:hover { background: #3D424C; color: #F5F6F8; border-color: #565C68; }
        .btn-danger {
            background: #D95959;
            border: none;
            color: #FFFFFF;
            border-radius: 8px;
            padding: 9px 16px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background 0.15s ease;
        }
        .btn-danger:hover { background: #C24848; }

        /* ============================
        TOMBOL AKSI TABEL
        ============================ */
        .btn-edit {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 7px;
            font-size: 12.5px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            border: none;
            font-family: 'Inter', sans-serif;
            transition: background 0.15s, transform 0.1s;
            background: rgba(99,102,241,0.15);
            color: #A5B4FC;
            border: 1px solid rgba(99,102,241,0.25);
        }
        .btn-edit:hover {
            background: rgba(99,102,241,0.25);
            transform: translateY(-1px);
        }
        .btn-delete {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 7px;
            font-size: 12.5px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            font-family: 'Inter', sans-serif;
            transition: background 0.15s, transform 0.1s;
            background: rgba(239,68,68,0.12);
            color: #FCA5A5;
            border: 1px solid rgba(239,68,68,0.2);
        }
        .btn-delete:hover {
            background: rgba(239,68,68,0.22);
            transform: translateY(-1px);
        }
        .btn-view {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 7px;
            font-size: 12.5px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            border: 1px solid rgba(61,220,156,0.2);
            font-family: 'Inter', sans-serif;
            transition: background 0.15s, transform 0.1s;
            background: rgba(61,220,156,0.1);
            color: #4FE6AB;
        }
        .btn-view:hover {
            background: rgba(61,220,156,0.18);
            transform: translateY(-1px);
        }
        .action-group {
            display: flex;
            gap: 6px;
            align-items: center;
            flex-wrap: wrap;
        }

        /* ============================
        MODAL HAPUS
        ============================ */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.active {
            display: flex;
            animation: fadeIn 0.15s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        .modal-box {
            background: #20262F;
            border: 1px solid #323A47;
            border-radius: 18px;
            padding: 28px;
            width: 100%;
            max-width: 400px;
            margin: 16px;
            animation: slideUp 0.2s ease;
        }
        @keyframes slideUp {
            from { transform: translateY(16px); opacity: 0; }
            to   { transform: translateY(0); opacity: 1; }
        }
        .modal-icon {
            width: 52px;
            height: 52px;
            background: rgba(239,68,68,0.12);
            border: 1px solid rgba(239,68,68,0.2);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            font-size: 22px;
        }
        .modal-title {
            font-size: 17px;
            font-weight: 600;
            color: #FAFBFC;
            margin-bottom: 8px;
        }
        .modal-desc {
            font-size: 13.5px;
            color: #9CA3AF;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .modal-desc strong {
            color: #E4E7EB;
            font-weight: 500;
        }
        .modal-actions {
            display: flex;
            gap: 10px;
        }
        .modal-btn-cancel {
            flex: 1;
            padding: 10px;
            border-radius: 10px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            color: #D7DAE0;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background 0.15s;
        }
        .modal-btn-cancel:hover { background: rgba(255,255,255,0.1); }
        .modal-btn-confirm {
            flex: 1;
            padding: 10px;
            border-radius: 10px;
            background: linear-gradient(135deg, #EF4444, #DC2626);
            border: none;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: opacity 0.15s, transform 0.1s;
        }
        .modal-btn-confirm:hover { opacity: 0.9; transform: translateY(-1px); }
    </style>
</head>
<body>

    <div class="shell">
        <aside class="sidebar">
            <div class="brand">
                <span class="brand-dot"></span>
                <span class="brand-text"><b>AI Service</b> Center</span>
            </div>

            <nav class="nav-group">
                <p class="nav-label">Operasional</p>
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="ti ti-layout-dashboard" aria-hidden="true"></i>
                    Dashboard
                </a>
            </nav>

            <nav class="nav-group">
                <p class="nav-label">Knowledge base</p>
                <a href="{{ route('admin.knowledge.index') }}" class="nav-link {{ request()->routeIs('admin.knowledge.*') ? 'active' : '' }}">
                    <i class="ti ti-file-text" aria-hidden="true"></i>
                    Pertanyaan & jawaban
                </a>
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="ti ti-folder" aria-hidden="true"></i>
                    Kategori
                </a>
            </nav>

            <nav class="nav-group">
                <p class="nav-label">Monitoring</p>
                <a href="{{ route('admin.feedback.index') }}" class="nav-link {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
                    <i class="ti ti-star" aria-hidden="true"></i>
                    Feedback
                </a>
            </nav>

            <nav class="nav-group">
                <p class="nav-label">Dokumen</p>
                <a href="{{ route('admin.documents.index') }}" class="nav-link {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}">
                    <i class="ti ti-file-upload" aria-hidden="true"></i>
                    Dokumen PDF
                </a>
            </nav>

            <nav class="nav-group">
                <p class="nav-label">Sistem</p>
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="ti ti-settings" aria-hidden="true"></i>
                    Pengaturan
                </a>
            </nav>

            <nav class="nav-group">
                <p class="nav-label">Manajemen</p>
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="ti ti-users" aria-hidden="true"></i>
                    User
                </a>
                <a href="{{ route('admin.admins.index') }}" class="nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                    <i class="ti ti-shield-check" aria-hidden="true"></i>
                    Admin
                </a>
            </nav>

            <div class="sidebar-foot">
                <div class="admin-chip">
                    <div class="admin-avatar">{{ strtoupper(substr(Auth::guard('admin')->user()->nama ?? 'A', 0, 2)) }}</div>
                    <div class="admin-meta">
                        <p class="admin-name">{{ Auth::guard('admin')->user()->nama ?? 'Admin' }}</p>
                        <p class="admin-role">{{ Auth::guard('admin')->user()->role ?? 'admin' }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="ti ti-logout" aria-hidden="true"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <div class="main">
            <div class="topbar">
                <div>
                    <p class="topbar-eyebrow">{{ $eyebrow ?? 'Panel admin' }}</p>
                    <h1>{{ $title ?? 'Dashboard' }}</h1>
                </div>
                @isset($topbarAction)
                    {{ $topbarAction }}
                @endisset
            </div>

            <div class="content">
                @if (session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif

                {{ $slot }}
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div class="modal-overlay" id="delete-modal">
        <div class="modal-box">
            <div class="modal-icon">🗑️</div>
            <p class="modal-title">Konfirmasi Hapus</p>
            <p class="modal-desc" id="modal-desc">
                Apakah Anda yakin ingin menghapus <strong id="modal-item-name"></strong>?
                Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="modal-actions">
                <button class="modal-btn-cancel" onclick="closeDeleteModal()">Batal</button>
                <form id="modal-delete-form" method="POST" style="flex: 1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modal-btn-confirm" style="width: 100%;">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
    function openDeleteModal(action, itemName) {
        document.getElementById('modal-delete-form').action = action;
        document.getElementById('modal-item-name').textContent = itemName;
        document.getElementById('delete-modal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.remove('active');
        document.body.style.overflow = '';
    }

    // Tutup modal kalau klik overlay
    document.getElementById('delete-modal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    // Tutup modal kalau tekan ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
    </script>
    

</body>
</html>