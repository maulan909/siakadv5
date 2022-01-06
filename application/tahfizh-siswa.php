<?php
$siswa = mysql_fetch_assoc(mysql_query("SELECT * FROM rb_siswa WHERE nisn = '" . $_SESSION['id'] . "'"));
?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">List Penilaian Tahfizh</h3>
            <form style='margin-right:5px; margin-top:0px' class='pull-right' action='index.php' method='GET'>
                <input type="hidden" name="view" value="tahfizh">
                <select name="kelas" id="kelas" style="padding:4px;" required>
                    <option value="">-- Pilih Kelas --</option>
                    <?php
                    $tahun = mysql_query("SELECT DISTINCT kelas_kode, nama_kelas FROM rb_tahfizh t LEFT JOIN rb_kelas k ON k.kode_kelas = t.kelas_kode WHERE siswa_id = '" . $siswa['id_siswa'] . "'");
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
                    $lists = mysql_query("SELECT * FROM rb_tahfizh WHERE siswa_id = '" . $siswa['id_siswa'] . "' AND kelas_kode = '" . $_GET['kelas'] . "' ORDER BY created_at ASC");
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