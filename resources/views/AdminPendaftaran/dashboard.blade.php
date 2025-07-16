@extends('main')

@section('title', 'Dashboard Admin Pendaftaran')

@section('content')

<section class="cards">
    <div class="card blue">
        <p>Data Pasien</p>
        <h3>{{ $jumlahPasien }} Pasien</h3>
    </div>
    <div class="card indigo">
        <p>Data Pelayanan</p>
        <h3>{{ $jumlahPelayanan }} Jenis</h3>
    </div>
    <div class="card violet">
        <p>Data Asuransi</p>
        <h3>{{ $jumlahAsuransi }} Asuransi</h3>
    </div>
    <div class="card purple">
        <p>Pasien Baru Hari ini</p>
        <h3>{{ $pendaftarHariIni }} Orang</h3>
    </div>
</section>

<section class="chart-section">
    <h3 class="chart-title">Grafik Pendaftaran Bulanan</h3>
    <div class="filter-card">
       <form method="GET" action="{{ route('dashboard.index') }}">
    <div class="filter-grid">
        <div class="filter-group">
            <label for="tahun">Tahun</label>
            <select name="tahun" id="tahun" onchange="this.form.submit()">
                @for ($y = now()->year; $y >= 2020; $y--)
                    <option value="{{ $y }}" {{ request('tahun', now()->year) == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        </div>
    </div>
</form>

    </div>
    <canvas id="chart"></canvas>
</section>

<style>
    /* Filter Card */
    .filter-card {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    /* Grid Form */
    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 20px;
        align-items: end;
    }

    /* Group */
    .filter-group {
        display: flex;
        flex-direction: column;
    }


    .filter-group label {
        display: block;
        text-align: left;
        margin-bottom: 6px;
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }


    .filter-group select,
    .filter-group input[type="date"] {
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
    }

    /* Tombol */
    .button-group button {
        padding: 10px 16px;
        background-color: #216ab2;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .button-group button:hover {
        background-color: #1a5c9b;
    }

    /* Cards */
    .cards {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
    }

    .card {
        flex: 1;
        padding: 20px;
        color: white;
        border-radius: 10px;
        text-align: center;
    }

    .card h3 {
        font-size: 20px;
    }

    .card.blue,
    .card.indigo,
    .card.violet,
    .card.purple {
        background: rgb(33, 106, 178);
    }


    /* Chart */
    .chart-section {
        background-color: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .chart-title {
        text-align: left;
        margin-bottom: 15px;
        font-size: 18px;
        font-weight: 600;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Jumlah Pendaftaran',
                data: @json($dataBulanan),
                backgroundColor: 'rgb(33, 106, 178)',
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>
@endsection