$(document).ready(function () {
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
    $('.surah').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: 'Pilih Surah',
    });
});
