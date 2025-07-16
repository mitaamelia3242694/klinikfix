@extends('main')

@section('title', 'Detail Data Asuransi - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1.5rem; color: rgb(33, 106, 178); text-align:left;">Detail Data Asuransi</h3>

    <div class="detail-wrapper">
        <!-- KIRI: ICON PERUSAHAAN -->
        <div class="detail-photo">
            <div class="icon-box">
                <!-- Icon Building -->
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#216ab2" class="bi bi-building"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M15.285.905a.5.5 0 0 1 .215.41v13.74a.5.5 0 0 1-.5.5H.999a.5.5 0 0 1-.5-.5V1.315a.5.5 0 0 1 .215-.41l7-4a.5.5 0 0 1 .57 0l7 4zM8 1.566L1.5 5.433v8.217h13V5.433L8 1.566zM4.5 6.5a.5.5 0 0 1 .5-.5h1.5v1H5a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5H9v1H8a.5.5 0 0 1-.5-.5zM4.5 9a.5.5 0 0 1 .5-.5h1.5v1H5a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5H9v1H8a.5.5 0 0 1-.5-.5z" />
                </svg>
            </div>
        </div>

        <!-- KANAN: DATA ASURANSI -->
        <div class="detail-content">
            <div class="detail-row">
                <span class="detail-label">Nama Perusahaan</span>
                <span>{{ $asuransi->nama_perusahaan }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Nomor Polis</span>
                <span>{{ $asuransi->nomor_polis }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Jenis Asuransi</span>
                <span>{{ $asuransi->jenis_asuransi }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Masa Berlaku Mulai</span>
                <span>{{ $asuransi->masa_berlaku_mulai }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Masa Berlaku Akhir</span>
                <span>{{ $asuransi->masa_berlaku_akhir }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span>{{ $asuransi->status }}</span>
            </div>
        </div>
    </div>

    <div style="margin-top:2rem;">
        <a href="{{ route('data-asuransi.index') }}" class="btn-back">Kembali</a>
        <a href="{{ route('data-asuransi.edit', $asuransi->id) }}" class="btn-edit">Edit</a>
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
