<section class="content">
    <!-- Alert -->
    <?php
      if (!empty($this->session->flashdata('cek'))) {
    ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 2%;">
        <?php echo $this->session->flashdata('cek'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
       } 
     ?>
    <div class="card">
        <div class="card-header" style="background-color: #ecf0f1;">
            <h1>Dashboard</h1>
            <strong>Selamat Datang</strong>
        </div>
    </div>
    <div class="row">
        <?php if($this->session->userdata('level') == 'superadmin') { ?>
        <div class="col-md-4">
            <div class="card rounded">
                <div class="card-header" style="background-color: #0984e3;">
                    <div class="row">
                        <div class="col-4 p-3 text-center text-white"><i class="fas fa-user  fa-3x"></i></div>

                        <div class="col-8 text-white">Total User<h3 class="text-white"><?php echo $user ?></h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo base_url('user/') ?>">
                        <div class="float-left">
                            <h6>Lihat Detail</h6>
                        </div>
                        <div class="float-right"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <?php if($this->session->userdata('level') == 'superadmin' || $this->session->userdata('level') == 'adminbaku') { ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="background-color: #29477F;">
                    <h4 class="text-white">Bahan Baku</h4>
                </div>
            </div>
        </div>
        <div class='col-md-4'>
            <div class="card rounded">
                <div class="card-header" style="background-color: #e67e22;">
                    <div class="row">
                        <div class="col-4 p-3 text-center text-white"><i class="fas fa-people-carry fa-3x"></i></div>

                        <div class="col-8 text-white">Total Supplier Bahan Baku<h3 class="text-white">
                                <?php echo $supplierBaku ?></h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo base_url('supplierBaku/') ?>">
                        <div class="float-left">
                            <h6>Lihat Detail</h6>
                        </div>
                        <div class="float-right"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>
        </div>
        <div class='col-md-4'>
            <div class="card rounded">
                <div class="card-header" style="background-color: #9b59b6;">
                    <div class="row">
                        <div class="col-4 p-3 text-center text-white"><i class="fas fa-boxes fa-3x"></i></div>

                        <div class="col-8 text-white">Total Bahan Baku<h3 class="text-white"><?php echo $baku ?></h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo base_url('baku/') ?>">
                        <div class="float-left">
                            <h6>Lihat Detail</h6>
                        </div>
                        <div class="float-right"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Stok Bahan Baku Hampir Habis</h4>
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <td width="50">No</td>
                                <td>Produk</td>
                                <td width="150">Minimal Stok</td>
                                <td width="50">Stok</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                         $no=1;
                         foreach ($limitBaku as $l) { ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $l->nama_baku ?></td>
                                <td><?php echo $l->stok_limit ?></td>
                                <td><?php echo $l->stok?></td>
                            </tr>
                            <?php $no++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Status Expired Bahan Baku</h4>
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <td width="50">No</td>
                                <td>Produk</td>
                                <td width="150">Expired</td>
                                <td width="150">Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                         $no=1;
                         foreach ($expiredBaku as $l) { ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $l->nama_baku ?></td>
                                <td><?php echo $l->expired ?></td>
                                <td><?php echo $l->status?></td>
                            </tr>
                            <?php $no++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Statistik Bahan Baku Masuk</h4>
                    <div class="row">
                        <div class="col-4">
                            <form class="navbar-form navbar-left" role="search" action="<?php echo site_url('home/');?>"
                                method="post">
                                <div class="form-group">
                                    <input class="form-control" type="date" name="startBaku"
                                        value="<?php echo $this->session->userdata('startSession') ?>" required>
                                </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <input class="form-control" type="date" name="endBaku"
                                    value="<?php echo $this->session->userdata('endSession') ?>" required>
                            </div>
                        </div>
                        <div class="col-1">
                            <button type="submit" class="btn btn-primary btn-sm"><i
                                    class="glyphicon glyphicon-search"></i>
                                <i class="fas fa-filter"></i></button>
                            </form>
                        </div>
                        <div class="col-sm-1">
                            <a href="<?php echo site_url('home/v_index');?>" class="btn btn-success btn-sm"><i
                                    class="fas fa-sync-alt"></i></a>
                        </div>
                    </div>
                    <table class="table table-sm table-striped">
                        <thead>
                            <?php
                            if($inputFilterBaku == null && $this->input->post('startBaku') != null){ 
                            }else if($this->session->userdata('startSession')!=null && $this->session->userdata('endSession') != null){
                                foreach ($inputFilterBaku as $mi){  
    
                                    $input_baku[] = [$mi->nama_baku,"Produsen: $mi->produsen","Satuan: $mi->satuan"];
                                    $jml_qty_input_baku[] = (float) $mi->total_stok;    
                                    echo "<canvas id='BarChartInputsBaku' width='90' height='36' 
                                    style='margin-bottom: -25px;'></canvas>'";
    
                                }
                            }else if($inputFilterBaku != null ){
                                foreach ($inputFilterBaku as $mi){ 
                                    $input_baku[] = [$mi->nama_baku,"Produsen: $mi->produsen","Satuan: $mi->satuan"];
                                    $jml_qty_input_baku[] = (float) $mi->total_stok;    
                                    echo "<canvas id='BarChartInputsBaku' width='90' height='36' 
                                    style='margin-bottom: -25px;'></canvas>'";
    
                                } } 
                            else{
                                    foreach ($mostInputBaku as $mi){ 
                                    $input_baku[] = [$mi->nama_baku,"Produsen: $mi->produsen","Satuan: $mi->satuan"];
                                    $jml_qty_input_baku[] = (float) $mi->total_stok;                                    
                                    echo "<canvas id='BarChartInputsBaku' width='90' height='36' 
                                    style='margin-bottom: -25px;'></canvas>'";
                                } 
                                } ?>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Statistik Bahan Baku Keluar</h4>
                    <div class="row">
                        <div class="col-4">
                            <form class="navbar-form navbar-left" role="search" action="<?php echo site_url('home/');?>"
                                method="post">
                                <div class="form-group">
                                    <input class="form-control" type="date" name="startOutBaku"
                                        value="<?php echo $this->session->userdata('startSession') ?>" required>
                                </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <input class="form-control" type="date" name="endOutBaku"
                                    value="<?php echo $this->session->userdata('endSession') ?>" required>
                            </div>
                        </div>
                        <div class="col-1">
                            <button type="submit" class="btn btn-primary btn-sm"><i
                                    class="glyphicon glyphicon-search"></i>
                                <i class="fas fa-filter"></i></button>
                            </form>
                        </div>
                        <div class="col-sm-1">
                            <a href="<?php echo site_url('home/v_index');?>" class="btn btn-success btn-sm"><i
                                    class="fas fa-sync-alt"></i></a>
                        </div>
                    </div>
                    <table class="table table-sm table-striped">
                        <thead>
                            <?php 
                            if($outputFilterBaku == null && $this->input->post('startOutBaku') != null){ 
                            }else if($this->session->userdata('startSession')!=null && $this->session->userdata('endSession') != null){
                                foreach ($outputFilterBaku as $mo){ 
    
                                    $output_baku[] = [$mo->nama_baku,"Produsen: $mo->produsen","Satuan: $mo->satuan"];
                                    $jml_qty_output_baku[] = (float) $mo->total_stok;       
                                
                                    echo "<canvas id='BarChartOutputsBaku' width='90' height='36' 
                                    style='margin-bottom: -25px;'></canvas>'";
    
                                } 
                            }else if($outputFilterBaku != null ){
                                foreach ($outputFilterBaku as $mo){ 
    
                                    $output_baku[] = [$mo->nama_baku,"Produsen: $mo->produsen","Satuan: $mo->satuan"];
                                    $jml_qty_output_baku[] = (float) $mo->total_stok;       
                                
                                    echo "<canvas id='BarChartOutputsBaku' width='90' height='36' 
                                    style='margin-bottom: -25px;'></canvas>'";
    
                                } }else{
                                foreach ($mostOutputBaku as $mo){ 
                                    $output_baku[] = [$mo->nama_baku,"Produsen: $mo->produsen","Satuan: $mo->satuan"];
                                    $jml_qty_output_baku[] = (float) $mo->total_stok;   
                                echo "<canvas id='BarChartOutputsBaku' width='90' height='36' 
                                 style='margin-bottom: -25px;'></canvas>'";
                                } 
                                } ?>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php if($this->session->userdata('level') == 'superadmin' || $this->session->userdata('level') == 'adminkemas') { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background-color: #29477F;">
                    <h4 class="text-white">Bahan Kemas</h4>
                </div>
            </div>
        </div>
        <div class='col-md-4'>
            <div class="card rounded">
                <div class="card-header" style="background-color: #f9ca24;">
                    <div class="row">
                        <div class="col-4 p-3 text-center text-white"><i class="fas fa-people-carry fa-3x"></i></div>

                        <div class="col-8 text-white">Total Supplier Bahan Kemas<h3 class="text-white">
                                <?php echo $supplier ?></h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo base_url('supplier/') ?>">
                        <div class="float-left">
                            <h6>Lihat Detail</h6>
                        </div>
                        <div class="float-right"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>
        </div>
        <div class='col-md-4'>
            <div class="card rounded">
                <div class="card-header" style="background-color: #2ecc71;">
                    <div class="row">
                        <div class="col-4 p-3 text-center text-white"><i class="fas fa-boxes fa-3x"></i></div>

                        <div class="col-8 text-white">Total Bahan Kemas<h3 class="text-white"><?php echo $kemas ?></h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo base_url('items/') ?>">
                        <div class="float-left">
                            <h6>Lihat Detail</h6>
                        </div>
                        <div class="float-right"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Stok Bahan Kemas Hampir Habis</h4>
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <td width="50">No</td>
                                <td>Produk</td>
                                <td width="150">Minimal Stok</td>
                                <td width="50">Stok</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                         $no=1;
                         foreach ($limitKemas as $l) { ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $l->nama_item ?></td>
                                <td><?php echo $l->stok_limit ?></td>
                                <td><?php echo $l->stok?></td>
                            </tr>
                            <?php $no++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Statistik Bahan Kemas Masuk</h4>
                    <div class="row">
                        <div class="col-4">
                            <form class="navbar-form navbar-left" role="search" action="<?php echo site_url('home/');?>"
                                method="post">
                                <div class="form-group">
                                    <input class="form-control" type="date" name="start"
                                        value="<?php echo $this->session->userdata('startSession') ?>" required>
                                </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <input class="form-control" type="date" name="end"
                                    value="<?php echo $this->session->userdata('endSession') ?>" required>
                            </div>
                        </div>
                        <div class="col-1">
                            <button type="submit" class="btn btn-primary btn-sm"><i
                                    class="glyphicon glyphicon-search"></i>
                                <i class="fas fa-filter"></i></button>
                            </form>
                        </div>
                        <div class="col-sm-1">
                            <a href="<?php echo site_url('home/v_index');?>" class="btn btn-success btn-sm"><i
                                    class="fas fa-sync-alt"></i></a>
                        </div>
                    </div>
                    <!-- <div>
                   
                    </div> -->
                    <table class="table table-sm table-striped">
                        <thead>
                            <?php
                            if($inputFilter == null && $this->input->post('start') != null){ 
                                
                            }else if($this->session->userdata('startSession')!=null && $this->session->userdata('endSession') != null){
                                foreach ($inputFilter as $mi){ 
    
                                    $input_item[] = [$mi->nama_item,"Jenis: $mi->jenis","Merk: $mi->merk","Netto: $mi->netto"];
                                    $jml_qty_input[] = (float) $mi->total_stok; 
                                
                                    echo "<canvas id='BarChartInputs' width='90' height='36' 
                                    style='margin-bottom: -25px;'></canvas>'";
    
                                }
                            }else if($inputFilter != null ){
                                foreach ($inputFilter as $mi){ 
    
                                    $input_item[] = [$mi->nama_item,"Jenis: $mi->jenis","Merk: $mi->merk","Netto: $mi->netto"];
                                    $jml_qty_input[] = (float) $mi->total_stok; 
                                
                                    echo "<canvas id='BarChartInputs' width='90' height='36' 
                                    style='margin-bottom: -25px;'></canvas>'";
    
                                } } 
                            else{
                                    foreach ($mostInput as $mi){ 
                                        $input_item[] = [$mi->nama_item,"Jenis: $mi->jenis","Merk: $mi->merk","Netto: $mi->netto"];
                                    $jml_qty_input[] = (float) $mi->total_stok;                                 
                                    echo "<canvas id='BarChartInputs' width='90' height='36' 
                                    style='margin-bottom: -25px;'></canvas>'";
                                } 
                                } ?>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Statistik Bahan Kemas Keluar</h4>
                    <div class="row">
                        <div class="col-4">
                            <form class="navbar-form navbar-left" role="search" action="<?php echo site_url('home/');?>"
                                method="post">
                                <div class="form-group">
                                    <input class="form-control" type="date" name="startOut"
                                        value="<?php echo $this->session->userdata('startSession') ?>" required>
                                </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <input class="form-control" type="date" name="endOut"
                                    value="<?php echo $this->session->userdata('endSession') ?>" required>
                            </div>
                        </div>
                        <div class="col-1">
                            <button type="submit" class="btn btn-primary btn-sm"><i
                                    class="glyphicon glyphicon-search"></i>
                                <i class="fas fa-filter"></i></button>
                            </form>
                        </div>
                        <div class="col-sm-1">
                            <a href="<?php echo site_url('home/v_index');?>" class="btn btn-success btn-sm"><i
                                    class="fas fa-sync-alt"></i></a>
                        </div>
                    </div>
                    <table class="table table-sm table-striped">
                        <thead>
                            <?php
                            if($outputFilter == null && $this->input->post('startOut') != null){ 
                            
                            }else if($this->session->userdata('startSession')!=null && $this->session->userdata('endSession') != null){
                                foreach ($outputFilter as $mo){ 
    
                                    $output_item[] = [$mo->nama_item,"Jenis: $mo->jenis","Merk: $mo->merk","Netto: $mo->netto"];
                                    $jml_qty_output[] = (float) $mo->total_stok;        
                                
                                    echo "<canvas id='BarChartOutputs' width='90' height='36' 
                                    style='margin-bottom: -25px;'></canvas>'";
    
                                }
                            }else if($outputFilter != null ){
                                foreach ($outputFilter as $mo){ 
    
                                    $output_item[] = [$mo->nama_item,"Jenis: $mo->jenis","Merk: $mo->merk","Netto: $mo->netto"];
                                    $jml_qty_output[] = (float) $mo->total_stok;        
                                
                                    echo "<canvas id='BarChartOutputs' width='90' height='36' 
                                    style='margin-bottom: -25px;'></canvas>'";
    
                                } }else{
                                foreach ($mostOutput as $mo){ 
                                    $output_item[] = [$mo->nama_item,"Jenis: $mo->jenis","Merk: $mo->merk","Netto: $mo->netto"];
                                    $jml_qty_output[] = (float) $mo->total_stok;    
                                echo "<canvas id='BarChartOutputs' width='90' height='36' 
                                 style='margin-bottom: -25px;'></canvas>'";
                                } 
                                } ?>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <footer class="footer hidden-xs-down">
        <p>© <?php echo date("Y");?>.</p>
    </footer>
</section>
<?php if($this->session->userdata('level') == 'superadmin' || $this->session->userdata('level') == 'adminkemas') { ?>
<?php if($limitKemas !=null){ ?>
<div id="modalKemas" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document" style="overflow-y: initial !important">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #ff3f34;">
                <h4 class="modal-title text-white mb-1">Stok Bahan Kemas Hampir Habis</h4>
                <button type="button" class="close text-white mb-3" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="height: 300px; overflow-y: auto;">
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <td width="50">No</td>
                                <td>Produk</td>
                                <td>Jenis</td>
                                <td>Netto</td>
                                <td>Merk</td>
                                <td width="150">Minimal Stok</td>
                                <td width="100">Stok</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                             $no=1;
                             foreach ($limitKemas as $l) { ?>
                            <tr>
                                <td><?php echo $no; ?>.</td>
                                <td><?php echo $l->nama_item ?></td>
                                <td><?php echo $l->jenis ?></td>
                                <td><?php echo $l->netto ?></td>
                                <td><?php echo $l->merk ?></td>
                                <td><?php echo $l->stok_limit ?></td>
                                <td><?php echo $l->stok?></td>
                            </tr>
                            <?php $no++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php } } ?>
<?php if($this->session->userdata('level') == 'superadmin' || $this->session->userdata('level') == 'adminbaku') { ?>
<?php if($limitBaku!=null){ ?>
<div id="modalBaku" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document" style="overflow-y: initial !important">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #ff3f34;">
                <h4 class="modal-title text-white mb-1">Stok Bahan Baku Hampir Habis</h4>
                <button type="button" class="close text-white mb-3" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="height: 300px; overflow-y: auto;">
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <td width="50">No</td>
                                <td>Produk</td>
                                <td>Produsen</td>
                                <td width="150">Minimal Stok</td>
                                <td width="100">Stok</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                             $no=1;
                             foreach ($limitBaku as $l) { ?>
                            <tr>
                                <td><?php echo $no; ?>.</td>
                                <td><?php echo $l->nama_baku ?></td>
                                <td><?php echo $l->produsen ?></td>
                                <td><?php echo $l->stok_limit ?></td>
                                <td><?php echo $l->stok?></td>
                            </tr>
                            <?php $no++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php if($expiredBaku!=null){ ?>
<div id="modalExpired" class="modal fade" tabindex="-2" role="dialog">
    <div class="modal-dialog modal-lg" role="document" style="overflow-y: initial !important">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #ff3f34;">
                <h4 class="modal-title text-white mb-1">Status Expired Bahan Baku</h4>
                <button type="button" class="close text-white mb-3" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="height: 300px; overflow-y: auto;">
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <td width="50">No</td>
                                <td>Produk</td>
                                <td>Produsen</td>
                                <td width="150">Expired</td>
                                <td width="150">Status</td>
                                <td>Stok (Hampir Expired)</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                             $no=1;
                             foreach ($expiredBaku as $l) { ?>
                            <tr>
                                <td><?php echo $no; ?>.</td>
                                <td><?php echo $l->nama_baku ?></td>
                                <td><?php echo $l->produsen ?></td>
                                <td><?php echo $l->expired ?></td>
                                <td><?php echo $l->status?></td>
                                <td><?php echo $l->qty_input?></td>
                            </tr>
                            <?php $no++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php } }?>
</div>

<script type="text/javascript">
$(window).load(function() {
    $('#modalKemas').modal('show');
});
</script>
<script type="text/javascript">
$(window).load(function() {
    $('#modalBaku').modal('show');
});
</script>
<script type="text/javascript">
$(window).load(function() {
    $('#modalExpired').modal('show');
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily =
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Bar Chart Example
var ctx = document.getElementById("BarChartInputs");
var myLineChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($input_item);?>,
        datasets: [{
            label: "Total Stok",
            backgroundColor: "rgba(2,117,216,1)",
            borderColor: "rgba(2,117,216,1)",
            data: <?php echo json_encode($jml_qty_input);?>,
        }],
    },
    options: {
        scales: {
            xAxes: [{
                time: {
                    unit: 'month'
                },
                gridLines: {
                    display: false
                },
                ticks: {
                    maxTicksLimit: 6
                }
            }],
            yAxes: [{
                ticks: {
                    min: 0,
                    max: 15000,
                    maxTicksLimit: 5
                },
                gridLines: {
                    display: true
                }
            }],
        },
        legend: {
            display: false
        }
    }
});
</script>
<script>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily =
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Bar Chart Example
var ctx = document.getElementById("BarChartOutputs");
var myLineChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($output_item);?>,
        datasets: [{
            label: "Total Stok",
            backgroundColor: "rgba(2,117,216,1)",
            borderColor: "rgba(2,117,216,1)",
            data: <?php echo json_encode($jml_qty_output);?>,
        }],
    },
    options: {
        scales: {
            xAxes: [{
                time: {
                    unit: 'month'
                },
                gridLines: {
                    display: false
                },
                ticks: {
                    maxTicksLimit: 6
                }
            }],
            yAxes: [{
                ticks: {
                    min: 0,
                    max: 15000,
                    maxTicksLimit: 5
                },
                gridLines: {
                    display: true
                }
            }],
        },
        legend: {
            display: false
        }
    }
});
</script>
<script>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily =
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Bar Chart Example
var ctx = document.getElementById("BarChartInputsBaku");
var myLineChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($input_baku);?>,
        datasets: [{
            label: "Total Stok",
            backgroundColor: "rgba(2,117,216,1)",
            borderColor: "rgba(2,117,216,1)",
            data: <?php echo json_encode($jml_qty_input_baku);?>,
        }],
    },
    options: {
        scales: {
            xAxes: [{
                time: {
                    unit: 'month'
                },
                gridLines: {
                    display: false
                },
                ticks: {
                    maxTicksLimit: 6
                }
            }],
            yAxes: [{
                ticks: {
                    min: 0,
                    max: 150000,
                    maxTicksLimit: 5
                },
                gridLines: {
                    display: true
                }
            }],
        },
        legend: {
            display: false
        }
    }
});
</script>
<script>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily =
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Bar Chart Example
var ctx = document.getElementById("BarChartOutputsBaku");
var myLineChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($output_baku);?>,
        datasets: [{
            label: "Total Stok",
            backgroundColor: "rgba(2,117,216,1)",
            borderColor: "rgba(2,117,216,1)",
            data: <?php echo json_encode($jml_qty_output_baku);?>,
        }],
    },
    options: {
        scales: {
            xAxes: [{
                time: {
                    unit: 'month'
                },
                gridLines: {
                    display: false
                },
                ticks: {
                    maxTicksLimit: 6
                }
            }],
            yAxes: [{
                ticks: {
                    min: 0,
                    max: 150000,
                    maxTicksLimit: 5
                },
                gridLines: {
                    display: true
                }
            }],
        },
        legend: {
            display: false
        }
    }
});
</script>