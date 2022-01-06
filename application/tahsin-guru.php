<?php
if ($_SESSION['level'] != 'guru') {
?>
    <script>
        window.location = 'index.php';
    </script>
<?php
    exit;
}
$tampil = mysql_num_rows(mysql_query("SELECT * FROM rb_jadwal_pelajaran WHERE nip = '" . $_SESSION['id'] . "' AND kode_pelajaran = 'T1'"));
if ($tampil < 1) {
?>
    <script>
        window.location = 'index.php';
    </script>
<?php
    exit;
}
if (!isset($_GET['siswa'])) :
?>
    <div class="col-xs-12">
        <?php if (isset($_SESSION['alert'])) : ?>
            <div class="alert alert-<?= $_SESSION['type']; ?>">
                <?= $_SESSION['alert']; ?>
            </div>
        <?php endif; ?>
        <?php unset($_SESSION['alert']); ?>
        <?php unset($_SESSION['type']); ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Penilaian Tahsin</h3>
                <form style='margin-right:5px; margin-top:0px' class='pull-right' action='index.php' method='GET'>
                    <input type="hidden" name="view" value="tahsin">
                    <select name="kelas" id="kelas" style="padding:4px;" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php
                        $tahun = mysql_query("SELECT a.*, rb_kelas.nama_kelas FROM rb_jadwal_pelajaran a LEFT JOIN rb_kelas ON rb_kelas.kode_kelas = a.kode_kelas WHERE kode_pelajaran = 'T1' AND a.nip = '" . $_SESSION['id'] . "'");
                        while ($t = mysql_fetch_assoc($tahun)) {
                        ?>
                            <option value="<?= $t['kode_kelas']; ?>" <?= isset($_GET['kelas']) && $_GET['kelas'] == $t['kode_kelas'] ? 'selected' : ''; ?>><?= $t['kode_kelas']; ?> - <?= $t['nama_kelas']; ?></option>
                        <?php } ?>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </form>
            </div>
            <div class="box-body">
                <table id='myTable' class='table table-bordered table-striped'>
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Siswa</th>
                            <th width="200">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($_GET['kelas']) and $_GET['kelas'] !== '') : ?>
                            <?php
                            $no = 1;
                            $siswa = mysql_query("SELECT * FROM rb_siswa WHERE kode_kelas = '" . $_GET['kelas'] . "'");
                            while ($s = mysql_fetch_assoc($siswa)) {
                            ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $s['nama']; ?></td>
                                    <td>
                                        <a href="index.php?view=tahsin&kelas=<?= $_GET['kelas']; ?>&siswa=<?= $s['id_siswa']; ?>" class="btn btn-primary btn-sm">Detail</a>
                                    </td>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3" style="text-align:center;color:red">Silahkan pilih kelas terlebih dahulu</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else : ?>
    <?php
    $siswa = mysql_fetch_assoc(mysql_query("SELECT s.*, k.nama_kelas FROM rb_siswa s LEFT JOIN rb_kelas k ON k.kode_kelas = s.kode_kelas WHERE id_siswa = '" . $_GET['siswa'] . "' AND s.kode_kelas = '" . $_GET['kelas'] . "'"));
    ?>
    <div class="col-xs-12">
        <?php if (isset($_SESSION['alert'])) : ?>
            <div class="alert alert-<?= $_SESSION['type']; ?>">
                <?= $_SESSION['alert']; ?>
            </div>
        <?php endif; ?>
        <?php unset($_SESSION['alert']); ?>
        <?php unset($_SESSION['type']); ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List Penilaian Tahsin</h3>
                <br>
                <button class="btn btn-primary buttonTambahTahsin" data-toggle="modal" data-target="#modalTahsin">Tambah Penilaian</button>
                <a href="index.php?view=tahsin&kelas=<?= $_GET['kelas']; ?>" class="btn btn-info">Kembali</a>
            </div>
            <div class="box-body">
                <table>
                    <tr>
                        <td width="50">Nama</td>
                        <td width="10">:</td>
                        <td width="300"><?= $siswa['nama']; ?></td>
                        <td width="50">Kelas</td>
                        <td width="10">:</td>
                        <td><?= $siswa['nama_kelas']; ?></td>
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
                            <th rowspan="2">Action</th>
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
                        $lists = mysql_query("SELECT t.*, s.nama_surah FROM rb_tahsin t LEFT JOIN rb_surah s ON s.id = t.surat_hafalan WHERE siswa_id = '" . $siswa['id_siswa'] . "' AND kelas_kode = '" . $siswa['kode_kelas'] . "' ORDER BY t.id ASC");
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
                                <td style="text-align: center;">
                                    <button class="btn btn-info btn-sm buttonEditTahsin" data-id="<?= $l['id']; ?>" data-toggle="modal" data-target="#modalTahsin">Edit</button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalTahsin" role="dialog" aria-labelledby="modalTahsinLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="action.php?view=tahsin&kelas=<?= $_GET['kelas']; ?>&siswa=<?= $_GET['siswa']; ?>&act=add" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modalTahsinLabel">Tambah Penilaian</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="siswa_id" value="<?= $_GET['siswa']; ?>">
                        <input type="hidden" name="kelas_kode" value="<?= $_GET['kelas']; ?>">
                        <input type="hidden" name="id" value="" id="id">
                        <div class="form-group">
                            <label for="tatap_muka">Tatap Muka</label>
                            <input type="number" class="form-control" id="tatap_muka" name="tatap_muka" placeholder="Tatap Muka" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal" required>
                        </div>
                        <div class="form-group">
                            <label for="jilid_surat">Jilid / Surat (UMMI / Al-Qur'an)</label>
                            <input type="text" class="form-control" id="jilid_surat" name="jilid_surat" placeholder="Jilid / Surat (UMMI / Al-Qur'an)">
                        </div>
                        <div class="form-group">
                            <label for="hal_ayat_ummi">Hal / Ayat (UMMI / Al-Qur'an)</label>
                            <input type="text" class="form-control" id="hal_ayat_ummi" name="hal_ayat_ummi" placeholder="Hal / Ayat (UMMI / Al-Qur'an)">
                        </div>
                        <div class="form-group">
                            <label for="juz_ummi">Juz (UMMI / Al-Qur'an)</label>
                            <input type="number" class="form-control" id="juz_ummi" name="juz_ummi" placeholder="Juz (UMMI / Al-Qur'an)">
                        </div>
                        <div class="form-group">
                            <label for="hal_gharib">Hal (Gharib)</label>
                            <input type="number" class="form-control" id="hal_gharib" name="hal_gharib" placeholder="Hal (Gharib)">
                        </div>
                        <div class="form-group">
                            <label for="materi_gharib">Materi (Gharib)</label>
                            <input type="text" class="form-control" id="materi_gharib" name="materi_gharib" placeholder="Materi (Gharib)">
                        </div>
                        <div class="form-group">
                            <label for="hal_tajwid">Hal (Tajwid)</label>
                            <input type="number" class="form-control" id="hal_tajwid" name="hal_tajwid" placeholder="Hal (Tajwid)">
                        </div>
                        <div class="form-group">
                            <label for="materi_tajwid">Materi (Tajwid)</label>
                            <input type="text" class="form-control" id="materi_tajwid" name="materi_tajwid" placeholder="Materi (Tajwid)">
                        </div>
                        <div class="form-group">
                            <label for="surat_hafalan">Surat (Hafalan)</label><br>
                            <select name="surat_hafalan" id="surat_hafalan" class="form-control surah">
                                <?php
                                $surah = mysql_query("SELECT * FROM rb_surah");
                                while ($s = mysql_fetch_assoc($surah)) {
                                ?>
                                    <option value="<?= $s['id']; ?>"><?= $s['nama_surah']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ayat_hafalan">Ayat (Hafalan)</label>
                            <input type="text" class="form-control" id="ayat_hafalan" name="ayat_hafalan" placeholder="Ayat (Hafalan)">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah Penilaian</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>