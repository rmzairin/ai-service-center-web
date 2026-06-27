<x-admin-layout :title="'Kelola Admin'" :eyebrow="'Manajemen'">

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px; align-items: start;">

        {{-- Form Tambah --}}
        <div class="surface" style="padding: 24px;">
            <p style="color: #9CA3AF; font-size: 11px; margin: 0 0 4px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em;">Tambah baru</p>
            <p style="color: #FAFBFC; font-size: 15px; font-weight: 600; margin: 0 0 20px;">Admin</p>

            <form action="{{ route('admin.admins.store') }}" method="POST">
                @csrf

                <div style="margin-bottom: 14px;">
                    <label class="field-label">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama lengkap" required>
                    @error('nama') <p style="color:#F0A8A8;font-size:12px;margin-top:5px;">{{ $message }}</p> @enderror
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
                    <label class="field-label">Role</label>
                    <select name="role" required>
                        <option value="operator">Operator</option>
                        <option value="admin">Admin</option>
                        <option value="superadmin">Superadmin</option>
                    </select>
                </div>

                <div style="margin-bottom: 18px;">
                    <label class="field-label">Status</label>
                    <select name="status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; justify-content: center;">
                    <i class="ti ti-plus"></i> Tambah Admin
                </button>
            </form>
        </div>

        {{-- Tabel --}}
        <div class="surface" style="padding: 4px 20px 16px;">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px 0 16px;">
                <div>
                    <p style="color: #9CA3AF; font-size: 11px; margin: 0 0 4px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em;">Daftar</p>
                    <p style="color: #FAFBFC; font-size: 15px; font-weight: 600; margin: 0;">Semua Admin</p>
                </div>
                <form method="GET" action="{{ route('admin.admins.index') }}" style="display: flex; gap: 8px;">
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
                        <th>Role</th>
                        <th>Status</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                        <tr>
                            <td style="font-weight: 500; color: #EDEFF2;">
                                {{ $admin->nama }}
                                @if($admin->id === auth('admin')->id())
                                    <span style="font-size: 10px; color: #4FE6AB; background: rgba(61,220,156,0.1); padding: 2px 6px; border-radius: 4px; margin-left: 6px;">Anda</span>
                                @endif
                            </td>
                            <td style="color: #9CA3AF;">{{ $admin->email }}</td>
                            <td>
                                <span class="badge" style="background: rgba(99,102,241,0.15); color: #A5B4FC;">
                                    {{ $admin->role }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $admin->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $admin->status }}
                                </span>
                            </td>
                            <td>
                                <div class="action-cluster">
                                    <button type="button" class="btn-edit" onclick="toggleEdit('admin-{{ $admin->id }}')">
                                        <i class="ti ti-pencil"></i>                                        <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 15px; height: 15px;"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="M15 5l4 4"/></svg>
                                    </button>
                                    @if($admin->id !== auth('admin')->id())
                                        <button type="button" class="btn-delete"
                                            onclick="openDeleteModal('{{ route('admin.admins.destroy', $admin->id) }}', '{{ addslashes($admin->nama) }}')">
                                            <i class="ti ti-trash"></i><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 15px; height: 15px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- Form Edit --}}
                        <tr id="admin-{{ $admin->id }}" style="display: none; background: #1C212B;">
                            <td colspan="5" style="padding: 16px 12px;">
                                <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px;">
                                        <div>
                                            <label class="field-label">Nama</label>
                                            <input type="text" name="nama" value="{{ $admin->nama }}" required>
                                        </div>
                                        <div>
                                            <label class="field-label">Email</label>
                                            <input type="email" name="email" value="{{ $admin->email }}" required>
                                        </div>
                                        <div>
                                            <label class="field-label">Password Baru <span style="color:#4D5562;">(kosongkan jika tidak diubah)</span></label>
                                            <input type="password" name="password" placeholder="Password baru...">
                                        </div>
                                        <div>
                                            <label class="field-label">Role</label>
                                            <select name="role">
                                                <option value="operator" {{ $admin->role === 'operator' ? 'selected' : '' }}>Operator</option>
                                                <option value="admin" {{ $admin->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="superadmin" {{ $admin->role === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="field-label">Status</label>
                                            <select name="status">
                                                <option value="active" {{ $admin->status === 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ $admin->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="display: flex; gap: 8px;">
                                        <button type="submit" class="btn-primary" style="padding: 7px 14px; font-size: 13px;">
                                            <i class="ti ti-check"></i> Simpan
                                        </button>
                                        <button type="button" onclick="toggleEdit('admin-{{ $admin->id }}')" class="btn-primary" style="background: #2A323E; color: #D7DAE0; padding: 7px 14px; font-size: 13px;">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #6B7280; padding: 32px;">
                                Belum ada admin terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top: 16px;">{{ $admins->links() }}</div>
        </div>
    </div>

    <script>
        function toggleEdit(id) {
            const row = document.getElementById(id);
            row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
        }
    </script>

</x-admin-layout>