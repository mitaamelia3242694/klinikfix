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
                <th>Stok Awal</th>
                   <th>Tanggal Masuk</th>
                            <th>Jumlah</th>
                <th>Satuan</th>
                                 <th>Total Stok</th>
                                   <th>Masuk/Keluar</th>
                                                  <th>Tanggal Keluar</th>
                 <th>Stok Akhir</th>
                <th>Kadaluarsa</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
           @php
$filteredCount = 0;
@endphp
@foreach ($sediaans as $index => $sediaan)
    @php
        $kadaluarsa = \Carbon\Carbon::parse($sediaan->tanggal_kadaluarsa);
        $selisihHari = now()->diffInDays($kadaluarsa, false);
        $tampilkan = !request('expiring_soon') || $selisihHari <= 7;

        if ($tampilkan) {
            $filteredCount++;
            $stokAwal = $sediaan->jumlah ?? 0;
            $jumlahKeluar = $sediaan->obat->resepDetails->sum('jumlah') ?? 0;
            $stokAkhir = max($stokAwal - $jumlahKeluar, 0);

            // Tentukan status
            if ($jumlahKeluar == 0) {
                $status = 'Tetap';
            } elseif ($jumlahKeluar > 0) {
                $status = 'Berkurang';
            } else {
                $status = '-';
            }

            // Highlight warna baris
            $rowColor = '';
            if ($selisihHari < 0) {
                $rowColor = 'background-color: #ffe6e6;';
            } elseif ($selisihHari <= 7) {
                $rowColor = 'background-color: #fff5e6;';
            }
        }
    @endphp
            <tr>
                <td>{{ $filteredCount }}</td>
                <td>{{ $sediaan->obat->nama_obat ?? '-' }}</td>
                 @php
                $terpakai = $sediaan->obat->resepDetails->sum('jumlah') ?? 0;
                $stokTersisa = $sediaan->obat->stok_total - $terpakai;
                $rowColor = '';

                if ($selisihHari < 0) $rowColor='background-color: #ffe6e6;' ; elseif ($selisihHari <=7)
                    $rowColor='background-color: #fff5e6;' ; @endphp
                    <td>{{ $sediaan->obat->stok_total ?? 0 }}</td>
                     <td>{{ \Carbon\Carbon::parse($sediaan->tanggal_masuk)->format('d-m-Y') }}</td>
                <td>{{ $sediaan->obat->stok_total ?? 0 }}</td>
                <td>{{ $sediaan->obat->satuan->nama_satuan ?? '-' }}</td>
         <td>{{ $sediaan->obat->stok_total ?? '-' }}</td> <!-- Total Stok -->
           <td>
    @if ($sediaan->jumlah_keluar_hari_ini > 0)
        <span style="color:red; font-weight:bold;">
            Berkurang ({{ $sediaan->jumlah_keluar_hari_ini }}) hari ini
        </span>
    @else
        <span style="color:gray;">Tidak ada perubahan hari ini</span>
    @endif
</td>
 <td>{{ \Carbon\Carbon::parse($sediaan->tanggal_keluar)->format('d-m-Y') }}</td>
<td>{{ max(($sediaan->obat->stok_total ?? 0) - $jumlahKeluar, 0) }}</td>

                    <td style="{{ $rowColor }}">{{ $kadaluarsa->format('d-m-Y') }}</td>

                    <td>
                    <!-- Tombol Riwayat -->
<button class="btn btn-primary no-underline" onclick="showModal({{ $sediaan->obat_id }})">
    <i class="fas fa-history"></i>
</button>

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


    <div id="modalRiwayat" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999;">
    <div style="background:#fff; padding:2rem; border-radius:12px; width:90%; max-width:600px; max-height:80vh; overflow:auto; position:relative;">
        <span onclick="document.getElementById('modalRiwayat').style.display='none'" style="position:absolute; top:1rem; right:1rem; font-size:1.5rem; cursor:pointer;">&times;</span>
        <h3 style="margin-bottom:1rem; color:#216ab2;">Riwayat Pengeluaran Obat (Bulan Ini)</h3>
        <div id="riwayatContent"></div>
    </div>
</div>

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
<select name="obat_id" required class="input-style" id="obatSelect" onchange="hitungStok(this)">
    <option value="">-- Pilih Obat --</option>
    @foreach ($obats as $obat)
        <option
            value="{{ $obat->id }}"
            data-total="{{ $obat->stok_total }}"
        >
            {{ $obat->nama_obat }}
        </option>
    @endforeach
</select>


<label style="display:block; text-align:left;"><strong>Jumlah (Masuk)</strong></label>
<input type="number" id="jumlahInput" class="input-style" name="jumlah" readonly>

<label style="display:block; text-align:left;"><strong>Stok Awal</strong></label>
<input type="number" id="stokAwal" class="input-style" name="stok_awal" readonly>

<label style="display:block; text-align:left;"><strong>Stok Akhir</strong></label>
<input type="number" id="stokAkhir" class="input-style" name="stok_akhir" readonly>

<label style="display:block; text-align:left;"><strong>Total Stok</strong></label>
<input type="number" id="totalStok" class="input-style" name="total_stok" readonly>


                <label style="display:block; text-align:left;"><strong>Tanggal Masuk</strong></label>
                <input type="date" name="tanggal_masuk" required class="input-style">

<label><strong>Tanggal Keluar</strong></label>
<input type="date" name="tanggal_keluar" class="input-style"> {{-- tanpa required --}}



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

<script>
    const semuaRiwayat = @json($riwayatObat);

    function showModal(obatId) {
        const data = semuaRiwayat[obatId] || [];
        const modal = document.getElementById('modalRiwayat');
        const content = document.getElementById('riwayatContent');

        if (data.length === 0) {
            content.innerHTML = '<p style="color:gray;">Tidak ada pengeluaran bulan ini.</p>';
        } else {
            let html = `<table style="width:100%; border-collapse:collapse;">
                    <tr style="background:#f0f0f0;"><th style="padding:8px; border:1px solid #ccc;">Tanggal</th><th style="padding:8px; border:1px solid #ccc;">Jumlah</th></tr>`;
            data.forEach(item => {
                html += `<tr>
                    <td style="padding:6px 8px; border:1px solid #ccc;">${item.tanggal}</td>
                    <td style="padding:6px 8px; border:1px solid #ccc;">${item.jumlah}</td>
                </tr>`;
            });
            html += `</table>`;
            content.innerHTML = html;
        }

        modal.style.display = 'flex';
    }

function tampilkanInfoStok(select) {
        const opt = select.options[select.selectedIndex];

        const jumlah = opt.dataset.jumlah || 0;
        const awal = opt.dataset.awal || 0;
        const akhir = opt.dataset.akhir || 0;
        const total = opt.dataset.total || 0;

        document.getElementById('infoJumlah').textContent = jumlah;
        document.getElementById('infoAwal').textContent = awal;
        document.getElementById('infoAkhir').textContent = akhir;
        document.getElementById('infoTotal').textContent = total;

        document.getElementById('infoStok').style.display = 'block';
    }

   function hitungStok(select) {
    const selectedOption = document.getElementById("obatSelect").selectedOptions[0];
    const total = parseInt(selectedOption.dataset.total || 0);

    // Jumlah = stok awal = stok akhir = total stok
    document.getElementById("jumlahInput").value = total;
    document.getElementById("stokAwal").value = total;
    document.getElementById("stokAkhir").value = total;
    document.getElementById("totalStok").value = total;
}

</script>
@endsection
