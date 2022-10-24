<?php if(isset($items)) { ?>
   
<div class="form-group">
    <label>Nama Items</label><br>
    <input class="form-control" name="nama_item" type="text" placeholder="Nama Items" value="<?php echo $items->nama_item;?>" readonly>
</div>
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

<?php } else { ?>
<div class="form-group">
    <label>Nama Items</label><br>
    <input class="form-control" name="nama_item" type="text" placeholder="Nama Items" readonly>
</div>
<div class="form-group">
    <label>Jenis</label><br>
    <input class="form-control" name="jenis" type="text" placeholder="Jenis" readonly>
</div>
<div class="form-group">
    <label>Netto</label><br>
    <input class="form-control" name="netto" type="text" placeholder="Netto" readonly>
</div>
<div class="form-group">
    <label>Merk</label><br>
    <input class="form-control" name="merk" type="text" placeholder="Merk" readonly>
</div>
<?php } ?>