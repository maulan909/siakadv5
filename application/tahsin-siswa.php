<?php
$siswa = mysql_fetch_assoc(mysql_query("SELECT * FROM rb_siswa WHERE nisn = '" . $_SESSION['id'] . "'"));
?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">List Penilaian Tahsin</h3>
            <form style='margin-right:5px; margin-top:0px' class='pull-right' action='index.php' method='GET'>
                <input type="hidden" name="view" value="tahsin">
                <select name="kelas" id="kelas" style="padding:4px;" required>
                    <option value="">-- Pilih Kelas --</option>
                    <?php
                    $tahun = mysql_query("SELECT DISTINCT kelas_kode, nama_kelas FROM rb_tahsin t LEFT JOIN rb_kelas k ON k.kode_kelas = t.kelas_kode WHERE siswa_id = '" . $siswa['id_siswa'] . "'");
                    while ($t = mysql_fetch_assoc($tahun)) {
                    ?>
                        <option value="<?= $t['kelas_kode']; ?>" <?= isset($_GET['kelas']) && $_GET['kelas'] == $t['kelas_kode'] ? 'selected' : ''; ?>><?= $t['kelas_kode']; ?> - <?= $t['nama_kelas']; ?></option>
                    <?php } ?>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
            </form>
        </div>
        <div class="box-body">
            <table>
                <tr>
                    <td width="50">Nama</td>
                    <td width="10">:</td>
                    <td width="300"><?= $siswa['nama']; ?></td>
                    <td width="50">Kelas</td>
                    <td width="10">:</td>
                    <?php
                    $kelas = mysql_fetch_assoc(mysql_query("SELECT * FROM rb_kelas WHERE kode_kelas = '" . $_GET['kelas'] . "'"))
                    ?>
                    <td><?= $kelas['nama_kelas']; ?></td>
                </tr>
            </table>
        </div>
        <div class="box-body">
            <table id='myTable' class='table table-bordered table-striped'>
                <thead>
                    <tr>
                        <th width="50" rowspan="2">TM</th>
                        <th rowspan="2">Tanggal</th>
                        <th colspan="3">UMMI / Al-Qur'an</th>
                        <th colspan="2">Ghorib</th>
                        <th colspan="2">Tajwid</th>
                        <th colspan="2">Hafalan</th>
                    </tr>
                    <tr>
                        <th>Jld / Surat</th>
                        <th>Hal / Ayat</th>
                        <th>Juz</th>
                        <th>Hal. </th>
                        <th>Materi</th>
                        <th>Hal. </th>
                        <th>Materi</th>
                        <th>Surat </th>
                        <th>Ayat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $lists = mysql_query("SELECT t.*, s.nama_surah FROM rb_tahsin t LEFT JOIN rb_surah s ON s.id = t.surat_hafalan WHERE siswa_id = '" . $siswa['id_siswa'] . "' AND kelas_kode = '" . $_GET['kelas'] . "' ORDER BY t.id ASC");
                    while ($l = mysql_fetch_assoc($lists)) {
                    ?>
                        <tr>
                            <td style="text-align: center;"><?= $l['tatap_muka']; ?></td>
                            <td style="text-align: center;"><?= $l['tanggal']; ?></td>
                            <td style="text-align: center;"><?= $l['jilid_surat']; ?></td>
                            <td style="text-align: center;"><?= $l['hal_ayat_ummi']; ?></td>
                            <td style="text-align: center;"><?= $l['juz_ummi']; ?></td>
                            <td style="text-align: center;"><?= $l['hal_gharib']; ?></td>
                            <td style="text-align: center;"><?= $l['materi_gharib']; ?></td>
                            <td style="text-align: center;"><?= $l['hal_tajwid']; ?></td>
                            <td style="text-align: center;"><?= $l['materi_tajwid']; ?></td>
                            <td style="text-align: center;"><?= $l['nama_surah']; ?></td>
                            <td style="text-align: center;"><?= $l['ayat_hafalan']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>