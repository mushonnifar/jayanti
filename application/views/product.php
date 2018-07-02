<div class="row">
    <div class="col-md-12">
        <div class="ibox ibox">
            <div class="ibox-title">
                <h5>Data <?= $title ?></h5>
            </div>
            <div class="ibox-content">
                <table id="example" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NAMA</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>NAMA</th>
                            <th>ACTION</th>
                        </tr>
                    </tfoot>
                </table> 
            </div>
            <div class="ibox-content">
                <?php if ($this->general->privilege_check('product', 'create')) { ?>
                    <button class="btn btn-success" onclick="add()"><i class="glyphicon glyphicon-plus"></i> Tambah </button>
                <?php } ?>
                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
            </div>
        </div>
    </div>
</div>

<script>
    var table;
    var save_method;
    $(document).ready(function () {
        table = $('#example').DataTable({
            "ajax": base_url + 'Product/get_data',
            "columns": [
                {"data": "no"},
                {"data": "name"},
                {"data": "action"}
            ],
            "scrollX": true
        });
    });

    function add() {
        save_method = 'add';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah <?= $title ?>');
    }


    function reload_table() {
        table.ajax.reload(null, false);
    }

    function save() {
        $('#btnSave').text('Saving...');
        $('#btnSave').attr('disabled', true);

        if (save_method == 'add') {
            url = "<?php echo base_url('Product/add') ?>"
        } else {
            url = "<?php echo base_url('Product/update') ?>"
        }
        $.ajax({
            url: url,
            type: "post",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function (data) {
                if (data.status) {
                    $('#modal_form').modal('hide');
                    reload_table();
                }
                $('#btnSave').text('simpan');
                $('#btnSave').attr('disabled', false);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#btnSave').text('simpan');
                $('#btnSave').attr('disabled', false);
            }
        });
    }
    function edit(id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $.ajax({
            url: "<?php echo base_url('Product/detail') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $('[name="id"]').val(id);
                $('[name="name"]').val(data.name);

                $('#modal_form').modal('show');
                $('.modal-title').text('Ubah <?= $title ?>');

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');

            }
        });
    }
    function hapus(id) {
        if (confirm('Are you sure delete this data?')) {
            $.ajax({
                url: "<?php echo base_url('Product/delete') ?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    $('#modal_form').modal('hide');
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error deleting data');
                }

            })

        }
    }
</script>

<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form <?= $title ?></h3>
            </div>
            <div class="modal-body FormElement">
                <form action="#" id="form" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">NAMA</label>
                            <div class="col-md-9">
                                <input name="id" type="hidden" value="">
                                <input name="name" placeholder="nama" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>                      
                        <div class="modal-footer">
                            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
