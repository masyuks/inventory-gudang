<?php if($cek == 0) { ?>
<div class="row">
    <div class="col-sm-6">
<div class="form-group">
    <label>Item</label>
    <select name="id_item" class="select2" id="item" required>
        <option disabled selected>Pilih Item</option>
        <?php foreach ($item as $i): ?>
        <option value="<?php echo  $i->id_item?>"><?php echo $i->jenis;?> - <?php echo $i->nama_item;?> <?php echo $i->netto;?> <?php if ($i->merk != "") { ?>
                 - <?php echo $i->merk;?>
            <?php } ?>
        </option>
        <?php endforeach; ?>
    </select> 
</div>
<div class="set-item">
    <input class="form-control" name="nama_item" type="hidden">
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
</div>
</div>
    <div class="col-sm-6">
<div class="form-group">
    <label>Quantity</label><br>
    <input class="form-control" name="qty_output" type="number" placeholder="000" required>
</div>
<div class="form-group">
    <label>Koli / Box</label><br>
    <input class="form-control" name="kb_output" type="number" placeholder="000" required>
</div>
<div class="form-group">
    <label>Tanggal</label><br>
    <input class="form-control" name="tgl_output" type="date" placeholder="00-00-0000" required>
</div>
<div class="form-group">
    <label>Keterangan</label><br>
    <textarea class="form-control" name="keterangan" cols="30" rows="2"></textarea>
</div>
</div>
<?php } else { ?>
    <?php foreach ($outputEdit as $outputEdit): ?>
    <input type="hidden" name="id_output" value="<?php echo $outputEdit->id_output;?>">
    <div class="form-group">
    <label>Item</label>
    <select name="id_item" class="custom-select form-control" required>
        <option selected value="<?php echo $outputEdit->id_item?>" read><?php echo $outputEdit->nama_item ?></option>
    </select>
</div>
<div class="form-group">
    <label>Quantity</label><br>
    <input class="form-control" name="qty_output" type="number" value="<?php echo $outputEdit->qty_output?>" placeholder="000" required>
</div>
<div class="form-group">
    <label>Koli / Box</label><br>
    <input class="form-control" name="kb_output" type="number" value="<?php echo $outputEdit->kb_output?>" placeholder="000" required>
</div>
<div class="form-group">
    <label>Tanggal</label><br>
    <input class="form-control" name="tgl_output" type="date" value="<?php echo $outputEdit->tgl_output?>" placeholder="00-00-0000" required>
</div>
<div class="form-group">
    <label>Keterangan</label><br>
    <textarea class="form-control" name="keterangan" cols="30" rows="2"><?php echo $outputEdit->keterangan ?></textarea>
</div>
<?php endforeach; ?>
<?php } ?>
<script>
$("select.select2").select2({
    dropdownAutoWidth: !0,
    width: "100%",
    dropdownParent: $(".modal")
})
$("#item").on("change keydown paste input", function() {
    var a = $("#item").val();
    $.get("<?php echo base_url();?>output/set_item/" + a, function (b) {
        $(".set-item").html(b);
    })
})
</script>