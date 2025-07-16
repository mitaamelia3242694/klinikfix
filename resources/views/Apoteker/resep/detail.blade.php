@extends('main')

@section('title', 'Detail Resep - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1.5rem; color: rgb(33, 106, 178); text-align:left;">Detail Resep</h3>

    <div class="detail-wrapper">
        <!-- KIRI: ICON PASIEN -->
        <div class="detail-photo">
            <div class="icon-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#216ab2" class="bi bi-person-vcard"
                    viewBox="0 0 16 16">
                    <path
                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.5h14V4a1 1 0 0 0-1-1H2zm13 2.5H1v6a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-6zM4 7a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm4.5 3.5h-5a.5.5 0 0 0-.5.5v.5h6v-.5a.5.5 0 0 0-.5-.5z" />
                </svg>
            </div>
        </div>

        <!-- KANAN: DATA -->
        <div class="detail-content">
            <div class="detail-row">
                <span class="detail-label">Nama Pasien</span>
                <span>{{ $resep->pasien->nama ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Dokter</span>
                <span>{{ $resep->user->nama_lengkap ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal Resep</span>
                <span>{{ $resep->tanggal }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Catatan</span>
                <span>{{ $resep->catatan ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Pelayanan</span>
                <span>{{ $resep->pelayanan->nama_pelayanan ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div style="margin-top:2rem;">
        <a href="{{ route('data-resep.index') }}" class="btn-back">Kembali</a>
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
