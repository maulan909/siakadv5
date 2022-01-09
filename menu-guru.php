<section class="sidebar">
  <!-- Sidebar user panel -->
  <div class="user-panel">
    <div class="pull-left image">
      <img src="<?php echo $foto; ?>" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
      <p><?php echo $nama; ?></p>
      <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
  </div>

  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu">
    <li class="header" style='color:#fff; text-transform:uppercase; border-bottom:2px solid #00c0ef'>MENU <?php echo $level; ?></li>
    <li><a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
    <li><a href="index.php?view=kaldik"><i class="fa fa-calendar"></i>Kalender Akademik</a></li>
    <li><a href="index.php?view=jadwal-pelajaran"><i class="fa fa-calendar"></i> <span>Jadwal Pelajaran</span></a></li>
    <li><a href="index.php?view=absensiswa&act=detailabsenguru"><i class="fa fa-th-large"></i> <span>Absensi Siswa</span></a></li>
    <li><a href="index.php?view=bahantugas&act=listbahantugasguru"><i class="fa fa-file"></i><span>Bahan dan Tugas</span></a></li>
    <li><a href="index.php?view=soal&act=detailguru"><i class="fa fa-users"></i><span>Quiz / Ujian Online</span></a></li>
    <li><a href="index.php?view=forum&act=detailguru"><i class="fa fa-th-list"></i> <span>Forum Diskusi</span></a></li>
    <li><a href="index.php?view=kompetensiguru"><i class="fa fa-tags"></i> <span>Kompetensi Dasar</span></a></li>
    <li><a href="index.php?view=journalguru"><i class="fa fa-list"></i> <span>Journal KBM</span></a></li>
    <?php
    $tampil = mysql_num_rows(mysql_query("SELECT * FROM rb_kelas WHERE nip = '" . $_SESSION['id'] . "'"));
    if ($tampil > 0) {
    ?>
      <li class="treeview">
        <a href="#"><i class="fa fa-calendar"></i> <span>Laporan Nilai Siswa</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li><a href="index.php?view=rapor"><i class="fa fa-circle-o"></i> Upload Raport Siswa</a></li>
          <li><a href="index.php?view=raport-list"><i class="fa fa-circle-o"></i> File Raport Siswa</a></li>
          <!-- <li><a href="index.php?view=raportuts&act=detailguru"><i class="fa fa-circle-o"></i> Input Nilai UTS</a></li>
        <li><a href="index.php?view=raport&act=detailguru"><i class="fa fa-circle-o"></i> Input Nilai Raport</a></li> -->
        </ul>
      </li>
    <?php
    }
    $tampil = mysql_num_rows(mysql_query("SELECT * FROM rb_jadwal_pelajaran WHERE kode_pelajaran = 'T1' AND nip = '" . $_SESSION['id'] . "'"));
    ?>
    <?php if ($tampil > 0) : ?>
      <li><a href="index.php?view=tahfizh"><i class="fa fa-newspaper-o"></i> Penilaian Tahfizh</a></li>
    <?php endif; ?>
    <?php
    $tampil = mysql_num_rows(mysql_query("SELECT * FROM rb_jadwal_pelajaran WHERE kode_pelajaran = 'T2' AND nip = '" . $_SESSION['id'] . "'"));
    ?>
    <?php if ($tampil > 0) : ?>
      <li><a href="index.php?view=tahsin"><i class="fa fa-newspaper-o"></i> Penilaian Tahsin</a></li>
    <?php endif; ?>
    <li><a href="index.php?view=dokumentasiguru"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
  </ul>
</section>