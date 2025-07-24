@extends('main')

@section('title', 'Data Stok Obat - Klinik')

@section('content')
<section class="blank-content">
    <div class="table-header">
        <h3>Data Stok Obat</h3>
        <button onclick="document.getElementById('modalTambah').style.display='flex'"
            style="padding: 0.5rem 1rem; background:rgb(33, 106, 178); color:#fff; border:none; border-radius:8px; cursor:pointer;">
            Tambah Obat
        </button>
    </div>
    @if (session('success'))
    <div class="alert-success" id="successAlert">
        {{ session('success') }}
    </div>
    @endif

    <form method="GET" action="{{ route('menejemen-obat.index') }}"
        style="margin-bottom: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center;">
        <label for="filter_bulan"><strong>Filter Bulan Masuk:</strong></label>
        <input type="month" id="filter_bulan" name="filter_bulan" value="{{ request('filter_bulan') }}"
            class="input-style" style="max-width: 200px;">

        <button type="submit" class="btn btn-primary">Terapkan</button>

        <button type="button" onclick="exportPDF()" class="btn btn-info">
            Export PDF
        </button>
    </form>


    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Satuan</th>
                <th>Stok Total</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Keluar</th>
                <th>Keterangan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($obats as $index => $obat)
            <tr>
                <td>{{ $obats->firstItem() + $index }}</td>
                <td>{{ $obat->nama_obat }}</td>
                <td>{{ $obat->satuan->nama_satuan ?? '-' }}</td>
                <td>{{ $obat->stok_total }}</td>
                <td>
    {{ $obat->created_at ? $obat->created_at->format('d-m-Y ') : '-' }}
</td>

                <td>
                    {{
        $obat->pengeluaran && $obat->pengeluaran->count() > 0
            ? \Carbon\Carbon::parse($obat->pengeluaran->max('tanggal_keluar'))->format('d-m-Y')
            : '-'
    }}
                </td>
                <td>{{ $obat->keterangan ?? '-' }}</td>
                <td>
                    <a href="{{ route('menejemen-obat.show', $obat->id) }}" class="btn btn-info no-underline"><i
                            class="fas fa-eye"></i></a>
                    <a href="{{ route('menejemen-obat.edit', $obat->id) }}" class="btn btn-warning no-underline"><i
                            class="fas fa-pen"></i></a>
                    <form action="{{ route('menejemen-obat.destroy', $obat->id) }}" method="POST"
                        style="display:inline-block;"
                        onsubmit="return confirm('Yakin ingin menghapus data obat ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if ($obats->hasPages())
    <ul class="pagination">
        {{-- Previous --}}
        @if ($obats->onFirstPage())
        <li class="disabled"><span>«</span></li>
        @else
        <li><a href="{{ $obats->previousPageUrl() }}" rel="prev">«</a></li>
        @endif

        {{-- Page Numbers --}}
        @foreach ($obats->links()->elements[0] as $page => $url)
        @if ($page == $obats->currentPage())
        @else
        <li><a href="{{ $url }}">{{ $page }}</a></li>
        @endif
        @endforeach

        {{-- Next --}}
        @if ($obats->hasMorePages())
        <li><a href="{{ $obats->nextPageUrl() }}" rel="next">»</a></li>
        @else
        <li class="disabled"><span>»</span></li>
        @endif
    </ul>
    @endif


    <!-- Modal Tambah Obat -->
    <div id="modalTambah" onclick="if(event.target === this) this.style.display='none'"
        style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">
        <div
            style="background:#fff; padding:2rem; border-radius:12px; width:90%; max-width:500px; max-height:90vh; overflow:auto; box-shadow:0 5px 20px rgba(0,0,0,0.2); position:relative;">
            <span onclick="document.getElementById('modalTambah').style.display='none'"
                style="position:absolute; top:1rem; right:1rem; font-size:1.5rem; cursor:pointer; color:rgb(33, 106, 178);">&times;</span>
            <h3 style="margin-bottom:1rem; color:rgb(33, 106, 178); text-align:left;">Tambah Obat</h3>

            <form method="POST" action="{{ route('menejemen-obat.store') }}">
                @csrf
                <label style="display:block; text-align:left;"><strong>Nama Obat</strong></label>
                <input type="text" name="nama_obat" required class="input-style">

                <label style="display:block; text-align:left;"><strong>Satuan</strong></label>
                <select name="satuan_id" required class="input-style">
                    <option value="">-- Pilih Satuan --</option>
                    @foreach ($satuans as $satuan)
                    <option value="{{ $satuan->id }}">{{ $satuan->nama_satuan }}</option>
                    @endforeach
                </select>

                <label style="display:block; text-align:left;"><strong>Stok Total</strong></label>
                <input type="number" name="stok_total" min="0" required class="input-style">

                <label style="display:block; text-align:left;"><strong>Keterangan</strong></label>
                <textarea name="keterangan" class="input-style" rows="2"></textarea>

                <div style="display:flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
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
    background-color: rgb(4, 135, 109);
    color: white;
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
    doc.text("Data Stok Obat", 14, 15);

    const filterBulan = document.getElementById("filter_bulan")?.value;
    if (filterBulan) {
        doc.setFontSize(10);
        doc.text(`Filter Bulan: ${filterBulan}`, 14, 22);
    }

    const rows = [];
    const headers = [];
    document.querySelectorAll(".data-table thead th").forEach((th, i) => {
        if (i < 6) headers.push(th.innerText); // ambil hanya sampai kolom "Keterangan"
    });

    document.querySelectorAll(".data-table tbody tr").forEach(tr => {
        const row = [];
        tr.querySelectorAll("td").forEach((td, i) => {
            if (i < 6) row.push(td.innerText.trim()); // skip kolom "Action"
        });
        rows.push(row);
    });

    doc.autoTable({
        head: [headers],
        body: rows,
        startY: filterBulan ? 30 : 25,
        styles: {
            fontSize: 9
        },
        headStyles: {
            fillColor: [33, 106, 178]
        },
    });

    doc.save(`data_stok_obat_${filterBulan || 'semua'}.pdf`);
}
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
