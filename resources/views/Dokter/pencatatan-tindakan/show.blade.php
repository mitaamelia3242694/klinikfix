@extends('main')

@section('title', 'Detail Tindakan - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1.5rem; color: rgb(33, 106, 178); text-align:left;">Detail Pencatatan Tindakan</h3>

    <div class="detail-wrapper">
        <!-- KIRI: ICON TINDAKAN -->
        <div class="detail-photo">
            <div class="icon-box">
                <!-- Icon Tindakan -->
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#216ab2" class="bi bi-heart-pulse"
                    viewBox="0 0 16 16">
                    <path d="M1 8s1-4 7-4 7 4 7 4-1 4-7 4-7-4-7-4z" />
                    <path
                        d="M8 0a.5.5 0 0 1 .5.5v3.225a5.538 5.538 0 0 1 2.77.875L10.5 3.5a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1h-1.134l.47 2.117A5.537 5.537 0 0 1 13.5 8c0 .534-.08 1.048-.23 1.534l-1.14-5.133L11.5 7a.5.5 0 0 1-1 .027L9.323 3.97A5.534 5.534 0 0 1 8 3.5V.5A.5.5 0 0 1 8 0z" />
                </svg>
            </div>
        </div>

        <!-- KANAN: DATA TINDAKAN -->
        <div class="detail-content">
            <div class="detail-row">
                <span class="detail-label">Nama Pasien</span>
                <span>{{ $tindakan->pasien->nama }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Dokter</span>
                <span>{{ $tindakan->user->nama_lengkap }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal Tindakan</span>
                <span>{{ $tindakan->tanggal }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Jenis Tindakan</span>
                <span>{{ $tindakan->jenis_tindakan }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tarif</span>
                <span>Rp {{ number_format($tindakan->tarif, 0, ',', '.') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Asuransi</span>
                <span> {{ $tindakan->pasien->asuransi->nama_perusahaan ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status Pembayaran</span>
                <span>
                    @if ($tindakan->pasien->asuransi)
                    <span style="color: green; font-weight: bold;">Asuransi</span>
                    @else
                    <span style="color: gray; font-weight: bold;">Non Asuransi</span>
                    @endif
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Catatan</span>
                <span>{{ $tindakan->catatan ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div style="margin-top:2rem;">
        <a href="{{ route('pencatatan-tindakan.index') }}" class="btn-back">Kembali</a>
        <a href="{{ route('pencatatan-tindakan.edit', $tindakan->id) }}" class="btn-edit">Edit</a>
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
