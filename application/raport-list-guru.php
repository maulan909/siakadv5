<?php if ($_SESSION['level'] != 'guru' && $_SESSION['level'] != 'superuser') : ?>
    <script>
        window.location = 'index.php';
    </script>
<?php endif; ?>
<?php
$check = mysql_num_rows(mysql_query("SELECT * FROM rb_kelas WHERE nip = '" . $_SESSION['id'] . "'"));
if ($check < 1) { ?>
    <script>
        window.location = 'index.php';
    </script>
<?php
}
?>
<div class="col-xs-12">
    <div class="box">
        <?php if (!isset($_GET['siswa'])) : ?>
            <div class="box-header">
                <h3 class="box-title">List Raport Siswa</h3>
                <form style='margin-right:5px; margin-top:0px' class='pull-right' action='index.php?view=raport-list' method='GET'>
                    <input type="hidden" name="view" value="raport-list">
                    <select name="tahun_ujian" id="tahun_ujian" style="padding:4px;" required>
                        <option value="">-- Pilih Tahun --</option>
                        <?php
                        $tahun = mysql_query("SELECT DISTINCT tahun_ujian FROM rb_file_raport");
                        while ($t = mysql_fetch_assoc($tahun)) {
                        ?>
                            <option value="<?= $t['tahun_ujian']; ?>" <?= $_GET['tahun_ujian'] == $t['tahun_ujian'] ? 'selected' : ''; ?>><?= $t['tahun_ujian']; ?></option>
                        <?php } ?>
                    </select>
                    <select name="semester" id="semester" style="padding:4px;" required>
                        <option value="">-- Pilih Semester --</option>
                        <option value="1" <?= $_GET['semester'] == 1 ? 'selected' : ''; ?>>Semester 1</option>
                        <option value="2" <?= $_GET['semester'] == 2 ? 'selected' : ''; ?>>Semester 2</option>
                    </select>
                    <select name="type" id="type" style="padding:4px;" required>
                        <option value="">-- Pilih Ujian --</option>
                        <option value="uts" <?= $_GET['type'] == 'uts' ? 'selected' : ''; ?>>UTS</option>
                        <option value="uas" <?= $_GET['type'] == 'uas' ? 'selected' : ''; ?>>UAS</option>
                    </select>
                    <select name="kelas" id="kelas" style="padding:4px" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php
                        if ($_SESSION['level'] == 'guru') {
                            $kelas = mysql_query("SELECT * FROM rb_kelas WHERE nip = '" . $_SESSION['id'] . "'");
                        } else if ($_SESSION['level'] == 'superuser') {
                            $kelas = mysql_query("SELECT * FROM rb_kelas");
                        }
                        while ($k = mysql_fetch_assoc($kelas)) {
                        ?>
                            <option value="<?= $k['kode_kelas']; ?>" <?= $_GET['kelas'] == $k['kode_kelas'] ? 'selected' : ''; ?>><?= $k['kode_kelas']; ?> - <?= $k['nama_kelas']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </form>
            </div>
            <div class="box-body">
                <table id='myTable' class='table table-bordered table-striped'>
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th width="150">NISN</th>
                            <th>Nama Siswa</th>
                            <th width="150">Angkatan</th>
                            <th width="150">Kelas</th>
                            <th width="300">Status</th>
                            <th width="200"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!isset($_GET['tahun_ujian']) || !isset($_GET['semester']) || !isset($_GET['type']) || !isset($_GET['kelas'])) : ?>
                            <tr>
                                <td colspan="7" style="text-align:center;color:red;">Silahkan pilih tahun, semester, ujian dan kelas terlebih dahulu</td>
                            </tr>
                        <?php else : ?>
                            <?php
                            $siswa = mysql_query("SELECT rb_siswa.id_siswa,rb_siswa.nisn,rb_siswa.nama,rb_siswa.angkatan,rb_siswa.kode_kelas,rb_kelas.nama_kelas FROM rb_siswa LEFT JOIN rb_kelas ON rb_kelas.kode_kelas = rb_siswa.kode_kelas WHERE rb_siswa.kode_kelas = '" . $_GET['kelas'] . "'");
                            // var_dump(mysql_fetch_assoc($siswa));
                            $no = 1;
                            while ($s = mysql_fetch_assoc($siswa)) {
                                $raport = mysql_num_rows(mysql_query("SELECT * FROM rb_file_raport WHERE id_siswa = '" . $s['id_siswa'] . "' AND tahun_ujian = '" . $_GET['tahun_ujian'] . "' AND semester = '" . $_GET['semester'] . "' AND jenis_ujian = '" . $_GET['type'] . "' AND kode_kelas = '" . $_GET['kelas'] . "'"));
                            ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $s['nisn']; ?></td>
                                    <td><?= $s['nama']; ?></td>
                                    <td><?= $s['angkatan']; ?></td>
                                    <td><?= $s['nama_kelas']; ?></td>
                                    <td><span class="badge" style="background-color:<?= $raport > 0 ? '#28A745' : '#DC3545'; ?>;"><?= $raport > 0 ? 'Raport tersedia' : 'Raport tidak tersedia'; ?></span></td>
                                    <td>
                                        <?php if ($raport > 0) : ?>
                                            <a href="index.php?view=raport-list&tahun_ujian=<?= $_GET['tahun_ujian']; ?>&semester=<?= $_GET['semester']; ?>&type=<?= $_GET['type']; ?>&kelas=<?= $_GET['kelas']; ?>&siswa=<?= $s['id_siswa']; ?>" class="btn btn-primary btn-sm">Lihat</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <?php $siswa = mysql_fetch_assoc(mysql_query("SELECT rb_siswa.*, rb_kelas.nama_kelas FROM rb_siswa LEFT JOIN rb_kelas ON rb_kelas.kode_kelas = rb_siswa.kode_kelas WHERE id_siswa = '" . $_GET['siswa'] . "'")); ?>
            <div class="box-header">
                <h3 class="box-title">List Raport <?= strtoupper($_GET['type']); ?> <?= $siswa['nama']; ?> (<?= $siswa['nama_kelas']; ?>) Tahun <?= $_GET['tahun_ujian']; ?> Semester <?= $_GET['semester']; ?></h3>
                <br>
                <a href="index.php?view=raport-list&tahun_ujian=<?= $_GET['tahun_ujian']; ?>&semester=<?= $_GET['semester']; ?>&type=<?= $_GET['type']; ?>&kelas=<?= $_GET['kelas']; ?>" class="btn btn-primary btn-sm">Kembali</a>
            </div>
            <div class="box-body">
                <table id='myTable' class='table table-bordered table-striped'>
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Tipe Raport</th>
                            <th width="200">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!isset($_GET['tahun_ujian']) || !isset($_GET['semester']) || !isset($_GET['type']) || !isset($_GET['kelas'])) : ?>
                            <tr>
                                <td colspan="7" style="text-align:center;color:red;">Silahkan pilih tahun, semester, ujian dan kelas terlebih dahulu</td>
                            </tr>
                        <?php else : ?>
                            <?php
                            $raports = mysql_query("SELECT * FROM rb_file_raport WHERE id_siswa = '" . $_GET['siswa'] . "' AND jenis_ujian = '" . $_GET['type'] . "' AND tahun_ujian = '" . $_GET['tahun_ujian'] . "' AND semester = '" . $_GET['semester'] . "' AND kode_kelas = '" . $_GET['kelas'] . "'");
                            // var_dump(mysql_fetch_assoc($siswa));
                            $no = 1;
                            while ($r = mysql_fetch_assoc($raports)) {
                            ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $r['jenis_raport']; ?></td>
                                    <td><a href="dist/raport/<?= $r['filename']; ?>" target="_blank" class="btn btn-primary btn-sm">Lihat</a></td>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>