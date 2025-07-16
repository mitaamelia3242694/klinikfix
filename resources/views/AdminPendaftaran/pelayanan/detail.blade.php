@extends('main')

@section('title', 'Detail Data Pelayanan - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1.5rem; color: rgb(33, 106, 178); text-align:left;">Detail Data Pelayanan</h3>

    <div class="detail-wrapper">
        <!-- KIRI: ICON PELAYANAN -->
        <div class="detail-photo">
            <div class="icon-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#216ab2" class="bi bi-stethoscope"
                    viewBox="0 0 16 16">
                    <path
                        d="M7 12.5v-.821A4.5 4.5 0 0 1 3 7V1.5a.5.5 0 0 1 1 0V7a3.5 3.5 0 0 0 7 0V1.5a.5.5 0 0 1 1 0V7a4.5 4.5 0 0 1-4 4.47v.03a2.5 2.5 0 1 0 3 2.45.5.5 0 0 1 1 0 3.5 3.5 0 1 1-7 0z" />
                </svg>
            </div>
        </div>

        <!-- KANAN: DATA -->
        <div class="detail-content">
            <div class="detail-row">
                <span class="detail-label">Nama Pelayanan</span>
                <span>{{ $layanan->nama_pelayanan }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Biaya</span>
                <span>Rp {{ number_format($layanan->biaya, 0, ',', '.') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span>{{ $layanan->status }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Deskripsi</span>
                <span>{{ $layanan->deskripsi ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div style="margin-top:2rem;">
        <a href="{{ route('data-pelayanan.index') }}" class="btn-back">Kembali</a>
        <a href="{{ route('data-pelayanan.edit', $layanan->id) }}" class="btn-edit">Edit</a>
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
