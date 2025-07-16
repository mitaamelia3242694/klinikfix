@extends('main')

@section('title', 'Data Pasien - Klinik')

@section('content')
<section class="blank-content">
    <div class="table-header">
        <h3>Data Pasien</h3>
        <button onclick="document.getElementById('modalTambah').style.display='flex'"
            style="padding: 0.5rem 1rem; background:rgb(33, 106, 178); color:#fff; border:none; border-radius:8px; cursor:pointer;">
            Tambah Pasien
        </button>
    </div>

    <!-- Search dipindahkan ke bawah tombol tambah -->
    <form method="GET" action="{{ route('data-pasien.index') }}"
        style="margin-bottom: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">

        <input type="text" name="keyword" placeholder="Cari Nama / NIK" value="{{ request('keyword') }}"
            class="input-style" style="max-width: 250px;">

        <input type="month" name="filter_bulan" value="{{ request('filter_bulan') }}" class="input-style"
            style="max-width: 200px;">

        <select name="filter_gender" class="input-style" style="max-width: 150px;">
            <option value="">Semua Jenis Kelamin</option>
            <option value="L" {{ request('filter_gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ request('filter_gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>

        <select name="filter_asuransi" class="input-style" style="max-width: 180px;">
            <option value="">Semua Status Asuransi</option>
            <option value="punya" {{ request('filter_asuransi') === 'punya' ? 'selected' : '' }}>Asuransi</option>
            <option value="tidak" {{ request('filter_asuransi') === 'tidak' ? 'selected' : '' }}>Non Asuransi
            </option>
        </select>

        <button type="submit" class="btn btn-primary">Terapkan</button>
        <button type="button" onclick="exportPDF()" class="btn btn-info">Export PDF</button>
    </form>




    @if (session('success'))
    <div class="alert-success" id="successAlert">
        {{ session('success') }}
    </div>
    @endif


    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>No HP</th>
                <th>Asuransi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pasiens as $index => $pasien)
            <tr>
                <td>{{ ($pasiens->currentPage() - 1) * $pasiens->perPage() + $index + 1 }}</td>
                <td>{{ $pasien->NIK }}</td>
                <td>{{ $pasien->nama }}</td>
                <td>{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d-m-Y') }}</td>
                <td>{{ $pasien->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td>{{ $pasien->no_hp }}</td>
                <td>{{ $pasien->asuransi->nama_perusahaan ?? '-' }}</td>
                <td>
                    <div style="display: flex; gap: 0.4rem; flex-wrap: wrap;">
                        <a href="{{ route('data-pasien.show', $pasien->id) }}" class="btn btn-info no-underline"><i
                                class="fas fa-eye"></i></a>
                        <a href="{{ route('data-pasien.edit', $pasien->id) }}" class="btn btn-warning"><i
                                class="fas fa-pen"></i></a>
                        <form action="{{ route('data-pasien.destroy', $pasien->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"> <i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

    @if ($pasiens->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($pasiens->onFirstPage())
        <li class="disabled"><span>«</span></li>
        @else
        <li><a href="{{ $pasiens->previousPageUrl() }}" rel="prev">«</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($pasiens->links()->elements[0] as $page => $url)
        @if ($page == $pasiens->currentPage())
        <li class="active"><span>{{ $page }}</span></li>
        @else
        <li><a href="{{ $url }}">{{ $page }}</a></li>
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($pasiens->hasMorePages())
        <li><a href="{{ $pasiens->nextPageUrl() }}" rel="next">»</a></li>
        @else
        <li class="disabled"><span>»</span></li>
        @endif
    </ul>
    @endif


    <!-- Modal Tambah Pasien -->
    <div id="modalTambah" onclick="if(event.target === this) this.style.display='none'"
        style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">
        <div
            style="background:#fff; padding:2rem; border-radius:12px; width:90%; max-width:600px; max-height:90vh; overflow:auto; box-shadow:0 5px 20px rgba(0,0,0,0.2); position:relative;">
            <span onclick="document.getElementById('modalTambah').style.display='none'"
                style="position:absolute; top:1rem; right:1rem; font-size:1.5rem; cursor:pointer; color:rgb(33, 106, 178);">&times;</span>
            <h3 style="margin-bottom:1rem; color:rgb(33, 106, 178); text-align:left;">Tambah Pasien</h3>

            <form method="POST" action="{{ route('data-pasien.store') }}">
                @csrf
                <label style="display:block; text-align:left;"><strong>NIK</strong></label>
                <input type="text" name="NIK" class="input-style" required>

                <label style="display:block; text-align:left;"><strong>Nama</strong></label>
                <input type="text" name="nama" class="input-style" required>

                <label style="display:block; text-align:left;"><strong>Tanggal Lahir</strong></label>
                <input type="date" name="tanggal_lahir" class="input-style" required>

                <label style="display:block; text-align:left;"><strong>Jenis Kelamin</strong></label>
                <select name="jenis_kelamin" class="input-style" required>
                    <option value="">-- Pilih --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>

                <label style="display:block; text-align:left;"><strong>Alamat</strong></label>
                <textarea name="alamat" class="input-style" rows="3" required></textarea>

                <label style="display:block; text-align:left;"><strong>No HP</strong></label>
                <input type="text" name="no_hp" class="input-style" required>

                <label style="display:block; text-align:left;"><strong>Asuransi</strong></label>
                <select name="asuransi_id" class="input-style">
                    <option value="">-- Pilih Asuransi --</option>
                    @foreach ($asuransis as $asuransi)
                    <option value="{{ $asuransi->id }}">{{ $asuransi->nama_perusahaan }}</option>
                    @endforeach
                </select>

                <div style="display:flex; justify-content:flex-end; gap: 0.5rem; margin-top: 1rem;">
                    <button type="button" onclick="document.getElementById('modalTambah').style.display='none'"
                        class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</section>

<style>
.alert-success {
    background-color: #d4edda;
    color: #155724;
    border-left: 5px solid #28a745;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 1rem;
    position: relative;
    animation: fadeSlide 0.5s ease-out;
}

@keyframes fadeSlide {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.input-style {
    width: 100%;
    padding: 0.6rem;
    margin-bottom: 0.6rem;
    border: 1px solid #ccc;
    border-radius: 6px;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

.data-table th,
.data-table td {
    padding: 10px 12px;
    border: 1px solid #ddd;
}

.data-table th {
    background-color: #f0f0f0;
}

.btn {
    padding: 6px 10px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    text-decoration: none;
    margin-right: 4px;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-warning {
    background-color: #ffc107;
    color: black;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

.btn-info {
    color: white;
    background-color: rgb(4, 135, 109);
}

.no-underline {
    text-decoration: none;
}

.data-table td div {
    flex-wrap: wrap;
    justify-content: flex-start;
}

/* Pagination custom minimalis */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 1rem;
    gap: 0.5rem;
    flex-wrap: wrap;
    list-style: none;
    padding: 0;
}

.pagination li {
    margin: 0;
}

.pagination li span,
.pagination li a {
    display: block;
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    color: rgb(33, 106, 178);
    background-color: #f2f2f2;
    transition: background-color 0.2s, color 0.2s;
}

.pagination li a:hover {
    background-color: rgb(33, 106, 178);
    color: #fff;
}

.pagination li.active span {
    background-color: rgb(33, 106, 178);
    color: #fff;
    font-weight: bold;
}

.pagination li.disabled span {
    color: #aaa;
    background-color: #eee;
    cursor: default;
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

<script>
function exportPDF() {
    const {
        jsPDF
    } = window.jspdf;
    const doc = new jsPDF();

    doc.setFontSize(14);
    doc.text("Data Pasien", 14, 15);

    const filterAsuransi = document.querySelector('select[name="filter_asuransi"]')?.value;
    let nextY = 22;

    if (filterBulan) {
        doc.setFontSize(10);
        doc.text(`Filter Bulan: ${filterBulan}`, 14, nextY);
        nextY += 7;
    }

    if (filterGender) {
        const genderText = filterGender === 'L' ? 'Laki-laki' : 'Perempuan';
        doc.text(`Jenis Kelamin: ${genderText}`, 14, nextY);
        nextY += 7;
    }

    if (filterAsuransi) {
        const asuransiText = filterAsuransi === 'punya' ? 'Punya Asuransi' : 'Tidak Punya Asuransi';
        doc.text(`Status Asuransi: ${asuransiText}`, 14, nextY);
        nextY += 7;
    }

    doc.autoTable({
        head: [headers],
        body: rows,
        startY: nextY + 3,
        styles: {
            fontSize: 9
        },
        headStyles: {
            fillColor: [33, 106, 178]
        },
    });

    const fileName =
        `data_pasien_${filterBulan || 'semua'}_${filterGender || 'semua'}_${filterAsuransi || 'semua'}.pdf`;
    doc.save(fileName);


    // Sembunyikan alert setelah 5 detik
    window.onload = function() {
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.transition = 'opacity 0.5s ease';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.style.display = 'none', 500);
            }, 5000);
        }
    };
</script>

@endsection
