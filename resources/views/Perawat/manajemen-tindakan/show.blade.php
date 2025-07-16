@extends('main')

@section('title', 'Detail Tindakan - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1.5rem; color: rgb(33, 106, 178); text-align:left;">Detail Tindakan Pasien</h3>

    <div class="detail-wrapper">
        <!-- KIRI: ICON PASIEN -->
        <div class="detail-photo">
            <div class="icon-box">
                <!-- Icon Pasien (Orang) -->
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#216ab2"
                    class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 10a3 3 0 1 0-6 0 5 5 0 0 0-5 5h16a5 5 0 0 0-5-5z" />
                    <path fill-rule="evenodd" d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zM8 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4z" />
                </svg>
            </div>
        </div>

        <!-- KANAN: DATA -->
        <div class="detail-content">
            <div class="detail-row">
                <span class="detail-label">Nama Pasien</span>
                <span>{{ $tindakan->pasien->nama ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Diagnosa Awal</span>
                <span>{{ $tindakan->pasien->diagnosaAwal->diagnosa ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Diagnosa Akhir</span>
                <span>{{ $tindakan->pasien->diagnosaAkhir->diagnosa ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Jenis Tindakan</span>
                <span>{{ $tindakan->jenis_tindakan }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal</span>
                <span>{{ \Carbon\Carbon::parse($tindakan->tanggal)->format('d-m-Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Dokter</span>
                <span>{{ $tindakan->user->nama_lengkap ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Catatan</span>
                <span>{{ $tindakan->catatan ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div style="margin-top:2rem;">
        <a href="{{ route('manajemen-tindakan.index') }}" class="btn-back">Kembali</a>

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