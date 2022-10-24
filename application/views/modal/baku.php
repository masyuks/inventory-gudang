<?php if ($cek == 0) { ?>
<div class="form-group">
    <label>Nama Bahan Baku</label><br>
    <input class="form-control" name="nama_baku" type="text" placeholder="Nama"
        required>
</div>
<div class="form-group">
    <label>Satuan Bahan Baku</label><br>
    <input class="form-control" name="satuan" type="text" placeholder="Satuan">
</div>
<div class="form-group">
    <label>Produsen</label><br>
    <input class="form-control" name="produsen" type="text" placeholder="Produsen">
</div>
<div class="form-group">
    <label>Limit Stok</label><br>
    <input class="form-control" name="stok_limit" type="text" placeholder="Limit Stok">
</div>
<?php } else if($cek == 1){ ?>
<input type="hidden" name="id_baku" value="<?php echo $baku->id_baku;?>">
<?php if($this->session->userdata('level')=="superadmin"){ ?>
<div class="form-group">
    <label>Nama Bahan baku</label><br>
    <input class="form-control" value="<?php echo $baku->nama_baku;?>" name="nama_baku" type="text" placeholder="Nama"
        required>
</div>
<div class="form-group">
    <label>Satuan Bahan Baku</label><br>
    <input class="form-control" value="<?php echo $baku->satuan;?>" name="satuan" type="text" placeholder="Satuan">
</div>
<div class="form-group">
    <label>Produsen</label><br>
    <input class="form-control" value="<?php echo $baku->produsen;?>" name="produsen" type="text" placeholder="Produsen">
</div>
<?php } else { ?>
    <input class="form-control" value="<?php echo $baku->nama_baku;?>" name="nama_baku" type="hidden" placeholder="Nama"
        required>
    <input class="form-control" value="<?php echo $baku->satuan;?>" name="satuan" type="hidden" placeholder="Satuan"
        required>
    <input class="form-control" value="<?php echo $baku->produsen;?>" name="produsen" type="hidden" placeholder="Produsen">
<?php } ?>
<div class="form-group">
    <label>Limit Stok</label><br>
    <input class="form-control" value="<?php echo $baku->stok_limit;?>" name="stok_limit" type="text"
        placeholder="Nama" required>
</div>
<?php } ?>