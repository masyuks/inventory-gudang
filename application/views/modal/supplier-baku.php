<?php if($cek == 1) { ?>
<div class="form-group">
    <input class="form-control" name="id_supplier" type="hidden" value="<?php echo $supplier->id_supplier;?>">
    <label>Nama Supplier Baku</label><br>
    <input class="form-control" name="nama_supplier" type="text" placeholder="Nama Supplier" value="<?php echo $supplier->nama_supplier;?>" required>
</div>
<div class="form-group">
    <label>Kontak</label><br>
    <input class="form-control" name="kontak" type="text" placeholder="Kontak" value="<?php echo $supplier->kontak;?>">
</div>
<?php } else { ?>
<div class="form-group">
    <label>Nama Supplier</label><br>
    <input class="form-control" name="nama_supplier" type="text" placeholder="Nama Supplier" required>
</div>
<div class="form-group">
    <label>Kontak</label><br>
    <input class="form-control" name="kontak" type="text" placeholder="Kontak">
</div>
<?php } ?>