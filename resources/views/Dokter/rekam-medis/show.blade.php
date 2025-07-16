@extends('main')

@section('title', 'Detail Rekam Medis - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1.5rem; color: rgb(33, 106, 178); text-align:left;">Detail Rekam Medis</h3>

    <div class="detail-wrapper">
        <!-- KIRI: ICON -->
        <div class="detail-photo">
            <div class="icon-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#216ab2"
                    class="bi bi-journal-medical" viewBox="0 0 16 16">
                    <path
                        d="M6 1.5v1h4v-1a.5.5 0 0 1 .5-.5h.5a1.5 1.5 0 0 1 0 3H2v9a1 1 0 0 0 1 1h7.086a1.5 1.5 0 0 1 1.06.44l1.914 1.914A.5.5 0 0 0 14 14.914V2.5A1.5 1.5 0 0 0 12.5 1h-.5a.5.5 0 0 1-.5-.5v-1h-4v1z" />
                    <path
                        d="M8.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 .5-.5z" />
                </svg>
            </div>
        </div>

        <!-- KANAN: DATA -->
        <div class="detail-content">
            <div class="detail-row">
                <span class="detail-label">Nama Pasien</span>
                <span>{{ $rekam->pasien->nama }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal Kunjungan</span>
                <span>{{ $rekam->tanggal_kunjungan }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Diagnosa</span>
                <span>{{ $rekam->diagnosa ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Keluhan</span>
                <span>{{ $rekam->keluhan }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tindakan</span>
                <span>{{ $rekam->tindakan->jenis_tindakan ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Catatan Tambahan</span>
                <span>{{ $rekam->catatan_tambahan ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div style="margin-top:2rem;">
        <a href="{{ route('rekam-medis.index') }}" class="btn-back">Kembali</a>
        <a href="{{ route('rekam-medis.edit', $rekam->id) }}" class="btn-edit">Edit</a>
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