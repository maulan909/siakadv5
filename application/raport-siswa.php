<div class="col-xs-12">
    <div class="box">
        <?php
        $siswa = mysql_fetch_assoc(mysql_query("SELECT rb_siswa.*, rb_kelas.nama_kelas FROM rb_siswa LEFT JOIN rb_kelas ON rb_kelas.kode_kelas = rb_siswa.kode_kelas WHERE nisn = '" . $_SESSION['id'] . "'"));
        ?>
        <div class="box-header">
            <h3 class="box-title">List Raport <?= isset($_GET['type']) && $_GET['type'] != '' ? strtoupper($_GET['type']) : ''; ?> <?= $siswa['nama']; ?> <?= isset($_GET['tahun_ujian']) && $_GET['tahun_ujian'] != '' ? 'Tahun ' . $_GET['tahun_ujian'] : ''; ?> <?= isset($_GET['semester']) && $_GET['semester'] != '' ? 'Semester ' . $_GET['semester'] : ''; ?></h3>
            <form style='margin-right:5px; margin-top:0px' class='pull-right' action='index.php?view=raport' method='GET'>
                <input type="hidden" name="view" value="rapor">
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
                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
            </form>
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
                    <?php if (!isset($_GET['tahun_ujian']) || !isset($_GET['semester']) || !isset($_GET['type'])) : ?>
                        <tr>
                            <td colspan="7" style="text-align:center;color:red;">Silahkan pilih tahun, semester, dan ujian terlebih dahulu</td>
                        </tr>
                    <?php else : ?>
                        <?php
                        $raports = mysql_query("SELECT * FROM rb_file_raport WHERE id_siswa = '" . $siswa['id_siswa'] . "' AND jenis_ujian = '" . $_GET['type'] . "' AND tahun_ujian = '" . $_GET['tahun_ujian'] . "' AND semester = '" . $_GET['semester'] . "'");
                        // var_dump(mysql_num_rows($raports));
                        if (mysql_num_rows($raports) < 1) {
                        ?>
                            <tr>
                                <td colspan="7" style="color:red;text-align:center;">Tidak ada data</td>
                            </tr>
                            <?php
                        } else {
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
                        }
                        ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>