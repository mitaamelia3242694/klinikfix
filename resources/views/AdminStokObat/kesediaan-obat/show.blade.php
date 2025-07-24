@extends('main')

@section('title', 'Detail Ketersediaan Obat - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1.5rem; color: rgb(33, 106, 178); text-align:left;">Detail Ketersediaan Obat</h3>

    <div class="detail-wrapper">
        <!-- KIRI: ICON OBAT -->
        <div class="detail-photo">
            <div class="icon-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#216ab2" class="bi bi-capsule"
                    viewBox="0 0 16 16">
                    <path
                        d="M8.5 1a5.5 5.5 0 0 0-3.89 9.39l4.95 4.95a3.5 3.5 0 1 0 4.95-4.95L9.61 2.11A5.5 5.5 0 0 0 8.5 1zm1.415 1.828 4.257 4.256a4.5 4.5 0 0 1-6.364 6.364L3.55 9.192a4.5 4.5 0 0 1 6.364-6.364z" />
                </svg>
            </div>
        </div>

        <!-- KANAN: DATA -->
        <div class="detail-content">
            <div class="detail-row">
                <span class="detail-label">Nama Obat</span>
                <span>{{ $sediaan->obat->nama_obat ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Jumlah</span>
                <span>{{ $sediaan->jumlah }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal Masuk</span>
                <span>{{ $sediaan->tanggal_masuk }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal Keluar</span>
                <span>{{ $sediaan->tanggal_keluar }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal Kadaluarsa</span>
                <span>{{ $sediaan->tanggal_kadaluarsa }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Keterangan</span>
                <span>{{ $sediaan->keterangan ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div style="margin-top:2rem;">
        <a href="{{ route('kesediaan-obat.index') }}" class="btn-back">Kembali</a>
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