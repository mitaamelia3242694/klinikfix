@extends('main')

@section('title', 'Data Resep - Klinik')

@section('content')
<section class="blank-content">
    <div class="table-header">
        <h3>Data Resep</h3>
        
    </div>

    <!-- Search dipindahkan ke bawah tombol tambah -->
    <form method="GET" action="" style="margin-bottom: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
        <input type="text" name="keyword" placeholder="Cari Nama Pasien / Dokter" value="" class="input-style"
            style="max-width: 250px;">
    </form>

    @if (session('success'))
    <div class="alert-success" id="successAlert">
        {{ session('success') }}
    </div>
    @endif

    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Obat (Jumlah – Dosis / Aturan)</th>
                <th>Pelayanan</th>
                <th>Tanggal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reseps as $index => $resep)
            <tr>
                <td>{{ $reseps->firstItem() + $index }}</td>
                <td>{{ $resep->pasien->nama ?? '-' }}</td>
                <td>{{ $resep->user->nama_lengkap ?? '-' }}</td>
                <td>
                    @foreach ($resep->detail as $d)
                    • {{ $d->obat->nama_obat }} ({{ $d->jumlah }}, {{ $d->dosis }}, {{ $d->aturan_pakai }})<br>
                    @endforeach
                </td>
                <td>{{ $resep->pelayanan->nama_pelayanan ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($resep->tanggal)->format('d-m-Y') }}</td>
                <td>
                    <a href="{{ route('data-resep.show', $resep->id) }}" class="btn btn-info no-underline"><i
                            class="fas fa-eye"></i></a>
                    
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

    @if ($reseps->hasPages())
    <ul class="pagination">
        {{-- Previous --}}
        @if ($reseps->onFirstPage())
        <li class="disabled"><span>«</span></li>
        @else
        <li><a href="{{ $reseps->previousPageUrl() }}" rel="prev">«</a></li>
        @endif

        {{-- Pages --}}
        @foreach ($reseps->links()->elements[0] as $page => $url)
        @if ($page == $reseps->currentPage())
        <li class="active"><span>{{ $page }}</span></li>
        @else
        <li><a href="{{ $url }}">{{ $page }}</a></li>
        @endif
        @endforeach

        {{-- Next --}}
        @if ($reseps->hasMorePages())
        <li><a href="{{ $reseps->nextPageUrl() }}" rel="next">»</a></li>
        @else
        <li class="disabled"><span>»</span></li>
        @endif
    </ul>
    @endif


    <!-- Modal Tambah -->
    <div id="modalTambah" onclick="if(event.target === this) this.style.display='none'"
        style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">
        <div
            style="background:#fff; padding:2rem; border-radius:12px; width:90%; max-width:500px; max-height:90vh; overflow:auto; box-shadow:0 5px 20px rgba(0,0,0,0.2); position:relative;">
            <span onclick="document.getElementById('modalTambah').style.display='none'"
                style="position:absolute; top:1rem; right:1rem; font-size:1.5rem; cursor:pointer; color:rgb(33, 106, 178);">&times;</span>
            <h3 style="margin-bottom:1rem; color:rgb(33, 106, 178); text-align:left;">Tambah Resep</h3>

            <form method="POST" action="{{ route('data-resep.store') }}">
                @csrf
                <label style="display:block; text-align:left;"><strong>Pasien</strong></label>
                <select name="pasien_id" required class="input-style">
                    <option value="">-- Pilih Pasien --</option>
                    @foreach ($pasiens as $pasien)
                    <option value="{{ $pasien->id }}">{{ $pasien->nama }}</option>
                    @endforeach
                </select>

                <label style="display:block; text-align:left;"><strong>Dokter</strong></label>
                <select name="user_id" required class="input-style">
                    <option value="">-- Pilih Dokter --</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->nama_lengkap }}</option>
                    @endforeach
                </select>

                <label style="display:block; text-align:left;"><strong>Pelayanan</strong></label>
                <select name="pelayanan_id" required class="input-style">
                    <option value="">-- Pilih Pelayanan --</option>
                    @foreach ($pelayanans as $pelayanan)
                    <option value="{{ $pelayanan->id }}">{{ $pelayanan->nama_pelayanan }}</option>
                    @endforeach
                </select>


                <label style="display:block; text-align:left;"><strong>Tanggal Resep</strong></label>
                <input type="date" name="tanggal" required class="input-style">

                <label style="display:block; text-align:left;"><strong>Catatan</strong></label>
                <textarea name="catatan" rows="2" class="input-style"></textarea>

                <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                    <button type="button" onclick="document.getElementById('modalTambah').style.display='none'"
                        class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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

.input-style {
    width: 100%;
    padding: 0.6rem;
    margin-bottom: 0.6rem;
    border: 1px solid #ccc;
    border-radius: 6px;
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
    text-decoration: none;
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
