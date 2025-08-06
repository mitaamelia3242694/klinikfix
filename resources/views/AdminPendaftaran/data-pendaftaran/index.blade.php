@extends('main')

@section('title', 'Pendaftaran Pasien - Klinik')

@section('content')
<section class="blank-content">
    <div class="table-header">
        <h3>Pendaftaran Pasien</h3>
        <button
            style="padding: 0.5rem 1rem; background:rgb(33, 106, 178); color:#fff; border:none; border-radius:8px; cursor:pointer;"
            onclick="document.getElementById('modalTambah').style.display='flex'" class="btn btn-primary">
            Tambah Pendaftaran
        </button>
    </div>

    <form id="searchForm" action="{{ route('data-pendaftaran.index') }}" method="GET" style="margin-bottom: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
        <input type="text" name="keyword" placeholder="Cari Nama / NIK" value="{{ request('keyword') }}"
            class="input-style" style="max-width: 250px;" oninput="document.getElementById('searchForm').submit();">

        {{-- <button type="submit" class="btn btn-primary">Terapkan</button> --}}
    </form>

    {{-- Success Alert --}}
    @if (session('success'))
    <div class="alert-success" id="successAlert">{{ session('success') }}</div>
    @endif

    {{-- Table --}}
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Pasien</th>
                <th>Kunjungan</th>
                <th>Dokter</th>
                <th>Tindakan</th>
                <th>Asal</th>
                <th>Keluhan</th>

                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pendaftarans as $i => $daftar)
            <tr>
                <td>{{ ($pendaftarans->currentPage() - 1) * $pendaftarans->perPage() + $i + 1 }}</td>
                <td>{{ $daftar->pasien->nama ?? '-' }}</td>
                <td>{{ ucfirst($daftar->jenis_kunjungan) }}</td>
                <td>{{ $daftar->dokter->nama_lengkap ?? '-' }}</td>
                <td>{{ $daftar->tindakan->jenis_tindakan ?? '-' }}</td>
                <td>{{ $daftar->asalPendaftaran->nama ?? '-' }}</td>
                <td>{{ $daftar->keluhan ?? '-' }}</td>

                <td>
                    <div style="display: flex; gap: 0.4rem; flex-wrap: wrap;">
                        <a href="{{ route('data-pendaftaran.show', $daftar->id) }}" class="btn btn-info no-underline"><i
                                class="fas fa-eye"></i></a>
                        <a href="{{ route('data-pendaftaran.edit', $daftar->id) }}" class="btn btn-warning btn-sm"><i
                                class="fas fa-pen"></i></a>
                        <form action="{{ route('data-pendaftaran.destroy', $daftar->id) }}" method="POST"
                            style="display:inline;" onsubmit="return confirm('Hapus pendaftaran ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    @if ($pendaftarans->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($pendaftarans->onFirstPage())
        <li class="disabled"><span>«</span></li>
        @else
        <li><a href="{{ $pendaftarans->previousPageUrl() }}" rel="prev">«</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($pendaftarans->links()->elements[0] as $page => $url)
        @if ($page == $pendaftarans->currentPage())
        <li class="active"><span>{{ $page }}</span></li>
        @else
        <li><a href="{{ $url }}">{{ $page }}</a></li>
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($pendaftarans->hasMorePages())
        <li><a href="{{ $pendaftarans->nextPageUrl() }}" rel="next">»</a></li>
        @else
        <li class="disabled"><span>»</span></li>
        @endif
    </ul>
    @endif


    {{-- Modal Tambah Pendaftaran --}}
    <div id="modalTambah" onclick="if(event.target === this) this.style.display='none'"
        style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:1000;">
        <div
            style="background:#fff; padding:2rem; border-radius:12px; width:90%; max-width:600px; max-height:90vh; overflow:auto; position:relative;">
            <span onclick="document.getElementById('modalTambah').style.display='none'"
                style="position:absolute; top:1rem; right:1rem; font-size:1.5rem; cursor:pointer;">&times;</span>
            <h3 style="margin-bottom:1rem; text-align:left;">Tambah Pendaftaran</h3>

            <form method="POST" action="{{ route('data-pendaftaran.store') }}">
                @csrf

                <label style="display:block; text-align:left;">Pasien</label>
                <select name="pasien_id" id="pasienSelect" class="input-style" required>
                    <option value="">-- Pilih Pasien --</option>
                    @foreach ($pasiens as $pasien)
                    <option value="{{ $pasien->id }}">{{ $pasien->nama }} - {{ $pasien->alamat}}</option>
                    @endforeach
                </select>
                <br>
                <label style="display:block; text-align:left;">Dokter</label>
                <select name="dokter_id" class="input-style" required>
                    <option value="">-- Pilih Dokter --</option>
                    @foreach ($dokters as $dokter)
                    <option value="{{ $dokter->id }}">{{ $dokter->nama_lengkap }}</option>
                    @endforeach
                </select>

                <label style="display:block; text-align:left;">Tindakan (Opsional)</label>
                <select name="tindakan_id" class="input-style">
                    <option value="">-- Pilih Tindakan --</option>
                    @foreach ($tindakans as $tindakan)
                    <option value="{{ $tindakan->id }}">{{ $tindakan->jenis_tindakan }}</option>
                    @endforeach
                </select>

                <label style="display:block; text-align:left;">Asal Pendaftaran</label>
                <select name="asal_pendaftaran_id" class="input-style">
                    <option value="">-- Pilih Asal --</option>
                    @foreach ($asals as $asal)
                    <option value="{{ $asal->id }}">{{ $asal->nama }}</option>
                    @endforeach
                </select>

                <label style="display:block; text-align:left;">Perawat (Opsional)</label>
                <select name="perawat_id" class="input-style">
                    <option value="">-- Pilih Perawat --</option>
                    @foreach ($perawats as $perawat)
                    <option value="{{ $perawat->id }}">{{ $perawat->nama_lengkap }}</option>
                    @endforeach
                </select>

                <label style="display:block; text-align:left;">Keluhan</label>
                <textarea name="keluhan" class="input-style" rows="3"></textarea>

                <div style="margin-top: 1rem; text-align:right;">
                    <button type="button" onclick="document.getElementById('modalTambah').style.display='none'"
                        class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
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

.select2-container--default .select2-selection--single .select2-selection__rendered {
        text-align: left !important;
    }

    .select2-results__option {
        text-align: left !important;
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
<script>
    window.onload = function() {
        // Auto-hide alert
        const alert = document.getElementById('successAlert');
        if (alert) {
            setTimeout(() => {
                alert.style.opacity = '0';
                setTimeout(() => alert.style.display = 'none', 500);
            }, 4000);
        }

        // Aktifkan Select2 untuk pencarian pasien
        $('#pasienSelect').select2({
            placeholder: '-- Pilih Pasien --',
            width: '100%',
            dropdownParent: $('#modalTambah').find('form') // supaya dropdown tetap muncul di dalam modal
        });
    };
</script>


@endsection
