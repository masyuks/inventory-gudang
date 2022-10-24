<?php if($cek == 0) { ?>
<div class="form-group">
	<label>Nama</label><br>
    <input class="form-control" name="nama_user" type="text" placeholder="Nama" required>
</div>
<div class="form-group">
	<label>Email</label><br>
    <input class="form-control" name="email" type="email" placeholder="Email" required>
</div>
<div class="form-group">
	<label>Password</label><br>
    <input class="form-control" name="password" type="password" placeholder="*****" required>
</div>
<div class="form-group">
	<label>Level</label><br>
	<select name="level" id="level" class="custom-select form-control">
	  <option value="adminkemas">Admin Bahan Kemas</option>
	  <option value="adminbaku">Admin Bahan Baku</option>	  
	  <option value="superadmin">Super Admin</option>
	</select>
</div>
<?php } else { ?>
<input type="hidden" name="id_user" value="<?php echo $user->id_user;?>">
<div class="form-group">
	<label>Nama</label><br>
    <input class="form-control" value="<?php echo $user->nama_user;?>" name="nama_user" type="text" placeholder="Nama" required>
</div>
<div class="form-group">
	<label>Email</label><br>
    <input class="form-control" value="<?php echo $user->email;?>" name="email" type="email" placeholder="Email" required>
</div>
<div class="form-group">
	<label>Level</label><br>
	<select name="level" id="level" class="form-control" value="<?php echo $user->level;?>">
	  <option value="adminkemas">Admin Bahan Kemas</option>
	  <option value="adminbaku">Admin Bahan Baku</option>	  
	  <option value="superadmin">Super Admin</option>
	</select>
</div>
<?php } ?>