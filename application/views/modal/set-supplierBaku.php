<?php if(isset($supplierBaku)) { ?>
<div class="form-group">
    <label>Nama Supplier</label><br>
    <input class="form-control" name="nama_supplier" type="text" placeholder="Nama Supplier" value="<?php echo $supplierBaku->nama_supplier;?>" readonly>
</div>
<div class="form-group">
    <label>Kontak</label><br>
    <input class="form-control" name="kontak" type="text" placeholder="Kontak" value="<?php echo $supplierBaku->kontak;?>" readonly>
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