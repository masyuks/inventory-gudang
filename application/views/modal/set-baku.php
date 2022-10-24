<?php if(isset($baku)) { ?>

<div class="form-group">
    <label>Nama Bahan Baku</label><br>
    <input class="form-control" name="nama_baku" type="text" placeholder="Nama Bahan Baku" value="<?php echo $baku->nama_baku;?>" readonly>
</div>
<div class="form-group">
    <label>Satuan Bahan Baku</label><br>
    <input class="form-control" name="satuan" type="text" placeholder="Satuan Bahan Baku" value="<?php echo $baku->satuan;?>" readonly>
</div>
<div class="form-group">
    <label>Produsen</label><br>
    <input class="form-control" name="produsen" type="text" placeholder="Produsen" value="<?php echo $baku->produsen;?>" readonly>
</div>

<?php } else { ?>
<div class="form-group">
    <label>Nama Bahan Baku</label><br>
    <input class="form-control" name="nama_baku" type="text" placeholder="Nama Bahan Baku" readonly>
</div>
<div class="form-group">
    <label>Satuan Bahan Baku</label><br>
    <input class="form-control" name="satuan" type="text" placeholder="Satuan" readonly>
</div>
<div class="form-group">
    <label>Produsen</label><br>
    <input class="form-control" name="produsen" type="text" placeholder="Produsen" readonly>
</div>
<?php } ?>