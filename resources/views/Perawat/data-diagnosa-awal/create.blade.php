@extends('main')

@section('title', 'Tambah Data Diagnosa Awal - Klinik')

@section('content')
    <section class="blank-content">
        <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Tambah Data Diagnosa Awal</h3>

        {{-- alert error dan success --}}
        <form method="POST" action="{{ route('data-diagnosa-awal.store') }}"
            style="max-width: 1000px; display: flex; gap: 2rem; flex-wrap: wrap;">
            @csrf

            <div style="flex: 1; min-width: 300px;">
                <!-- Pilih Pasien -->
                <!-- <label style="display:block; text-align:left;"><strong>Pasien</strong></label>
                <select name="pasien_id" id="selectPasien" class="form-input" required
                    onchange="updateTanggalPendaftaran()">
                    <option value="">-- Pilih Pasien --</option>
                    @foreach ($pendaftarans as $item)
                        <option value="{{ $item->pasien->id }}" data-created-at="{{ $item->created_at->format('Y-m-d') }}"
                            data-pelayanan-id="{{ (string) $item->pengkajianAwal?->pelayanan_id ?? '' }}">
                            {{ $item->pasien->nama }}
                        </option>
                    @endforeach
                </select> -->
                <!-- Pasien (auto-filled) -->
                <label style="display:block; text-align:left;"><strong>Pasien</strong></label>
                @if (isset($pendaftaran))
                    <input type="hidden" name="pasien_id" value="{{ $pendaftaran->pasien->id }}">
                    <input type="text" class="form-input" value="{{ $pendaftaran->pasien->nama }}" readonly>
                @else
                    <select name="pasien_id" id="selectPasien" class="form-input" required
                        onchange="updateTanggalPendaftaran()">
                        <option value="">-- Pilih Pasien --</option>
                        @foreach ($pendaftarans as $item)
                            <option value="{{ $item->pasien->id }}"
                                data-created-at="{{ $item->created_at->format('Y-m-d') }}"
                                data-pelayanan-id="{{ (string) $item->pengkajianAwal?->pelayanan_id ?? '' }}">
                                {{ $item->pasien->nama }}</option>
                        @endforeach
                    </select>
                @endif

                <label style="display:block; text-align:left;"><strong>Tanggal</strong></label>
                <input type="date" name="tanggal" required class="form-input"
                    value="{{ $defaultTanggal ?? date('Y-m-d') }}" id="tanggalPendaftaran">

                <label style="display:block; text-align:left;"><strong>Diagnosa Awal</strong></label>
                <textarea name="diagnosa" rows="3" required class="form-input"></textarea>

                <label style="display:block; text-align:left;"><strong>Master Diagnosa</strong></label>
                <select name="master_diagnosa_id" required class="form-input">
                    <option value="">-- Pilih Diagnosa --</option>
                    @foreach ($masters as $master)
                        <option value="{{ $master->id }}">{{ $master->nama }}</option>
                    @endforeach
                </select>

                {{-- <label style="display:block; text-align:left;"><strong>Pelayanan</strong></label>
                <select name="pelayanan_id" class="form-input" required disabled>
                    <option value="">-- Pilih Pelayanan --</option>
                    @foreach ($layanans as $layanan)
                        <option value="{{ (string) $layanan->id }}">{{ $layanan->nama_pelayanan }}</option>
                    @endforeach
                </select> --}}
                <label style="display:block; text-align:left;"><strong>Pelayanan</strong></label>
                <select name="pelayanan_id" class="form-input" required
                    @if (isset($pendaftaran)) id="pelayananSelect" @else disabled @endif>
                    <option value="">-- Pilih Pelayanan --</option>
                    @foreach ($layanans as $layanan)
                        <option value="{{ $layanan->id }}" @if (isset($pendaftaran) && $pendaftaran->pengkajianAwal && $pendaftaran->pengkajianAwal->pelayanan_id == $layanan->id) selected @endif>
                            {{ $layanan->nama_pelayanan }}
                        </option>
                    @endforeach
                </select>

                <label style="display:block; text-align:left;"><strong>Perawat</strong></label>
                <input type="hidden" name="user_id" required value="{{ $perawats->id }}">
                <input type="text" class="form-input" value="{{ $perawats->nama_lengkap }}" readonly>

                <div style="margin-top: 1rem; display: flex; justify-content: flex-end; gap: 0.5rem;">
                    <a href="{{ route('data-diagnosa-awal.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">Simpan</button>
                </div>
            </div>
            <div style="flex: 1; min-width: 300px;">
            </div>
        </form>
    </section>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Jika ada pendaftaran yang dipilih, set nilai awal
            @if (isset($pendaftaran))
                document.getElementById('tanggalPendaftaran').value = "{{ $defaultTanggal }}";

                const pelayananSelect = document.getElementById('pelayananSelect');
                if (pelayananSelect) {
                    pelayananSelect.disabled = false;
                    @if ($pendaftaran->pengkajianAwal && $pendaftaran->pengkajianAwal->pelayanan_id)
                        pelayananSelect.value = "{{ $pendaftaran->pengkajianAwal->pelayanan_id }}";
                    @endif
                }
            @endif
        });

        function updateTanggalPendaftaran() {
            const pasienSelect = document.getElementById('selectPasien');
            const selectedOption = pasienSelect.options[pasienSelect.selectedIndex];
            const tanggal = selectedOption.getAttribute('data-created-at');
            const pelayananId = selectedOption.getAttribute('data-pelayanan-id');

            document.getElementById('tanggalPendaftaran').value = tanggal;

            const pelayananSelect = document.querySelector('select[name="pelayanan_id"]');
            pelayananSelect.disabled = false;

            // Pilih otomatis pelayanan sesuai data
            Array.from(pelayananSelect.options).forEach(option => {
                option.selected = option.value === pelayananId;
            });
        }
    </script>

@endsection
