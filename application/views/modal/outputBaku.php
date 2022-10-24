<?php if($cek == 0) { ?>
<div class="row">
    <div class="col-sm-6">
<div class="form-group">
    <label>Bahan Baku</label>
    <select name="id_baku" class="select2" id="baku" required>
        <option disabled selected>Pilih Bahan Baku</option>
        <?php foreach ($baku as $i): ?>
        <option value="<?php echo  $i->id_baku?>"><?php echo $i->nama_baku;?> - <?php echo $i->produsen;?></option>
        <?php endforeach; ?>
    </select> 
</div>
<div class="set-baku">
    <input class="form-control" name="nama_baku" type="hidden">
    <div class="form-group">
        <label>Satuan Bahan Baku</label><br>
        <input class="form-control" name="satuan" type="text" placeholder="Satuan" readonly>
    </div>
    <div class="form-group">
        <label>Produsen</label><br>
        <input class="form-control" name="produsen" type="text" placeholder="Produsen" readonly>
    </div>
</div>
</div>
    <div class="col-sm-6">
<div class="form-group">
    <label>Quantity</label><br>
    <input class="form-control" name="qty_output" type="number" placeholder="000" step="0.00001" required>
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
    <label>Bahan Baku</label>
    <select name="id_baku" class="custom-select form-control" required>
        <option selected value="<?php echo $outputEdit->id_baku?>" read><?php echo $outputEdit->nama_baku ?></option>
    </select>
</div>
<div class="form-group">
    <label>Quantity</label><br>
    <input class="form-control" name="qty_output" type="number" value="<?php echo $outputEdit->qty_output?>" step="0.00001" placeholder="000" required>
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
$("#baku").on("change keydown paste input", function() {
    var a = $("#baku").val();
    $.get("<?php echo base_url();?>outputBaku/set_baku/" + a, function (b) {
        $(".set-baku").html(b);
    })
})
</script>