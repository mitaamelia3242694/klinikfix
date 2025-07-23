@extends('main')

@section('title', 'Detail Data Diagnosa Awal - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1.5rem; color: rgb(33, 106, 178); text-align:left;">Detail Data Diagnosa Awal</h3>

    <div class="detail-wrapper">
        <!-- KIRI: ICON -->
        <div class="detail-photo">
            <div class="icon-box">
                <!-- Icon: Stethoscope (Bootstrap Icons) -->
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#216ab2" class="bi bi-stethoscope"
                    viewBox="0 0 16 16">
                    <path
                        d="M8 1a.5.5 0 0 1 .5.5V2h1V1.5a.5.5 0 0 1 1 0V2h1V1.5a.5.5 0 0 1 1 0V2a2 2 0 0 1-2 2h-.5v4.528a3.5 3.5 0 1 1-1 0V4H8V2a1 1 0 0 1 0-1z" />
                    <path
                        d="M4 4a.5.5 0 0 1 .5.5v3.75a2.5 2.5 0 1 0 5 0V4.5a.5.5 0 0 1 1 0v3.75a3.5 3.5 0 1 1-7 0V4.5A.5.5 0 0 1 4 4z" />
                </svg>

            </div>
        </div>

        <!-- KANAN: DATA -->
        <div class="detail-content">
            <div class="detail-row">
                <span class="detail-label">Nama Pasien</span>
                <span>{{ $diagnosa->pasien->nama }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Perawat</span>
                <span>{{ $diagnosa->user->nama_lengkap }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal</span>
                <span>{{ $diagnosa->tanggal }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Diagnosa</span>
                <span>{{ $diagnosa->diagnosa }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Master Diagnosa</span>
                <span>{{ $diagnosa->masterDiagnosa->nama }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Pelayanan</span>
                <span>{{ $diagnosa->pelayanan->nama_pelayanan }}</span>
            </div>
        </div>
    </div>

    <div style="margin-top:2rem;">
        <a href="{{ route('data-diagnosa-awal.index') }}" class="btn-back">Kembali</a>
        <a href="{{ route('data-diagnosa-awal.edit', $diagnosa->id) }}" class="btn-edit">Edit</a>
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