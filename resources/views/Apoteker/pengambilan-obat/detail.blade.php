@extends('main')

@section('title', 'Detail Pengambilan Obat - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1.5rem; color: rgb(33, 106, 178); text-align:left;">Detail Pengambilan Obat</h3>

    <div class="detail-wrapper">
        <!-- KIRI: ICON OBAT -->
        <div class="detail-photo">
            <div class="icon-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#216ab2" viewBox="0 0 16 16">
                    <path
                        d="M8.5 1a3.5 3.5 0 0 0-3.162 5.032l4.63 4.63A3.5 3.5 0 0 0 13 8.5 3.5 3.5 0 0 0 8.5 1zM4 8.5c0 .798.312 1.52.82 2.062l-2.75 2.75a.5.5 0 0 0 .708.708l2.75-2.75A3.495 3.495 0 0 0 8.5 13c.798 0 1.52-.312 2.062-.82l2.75 2.75a.5.5 0 0 0 .708-.708l-2.75-2.75A3.495 3.495 0 0 0 13 8.5a3.5 3.5 0 0 0-7 0z" />
                </svg>
            </div>
        </div>
        {{-- @dd($pengambilan->toArray()) --}}

        <!-- KANAN: DATA -->
        <div class="detail-content">
            <div class="detail-row">
                <span class="detail-label">Nama Pasien</span>
                <span>{{ $pengambilan->resep->pasien->nama ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Dokter</span>
                <span>{{ $pengambilan->resep->user->nama_lengkap ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal Resep</span>
                <span>{{ $pengambilan->resep->tanggal ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal Pengambilan</span>
                <span>{{ $pengambilan->tanggal_pengambilan ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status Pengambilan</span>
                <span>{{ strtolower(trim($pengambilan->status_checklist)) === 'sudah diambil' ? 'Sudah' : 'Belum' }}
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Petugas Apotek</span>
                <span>{{ $pengambilan->user->nama_lengkap ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div style="margin-top:2rem;">
        <a href="{{ route('pengambilan-obat.index') }}" class="btn-back">Kembali</a>
        <a href="{{ route('pengambilan-obat.edit', $pengambilan->id) }}" class="btn-edit">Edit</a>
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
