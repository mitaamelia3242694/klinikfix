@extends('main')

@section('title', 'Manajemen Jabatan - Klinik')

@section('content')
<section class="blank-content">
    <div class="table-header">
        <h3>Manajemen Data Jabatan</h3>
        <button onclick="document.getElementById('modalTambah').style.display='flex'"
            style="padding: 0.5rem 1rem; background:rgb(33, 106, 178); color:#fff; border:none; border-radius:8px; cursor:pointer;">
            Tambah Jabatan
        </button>
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
                <th>Nama Jabatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jabatans as $index => $jabatan)
            <tr>
                <td>{{ $jabatans->firstItem() + $index }}</td>
                <td>{{ $jabatan->nama_jabatan }}</td>
                <td>
                    <button onclick="document.getElementById('modalEdit{{ $jabatan->id }}').style.display='flex'"
                        class="btn btn-warning no-underline" style="margin-right: 5px;"><i
                            class="fas fa-pen"></i></button>

                    <form action="{{ route('data-jabatan.destroy', $jabatan->id) }}" method="POST"
                        style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus jabatan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>

            <!-- Modal Edit Jabatan -->
            <div id="modalEdit{{ $jabatan->id }}" onclick="if(event.target === this) this.style.display='none'"
                style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">
                <div
                    style="background:#fff; padding:2rem; border-radius:12px; width:90%; max-width:480px; box-shadow:0 5px 20px rgba(0,0,0,0.2); position:relative;">
                    <span onclick="document.getElementById('modalEdit{{ $jabatan->id }}').style.display='none'"
                        style="position:absolute; top:1rem; right:1rem; font-size:1.5rem; cursor:pointer; color:rgb(33, 106, 178);">&times;</span>

                    <h3 style="margin-bottom:1rem; color:rgb(33, 106, 178); text-align:left;">
                        <i class="fas fa-edit"></i> Edit Jabatan
                    </h3>

                    <form method="POST" action="{{ route('data-jabatan.update', $jabatan->id) }}">
                        @csrf
                        @method('PUT')
                        <label style="display:block; text-align:left;"><strong>Nama Jabatan</strong></label>
                        <input type="text" name="nama_jabatan" value="{{ $jabatan->nama_jabatan }}" required
                            style="width:100%; margin-bottom:1rem; padding:0.6rem; border:1px solid #ccc; border-radius:6px;">

                        <div style="display:flex; justify-content: flex-end; gap: 0.5rem;">
                            <button type="button"
                                onclick="document.getElementById('modalEdit{{ $jabatan->id }}').style.display='none'"
                                style="padding: 0.5rem 1.2rem; background:#ccc; color:#333; border:none; border-radius:8px; cursor:pointer;">Batal</button>
                            <button type="submit"
                                style="padding: 0.5rem 1.2rem; background:rgb(33, 106, 178); color:#fff; border:none; border-radius:8px; cursor:pointer;">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    @if ($jabatans->hasPages())
    <ul class="pagination">
        @if ($jabatans->onFirstPage())
        <li class="disabled"><span>«</span></li>
        @else
        <li><a href="{{ $jabatans->previousPageUrl() }}">«</a></li>
        @endif

        @foreach ($jabatans->links()->elements[0] as $page => $url)
        @if ($page == $jabatans->currentPage())
        <li class="active"><span>{{ $page }}</span></li>
        @else
        <li><a href="{{ $url }}">{{ $page }}</a></li>
        @endif
        @endforeach

        @if ($jabatans->hasMorePages())
        <li><a href="{{ $jabatans->nextPageUrl() }}">»</a></li>
        @else
        <li class="disabled"><span>»</span></li>
        @endif
    </ul>
    @endif

    <!-- Modal Tambah Jabatan -->
    <div id="modalTambah" onclick="if(event.target === this) this.style.display='none'"
        style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">
        <div
            style="background:#fff; padding:2rem; border-radius:12px; width:90%; max-width:480px; box-shadow:0 5px 20px rgba(0,0,0,0.2); position:relative;">
            <span onclick="document.getElementById('modalTambah').style.display='none'"
                style="position:absolute; top:1rem; right:1rem; font-size:1.5rem; cursor:pointer; color:rgb(33, 106, 178);">&times;</span>

            <h3 style="margin-bottom:1rem; color:rgb(33, 106, 178); text-align:left;"><i class="fas fa-briefcase"></i>
                Tambah Jabatan</h3>

            <form method="POST" action="{{ route('data-jabatan.store') }}">
                @csrf
                <label style="display:block; text-align:left;"><strong>Nama Jabatan</strong></label>
                <input type="text" name="nama_jabatan" required
                    style="width:100%; margin-bottom:1rem; padding:0.6rem; border:1px solid #ccc; border-radius:6px;">

                <div style="display:flex; justify-content: flex-end; gap: 0.5rem;">
                    <button type="button" onclick="document.getElementById('modalTambah').style.display='none'"
                        style="padding: 0.5rem 1.2rem; background:#ccc; color:#333; border:none; border-radius:8px; cursor:pointer;">Batal</button>
                    <button type="submit"
                        style="padding: 0.5rem 1.2rem; background:rgb(33, 106, 178); color:#fff; border:none; border-radius:8px; cursor:pointer;">Simpan</button>
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

.btn-warning {
    background-color: #ffc107;
    color: black;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

.btn-info {
    color: white;
    background-color: rgb(4, 135, 109);
}

.no-underline {
    text-decoration: none;
}

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
