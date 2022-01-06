<?php

session_start();
// error_reporting(0);
include "config/koneksi.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_seo.php";

$view = isset($_GET['view']) ? $_GET['view'] : '';
$act = isset($_GET['act']) ? $_GET['act'] : '';

if ($view == 'tahfizh') {
    if ($act == 'add') {
        $siswa_id = $_POST['siswa_id'];
        $kelas_kode = $_POST['kelas_kode'];
        $capaian_juz = $_POST['capaian_juz'];
        $mutqin_juz = $_POST['mutqin_juz'];
        $capaian_pekan = $_POST['capaian_pekan'];
        $total_lembar = $_POST['total_lembar'];
        $rata_nilai_setoran = $_POST['rata_nilai_setoran'];
        $catatan_muhafizh = $_POST['catatan_muhafizh'];
        mysql_query("INSERT INTO rb_tahfizh VALUES(null, '$siswa_id', '$kelas_kode', 'reguler', '$capaian_juz', '$mutqin_juz', '$capaian_pekan', '$total_lembar', '$rata_nilai_setoran', '$catatan_muhafizh', now(), now())");
        $_SESSION['alert'] = 'Tambah Penilaian Berhasil';
        $_SESSION['type'] = 'success';
        header('location:index.php?view=' . $_GET['view'] . '&kelas=' . $_GET['kelas'] . '&siswa=' . $_GET['siswa']);
    } else if ($act == 'get') {
        echo json_encode(mysql_fetch_assoc(mysql_query("SELECT * FROM rb_tahfizh WHERE id = '" . $_POST['id'] . "'")));
    } else if ($act == 'edit') {
        $siswa_id = $_POST['siswa_id'];
        $kelas_kode = $_POST['kelas_kode'];
        $capaian_juz = $_POST['capaian_juz'];
        $mutqin_juz = $_POST['mutqin_juz'];
        $capaian_pekan = $_POST['capaian_pekan'];
        $total_lembar = $_POST['total_lembar'];
        $rata_nilai_setoran = $_POST['rata_nilai_setoran'];
        $catatan_muhafizh = $_POST['catatan_muhafizh'];
        mysql_query("UPDATE rb_tahfizh SET capaian_juz = '" . $capaian_juz . "',
                                            mutqin_juz = '" . $mutqin_juz . "',
                                            capaian_pekan = '" . $capaian_pekan . "',
                                            total_lembar = '" . $total_lembar . "',
                                            rata_nilai_setoran = '" . $rata_nilai_setoran . "',
                                            catatan_muhafizh = '" . $catatan_muhafizh . "',
                                            updated_at = now()
                                            WHERE id = '" . $_POST['id'] . "'");
        $_SESSION['alert'] = 'Edit Penilaian Berhasil';
        $_SESSION['type'] = 'success';
        header('location:index.php?view=' . $_GET['view'] . '&kelas=' . $_GET['kelas'] . '&siswa=' . $_GET['siswa']);
    }
} else if ($view == 'tahsin') {
    if ($act == 'add') {
        $siswa_id = $_POST['siswa_id'];
        $kelas_kode = $_POST['kelas_kode'];
        $tatap_muka = $_POST['tatap_muka'];
        $tanggal = $_POST['tanggal'];
        $jilid_surat = $_POST['jilid_surat'];
        $hal_ayat_ummi = $_POST['hal_ayat_ummi'];
        $juz_ummi = $_POST['juz_ummi'];
        $hal_gharib = $_POST['hal_gharib'];
        $materi_gharib = $_POST['materi_gharib'];
        $hal_tajwid = $_POST['hal_tajwid'];
        $materi_tajwid = $_POST['materi_tajwid'];
        $surat_hafalan = $_POST['surat_hafalan'];
        $ayat_hafalan = $_POST['ayat_hafalan'];
        mysql_query("INSERT INTO rb_tahsin VALUES(null, '$siswa_id', '$kelas_kode', '$tatap_muka', '$tanggal', '$jilid_surat', '$hal_ayat_ummi', '$juz_ummi', '$hal_gharib', '$materi_gharib', '$hal_tajwid', '$materi_tajwid', '$surat_hafalan', '$ayat_hafalan')");
        $_SESSION['alert'] = 'Tambah Penilaian Berhasil';
        $_SESSION['type'] = 'success';
        header('location:index.php?view=' . $_GET['view'] . '&kelas=' . $_GET['kelas'] . '&siswa=' . $_GET['siswa']);
    }
} else {
    header('location:index.php');
}
