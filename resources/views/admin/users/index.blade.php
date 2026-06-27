<x-admin-layout :title="'Kelola User'" :eyebrow="'Manajemen'">

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px; align-items: start;">

        {{-- Form Tambah --}}
        <div class="surface" style="padding: 24px;">
            <p style="color: #9CA3AF; font-size: 11px; margin: 0 0 4px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em;">Tambah baru</p>
            <p style="color: #FAFBFC; font-size: 15px; font-weight: 600; margin: 0 0 20px;">User</p>

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div style="margin-bottom: 14px;">
                    <label class="field-label">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap" required>
                    @error('name') <p style="color:#F0A8A8;font-size:12px;margin-top:5px;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 14px;">
                    <label class="field-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@domain.com" required>
                    @error('email') <p style="color:#F0A8A8;font-size:12px;margin-top:5px;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 14px;">
                    <label class="field-label">Password</label>
                    <input type="password" name="password" placeholder="Min. 6 karakter" required>
                    @error('password') <p style="color:#F0A8A8;font-size:12px;margin-top:5px;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 14px;">
                    <label class="field-label">No. HP <span style="color:#4D5562;">(opsional)</span></label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx">
                </div>

                <div style="margin-bottom: 18px;">
                    <label class="field-label">Status</label>
                    <select name="status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; justify-content: center;">
                    <i class="ti ti-plus"></i> Tambah User
                </button>
            </form>
        </div>

        {{-- Tabel --}}
        <div class="surface" style="padding: 4px 20px 16px;">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px 0 16px;">
                <div>
                    <p style="color: #9CA3AF; font-size: 11px; margin: 0 0 4px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em;">Daftar</p>
                    <p style="color: #FAFBFC; font-size: 15px; font-weight: 600; margin: 0;">Semua User</p>
                </div>
                <form method="GET" action="{{ route('admin.users.index') }}" style="display: flex; gap: 8px;">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama / email..." style="width: 200px;">
                    <button type="submit" class="btn-primary" style="background: #2A323E; color: #D7DAE0; padding: 8px 12px;">
                        <i class="ti ti-search"></i>
                    </button>
                </form>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Status</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td style="font-weight: 500; color: #EDEFF2;">{{ $user->name }}</td>
                            <td style="color: #9CA3AF;">{{ $user->email }}</td>
                            <td style="color: #9CA3AF;">{{ $user->no_hp ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $user->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $user->status }}
                                </span>
                            </td>
                            <td>
                                <div class="action-cluster">
                                    <button type="button" class="btn-edit" onclick="toggleEdit('user-{{ $user->id }}')">
                                        <i class="ti ti-pencil"></i>                                        <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 15px; height: 15px;"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/></svg>
                                    </button>
                                    <button type="button" class="btn-delete"
                                        onclick="openDeleteModal('{{ route('admin.users.destroy', $user->id) }}', '{{ addslashes($user->name) }}')">
                                        <i class="ti ti-trash"></i><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 15px; height: 15px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        {{-- Form Edit --}}
                        <tr id="user-{{ $user->id }}" style="display: none; background: #1C212B;">
                            <td colspan="5" style="padding: 16px 12px;">
                                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px;">
                                        <div>
                                            <label class="field-label">Nama</label>
                                            <input type="text" name="name" value="{{ $user->name }}" required>
                                        </div>
                                        <div>
                                            <label class="field-label">Email</label>
                                            <input type="email" name="email" value="{{ $user->email }}" required>
                                        </div>
                                        <div>
                                            <label class="field-label">Password Baru <span style="color:#4D5562;">(kosongkan jika tidak diubah)</span></label>
                                            <input type="password" name="password" placeholder="Password baru...">
                                        </div>
                                        <div>
                                            <label class="field-label">No. HP</label>
                                            <input type="text" name="no_hp" value="{{ $user->no_hp }}">
                                        </div>
                                        <div>
                                            <label class="field-label">Status</label>
                                            <select name="status">
                                                <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="display: flex; gap: 8px;">
                                        <button type="submit" class="btn-primary" style="padding: 7px 14px; font-size: 13px;">
                                            <i class="ti ti-check"></i> Simpan
                                        </button>
                                        <button type="button" onclick="toggleEdit('user-{{ $user->id }}')" class="btn-primary" style="background: #2A323E; color: #D7DAE0; padding: 7px 14px; font-size: 13px;">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #6B7280; padding: 32px;">
                                Belum ada user terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top: 16px;">{{ $users->links() }}</div>
        </div>
    </div>

    <script>
        function toggleEdit(id) {
            const row = document.getElementById(id);
            row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
        }
    </script>

</x-admin-layout>