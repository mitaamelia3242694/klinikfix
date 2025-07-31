@extends('main')

@section('title', 'Detail Data Kajian Awal - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1.5rem; color: rgb(33, 106, 178); text-align:left;">Detail Data Kajian Awal</h3>

    <div class="detail-wrapper">
        <!-- KIRI: ICON -->
        <div class="detail-photo">
            <div class="icon-box">
                <!-- Icon Clipboard -->
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#216ab2"
                    class="bi bi-clipboard2-pulse" viewBox="0 0 16 16">
                    <path d="M7.5 1v1h1V1h-1z" />
                    <path
                        d="M4 1.5A1.5 1.5 0 0 0 2.5 3v10A1.5 1.5 0 0 0 4 14.5h8a1.5 1.5 0 0 0 1.5-1.5V3A1.5 1.5 0 0 0 12 1.5H4zm3.36 8.528L6.89 8.276 5.97 9.514a.5.5 0 0 1-.846-.058l-1.5-3a.5.5 0 1 1 .892-.448L5.53 8.28l.92-1.237a.5.5 0 0 1 .763-.057l.97 1.05 1.53-2.297a.5.5 0 0 1 .854.52l-2 3a.5.5 0 0 1-.787.07z" />
                </svg>
            </div>
        </div>

        <!-- KANAN: DATA -->
        <div class="detail-content">
            <div class="detail-row">
                <span class="detail-label">Nama Pasien</span>
                <span>{{ $kajian->pendaftaran->pasien->nama }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Perawat</span>
                <span>{{ $kajian->user->nama_lengkap }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal</span>
                <span>{{ $kajian->tanggal }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Keluhan Utama</span>
                <span>{{ $kajian->keluhan_utama }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tekanan Darah</span>
                <span>{{ $kajian->tekanan_darah }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Suhu Tubuh</span>
                <span>{{ $kajian->suhu_tubuh }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Diagnosa Awal</span>
                <span>{{ $kajian->diagnosa_awal ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Pelayanan</span>
                <span>{{ $kajian->pelayanan->nama_pelayanan ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Catatan</span>
                <span>{{ $kajian->catatan ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div style="margin-top:2rem;">
        <a href="{{ route('data-kajian-awal.index') }}" class="btn-back">Kembali</a>
        <a href="{{ route('data-kajian-awal.edit', $kajian->id) }}" class="btn-edit">Edit</a>
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