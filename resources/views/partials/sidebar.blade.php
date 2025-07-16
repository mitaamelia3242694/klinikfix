<aside class="sidebar">
    <div class="sidebar-header">
        <img src="/logo.png" alt="Logo" />
        <span>Klinik Pratama<br><strong>Lanal Banyuwangi</strong></span>
    </div>
    <ul class="nav">
        @php
        $role = auth()->user()->role->nama_role ?? '';
        @endphp

        @if ($role === 'Admin Pendaftaran')
        <li class="menu-label">Admin Pendaftaran</li>
        <li class="{{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
            <a href="{{ route('dashboard.index') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
        </li>
        <li class="{{ request()->routeIs('data-pasien.index') ? 'active' : '' }}">
            <a href="{{ route('data-pasien.index') }}"><i class="fas fa-user-injured"></i> <span>Data
                    Pasien</span></a>
        </li>
        <li class="{{ request()->routeIs('data-pendaftaran.index') ? 'active' : '' }}">
            <a href="{{ route('data-pendaftaran.index') }}"><i class="fas fa-user-plus"></i>
                <span>Pendaftaran</span></a>
        </li>
        <li class="{{ request()->routeIs('data-asal-pendaftaran.index') ? 'active' : '' }}">
            <a href="{{ route('data-asal-pendaftaran.index') }}"><i class="fas fa-map-marker-alt"></i>
                <span>Data Asal Pendaftar</span></a>
        </li>

        <li class="{{ request()->routeIs('data-pelayanan.index') ? 'active' : '' }}">
            <a href="{{ route('data-pelayanan.index') }}"><i class="fas fa-concierge-bell"></i> <span>Data
                    Pelayanan</span></a>
        </li>
        <li class="{{ request()->routeIs('data-asuransi.index') ? 'active' : '' }}">
            <a href="{{ route('data-asuransi.index') }}">
                <i class="fas fa-file-medical"></i> <span>Data Asuransi</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('master-diagnosa.index') ? 'active' : '' }}">
            <a href="{{ route('master-diagnosa.index') }}">
                <i class="fas fa-notes-medical"></i> <span>Master Diagnosa</span>
            </a>
        </li>
        @endif

        @if ($role === 'Perawat')
        <li class="menu-label">Perawat</li>
        <li class="{{ request()->routeIs('dashboard-perawat.index') ? 'active' : '' }}">
            <a href="{{ route('dashboard-perawat.index') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
        </li>
        <li class="{{ request()->routeIs('data-kajian-awal.index') ? 'active' : '' }}">
            <a href="{{ route('data-kajian-awal.index') }}"><i class="fas fa-file-medical-alt"></i> <span>Data Kajian
                    Awal</span></a>
        </li>
        <li class="{{ request()->routeIs('data-diagnosa-awal.index') ? 'active' : '' }}">
            <a href="{{ route('data-diagnosa-awal.index') }}"><i class="fas fa-notes-medical"></i> <span>Data Diagnosa
                    Awal</span></a>
        </li>
        <li class="{{ request()->routeIs('manajemen-tindakan.index') ? 'active' : '' }}">
            <a href="{{ route('manajemen-tindakan.index') }}"><i class="fas fa-briefcase-medical"></i> <span>Manajemen
                    Tindakan</span></a>
        </li>
        @endif

        @if ($role === 'Dokter')
        <li class="menu-label">Dokter</li>
        <li class="{{ request()->routeIs('dashboard-dokter.index') ? 'active' : '' }}">
            <a href="{{ route('dashboard-dokter.index') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
        </li>
        <li class="{{ request()->routeIs('pencatatan-diagnosa.index') ? 'active' : '' }}">
            <a href="{{ route('pencatatan-diagnosa.index') }}"><i class="fas fa-stethoscope"></i> <span>Pencatatan
                    Diagnosa</span></a>
        </li>
        <li class="{{ request()->routeIs('pencatatan-tindakan.index') ? 'active' : '' }}">
            <a href="{{ route('pencatatan-tindakan.index') }}"><i class="fas fa-hand-holding-heart"></i>
                <span>Pencatatan
                    Tindakan</span></a>
        </li>
        <li class="{{ request()->routeIs('penerbitan-resep.index') ? 'active' : '' }}">
            <a href="{{ route('penerbitan-resep.index') }}"><i class="fas fa-prescription-bottle-alt"></i>
                <span>Penerbitan
                    Resep</span></a>
        </li>
        <li class="{{ request()->routeIs('rekam-medis.index') ? 'active' : '' }}">
            <a href="{{ route('rekam-medis.index') }}">
                <i class="fas fa-notes-medical"></i> <span>Rekam Medis</span>
            </a>
        </li>
        @endif

        @if ($role === 'Apoteker')
        <li class="menu-label">Apoteker</li>
        <li class="{{ request()->routeIs('dashboard-apoteker.index') ? 'active' : '' }}">
            <a href="{{ route('dashboard-apoteker.index') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
        </li>
        <li class="{{ request()->routeIs('data-resep.index') ? 'active' : '' }}">
            <a href="{{ route('data-resep.index') }}"><i class="fas fa-prescription-bottle-alt"></i>
                <span>Resep</span></a>
        </li>
        <li class="{{ request()->routeIs('pengambilan-obat.index') ? 'active' : '' }}">
            <a href="{{ route('pengambilan-obat.index') }}"><i class="fas fa-hand-holding-medical"></i>
                <span>Pengambilan
                    Obat</span></a>
        </li>
        @endif

        @if ($role === 'Admin Stok Obat')
        <li class="menu-label">Admin Stok Obat</li>
        <li class="{{ request()->routeIs('dashboard-stokobat.index') ? 'active' : '' }}">
            <a href="{{ route('dashboard-stokobat.index') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
        </li>
        <li class="{{ request()->routeIs('menejemen-obat.index') ? 'active' : '' }}">
            <a href="{{ route('menejemen-obat.index') }}"><i class="fas fa-pills"></i> <span>Manage Stok Obat</span></a>
        </li>
        <li class="{{ request()->routeIs('satuan-obat.index') ? 'active' : '' }}">
            <a href="{{ route('satuan-obat.index') }}"><i class="fas fa-boxes"></i> <span>Satuan Obat</span></a>
        </li>
        <li class="{{ request()->routeIs('kesediaan-obat.index') ? 'active' : '' }}">
            <a href="{{ route('kesediaan-obat.index') }}"><i class="fas fa-warehouse"></i> <span>Ketersediaan
                    Obat</span></a>
        </li>
        @endif

        @if ($role === 'Admin IT')
        <li class="menu-label">Admin IT</li>
        <li class="{{ request()->routeIs('dashboard-it.index') ? 'active' : '' }}">
            <a href="{{ route('dashboard-it.index') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
        </li>
        <li class="{{ request()->routeIs('data-pegawai.index') ? 'active' : '' }}">
            <a href="{{ route('data-pegawai.index') }}"><i class="fas fa-users"></i> <span>Data Pegawai</span></a>
        </li>
        <li class="{{ request()->routeIs('data-jabatan.index') ? 'active' : '' }}">
            <a href="{{ route('data-jabatan.index') }}"><i class="fas fa-id-badge"></i> <span>Data Jabatan</span></a>
        </li>
        <li class="{{ request()->routeIs('manajemen-pengguna.index') ? 'active' : '' }}">
            <a href="{{ route('manajemen-pengguna.index') }}"><i class="fas fa-user-cog"></i> <span>Manage
                    Pengguna</span></a>
        </li>
        @endif
        <li>
            <form action="{{ route('logout') }}" method="POST"
                style="display: flex; align-items: center; padding: 0.75rem 1rem;">
                @csrf
                <button type="submit"
                    style="background: none; border: none; color: inherit; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                </button>
            </form>
        </li>
    </ul>
</aside>


<style>
.menu-label {
    font-size: 12px;
    text-transform: uppercase;
    padding: 8px 20px 4px;
    color: #888;
    font-weight: bold;
    user-select: none;
}

.sidebar {
    width: 250px;
    background-color: #fff;
    min-height: 100vh;
    padding: 20px 0;
    font-family: Arial, sans-serif;
}

.sidebar-header {
    text-align: center;
    padding: 10px 20px;
    border-bottom: 1px solidrgb(255, 255, 255);
}

.sidebar-header img {
    width: 80px;
    margin-bottom: 10px;
}

.sidebar-header span {
    display: block;
    font-size: 14px;
    line-height: 1.4;
    color: #2c3e50;
}

.nav {
    list-style-type: none;
    padding: 0;
    margin: 20px 0 0 0;
}

.nav li {
    padding: 12px 20px;
    transition: background 0.3s;
}

.nav li a {
    color: #2c3e50;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 12px;
}

.nav li:hover {
    background-color: #dfe6e9;
}

.nav li.active {
    background-color: rgb(33, 106, 178);
}

.nav li.active a {
    font-weight: bold;
    color: white;
}

.nav li.active i {
    color: white;
}

.nav i {
    width: 20px;
    text-align: center;
    color: #2c3e50;
}

.nav span {
    display: inline-block;
}
</style>
