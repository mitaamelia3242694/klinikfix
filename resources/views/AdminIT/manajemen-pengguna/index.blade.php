@extends('main')

@section('title', 'Manajemen Pengguna - Klinik')

@section('content')
<section class="blank-content">
    <div class="table-header">
        <h3>Manajemen Data Pengguna</h3>
        <button class="btn btn-primary" onclick="openModal()">Tambah Pengguna</button>
    </div>

    @if (session('success'))
    <div class="alert-success" id="successAlert">
        {{ session('success') }}
    </div>
    @endif

    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Status</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
            <tr>
                <td>{{ $users->firstItem() + $index }}</td>
                <td>{{ $user->nama_lengkap }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="status-indicator {{ $user->status === 'aktif' ? 'aktif' : 'nonaktif' }}"></span>
                    {{ ucfirst($user->status ?? '-') }}
                </td>

                <td>{{ $user->role->nama_role ?? '-' }}</td>
                <td>
                    <!-- <a href="{{ route('manajemen-pengguna.show', $user->id) }}"
                        class="btn btn-info no-underline">Detail</a> -->
                    <a href="{{ route('manajemen-pengguna.edit', $user->id) }}" class="btn btn-warning no-underline"><i
                            class="fas fa-pen"></i></a>

                    <form action="{{ route('manajemen-pengguna.destroy', $user->id) }}" method="POST"
                        style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if ($users->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($users->onFirstPage())
        <li class="disabled"><span>«</span></li>
        @else
        <li><a href="{{ $users->previousPageUrl() }}" rel="prev">«</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($users->links()->elements[0] as $page => $url)
        @if ($page == $users->currentPage())
        <li class="active"><span>{{ $page }}</span></li>
        @else
        <li><a href="{{ $url }}">{{ $page }}</a></li>
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($users->hasMorePages())
        <li><a href="{{ $users->nextPageUrl() }}" rel="next">»</a></li>
        @else
        <li class="disabled"><span>»</span></li>
        @endif
    </ul>
    @endif


    <!-- Modal Tambah Pengguna -->
    <div id="modalTambah" class="modal-overlay">
        <div class="modal-content">
            <h3>Tambah Pengguna</h3>
            <form action="{{ route('manajemen-pengguna.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role_id" required>
                        <option value=""> Pilih Role </option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-buttons">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" onclick="closeModal()">Batal</button>
                </div>
            </form>
        </div>
    </div>

</section>

<style>
.alert-success {
    background-color: #d4edda;
    color: #155724;
    border-left: 5px solid #28a745;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 1rem;
    position: relative;
    animation: fadeSlide 0.5s ease-out;
}

@keyframes fadeSlide {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.status-indicator {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-right: 6px;
    vertical-align: middle;
}

.status-indicator.aktif {
    background-color: #28a745;
    /* Hijau */
}

.status-indicator.nonaktif {
    background-color: #dc3545;
    /* Merah */
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: none;
    justify-content: center;
    align-items: center;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
}

.modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    width: 400px;
    max-width: 90%;
}

.modal-content h3 {
    margin-top: 0;
    margin-bottom: 15px;
}

.form-group {
    margin-bottom: 12px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    text-align: left;
    /* <--- Tambahkan ini */
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
    justify-content: flex-end;
    gap: 8px;
}

.no-underline {
    text-decoration: none;
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.table-header h3 {
    margin: 0;
    font-size: 18px;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

.data-table th,
.data-table td {
    padding: 10px 12px;
    border: 1px solid #ddd;
}

.data-table th {
    background-color: #f0f0f0;
}

.btn {
    padding: 6px 10px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    margin-right: 4px;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-info {
    background-color: #17a2b8;
    color: white;
}

.btn-warning {
    background-color: #ffc107;
    color: black;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

/* Pagination custom minimalis */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 1rem;
    gap: 0.5rem;
    flex-wrap: wrap;
    list-style: none;
    padding: 0;
}

.pagination li {
    margin: 0;
}

.pagination li span,
.pagination li a {
    display: block;
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    color: rgb(33, 106, 178);
    background-color: #f2f2f2;
    transition: background-color 0.2s, color 0.2s;
}

.pagination li a:hover {
    background-color: rgb(33, 106, 178);
    color: #fff;
}

.pagination li.active span {
    background-color: rgb(33, 106, 178);
    color: #fff;
    font-weight: bold;
}

.pagination li.disabled span {
    color: #aaa;
    background-color: #eee;
    cursor: default;
}
</style>

<script>
function openModal() {
    document.getElementById('modalTambah').style.display = 'flex';
}

function closeModal() {
    document.getElementById('modalTambah').style.display = 'none';
}

// Sembunyikan alert setelah 5 detik
window.onload = function() {
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.transition = 'opacity 0.5s ease';
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.style.display = 'none', 500);
        }, 5000);
    }
};
</script>

@endsection
