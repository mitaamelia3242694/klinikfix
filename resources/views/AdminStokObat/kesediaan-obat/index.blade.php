@extends('main')

@section('title', 'Ketersediaan Obat - Klinik')

@section('content')
<section class="blank-content">
    <div class="table-header">
        <h3>Ketersediaan Obat</h3>
        <button onclick="document.getElementById('modalTambah').style.display='flex'"
            style="padding: 0.5rem 1rem; background:rgb(33, 106, 178); color:#fff; border:none; border-radius:8px; cursor:pointer;">
            Tambah Ketersediaan
        </button>
    </div>

    <form method="GET"
        style="margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; font-size: 14px; justify-content: flex-start;">
        <input type="checkbox" id="expiring_soon" name="expiring_soon" onchange="this.form.submit()"
            {{ request('expiring_soon') ? 'checked' : '' }} style="width: 16px; height: 16px; cursor: pointer;">
        <label for="expiring_soon" style="cursor: pointer; color: #333;">Obat hampir kadaluarsa</label>
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
                <th>Nama Obat</th>
                <th>Satuan</th>
                <th>Jumlah</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Keluar</th>
                <th>Kadaluarsa</th>
                <th>Keterangan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $filteredCount = 0; @endphp
            @foreach ($sediaans as $index => $sediaan)
            @php
            $kadaluarsa = \Carbon\Carbon::parse($sediaan->tanggal_kadaluarsa);
            $selisihHari = now()->diffInDays($kadaluarsa, false);
            $tampilkan = true;

            if (request('expiring_soon') && $selisihHari > 7) {
            $tampilkan = false;
            }

            if ($tampilkan) {
            $filteredCount++;
            @endphp
            <tr>
                <td>{{ $filteredCount }}</td>
                <td>{{ $sediaan->obat->nama_obat ?? '-' }}</td>
                <td>{{ $sediaan->obat->satuan->nama_satuan ?? '-' }}</td>
                @php
                $terpakai = $sediaan->obat->resepDetails->sum('jumlah') ?? 0;
                $stokTersisa = $sediaan->obat->stok_total - $terpakai;
                $rowColor = '';

                if ($selisihHari < 0) $rowColor='background-color: #ffe6e6;' ; elseif ($selisihHari <=7)
                    $rowColor='background-color: #fff5e6;' ; @endphp <td>{{ $stokTersisa }}</td>
                    <td>{{ \Carbon\Carbon::parse($sediaan->tanggal_masuk)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($sediaan->tanggal_keluar)->format('d-m-Y') }}</td>
                    <td style="{{ $rowColor }}">{{ $kadaluarsa->format('d-m-Y') }}</td>

                    <td>{{ $sediaan->keterangan ?? '-' }}</td>
                    <td>
                        <a href="{{ route('kesediaan-obat.show', $sediaan->id) }}" class="btn btn-info no-underline"><i
                                class="fas fa-eye"></i></a>
                        <a href="{{ route('kesediaan-obat.edit', $sediaan->id) }}"
                            class="btn btn-warning no-underline"><i class="fas fa-pen"></i></a>
                        <form action="{{ route('kesediaan-obat.destroy', $sediaan->id) }}" method="POST"
                            style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
            </tr>
            @php } @endphp
            @endforeach

            @if ($filteredCount === 0)
            <tr>
                <td colspan="8" style="text-align: center; padding: 1rem; background: #f9f9f9; color: #888;">
                    @if (request('expiring_soon'))
                    Tidak ada obat yang hampir kadaluarsa.
                    @else
                    Data obat tidak tersedia.
                    @endif
                </td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- Modal Tambah -->
    <div id="modalTambah" onclick="if(event.target === this) this.style.display='none'"
        style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">
        <div
            style="background:#fff; padding:2rem; border-radius:12px; width:90%; max-width:500px; max-height:90vh; overflow:auto; box-shadow:0 5px 20px rgba(0,0,0,0.2); position:relative;">
            <span onclick="document.getElementById('modalTambah').style.display='none'"
                style="position:absolute; top:1rem; right:1rem; font-size:1.5rem; cursor:pointer; color:rgb(33, 106, 178);">&times;</span>
            <h3 style="margin-bottom:1rem; color:rgb(33, 106, 178); text-align:left;">Tambah Ketersediaan Obat</h3>

            <form method="POST" action="{{ route('kesediaan-obat.store') }}">
                @csrf
                <label style="display:block; text-align:left;"><strong>Nama Obat</strong></label>
                <select name="obat_id" required class="input-style">
                    <option value="">-- Pilih Obat --</option>
                    @foreach ($obats as $obat)
                    <option value="{{ $obat->id }}">{{ $obat->nama_obat }} ({{ $obat->satuan->nama_satuan ?? '' }})
                    </option>
                    @endforeach
                </select>

                <label style="display:block; text-align:left;"><strong>Tanggal Masuk</strong></label>
                <input type="date" name="tanggal_masuk" required class="input-style">

                <label style="display:block; text-align:left;"><strong>Tanggal Keluar</strong></label>
                <input type="date" name="tanggal_keluar" required class="input-style">

                <label style="display:block; text-align:left;"><strong>Tanggal Kadaluarsa</strong></label>
                <input type="date" name="tanggal_kadaluarsa" required class="input-style">

                <label style="display:block; text-align:left;"><strong>Keterangan</strong></label>
                <textarea name="keterangan" rows="2" class="input-style"></textarea>

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