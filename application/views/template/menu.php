<div class="page-loader">
    <div class="page-loader__spinner">
        <svg viewBox="25 25 50 50">
            <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
</div>
<header class="header" style="background-color: #29477F;">
    <div class="navigation-trigger hidden-xl-up" data-ma-action="aside-open" data-ma-target=".sidebar">
        <div class="navigation-trigger__inner">
            <i class="navigation-trigger__line"></i>
            <i class="navigation-trigger__line"></i>
            <i class="navigation-trigger__line"></i>
        </div>
    </div>
    <div class="header__logo hidden-sm-down">
        <h1><a href="<?php echo base_url();?>"><i class="fas fa-warehouse fa-2x  "></i> Inventory</a></h1>
    </div>
</header>
<aside class="sidebar">
    <div class="scrollbar-inner">
        <div class="user">
            <div class="user__info" data-toggle="dropdown">
                <img class="user__img" src="<?php echo base_url();?>assets/demo/img/profile-pics/4.jpg" alt="">
                <div style="color: #29477F;">
                    <?php echo $this->session->userdata('nama_user') ?>
                </div>
            </div>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="<?php echo base_url();?>home/logout">Logout</a>
            </div>
        </div>
        <style>
        /* Style the active class (and buttons on mouse-over) */
        .active {
            color: red;
        }
        </style>
        <ul class="navigation">
            <li><a style="<?php echo $this->uri->segment(2) == 'index_refresh' ? 'color: #29477F;' : ''; ?>"
                    href="<?php echo base_url('home/');?>"> <i class="fas fa-tachometer-alt"></i> Home</a></li>
            <?php if($this->session->userdata('level') == 'superadmin'){ ?>
            <li class="navigation__sub">
                <a style="<?php echo $this->uri->segment(1) == 'user' ? 'color: #29477F;' : ''; ?>"
                    data-toggle="collapse" href="#xmod1" role="button" aria-expanded="false" aria-controls="xmod1"><i
                        class="fas fa-fire"></i>
                    Master Data<i class="zmdi zmdi-chevron-down zmdi-hc-fw"></i></a>
                <div class="collapse xmenu" id="xmod1">
                    <ul style="padding-left: 10px;">
                        <li><a style="<?php echo $this->uri->segment(1) == 'user' ? 'color: #29477F;' : ''; ?>"
                                href="<?php echo base_url('user/');?>"><i class="fas fa-user"></i> User</a></li>
                    </ul><br>
                </div>
            </li>
            <?php } ?>
            <?php if($this->session->userdata('level') == 'superadmin' || $this->session->userdata('level') == 'adminkemas') { ?>
            <li class="navigation__sub">
                <?php if($this->uri->segment(1) == 'Items'){ ?>
                <a style="<?php echo $this->uri->segment(1) == 'Items' ? 'color: #29477F;' : ''; ?>"
                    data-toggle="collapse" href="#xmod" role="button" aria-expanded="false" aria-controls="xmod"><i
                        class="fas fa-box"></i> Data
                    Bahan Kemas<i class="zmdi zmdi-chevron-down zmdi-hc-fw"></i></a>
                <?php }else if($this->uri->segment(1) == 'Supplier'){ ?>
                <a style="<?php echo $this->uri->segment(1) == 'Supplier' ? 'color: #29477F;' : ''; ?>"
                    data-toggle="collapse" href="#xmod" role="button" aria-expanded="false" aria-controls="xmod"><i
                        class="fas fa-box"></i> Data
                    Bahan Kemas<i class="zmdi zmdi-chevron-down zmdi-hc-fw"></i></a>
                <?php }else if($this->uri->segment(1) == 'Input'){ ?>
                <a style="<?php echo $this->uri->segment(1) == 'Input' ? 'color: #29477F;' : ''; ?>"
                    data-toggle="collapse" href="#xmod" role="button" aria-expanded="false" aria-controls="xmod"><i
                        class="fas fa-box"></i> Data
                    Bahan Kemas<i class="zmdi zmdi-chevron-down zmdi-hc-fw"></i></a>
                <?php }else if($this->uri->segment(1) == 'Output'){ ?>
                <a style="<?php echo $this->uri->segment(1) == 'Output' ? 'color: #29477F;' : ''; ?>"
                    data-toggle="collapse" href="#xmod" role="button" aria-expanded="false" aria-controls="xmod"><i
                        class="fas fa-box"></i> Data
                    Bahan Kemas<i class="zmdi zmdi-chevron-down zmdi-hc-fw"></i></a>
                <?php }else{ ?>
                <a data-toggle="collapse" href="#xmod" role="button" aria-expanded="false" aria-controls="xmod"><i
                        class="fas fa-box"></i> Data
                    Bahan Kemas<i class="zmdi zmdi-chevron-down zmdi-hc-fw"></i></a>
                <?php } ?>
                <div class="collapse xmenu" id="xmod">
                    <ul style="padding-left: 10px;">
                        <li><a style="<?php echo $this->uri->segment(1) == 'Items' ? 'color: #29477F;' : ''; ?>"
                                href="<?php echo base_url('Items/');?>"><i class="fas fa-boxes"></i> Barang</a></li>
                        <li><a style="<?php echo $this->uri->segment(1) == 'Supplier' ? 'color: #29477F;' : ''; ?>"
                                href="<?php echo base_url('Supplier/');?>"><i class="fas fa-people-carry"></i>
                                Supplier</a></li>
                        <li><a style="<?php echo $this->uri->segment(1) == 'Input' ? 'color: #29477F;' : ''; ?>"
                                href="<?php echo base_url('Input/');?>"><i class="fas fa-sign-in-alt"></i> Barang
                                Masuk</a></li>
                        <li><a style="<?php echo $this->uri->segment(1) == 'Output' ? 'color: #29477F;' : ''; ?>"
                                href="<?php echo base_url('Output/');?>"><i class="fas fa-sign-out-alt"></i> Barang
                                Keluar</a></li>
                    </ul><br>
                </div>
            </li>
            <?php } 
            if($this->session->userdata('level') == 'superadmin' || $this->session->userdata('level') == 'adminbaku') { ?>
            <li class="navigation__sub">
                <?php if($this->uri->segment(1) == 'Baku'){ ?>
                <a style="<?php echo $this->uri->segment(1) == 'Baku' ? 'color: #29477F;' : ''; ?>"
                    data-toggle="collapse" href="#xmod2" role="button" aria-expanded="false" aria-controls="xmod2"><i
                        class="fas fa-archive"></i> Data
                    Bahan Baku<i class="zmdi zmdi-chevron-down zmdi-hc-fw"></i></a>
                <?php } else if($this->uri->segment(1) == 'baku'){?>
                <a style="<?php echo $this->uri->segment(1) == 'baku' ? 'color: #29477F;' : ''; ?>"
                    data-toggle="collapse" href="#xmod2" role="button" aria-expanded="false" aria-controls="xmod2"><i
                        class="fas fa-archive"></i> Data
                    Bahan Baku<i class="zmdi zmdi-chevron-down zmdi-hc-fw"></i></a>
                <?php }else if($this->uri->segment(1) == 'SupplierBaku'){ ?>
                <a style="<?php echo $this->uri->segment(1) == 'SupplierBaku' ? 'color: #29477F;' : ''; ?>"
                    data-toggle="collapse" href="#xmod2" role="button" aria-expanded="false" aria-controls="xmod2"><i
                        class="fas fa-archive"></i> Data
                    Bahan Baku<i class="zmdi zmdi-chevron-down zmdi-hc-fw"></i></a>
                <?php }else if($this->uri->segment(1) == 'InputBaku'){ ?>
                <a style="<?php echo $this->uri->segment(1) == 'InputBaku' ? 'color: #29477F;' : ''; ?>"
                    data-toggle="collapse" href="#xmod2" role="button" aria-expanded="false" aria-controls="xmod2"><i
                        class="fas fa-archive"></i> Data
                    Bahan Baku<i class="zmdi zmdi-chevron-down zmdi-hc-fw"></i></a>
                <?php }else if($this->uri->segment(1) == 'OutputBaku'){ ?>
                <a style="<?php echo $this->uri->segment(1) == 'OutputBaku' ? 'color: #29477F;' : ''; ?>"
                    data-toggle="collapse" href="#xmod2" role="button" aria-expanded="false" aria-controls="xmod2"><i
                        class="fas fa-archive"></i> Data
                    Bahan Baku<i class="zmdi zmdi-chevron-down zmdi-hc-fw"></i></a>
                <?php }else if($this->uri->segment(1) == 'InputExpired'){ ?>
                <a style="<?php echo $this->uri->segment(1) == 'InputExpired' ? 'color: #29477F;' : ''; ?>"
                    data-toggle="collapse" href="#xmod2" role="button" aria-expanded="false" aria-controls="xmod2"><i
                        class="fas fa-archive"></i> Data
                    Bahan Baku<i class="zmdi zmdi-chevron-down zmdi-hc-fw"></i></a>
                <?php }else{ ?>
                <a data-toggle="collapse" href="#xmod2" role="button" aria-expanded="false" aria-controls="xmod2"><i
                        class="fas fa-archive"></i> Data
                    Bahan Baku<i class="zmdi zmdi-chevron-down zmdi-hc-fw"></i></a>
                <?php } ?>

                <div class="collapse xmenu" id="xmod2">
                    <ul style="padding-left: 10px;">
                        <?php if($this->uri->segment(1) == 'Baku'){ ?>
                        <li><a style="<?php echo $this->uri->segment(1) == 'Baku' ? 'color: #29477F;' : ''; ?>"
                                href="<?php echo base_url('Baku');?>"><i class="fas fa-boxes"></i> Barang</a></li>
                        <?php } else if($this->uri->segment(1) == 'baku'){?>
                        <li><a style="<?php echo $this->uri->segment(1) == 'baku' ? 'color: #29477F;' : ''; ?>"
                                href="<?php echo base_url('Baku');?>"><i class="fas fa-boxes"></i> Barang</a></li>
                        <?php }else{ ?>
                        <li><a href="<?php echo base_url('Baku');?>"><i class="fas fa-boxes"></i> Barang</a></li>
                        <?php } ?>
                        <li><a style="<?php echo $this->uri->segment(1) == 'SupplierBaku' ? 'color: #29477F;' : ''; ?>"
                                href="<?php echo base_url('SupplierBaku/');?>"><i class="fas fa-people-carry"></i>
                                Supplier</a></li>
                        <li><a style="<?php echo $this->uri->segment(1) == 'InputBaku' ? 'color: #29477F;' : ''; ?>"
                                href="<?php echo base_url('InputBaku');?>"><i class="fas fa-sign-in-alt"></i> Barang
                                Masuk</a></li>
                        <li><a style="<?php echo $this->uri->segment(1) == 'OutputBaku' ? 'color: #29477F;' : ''; ?>"
                                href="<?php echo base_url('OutputBaku');?>"><i class="fas fa-sign-out-alt"></i> Barang
                                Keluar</a></li>
                        <li><a style="<?php echo $this->uri->segment(1) == 'InputExpired' ? 'color: #29477F;' : ''; ?>"
                                href="<?php echo base_url('InputExpired');?>"><i
                                    class="fas fa fa-exclamation-triangle"></i> Barang
                                Expired</a></li>
                    </ul><br>
                </div>
            </li>
            <?php } ?>
            <?php if($this->session->userdata('level') == 'superadmin'){ ?>
            <li onclick="backup()"><a href="#"> <i class="fas fa-tachometer-alt"></i> Backup Database</a></li>
            <?php } ?>

        </ul>

    </div>
</aside>
<script>
function backup() {
    Swal.fire({
        title: 'Backup Data?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.value == true) {
            window.location.href = "<?php echo base_url('BackupDatabase/backup');?>";
        }
    })
};
</script>