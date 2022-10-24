<?php if(isset($items)) { ?>
<input name="nama_item" value="<?php echo $items->nama_item;?>" type="hidden">
<div class="form-group">
    <label>Jenis</label><br>
    <input class="form-control" name="jenis" type="text" placeholder="Jenis" value="<?php echo $items->jenis;?>" readonly>
</div>
<div class="form-group">
    <label>Netto</label><br>
    <input class="form-control" name="netto" type="text" placeholder="Netto" value="<?php echo $items->netto;?>" readonly>
</div>
<div class="form-group">
    <label>Merk</label><br>
    <input class="form-control" name="merk" type="text" placeholder="Merk" value="<?php echo $items->merk;?>" readonly>
</div>

<?php }