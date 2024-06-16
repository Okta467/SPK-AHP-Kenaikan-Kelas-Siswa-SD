<?php $current_page = $_GET['go'] ?? '' ?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item <?php if ($current_page==='dashboard') echo 'active' ?>">
      <a class="nav-link" href="index.php?go=dashboard">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    
    <li class="nav-item <?php if ($current_page==='profil') echo 'active' ?>">
      <a class="nav-link" href="profil.php?go=profil">
        <i class="icon-head menu-icon"></i>
        <span class="menu-title">Profil</span>
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
    
    <li class="nav-item <?php if ($current_page==='range_nilai') echo 'active' ?>">
      <a class="nav-link" href="range_nilai.php?go=range_nilai">
        <i class="ti-dashboard menu-icon"></i>
        <span class="menu-title">Range Nilai</span>
      </a>
    </li>
    
    <li class="nav-item <?php if ($current_page==='penilaian_alternatif') echo 'active' ?>">
      <a class="nav-link" href="penilaian_alternatif.php?go=penilaian_alternatif">
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
    
    <li class="nav-item <?php if ($current_page==='keluar') echo 'active' ?>">
      <a class="nav-link" href="<?= base_url('logout.php'); ?>">
        <i class="icon-power menu-icon"></i>
        <span class="menu-title">Keluar</span>
      </a>
    </li>

  </ul>
</nav>