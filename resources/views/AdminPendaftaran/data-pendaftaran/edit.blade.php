@extends('main')

@section('title', 'Edit Pendaftaran Pasien - Klinik')

@section('content')
<section class="blank-content">
    <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Edit Pendaftaran</h3>

    <form method="POST" action="{{ route('data-pendaftaran.update', $pendaftaran->id) }}"
        style="max-width: 1000px; display: flex; gap: 2rem; flex-wrap: wrap;">
        @csrf
        @method('PUT')

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Pasien</strong></label>
            <select name="pasien_id" class="form-input" required>
                <option value="">-- Pilih Pasien --</option>
                @foreach ($pasiens as $pasien)
                <option value="{{ $pasien->id }}" {{ $pendaftaran->pasien_id == $pasien->id ? 'selected' : '' }}>
                    {{ $pasien->nama }} - {{ $pasien->NIK }}
                </option>
                @endforeach
            </select>

            <label style="display:block; text-align:left;"><strong>Jenis Kunjungan</strong></label>
            <select name="jenis_kunjungan" class="form-input" required>
                <option value="">-- Pilih Jenis --</option>
                <option value="baru" {{ $pendaftaran->jenis_kunjungan == 'baru' ? 'selected' : '' }}>Baru</option>
                <option value="lama" {{ $pendaftaran->jenis_kunjungan == 'lama' ? 'selected' : '' }}>Lama</option>
            </select>

            <label style="display:block; text-align:left;"><strong>Dokter</strong></label>
            <select name="dokter_id" class="form-input" required>
                <option value="">-- Pilih Dokter --</option>
                @foreach ($dokters as $dokter)
                <option value="{{ $dokter->id }}" {{ $pendaftaran->dokter_id == $dokter->id ? 'selected' : '' }}>
                    {{ $dokter->nama_lengkap }}
                </option>
                @endforeach
            </select>

            <label style="display:block; text-align:left;"><strong>Tindakan</strong></label>
            <select name="tindakan_id" class="form-input">
                <option value="">-- Pilih Tindakan --</option>
                @foreach ($tindakans as $tindakan)
                <option value="{{ $tindakan->id }}" {{ $pendaftaran->tindakan_id == $tindakan->id ? 'selected' : '' }}>
                    {{ $tindakan->jenis_tindakan }}
                </option>
                @endforeach
            </select>
        </div>

        <div style="flex: 1; min-width: 300px;">
            <label style="display:block; text-align:left;"><strong>Asal Pendaftaran</strong></label>
            <select name="asal_pendaftaran_id" class="form-input">
                <option value="">-- Pilih Asal --</option>
                @foreach ($asalPendaftarans as $asal)
                <option value="{{ $asal->id }}" {{ $pendaftaran->asal_pendaftaran_id == $asal->id ? 'selected' : '' }}>
                    {{ $asal->nama }}
                </option>
                @endforeach
            </select>

            <label style="display:block; text-align:left;"><strong>Perawat</strong></label>
            <select name="perawat_id" class="form-input">
                <option value="">-- Pilih Perawat --</option>
                @foreach ($perawats as $perawat)
                <option value="{{ $perawat->id }}" {{ $pendaftaran->perawat_id == $perawat->id ? 'selected' : '' }}>
                    {{ $perawat->nama_lengkap }}
                </option>
                @endforeach
            </select>

            <label style="display:block; text-align:left;"><strong>Keluhan</strong></label>
            <textarea name="keluhan" rows="3" class="form-input">{{ $pendaftaran->keluhan }}</textarea>

            <label style="display:block; text-align:left;"><strong>Status</strong></label>
            <input type="text" name="status" class="form-input" value="{{ $pendaftaran->status }}"
                placeholder="Contoh: menunggu, selesai, batal" />

            <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                <a href="{{ route('data-pendaftaran.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">Update</button>
            </div>
        </div>
    </form>
</section>

{{-- Style --}}
<style>
.form-input {
    width: 100%;
    margin-bottom: 0.6rem;
    padding: 0.6rem;
    border: 1px solid #ccc;
    border-radius: 6px;
    box-sizing: border-box;
}

.btn-submit {
    padding: 0.5rem 1.2rem;
    background: rgb(33, 106, 178);
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}

.btn-cancel {
    padding: 0.5rem 1.2rem;
    background: #ccc;
    color: #333;
    border: none;
    border-radius: 8px;
    text-decoration: none;
}
</style>
@endsection
