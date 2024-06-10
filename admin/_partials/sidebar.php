<?php $current_page = $_GET['go'] ?? '' ?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item <?php if ($current_page==='dashboard') echo 'active' ?>">
      <a class="nav-link" href="index.php?go=dashboard">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    
    <li class="nav-item <?php if ($current_page==='guru') echo 'active' ?>">
      <a class="nav-link" href="guru.php?go=guru">
        <i class="icon-head menu-icon"></i>
        <span class="menu-title">Guru</span>
      </a>
    </li>
    
    <li class="nav-item <?php if ($current_page==='siswa') echo 'active' ?>">
      <a class="nav-link" href="siswa.php?go=siswa">
        <i class="icon-head menu-icon"></i>
        <span class="menu-title">Siswa</span>
      </a>
    </li>
    
    <li class="nav-item <?php if ($current_page==='alternatif') echo 'active' ?>">
      <a class="nav-link" href="alternatif.php?go=alternatif">
        <i class="icon-star menu-icon"></i>
        <span class="menu-title">Alternatif</span>
      </a>
    </li>
    
    <li class="nav-item <?php if ($current_page==='kriteria') echo 'active' ?>">
      <a class="nav-link" href="kriteria.php?go=kriteria">
        <i class="ti-agenda menu-icon"></i>
        <span class="menu-title">kriteria</span>
      </a>
    </li>
    
    <li class="nav-item <?php if ($current_page==='sub_kriteria') echo 'active' ?>">
      <a class="nav-link" href="sub_kriteria.php?go=sub_kriteria">
        <i class="ti-agenda menu-icon"></i>
        <span class="menu-title">Sub-Kriteria</span>
      </a>
    </li>
    
    <li class="nav-item <?php if ($current_page==='jabatan') echo 'active' ?>">
      <a class="nav-link" href="jabatan.php?go=jabatan">
        <i class="icon-file menu-icon"></i>
        <span class="menu-title">Jabatan</span>
      </a>
    </li>
    
    <li class="nav-item <?php if ($current_page==='nilai') echo 'active' ?>">
      <a class="nav-link" href="nilai.php?go=nilai">
        <i class="ti-write menu-icon"></i>
        <span class="menu-title">Nilai</span>
      </a>
    </li>
    
    <li class="nav-item <?php if ($current_page==='hasil_perhitungan') echo 'active' ?>">
      <a class="nav-link" href="hasil_perhitungan.php?go=hasil_perhitungan">
        <i class="ti-bar-chart menu-icon"></i>
        <span class="menu-title">Hasil Perhitungan</span>
      </a>
    </li>
    
    <li class="nav-item <?php if ($current_page==='jabatan') echo 'active' ?>">
      <a class="nav-link" href="jabatan.php?go=jabatan">
        <i class="icon-briefcase menu-icon"></i>
        <span class="menu-title">Jabatan</span>
      </a>
    </li>
    
    <li class="nav-item <?php if ($current_page==='pangkat_golongan') echo 'active' ?>">
      <a class="nav-link" href="pangkat_golongan.php?go=pangkat_golongan">
        <i class="icon-briefcase menu-icon"></i>
        <span class="menu-title">Pangkat/Golongan</span>
      </a>
    </li>

    <li class="nav-item <?php if ($current_page==='pendidikan' || $current_page==='jurusan_pendidikan') echo 'active' ?>">
      <a class="nav-link" data-toggle="collapse" href="#pendidikan" aria-expanded="false" aria-controls="pendidikan">
        <i class="ti-agenda menu-icon"></i>
        <span class="menu-title">Pendidikan</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="pendidikan">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link <?php if ($current_page==='pendidikan') echo 'active' ?>" href="pendidikan.php?go=pendidikan">
              <i class="mdi mdi-chevron-right mr-1"></i> Data Pendidikan
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if ($current_page==='jurusan_pendidikan') echo 'active' ?>" href="jurusan_pendidikan.php?go=jurusan_pendidikan">
              <i class="mdi mdi-chevron-right mr-1"></i> Data Jurusan 
            </a>
          </li>
        </ul>
      </div>
    </li>
    
    <li class="nav-item <?php if ($current_page==='kelas') echo 'active' ?>">
      <a class="nav-link" href="kelas.php?go=kelas">
        <i class="ti-blackboard menu-icon"></i>
        <span class="menu-title">Kelas</span>
      </a>
    </li>
    
    <li class="nav-item <?php if ($current_page==='pengguna') echo 'active' ?>">
      <a class="nav-link" href="pengguna.php?go=pengguna">
        <i class="icon-head menu-icon"></i>
        <span class="menu-title">Pengguna</span>
      </a>
    </li>
    
    <li class="nav-item <?php if ($current_page==='keluar') echo 'active' ?>">
      <a class="nav-link" href="<?= base_url('logout.php'); ?>">
        <i class="icon-power menu-icon"></i>
        <span class="menu-title">Keluar</span>
      </a>
    </li>

  </ul>
</nav>