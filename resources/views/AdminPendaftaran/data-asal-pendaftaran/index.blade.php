@extends('main')

@section('title', 'Data Asal Pendaftaran - Klinik')

@section('content')
<section class="blank-content">
    <div class="table-header">
        <h3>Data Asal Pendaftaran</h3>
        <button
            style="padding: 0.5rem 1rem; background:rgb(33, 106, 178); color:#fff; border:none; border-radius:8px; cursor:pointer;"
            onclick="document.getElementById('modalTambah').style.display='flex'" class="btn btn-primary">
            Tambah Asal
        </button>
    </div>

    {{-- Success Alert --}}
    @if (session('success'))
    <div class="alert-success" id="successAlert">{{ session('success') }}</div>
    @endif

    {{-- Table --}}
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Asal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($asals as $i => $asal)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $asal->nama }}</td>
                <td>
                    <div style="display: flex; gap: 0.4rem;">
                        <a href="#" onclick="document.getElementById('modalEdit{{ $asal->id }}').style.display='flex'"
                            class="btn btn-warning btn-sm">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form action="{{ route('data-asal-pendaftaran.destroy', $asal->id) }}" method="POST"
                            onsubmit="return confirm('Hapus asal pendaftaran ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align:center;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    @if ($asals->hasPages())
    <ul class="pagination">
        {{-- Previous Page --}}
        @if ($asals->onFirstPage())
        <li class="disabled"><span>«</span></li>
        @else
        <li><a href="{{ $asals->previousPageUrl() }}" rel="prev">«</a></li>
        @endif

        {{-- Page Numbers --}}
        @foreach ($asals->links()->elements[0] as $page => $url)
        @if ($page == $asals->currentPage())
        <li class="active"><span>{{ $page }}</span></li>
        @else
        <li><a href="{{ $url }}">{{ $page }}</a></li>
        @endif
        @endforeach

        {{-- Next Page --}}
        @if ($asals->hasMorePages())
        <li><a href="{{ $asals->nextPageUrl() }}" rel="next">»</a></li>
        @else
        <li class="disabled"><span>»</span></li>
        @endif
    </ul>
    @endif


    {{-- Modal Tambah --}}
    <div id="modalTambah" onclick="if(event.target === this) this.style.display='none'"
        style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:1000;">
        <div style="background:#fff; padding:2rem; border-radius:12px; width:90%; max-width:400px; position:relative;">
            <span onclick="document.getElementById('modalTambah').style.display='none'"
                style="position:absolute; top:1rem; right:1rem; font-size:1.5rem; cursor:pointer;">&times;</span>
            <h3 style="margin-bottom:1rem; text-align:left;">Tambah Asal Pendaftaran</h3>
            <form method="POST" action="{{ route('data-asal-pendaftaran.store') }}">
                @csrf
                <label style="display:block; text-align:left;">Nama Asal</label>
                <input type="text" name="nama" class="input-style" required />
                <div style="text-align:right; margin-top:1rem;">
                    <button type="button" onclick="document.getElementById('modalTambah').style.display='none'"
                        class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>


    {{-- Modal Edit --}}
    @foreach ($asals as $asal)
    <div id="modalEdit{{ $asal->id }}" onclick="if(event.target === this) this.style.display='none'"
        style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:1000;">
        <div style="background:#fff; padding:2rem; border-radius:12px; width:90%; max-width:400px; position:relative;">
            <span onclick="document.getElementById('modalEdit{{ $asal->id }}').style.display='none'"
                style="position:absolute; top:1rem; right:1rem; font-size:1.5rem; cursor:pointer;">&times;</span>
            <h3 style="margin-bottom:1rem; text-align:left;">Edit Asal Pendaftaran</h3>
            <form method="POST" action="{{ route('data-asal-pendaftaran.update', $asal->id) }}">
                @csrf
                @method('PUT')
                <label style="display:block; text-align:left;">Nama Asal</label>
                <input type="text" name="nama" class="input-style" value="{{ $asal->nama }}" required />
                <div style="text-align:right; margin-top:1rem;">
                    <button type="button"
                        onclick="document.getElementById('modalEdit{{ $asal->id }}').style.display='none'"
                        class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

</section>

{{-- Style --}}
<style>
.input-style {
    width: 100%;
    padding: 0.6rem;
    margin-bottom: 0.6rem;
    border: 1px solid #ccc;
    border-radius: 6px;
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th,
.data-table td {
    padding: 10px;
    border: 1px solid #ddd;
}

.data-table th {
    background-color: #f0f0f0;
}

.btn {
    padding: 6px 10px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
}

.btn-sm {
    padding: 4px 8px;
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


.alert-success {
    background-color: #d4edda;
    color: #155724;
    border-left: 5px solid #28a745;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 1rem;
}
</style>

{{-- Script --}}
<script>
window.onload = function() {
    const alert = document.getElementById('successAlert');
    if (alert) {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.style.display = 'none', 500);
        }, 4000);
    }
}
</script>
@endsection
