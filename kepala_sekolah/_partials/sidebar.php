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
    
    <li class="nav-item <?php if ($current_page==='laporan_kelulusan') echo 'active' ?>">
      <a class="nav-link" href="laporan_kelulusan.php?go=laporan_kelulusan">
        <i class="icon-file menu-icon"></i>
        <span class="menu-title">Laporan Kelulusan</span>
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