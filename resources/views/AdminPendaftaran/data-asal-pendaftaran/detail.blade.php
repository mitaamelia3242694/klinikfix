@extends('main')

@section('title', 'Detail Data Pendaftaran - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1.5rem; color: rgb(33, 106, 178); text-align:left;">Detail Data Pendaftaran</h3>

    <div class="detail-wrapper">
        {{-- Icon --}}
        <div class="detail-photo">
            <div class="icon-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#216ab2"
                    class="bi bi-journal-medical" viewBox="0 0 16 16">
                    <path
                        d="M6 1.5v1h4v-1a.5.5 0 0 1 1 0v1H14a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h3v-1a.5.5 0 0 1 1 0zm-3 2v11h10v-11H3z" />
                    <path
                        d="M8 5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V9.5a.5.5 0 0 1-1 0V8H6a.5.5 0 0 1 0-1h1.5V5.5A.5.5 0 0 1 8 5z" />
                </svg>
            </div>
        </div>

        {{-- Detail Content --}}
        <div class="detail-content">
            <div class="detail-row">
                <span class="detail-label">Pasien</span>
                <span>{{ $pendaftaran->pasien->nama ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Jenis Kunjungan</span>
                <span>{{ ucfirst($pendaftaran->jenis_kunjungan) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Dokter</span>
                <span>{{ $pendaftaran->dokter->nama_lengkap ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Perawat</span>
                <span>{{ $pendaftaran->perawat->nama_lengkap ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tindakan</span>
                <span>{{ $pendaftaran->tindakan->jenis_tindakan ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Asal Pendaftaran</span>
                <span>{{ $pendaftaran->asalPendaftaran->nama ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Keluhan</span>
                <span>{{ $pendaftaran->keluhan ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span>{{ ucfirst($pendaftaran->status ?? '-') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal Daftar</span>
                <span>{{ $pendaftaran->created_at->format('d-m-Y H:i') }}</span>
            </div>
        </div>
    </div>

    <div style="margin-top:2rem;">
        <a href="{{ route('data-pendaftaran.index') }}" class="btn-back">Kembali</a>
        <a href="{{ route('data-pendaftaran.edit', $pendaftaran->id) }}" class="btn-edit">Edit</a>
    </div>
</section>

{{-- Style --}}
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
    flex: 0 0 160px;
    display: flex;
    justify-content: center;
    align-items: flex-start;
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
    border-bottom: 1px dashed #ccc;
    padding: 0.5rem 0;
    margin-bottom: 0.5rem;
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
