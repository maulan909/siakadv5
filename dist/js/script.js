$(document).ready(function () {
    $('#surat_hafalan').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: 'Pilih Surah',
    });
    $('.buttonTambahTahfizh').on('click', function () {
        $('#modalTahfizhLabel').html('Tambah Penilaian');
        $('.modal-content form').attr(
            'action',
            'action.php?view=tahfizh&kelas=' +
                kelas +
                '&siswa=' +
                siswa +
                '&act=add'
        );
        $('.modal-footer button[type=submit]').html('Tambah Penilaian');

        $('#id').val('');
        $('#capaian_juz').val('');
        $('#mutqin_juz').val('');
        $('#capaian_pekan').val('');
        $('#total_lembar').val('');
        $('#rata_nilai_setoran').val('');
        $('#catatan_muhafizh').val('');
    });

    $('.buttonEditTahfizh').on('click', function () {
        const id = $(this).data('id');
        $('#modalTahfizhLabel').html('Edit Penilaian');
        $('.modal-content form').attr(
            'action',
            'action.php?view=tahfizh&kelas=' +
                kelas +
                '&siswa=' +
                siswa +
                '&act=edit'
        );
        $('.modal-footer button[type=submit]').html('Edit Penilaian');
        $.ajax({
            url:
                url +
                'action.php?view=' +
                view +
                '&kelas=' +
                kelas +
                '&siswa=' +
                '&act=get',
            data: { id: id },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                $('#id').val(data.id);
                $('#capaian_juz').val(data.capaian_juz);
                $('#mutqin_juz').val(data.mutqin_juz);
                $('#capaian_pekan').val(data.capaian_pekan);
                $('#total_lembar').val(data.total_lembar);
                $('#rata_nilai_setoran').val(data.rata_nilai_setoran);
                $('#catatan_muhafizh').val(data.catatan_muhafizh);
            },
        });
    });
    $('.buttonTambahTahsin').on('click', function () {
        $('#modalTahsinLabel').html('Tambah Penilaian');
        $('.modal-content form').attr(
            'action',
            'action.php?view=tahsin&kelas=' +
                kelas +
                '&siswa=' +
                siswa +
                '&act=add'
        );
        $('.modal-footer button[type=submit]').html('Tambah Penilaian');

        $('#id').val('');
        $('#tatap_muka').val('');
        $('#tanggal').val('');
        $('#jilid_surat').val('');
        $('#hal_ayat_ummi').val('');
        $('#juz_ummi').val('');
        $('#hal_gharib').val('');
        $('#materi_gharib').val('');
        $('#hal_tajwid').val('');
        $('#materi_tajwid').val('');
        $('#surat_hafalan option').removeAttr('selected');
        $('#surat_hafalan option[value=' + 1 + ']').attr('selected', '');
        $('#select2-surat_hafalan-container')
            .attr('title', 'Al-Fatihah')
            .html('Al-Fatihah');
        $('#ayat_hafalan').val('');
    });
    $('.buttonEditTahsin').on('click', function () {
        const id = $(this).data('id');
        $('#modalTahfizhLabel').html('Edit Penilaian');
        $('.modal-content form').attr(
            'action',
            'action.php?view=tahsin&kelas=' +
                kelas +
                '&siswa=' +
                siswa +
                '&act=edit'
        );
        $('.modal-footer button[type=submit]').html('Edit Penilaian');
        $.ajax({
            url:
                url +
                'action.php?view=' +
                view +
                '&kelas=' +
                kelas +
                '&siswa=' +
                '&act=get',
            data: { id: id },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                $('#id').val(data.id);
                $('#tatap_muka').val(data.tatap_muka);
                $('#tanggal').val(data.tanggal);
                $('#jilid_surat').val(data.jilid_surat);
                $('#hal_ayat_ummi').val(data.hal_ayat_ummi);
                $('#juz_ummi').val(data.juz_ummi);
                $('#hal_gharib').val(data.hal_gharib);
                $('#materi_gharib').val(data.materi_gharib);
                $('#hal_tajwid').val(data.hal_tajwid);
                $('#materi_tajwid').val(data.materi_tajwid);
                $('#surat_hafalan option').removeAttr('selected');
                $(
                    '#surat_hafalan option[value=' + data.surat_hafalan + ']'
                ).attr('selected', '');
                $('#select2-surat_hafalan-container')
                    .attr('title', data.nama_surah)
                    .html(data.nama_surah);
                $('#ayat_hafalan').val(data.ayat_hafalan);
            },
        });
    });
});
