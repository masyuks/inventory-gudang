<?php if($cek == 1) { ?>
<input type="hidden" name="id_ti" value="<?php echo $transaksi_items->id_ti;?>">
<div class="form-group">
	<label>Keterangan</label><br>
    <textarea class="form-control" placeholder="Keterangan" name="keterangan"><?php echo $transaksi_items->keterangan;?></textarea>
</div>
<?php } ?>