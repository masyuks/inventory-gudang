<?php if($cek == 1) { ?>
<input type="hidden" name="id_tb" value="<?php echo $transaksi_baku->id_tb;?>">
<div class="form-group">
	<label>Keterangan</label><br>
    <textarea class="form-control" placeholder="Keterangan" name="keterangan"><?php echo $transaksi_baku->keterangan;?></textarea>
</div>
<?php } ?>