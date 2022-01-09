<div class="col-md-6">
    <?php if (isset($_SESSION['alert'])) : ?>
        <div class="alert alert-<?= $_SESSION['type']; ?>">
            <?= $_SESSION['alert']; ?>
        </div>
    <?php endif; ?>
    <?php unset($_SESSION['alert']); ?>
    <?php unset($_SESSION['type']); ?>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Kalender Akademik</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12">
                    <table id='myTable' class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Tahun Ajaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $list = mysql_query("SELECT * FROM rb_kaldik");
                            while ($l = mysql_fetch_assoc($list)) {
                            ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><a class="btnDetailKD" data-toggle="modal" data-target="#modalKaldik" href="#" data-kaldik="dist/kaldik/<?= $l['filename']; ?>"><?= $l['tahun_ajaran']; ?></a></td>
                                    <td>
                                        <form action="action.php?view=kaldik&act=delete" method="POST" onsubmit="return confirm('Data akan dihapus, anda yakin?');">
                                            <input type="hidden" name="id" value="<?= $l['id']; ?>">
                                            <input type="hidden" name="filename" value="<?= $l['filename']; ?>">
                                        </form>
                                    </td>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalKaldik" tabindex="-1" role="dialog" aria-labelledby="modalKaldikLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="action.php?view=kaldik&act=add" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalKaldikLabel">Tambah Data Kalender Akademik</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tahun_ajaran">Tahun Ajaran</label>
                        <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" placeholder="2010/2011">
                    </div>
                    <div class="form-group">
                        <label for="filename">File input</label>
                        <input type="file" id="filename" name="filename">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>