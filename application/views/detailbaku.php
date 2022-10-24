<section class="content">
    <header class="content__title">
        <h1>Detail Bahan Baku</h1>
        <!-- <div class="actions">
                  <button class="btn btn-primary font-btn" onclick="tambah()">Tambah</button>
               </div> -->
    </header>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <?php if($id!=null){ ?>
                    <form class="navbar-form navbar-left" role="search"
                        action="<?php echo site_url('baku/detail/'.$id->id_baku);?>" method="post">
                        <?php } ?>
                        <div class="form-group">
                            <input class="form-control" type="date" name="start"
                                value="<?php echo $this->session->userdata('startSession') ?>" required>
                        </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <input class="form-control" type="date" name="end"
                            value="<?php echo $this->session->userdata('endSession') ?>" required>
                    </div>
                </div>
                <div class="col-3">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-search"></i>
                        <i class="fas fa-filter"></i> Filter</button>
                    </form>
                    <?php if($id!=null){ ?>
                    <a href="<?php echo site_url('baku/v_detail/'.$id->id_baku);?>" class="btn btn-success btn-sm"><i
                            class="fas fa-sync-alt"></i> Reset</a>
                    <?php }else{
                        echo '<a href="#" class="btn btn-success btn-sm"><i class="fas fa-sync-alt"></i> Reset</a>';
                    } ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="datatables" style=" width: 100%;">
                    <thead>
                        <tr>
                            <th colspan="10">
                                <h4 style="text-transform: capitalize; margin-left: 10px;">
                                    Produk - <?php echo $data->nama_baku; ?>
                                </h4>
                                <div style="text-transform: capitalize; margin-left: 10px;">
                                    Produsen <span style="margin-left: 13px"> : &nbsp; <?php echo $data->produsen; ?>
                                    </span>
                                    <br>
                                    <br>
                                    <a href="<?php echo site_url('DetailBaku/sinkronisasi/'.$data->id_baku);?>" class="btn btn-primary"><i class="fas fa-sync-alt"></i> Synchronization </a>
                                    <?php
                                        if (!empty($this->session->flashdata('sinkronisasi'))) {
                                    ?>
                                    <div style="color: red;"><i class="fas fa-window-close"></i> &nbsp;<?php echo $this->session->flashdata('sinkronisasi'); ?></div>
                                    <?php 
                                        }
                                        else {
                                    ?>
                                    <div style="color: green;"><i class="fas fa-check-square"></i> &nbsp; Detail transaksi telah valid</div>
                                    <?php
                                        } 
                                    ?>
                                    <br>
                                </div>
                            </th>
                        </tr>
                        <tr class="bg-primary text-white">
                            <th rowspan="2" class="text-center" style="vertical-align: middle;">No</th>
                            <th rowspan="2" class="text-center" style="vertical-align: middle;">Tanggal</th>
                            <th class="text-center">Masuk</th>
                            <th class="text-center">Keluar</th>
                            <th class="text-center">Sisa Stok</th>
                            <th rowspan="2" class="text-center" style="vertical-align: middle; width: 10px;">Keterangan
                            </th>
                            <th class="disabled-sorting text-center" rowspan="2" style="vertical-align: middle;">Actions
                            </th>
                        </tr>
                        <tr class="bg-primary text-white">
                            <!-- <th>No</th> -->
                            <th class="text-center">Jumlah (<?php echo $data->satuan; ?>)</th>
                            <th class="text-center">Jumlah (<?php echo $data->satuan; ?>)</th>
                            <th class="text-center">Jumlah (<?php echo $data->satuan; ?>)</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr class="bg-primary text-white">
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Masuk</th>
                            <th class="text-center">Keluar</th>
                            <th class="text-center">Sisa Stok</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php if($filter == null && $this->input->post('start') != null){
                        }else if($this->session->userdata('startSession')!=null && $this->session->userdata('endSession') != null){ ?>
                            <?php $no=1;
                            foreach ($filter as $t) { ?>
                            <tr>
                                <td class="text-center"><?php echo $no;?></td>
                                <td class="text-center">
                                    <?php $d = new DateTime($t->tanggal);
                                 echo $d->format("d/m/Y");?>
                                </td>
                                <td class="text-center"><?php echo $t->stok_masuk;?></td>
                                <td class="text-center"><?php echo $t->stok_keluar;?></td>
                                <td class="text-center"><?php echo $t->sisa_stok;?></td>
                                <td class="text-center"><?php echo $t->keterangan;?></td>
                                <td class="td-actions text-center">
                                    <button type="button" onclick="ganti(<?php echo $t->id_tb;?>)" rel="tooltip"
                                        class="btn btn-success btn-round" data-original-title="" title="">
                                        <i class="zmdi zmdi-edit zmdi-hc-fw"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php $no++; } 
                    }else if($filter != null){ ?>
                        <?php $no=1;
                        foreach ($filter as $t) { ?>
                        <tr>
                            <!-- <div class="set-lap"> -->
                            <td class="text-center"><?php echo $no;?></td>
                            <td class="text-center">
                                <?php $d = new DateTime($t->tanggal);
							 echo $d->format("d/m/Y");?>
                            </td>
                            <td class="text-center"><?php echo $t->stok_masuk;?></td>
                            <td class="text-center"><?php echo $t->stok_keluar;?></td>
                            <td class="text-center"><?php echo $t->sisa_stok;?></td>
                            <td class="text-center"><?php echo $t->keterangan;?></td>
                            <td class="td-actions text-center">
                                <button type="button" onclick="ganti(<?php echo $t->id_tb;?>)" rel="tooltip"
                                    class="btn btn-success btn-round" data-original-title="" title="">
                                    <i class="zmdi zmdi-edit zmdi-hc-fw"></i>
                                </button>
                            </td>
                            <!-- </div> -->
                        </tr>
                        <?php $no++; } 
                        }else{?>
                        <?php $no=1;
                         foreach ($transaksi as $t) { ?>
                        <tr>
                            <!-- <div class="set-lap"> -->
                            <td class="text-center"><?php echo $no;?></td>
                            <td class="text-center"><?php echo $t->tanggal;?></td>
                            <td class="text-center"><?php echo $t->stok_masuk;?></td>
                            <td class="text-center"><?php echo $t->stok_keluar;?></td>
                            <td class="text-center"><?php echo $t->sisa_stok;?></td>
                            <td class="text-center"><?php echo $t->keterangan;?></td>
                            <td class="td-actions text-center">
                                <button type="button" onclick="ganti(<?php echo $t->id_tb;?>)" rel="tooltip"
                                    class="btn btn-success btn-round" data-original-title="" title="">
                                    <i class="zmdi zmdi-edit zmdi-hc-fw"></i>
                                </button>
                            </td>
                            <!-- </div> -->
                        </tr>
                        <?php $no++; } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <footer class="footer hidden-xs-down">
        <p>© Mellydia's Team <?php echo date("Y");?>.</p>
    </footer>
</section>
<script>

</script>
<script>
var table;
var simpan;
$(document).ready(function() {
    setTimeout(function() {
        table = $("#datatables").DataTable({
            autoWidth: !1,
            responsive: !0,
            lengthMenu: [
                [15, 30, 45, -1],
                ["15 Rows", "30 Rows", "45 Rows", "Everything"]
            ],
            language: {
                searchPlaceholder: "Search for records..."
            },
            sDom: '<"dataTables__top"lfB>rt<"dataTables__bottom"ip><"clear">',
            buttons: [{
                extend: "excelHtml5",
                title: "Export Data",
                exportOptions: {
                    format: {
                        body: function(data, column, row) {
                            if (typeof data === 'string' ||
                                data instanceof String) {
                                data = data.replace(/<br\s*\/?>/ig, "\r\n");
                            }
                            data = data.replace(/<.*?>/ig, "");
                            return data;
                        }
                    }
                },
            }, {
                extend: "print",
                title: "Print"
            }],
            initComplete: function(a, b) {
                $(this).closest(".dataTables_wrapper").find(".dataTables__top").prepend(
                    '<div class="dataTables_buttons hidden-sm-down actions"><div class="dropdown actions__item"><i data-toggle="dropdown" class="zmdi zmdi-download" /><ul class="dropdown-menu dropdown-menu-right"><a href="" class="dropdown-item" data-table-action="excel">Excel (.xlsx)</a></ul></div></div>'
                )
            }
        }), $(".dataTables_filter input[type=search]").focus(function() {
            $(this).closest(".dataTables_filter").addClass("dataTables_filter--toggled")
        }), $(".dataTables_filter input[type=search]").blur(function() {
            $(this).closest(".dataTables_filter").removeClass("dataTables_filter--toggled")
        }), $("body").on("click", "[data-table-action]", function(a) {
            a.preventDefault();
            var b = $(this).data("table-action");
            if ("excel" === b && $(this).closest(".dataTables_wrapper").find(".buttons-excel")
                .trigger("click"), "csv" === b && $(this).closest(".dataTables_wrapper").find(
                    ".buttons-csv").trigger("click"), "print" === b && $(this).closest(
                    ".dataTables_wrapper").find(".buttons-print").trigger("click"),
                "fullscreen" === b) {
                var c = $(this).closest(".card");
                c.hasClass("card--fullscreen") ? (c.removeClass("card--fullscreen"), $("body")
                    .removeClass("data-table-toggled")) : (c.addClass("card--fullscreen"),
                    $("body").addClass("data-table-toggled"))
            }
        })

        $(".xform").on("submit", (function(b) {
            b.preventDefault();
            var a;
            if (simpan == "tambah") {
                a = "<?php echo base_url();?>DetailBaku/add"
            } else if (simpan == "update") {
                a = "<?php echo base_url();?>DetailBaku/update"
            }
            $.ajax({
                url: a,
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(c) {
                    $("#myModal").modal("hide");
                    //swal("Sukses!", "", "success");
                    location.reload();
                },
                error: function(c, e, d) {
                    swal("Error", "", "error")
                }
            });
            return false
        }));

    }, 1500)
});

function tambah() {
    simpan = "tambah";
    $(".form")[0].reset();
    $("#myModal").modal("show");
    $("#modalbody").load("<?php echo base_url();?>Baku/modal/", function(a) {
        $("#modalbody").html(a)
    })
}

function ganti(a) {
    simpan = "update";
    $(".form")[0].reset();
    $("#myModal").modal("show");
    $("#modalbody").load("<?php echo base_url();?>DetailBaku/edit/" + a, function(b) {
        $("#modalbody").html(b)
    })
}


function hapus(a) {
    Swal.fire({
        title: 'Hapus Data?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.value == true) {
            $.get("<?php echo base_url()?>Baku/delete/" + a, function(b) {
                location.reload();
            })
        }
    })
};
</script>