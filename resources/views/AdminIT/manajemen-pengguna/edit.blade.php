@extends('main')

@section('title', 'Edit Pengguna - Klinik')

@section('content')
<section class="blank-content">
    <h3 class="section-title">Edit Pengguna</h3>

    <form action="{{ route('manajemen-pengguna.update', $user->id) }}" method="POST" class="edit-form">
        @csrf
        @method('PUT')

        <div class="form-columns">
            <!-- KIRI -->
            <div class="form-column">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" required>
                </div>
                <div class="form-group">
                    <label>Password (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password">
                </div>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                        required>
                </div>
            </div>

            <!-- KANAN -->
            <div class="form-column">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="aktif" {{ $user->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ $user->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role_id" required>
                        <option value="">Pilih Role</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                            {{ $role->nama_role }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="modal-buttons">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('manajemen-pengguna.index') }}" class="btn btn-danger no-underline">Batal</a>
        </div>
    </form>
</section>

<style>
.section-title {
    text-align: left;
    margin-bottom: 20px;
    font-size: 20px;
    font-weight: bold;
}

.edit-form {
    margin-top: 20px;
    max-width: 1000px;
}

.form-columns {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
}

.form-column {
    flex: 1;
    min-width: 300px;
}

.form-group {
    margin-bottom: 14px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    text-align: left;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 8px 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
}

.modal-buttons {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
}

.btn {
    padding: 6px 12px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    text-decoration: none;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}
</style>
@endsection
