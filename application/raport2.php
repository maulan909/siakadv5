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
    <?php
    if (!isset($_GET['siswa'])) {
        if (isset($_POST['id_siswa'])) {
            if (!isset($_POST['action'])) {
                $allowed_extension = ['pdf'];
                $jumlahFile = count($_FILES['rapor']['name']);
                if ($jumlahFile == 3) {
                    $dataFile = [];
                    for ($i = 0; $i < $jumlahFile; $i++) {
                        $namaFile = $_FILES['rapor']['name'][$i];
                        $tmp = $_FILES['rapor']['tmp_name'][$i];
                        $fileType = pathinfo($namaFile, PATHINFO_EXTENSION);
                        $jenis = explode(' ', $namaFile);
                        if (in_array($fileType, $allowed_extension)) {
                            if (in_array(strtolower($jenis[1]), ['dinas', 'pondok', 'kompetensi'])) {
                                $uploadedName = randomStr(15);
                                move_uploaded_file($tmp, 'dist/raport/' . $uploadedName . '.pdf');
                                array_push($dataFile, [$uploadedName . '.pdf', $jenis[1]]);
                            } else {
                                for ($j = 0; $j < count($dataFile); $j++) {
                                    if (file_exists('dist/raport/' . $dataFile[$j][0])) {
                                        chmod('dist/raport/' . $dataFile[$j][0], 0777);
                                        unlink('dist/raport/' . $dataFile[$j][0]);
                                    }
                                }
                                $_SESSION['alert'] = 'Ada kesalahan pada salah satu file yang di upload, silahkan cek kembali';
                                $_SESSION['type'] = 'danger';
                                // header('location:index.php?view=' . $_GET['view'] . '&angkatan=' . $_GET['angkatan'] . '&kelas=' . $_GET['kelas']);
    ?>
                                <script>
                                    window.location = "index.php?view=<?= $_GET['view']; ?>&type=<?= $_GET['type']; ?>&kelas=<?= $_GET['kelas']; ?>";
                                </script>
                            <?php
                                exit;
                            }
                        } else {
                            for ($j = 0; $j < count($dataFile); $j++) {
                                if (file_exists('dist/raport/' . $dataFile[$j][0])) {
                                    chmod('dist/raport/' . $dataFile[$j][0], 0777);
                                    unlink('dist/raport/' . $dataFile[$j][0]);
                                }
                            }
                            $_SESSION['alert'] = 'Ada kesalahan format file pada salah satu file yang di upload, format harus pdf, silahkan cek kembali';
                            $_SESSION['type'] = 'danger';
                            // header('location:index.php?view=' . $_GET['view'] . '&angkatan=' . $_GET['angkatan'] . '&kelas=' . $_GET['kelas']);
                            ?>
                            <script>
                                window.location = "index.php?view=<?= $_GET['view']; ?>&type=<?= $_GET['type']; ?>&kelas=<?= $_GET['kelas']; ?>";
                            </script>
                    <?php
                            exit;
                        }
                    }
                } else {
                    $_SESSION['alert'] = 'File yang di upload harus berjumlah 4 File';
                    $_SESSION['type'] = 'danger';
                    // header('location:index.php?view=' . $_GET['view'] . '&kelas=' . $_GET['kelas'] . '&type=' . $_GET['type']);
                    ?>
                    <script>
                        window.location = "index.php?view=<?= $_GET['view']; ?>&type=<?= $_GET['type']; ?>&kelas=<?= $_GET['kelas']; ?>";
                    </script>
        <?php
                    exit;
                }
                $_SESSION['alert'] = 'Upload Data Berhasil';
                $_SESSION['type'] = 'success';
                //lakukan input ke db disini;
                $tahun = date('Y');
                $semester = date('m') < 7 ? 2 : 1;
                for ($i = 0; $i < count($dataFile); $i++) {
                    $filename = $dataFile[$i][0];
                    $jenis_raport = $dataFile[$i][1];
                    mysql_query("INSERT INTO rb_file_raport VALUES(null, $tahun, $semester, '$_GET[type]', '$jenis_raport', '$_GET[kelas]', '$_POST[id_siswa]', '$filename')");
                }
            } else {
                if ($_POST['action'] == 'delete') {
                    $id_siswa = $_POST['id_siswa'];
                    $semester = date('m') < 7 ? 2 : 1;
                    $files = mysql_query("SELECT rb_file_raport.*, rb_siswa.nama FROM rb_file_raport LEFT JOIN rb_siswa ON rb_siswa.id_siswa = rb_file_raport.id_siswa WHERE rb_file_raport.id_siswa = " . $id_siswa . " AND tahun_ujian = '" . date('Y') . "' AND semester = '" . $semester . "' AND jenis_ujian = '" . $_GET['type'] . "' AND rb_file_raport.kode_kelas = '" . $_GET['kelas'] . "'");
                    $nama = '';
                    while ($file = mysql_fetch_assoc($files)) {
                        $nama = $file['nama'];
                        chmod('dist/raport/' . $file['filename'], 0777);
                        unlink('dist/raport/' . $file['filename']);
                        mysql_query("DELETE FROM rb_file_raport WHERE id = " . $file['id']);
                    }
                    $_SESSION['alert'] = 'Hapus Raport ' . strtoupper($_GET['type']) . ' Semester ' . $semester . ' Tahun ' . date('Y') . ' ' . $nama . ' Berhasil';
                    $_SESSION['type'] = 'success';
                }
            }
        }
        ?>

        <?php if (isset($_SESSION['alert'])) : ?>
            <div class="alert alert-<?= $_SESSION['type']; ?>">
                <?= $_SESSION['alert']; ?>
            </div>
        <?php endif; ?>
        <?php unset($_SESSION['alert']); ?>
        <?php unset($_SESSION['type']); ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Upload Raport Siswa</h3>

                <form style='margin-right:5px; margin-top:0px' class='pull-right' action='index.php?view=rapor' method='GET'>
                    <input type="hidden" name='view' value='rapor'>
                    <!-- <input type="number" name='angkatan' style='padding:3px' placeholder='Angkatan' value='<?php //echo $_GET[angkatan]; 
                                                                                                                ?>'> -->
                    <select name="type" id="type" style="padding:4px" required>
                        <option value="" <?= (!isset($_GET['type'])) ? 'selected' : ''; ?>>Pilih Tipe Ujian</option>
                        <option value="uts" <?= (isset($_GET['type']) && $_GET['type'] == 'uts') ? 'selected' : ''; ?>>UTS</option>
                        <option value="uas" <?= (isset($_GET['type']) && $_GET['type'] == 'uas') ? 'selected' : ''; ?>>UAS</option>
                    </select>
                    <select name='kelas' style='padding:4px' required>
                        <?php
                        echo "<option value=''>- Filter Kelas -</option>";
                        if ($_SESSION['level'] == 'guru') {
                            $kelas = mysql_query("SELECT * FROM rb_kelas WHERE nip = '" . $_SESSION['id'] . "'");
                        } else if ($_SESSION['level'] == 'superuser') {
                            $kelas = mysql_query("SELECT * FROM rb_kelas");
                        }
                        while ($k = mysql_fetch_array($kelas)) {
                            if ($_GET[kelas] == $k[kode_kelas]) {
                                echo "<option value='$k[kode_kelas]' selected>$k[kode_kelas] - $k[nama_kelas]</option>";
                            } else {
                                echo "<option value='$k[kode_kelas]'>$k[kode_kelas] - $k[nama_kelas]</option>";
                            }
                        }
                        ?>
                    </select>
                    <input type="submit" style='margin-top:-4px' class='btn btn-info btn-sm' value='Lihat'>
                </form>
            </div><!-- /.box-header -->
            <div class="box-body">
                <table id='myTable' class='table table-bordered table-striped'>
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th width="150">NISN</th>
                            <th>Nama Siswa</th>
                            <th width="150">Angkatan</th>
                            <th width="150">Kelas</th>
                            <th width="300">Pilih File</th>
                            <th width="200">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php


                        $tampil = mysql_query("SELECT * FROM rb_siswa a LEFT JOIN rb_kelas b ON a.kode_kelas=b.kode_kelas 
                                                LEFT JOIN rb_jenis_kelamin c ON a.id_jenis_kelamin=c.id_jenis_kelamin 
                                                LEFT JOIN rb_jurusan d ON b.kode_jurusan=d.kode_jurusan 
                                                where a.kode_kelas='$_GET[kelas]' ORDER BY a.id_siswa");

                        $no = 1;
                        while ($r = mysql_fetch_array($tampil)) {
                            $tahun = date('Y');
                            $semester = (date('m') < 7) ? 2 : 1;
                            $cek = mysql_num_rows(mysql_query("SELECT * FROM rb_file_raport WHERE tahun_ujian = '" . $tahun . "' AND semester = '" . $semester . "' AND jenis_ujian = '" . $_GET['type'] . "' AND id_siswa = '" . $r['id_siswa'] . "' AND kode_kelas = '" . $r['kode_kelas'] . "'"));
                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $r[nisn]; ?></td>
                                <td><?= $r[nama]; ?></td>
                                <td><?= $r[angkatan]; ?></td>
                                <td><?= $r[nama_kelas]; ?></td>
                                <?php if ($cek > 0) : ?>
                                    <td><span class="badge" style="background-color: #28A745;">File sudah diupload</span></td>
                                    <td>
                                        <a href="index.php?view=rapor&type=<?= $_GET['type']; ?>&kelas=<?= $_GET['kelas']; ?>&siswa=<?= $r['id_siswa']; ?>" class="btn btn-primary btn-sm">Lihat File</a>
                                        <form action="index.php?view=rapor&type=<?= $_GET['type']; ?>&kelas=<?= $_GET['kelas']; ?>" onsubmit="return confirm('Yakin ingin hapus?');" style="display:inline;" method="post">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id_siswa" value="<?= $r['id_siswa']; ?>">
                                            <input type="hidden" name="kelas" value="<?= $_GET['kelas']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                <?php else : ?>
                                    <form action="index.php?view=rapor&type=<?= $_GET['type']; ?>&angkatan=<?= $_GET['angkatan']; ?>&kelas=<?= $_GET['kelas']; ?>" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="id_siswa" value="<?= $r['id_siswa']; ?>">
                                        <td><input type="file" name="rapor[]" accept=".pdf" multiple required></td>
                                        <td><button class="btn btn-primary btn-sm">Upload</button></td>
                                    </form>
                                <?php endif; ?>
                            </tr>
                        <?php
                            $no++;
                        }
                        if (isset($_GET[hapus])) {
                            mysql_query("DELETE FROM rb_siswa where nisn='$_GET[hapus]'");
                            echo "<script>document.location='index.php?view=siswa';</script>";
                        }
                        ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
            <?php
            if ($_GET[kelas] == '' and $_GET[tahun] == '') {
                echo "<center style='padding:60px; color:red'>Silahkan Input Angkatan dan Memilih Kelas Terlebih dahulu...</center>";
            }
            ?>
        </div><!-- /.box -->
        <?php
    } else {
        $semester = date('m') < 7 ? 2 : 1;
        $siswa = mysql_fetch_assoc(mysql_query("SELECT * FROM rb_siswa WHERE id_siswa = '$_GET[siswa]'"));
        $raports = mysql_query("SELECT * FROM rb_file_raport WHERE id_siswa = '" . $_GET['siswa'] . "' AND jenis_ujian = '" . $_GET['type'] . "' AND tahun_ujian = '" . date('Y') . "' AND semester = '" . $semester . "' AND kode_kelas = '" . $siswa['kode_kelas'] . "'");
        if (mysql_num_rows($raports) < 1) {
        ?>
            <script>
                window.location = 'index.php?view=rapor&type=uts&kelas=X.MIPA.1'
            </script>
        <?php
        }
        ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Raport <?= strtoupper($_GET['type']); ?> <?= $siswa['nama']; ?> Tahun <?= date('Y'); ?> Semester <?= $semester; ?></h3>
                <div style="margin-top:5px;"><a href="index.php?view=rapor&type=<?= $_GET['type']; ?>&kelas=<?= $_GET['kelas']; ?>" class="btn btn-primary btn-sm">Kembali</a></div>
            </div>
            <div class="box-body">
                <table id='myTable' class='table table-bordered table-striped'>
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Tipe Raport</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($raport = mysql_fetch_assoc($raports)) {
                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td>Rapor <?= $raport['jenis_raport']; ?></td>
                                <td><a href="dist/raport/<?= $raport['filename']; ?>" target="_blank" class="btn btn-primary btn-sm">Lihat</a></td>
                            </tr>
                        <?php
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
    }
    ?>
</div>