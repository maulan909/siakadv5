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
                <h3 class="box-title">Penilaian tahfizh</h3>
                <form style='margin-right:5px; margin-top:0px' class='pull-right' action='index.php' method='GET'>
                    <input type="hidden" name="view" value="tahfizh">
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
                                        <a href="index.php?view=tahfizh&kelas=<?= $_GET['kelas']; ?>&siswa=<?= $s['id_siswa']; ?>" class="btn btn-primary btn-sm">Detail</a>
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
                <h3 class="box-title">List Penilaian Tahfizh</h3>
                <br>
                <button class="btn btn-primary buttonTambahTahfizh" data-toggle="modal" data-target="#modalTahfizh">Tambah Penilaian</button>
                <a href="index.php?view=tahfizh&kelas=<?= $_GET['kelas']; ?>" class="btn btn-info">Kembali</a>
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
                            <th width="50">Date</th>
                            <th>Golongan</th>
                            <th>Capaian Juz (Tahfizh Bil Ghaib)</th>
                            <th>Mutqin Juz</th>
                            <th>Capaian Per Pekan</th>
                            <th>Total Lembar</th>
                            <th>Rata-rata Nilai Setoran</th>
                            <th>Catatan Muhafizh</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $lists = mysql_query("SELECT * FROM rb_tahfizh WHERE siswa_id = '" . $siswa['id_siswa'] . "' AND kelas_kode = '" . $siswa['kode_kelas'] . "' ORDER BY created_at ASC");
                        while ($l = mysql_fetch_assoc($lists)) {
                        ?>
                            <tr>
                                <td><?= $l['created_at']; ?></td>
                                <td><?= $l['golongan']; ?></td>
                                <td><?= $l['capaian_juz']; ?></td>
                                <td><?= $l['mutqin_juz']; ?></td>
                                <td><?= $l['capaian_pekan']; ?></td>
                                <td><?= $l['total_lembar']; ?></td>
                                <td><?= $l['rata_nilai_setoran']; ?></td>
                                <td><?= $l['catatan_muhafizh']; ?></td>
                                <td>
                                    <button class="btn btn-info btn-sm buttonEditTahfizh" data-id="<?= $l['id']; ?>" data-toggle="modal" data-target="#modalTahfizh">Edit</button>
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
    <div class="modal fade" id="modalTahfizh" tabindex="-1" role="dialog" aria-labelledby="modalTahfizhLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="action.php?view=tahfizh&kelas=<?= $_GET['kelas']; ?>&siswa=<?= $_GET['siswa']; ?>&act=add" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modalTahfizhLabel">Tambah Penilaian</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="siswa_id" value="<?= $_GET['siswa']; ?>">
                        <input type="hidden" name="kelas_kode" value="<?= $_GET['kelas']; ?>">
                        <input type="hidden" name="id" value="" id="id">
                        <div class="form-group">
                            <label for="capaian_juz">Capaian Juz (Tahfizh Bil Ghaib)</label>
                            <input type="text" class="form-control" id="capaian_juz" name="capaian_juz" placeholder="Capaian Juz (Tahfizh Bil Ghaib)" required>
                        </div>
                        <div class="form-group">
                            <label for="mutqin_juz">Mutqin Juz</label>
                            <input type="text" class="form-control" id="mutqin_juz" name="mutqin_juz" placeholder="Mutqin Juz" required>
                        </div>
                        <div class="form-group">
                            <label for="capaian_pekan">Capaian per Pekan</label>
                            <input type="text" class="form-control" id="capaian_pekan" name="capaian_pekan" placeholder="Capaian per Pekan" required>
                        </div>
                        <div class="form-group">
                            <label for="total_lembar">Total Lembar</label>
                            <input type="number" class="form-control" id="total_lembar" name="total_lembar" placeholder="Total Lembar" required>
                        </div>
                        <div class="form-group">
                            <label for="rata_nilai_setoran">Rata-rata Nilai Setoran</label>
                            <input type="text" class="form-control" id="rata_nilai_setoran" name="rata_nilai_setoran" placeholder="Rata-rata Nilai Setoran" required>
                        </div>
                        <div class="form-group">
                            <label for="catatan_muhafizh">Catatan Muhafizh</label>
                            <input type="text" class="form-control" id="catatan_muhafizh" name="catatan_muhafizh" placeholder="Catatan Muhafizh" required>
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