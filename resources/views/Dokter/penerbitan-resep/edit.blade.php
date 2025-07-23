@extends('main')

@section('title', 'Edit Resep - Klinik')

@section('content')
    <section class="blank-content">
        <h3 style="margin-bottom: 1rem; color: rgb(33, 106, 178); text-align:left;">Edit Penerbitan Resep</h3>

        <form method="POST" action="{{ route('penerbitan-resep.update', $resep->id) }}"
            style="max-width: 1000px; display: flex; gap: 2rem; flex-wrap: wrap;">
            @csrf
            @method('PUT')

            <div style="flex: 1; min-width: 300px;">
                <label style="display:block; text-align:left;"><strong>Pasien</strong></label>
                <select name="pasien_id" required class="form-input">
                    <option value="">-- Pilih Pasien --</option>
                    @foreach ($pasiens as $pasien)
                        <option value="{{ $pasien->id }}" {{ $resep->pasien_id == $pasien->id ? 'selected' : '' }}>
                            {{ $pasien->nama }}
                        </option>
                    @endforeach
                </select>

                <label style="display:block; text-align:left;"><strong>Dokter</strong></label>
                <input type="hidden" name="user_id" class="input-style" required value="{{ $dokters->id }}" readonly>
                <input type="text" class="input-style" value="{{ $dokters->nama_lengkap }}" readonly>

                <label style="display:block; text-align:left;"><strong>Tanggal</strong></label>
                <input type="date" name="tanggal" value="{{ $resep->tanggal }}" required class="form-input">

                <label style="display:block; text-align:left;"><strong>Catatan</strong></label>
                <textarea name="catatan" rows="4" class="form-input">{{ $resep->catatan }}</textarea>

            </div>

            <div style="flex: 1; min-width: 300px;">
                <label style="display:block; text-align:left;"><strong>Obat</strong></label>
                <div id="obat-container">
                    @foreach ($resep->detail as $i => $detail)
                        <div class="obat-group">
                            <select name="obat_id[]" required class="form-input">
                                <option value="">-- Pilih Obat --</option>
                                @foreach ($obats as $obat)
                                    <option value="{{ $obat->id }}"
                                        {{ $obat->id == $detail->obat_id ? 'selected' : '' }}>
                                        {{ $obat->nama_obat }}
                                    </option>
                                @endforeach
                            </select>

                            <input type="number" name="jumlah[]" value="{{ $detail->jumlah }}" placeholder="Jumlah"
                                class="form-input" required>
                            <input type="text" name="dosis[]" value="{{ $detail->dosis }}" placeholder="Dosis"
                                class="form-input" required>
                            <input type="text" name="aturan_pakai[]" value="{{ $detail->aturan_pakai }}"
                                placeholder="Aturan Pakai" class="form-input" required>

                            @if ($i > 0)
                                <button type="button" class="btn-remove" onclick="removeObat(this)">Hapus</button>
                            @endif
                        </div>
                    @endforeach
                </div>

                <button type="button" class="btn btn-info" onclick="tambahObat()">+ Tambah Obat</button>

                <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                    <a href="{{ route('penerbitan-resep.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">Update</button>
                </div>
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

        .btn-info {
            padding: 0.5rem 1.2rem;
            color: white;
            background-color: rgb(4, 135, 109);
            border: none;
            border-radius: 8px;
            cursor: pointer;
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

        .btn-remove {
            background-color: red;
            color: white;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            cursor: pointer;
        }

        .obat-group {
            border: 1px solid #ddd;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border-radius: 6px;
        }
    </style>

    <script>
        function tambahObat() {
            const container = document.getElementById('obat-container');
            const div = document.createElement('div');
            div.classList.add('obat-group');

            div.innerHTML = `
            <select name="obat_id[]" required class="form-input">
                <option value="">-- Pilih Obat --</option>
                @foreach ($obats as $obat)
                    <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                @endforeach
            </select>
            <input type="number" name="jumlah[]" placeholder="Jumlah" class="form-input" required>
            <input type="text" name="dosis[]" placeholder="Dosis" class="form-input" required>
            <input type="text" name="aturan_pakai[]" placeholder="Aturan Pakai" class="form-input" required>
            <button type="button" class="btn-remove" onclick="removeObat(this)">Hapus</button>
        `;

            container.appendChild(div);
        }

        function removeObat(button) {
            button.parentElement.remove();
        }
    </script>
@endsection
