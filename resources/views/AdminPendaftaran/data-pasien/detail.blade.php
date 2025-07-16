@extends('main')

@section('title', 'Detail Data Pasien - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1.5rem; color: rgb(33, 106, 178); text-align:left;">Detail Data Pasien</h3>

    <div class="detail-wrapper">
        <!-- KIRI: ICON PASIEN -->
        <div class="detail-photo">
            <div class="icon-box">
                <!-- Icon User -->
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#216ab2"
                    class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 10a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    <path fill-rule="evenodd"
                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37c.323-.272.674-.519 1.05-.738C4.905 10.356 6.377 10 8 10s3.095.356 4.418.632c.376.22.727.466 1.05.738A7 7 0 0 0 8 1z" />
                </svg>
            </div>
        </div>

        <!-- KANAN: DATA PASIEN -->
        <div class="detail-content">
            <div class="detail-row">
                <span class="detail-label">NIK</span>
                <span>{{ $pasien->NIK }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Nama</span>
                <span>{{ $pasien->nama }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal Lahir</span>
                <span>{{ $pasien->tanggal_lahir }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Jenis Kelamin</span>
                <span>{{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">No HP</span>
                <span>{{ $pasien->no_hp }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Alamat</span>
                <span>{{ $pasien->alamat }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal Daftar</span>
                <span>{{ $pasien->tanggal_daftar }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Asuransi</span>
                <span>{{ $pasien->asuransi->nama_perusahaan ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div style="margin-top:2rem;">
        <a href="{{ route('data-pasien.index') }}" class="btn-back">Kembali</a>
        <a href="{{ route('data-pasien.edit', $pasien->id) }}" class="btn-edit">Edit</a>
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
