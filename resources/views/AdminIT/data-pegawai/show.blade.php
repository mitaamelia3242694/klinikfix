@extends('main')

@section('title', 'Detail Pegawai - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1.5rem; color: rgb(33, 106, 178); text-align:left;">Detail Data Pegawai</h3>

    <div class="detail-wrapper">
        <!-- KIRI: ICON -->
        <div class="detail-photo">
            <div class="icon-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#216ab2"
                    class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 10a3 3 0 1 0-6 0 3 3 0 0 0 6 0z" />
                    <path fill-rule="evenodd"
                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37c.69-.88 1.99-1.37 3.468-1.37s2.778.49 3.468 1.37A7 7 0 0 0 8 1z" />
                </svg>
            </div>
        </div>

        <!-- KANAN: DATA -->
        <div class="detail-content">
            <div class="detail-row"><span class="detail-label">NIK</span><span>{{ $pegawai->nik }}</span></div>
            <div class="detail-row"><span class="detail-label">NIP</span><span>{{ $pegawai->nip ?? '-' }}</span></div>
            <div class="detail-row"><span class="detail-label">Nama
                    Lengkap</span><span>{{ $pegawai->nama_lengkap }}</span></div>
            <div class="detail-row"><span class="detail-label">Gelar</span><span>{{ $pegawai->gelar ?? '-' }}</span>
            </div>
            <div class="detail-row"><span class="detail-label">Jenis
                    Kelamin</span><span>{{ $pegawai->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span></div>
            <div class="detail-row"><span class="detail-label">Tanggal
                    Lahir</span><span>{{ \Carbon\Carbon::parse($pegawai->ttl)->translatedFormat('d F Y') }}</span></div>
            <div class="detail-row"><span class="detail-label">Alamat</span><span>{{ $pegawai->alamat }}</span></div>
            <div class="detail-row"><span class="detail-label">No Telepon</span><span>{{ $pegawai->no_telp }}</span>
            </div>
            <div class="detail-row"><span class="detail-label">STR</span><span>{{ $pegawai->str ?? '-' }}</span></div>
            <div class="detail-row"><span class="detail-label">SIP</span><span>{{ $pegawai->sip ?? '-' }}</span></div>
            <div class="detail-row"><span
                    class="detail-label">Jabatan</span><span>{{ $pegawai->jabatan->nama_jabatan ?? '-' }}</span></div>
            <div class="detail-row"><span class="detail-label">Instansi
                    Induk</span><span>{{ $pegawai->instansi_induk ?? '-' }}</span></div>
            <div class="detail-row"><span class="detail-label">Tanggal
                    Berlaku</span><span>{{ \Carbon\Carbon::parse($pegawai->tanggal_berlaku)->translatedFormat('d F Y') }}</span>
            </div>
        </div>
    </div>

    <div style="margin-top:2rem;">
        <a href="{{ route('data-pegawai.index') }}" class="btn-back">Kembali</a>
        <a href="{{ route('data-pegawai.edit', $pegawai->id) }}" class="btn-edit">Edit</a>
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
