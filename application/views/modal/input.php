<?php if($cek == 0) { ?>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>Bahan Kemas</label>
            <select name="id_item" class="select2 item" required>
                <!-- <option value="0">Item Baru</option> -->
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
            <div class="form-group">
                <label>Nama Items</label><br>
                <input class="form-control" name="nama_item" type="text" placeholder="Nama Item" readonly>
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
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>Supplier</label>
            <select name="id_supplier" class="select2 supp" required>
                <option value="0">Supplier Baru</option>
                <!-- <option disabled selected>Pilih Supplier</option> -->
                <option disabled>--------------------------</option>
                <?php foreach ($supplier as $s): ?>
                <option value="<?php echo $s->id_supplier?>"><?php echo $s->nama_supplier ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="set-supplier">
            <div class="form-group">
                <label>Nama Supplier</label><br>
                <input class="form-control" name="nama_supplier" type="text" placeholder="Nama Supplier" required>
            </div>
            <div class="form-group">
                <label>Kontak</label><br>
                <input class="form-control" name="kontak" type="text" placeholder="Kontak">
            </div>
        </div>
        <div class="form-group">
            <label>Quantity</label><br>
            <input class="form-control" name="qty_input" type="number" placeholder="000" required>
        </div>
        <div class="form-group">
            <label>Koli / Box</label><br>
            <input class="form-control" name="kb_input" type="number" placeholder="000" required>
        </div>
        <div class="form-group">
            <label>Tanggal</label><br>
            <input class="form-control" name="tgl_input" type="date" placeholder="00-00-0000" required>
        </div>
        <!-- <input name="id_user" value="1" type="hidden"> -->
    </div>
</div>
<?php } else { ?>
    <?php foreach ($inputEdit as $inputEdit): ?>
    <input type="hidden" name="id_input" value="<?php echo $inputEdit->id_input;?>">
    <input name="id_user" type="hidden" value="<?php echo  $inputEdit->id_user?>">
    <div class="form-group">
        <label>Item</label>
        <select name="id_item" class="custom-select form-control" required>
            <option selected value="<?php echo  $inputEdit->id_item?>" read><?php echo $inputEdit->nama_item ?></option>
        </select>
    </div>
    <div class="form-group">
        <label>Supplier</label>
        <select name="id_supplier" class="custom-select form-control" required>
            <option selected value="<?php echo  $inputEdit->id_supplier?>"><?php echo $inputEdit->nama_supplier ?></option>
            <option disabled>--------------------------</option>
            <?php foreach ($supplier as $s): ?>
            <option value="<?php echo  $s->id_supplier?>"><?php echo $s->nama_supplier ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Quantity</label><br>
        <input class="form-control" name="qty_input" type="number" value="<?php echo  $inputEdit->qty_input?>" placeholder="000" required>
    </div>
    <div class="form-group">
        <label>Koli / Box</label><br>
        <input class="form-control" name="kb_input" type="number" value="<?php echo  $inputEdit->kb_input?>" placeholder="000" required>
    </div>
    <div class="form-group">
        <label>Tanggal</label><br>
        <input class="form-control" name="tgl_input" type="date" value="<?php echo  $inputEdit->tgl_input?>" placeholder="00-00-0000" required>
    </div>
<?php endforeach; ?>
<?php } ?>
<script>
$("select.select2").select2({
    dropdownAutoWidth: !0,
    width: "100%",
    dropdownParent: $(".modal")
})
$(".supp").on("change keydown paste input", function() {
    var a = $(".supp").val();
    $.get("<?php echo base_url();?>Input/set_supplier/" + a, function (b) {
        $(".set-supplier").html(b);
    })
})
$(".item").on("change keydown paste input", function() {
    var a = $(".item").val();
    $.get("<?php echo base_url();?>Input/set_item/" + a, function (b) {
        $(".set-item").html(b);
    })
})
</script>