@extends('main')

@section('title', 'Detail Resep - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1.5rem; color: rgb(33, 106, 178); text-align:left;">Detail Penerbitan Resep</h3>

    <div class="detail-wrapper">
        <!-- KIRI: ICON OBAT/RESEP -->
        <div class="detail-photo">
            <div class="icon-box">
                <!-- Icon Obat / Resep -->
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#216ab2" class="bi bi-capsule"
                    viewBox="0 0 16 16">
                    <path
                        d="M6.5 9.9L2.1 5.5a3.536 3.536 0 1 1 5-5l4.4 4.4a3.536 3.536 0 1 1-5 5zM3.1 4.5l4.4 4.4a2.536 2.536 0 1 0 3.6-3.6L6.7.9a2.536 2.536 0 1 0-3.6 3.6z" />
                </svg>
            </div>
        </div>

        <!-- KANAN: DATA RESEP -->
        <div class="detail-content">
            <div class="detail-row">
                <span class="detail-label">Nama Pasien</span>
                <span>{{ $resep->pasien->nama }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Dokter</span>
                <span>{{ $resep->user->nama_lengkap }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal Resep</span>
                <span>{{ $resep->tanggal }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Catatan</span>
                <span>{{ $resep->catatan ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div style="margin-top: 2rem;">
        <h4 style="margin-bottom: 1rem; text-align:left;">Daftar Obat</h4>
        <div class="obat-table">
            <table style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f1f1f1;">
                        <th style="padding: 0.6rem; border: 1px solid #ccc;">No</th>
                        <th style="padding: 0.6rem; border: 1px solid #ccc;">Nama Obat</th>
                        <th style="padding: 0.6rem; border: 1px solid #ccc;">Jumlah</th>
                        <th style="padding: 0.6rem; border: 1px solid #ccc;">Dosis</th>
                        <th style="padding: 0.6rem; border: 1px solid #ccc;">Aturan Pakai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resep->detail as $index => $detail)
                    <tr>
                        <td style="padding: 0.6rem; border: 1px solid #ccc;">{{ $index + 1 }}</td>
                        <td style="padding: 0.6rem; border: 1px solid #ccc;">{{ $detail->obat->nama_obat }}</td>
                        <td style="padding: 0.6rem; border: 1px solid #ccc;">{{ $detail->jumlah }} /
                            {{ $detail->obat->satuan->nama_satuan }}</td>
                        <td style="padding: 0.6rem; border: 1px solid #ccc;">{{ $detail->dosis }}</td>
                        <td style="padding: 0.6rem; border: 1px solid #ccc;">{{ $detail->aturan_pakai }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top:2rem;">
        <a href="{{ route('penerbitan-resep.index') }}" class="btn-back">Kembali</a>
        <a href="{{ route('penerbitan-resep.edit', $resep->id) }}" class="btn-edit">Edit</a>
    </div>
</section>

<style>
.detail-wrapper {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
    max-width: 900px;
    background: #fff;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.detail-photo {
    flex: 0 0 180px;
    display: flex;
    justify-content: start;
    align-items: start;
}

.icon-box {
    width: 140px;
    height: 140px;
    background: #f1f1f1;
    border-radius: 16px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.detail-content {
    flex: 1;
    min-width: 300px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    border-bottom: 1px dashed #ccc;
    padding-bottom: 0.5rem;
}

.detail-label {
    font-weight: bold;
    color: #444;
}

.btn-back,
.btn-edit {
    padding: 0.5rem 1.2rem;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
}

.btn-back {
    background: #ccc;
    color: #333;
    margin-right: 0.5rem;
}

.btn-edit {
    background: rgb(33, 106, 178);
    color: white;
}
</style>
@endsection
