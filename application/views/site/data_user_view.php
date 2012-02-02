		<?php ME()->print_flash_message(); ?>	
		
		<div id="flash-msg" style="display:none">tes</div>
			
		<div class="clear"></div>
		
		<div id="form-layer" style="display: none">
		<h1 align="center">Tambah Pengguna Baru</h1>
		<form action="<?php echo (@$action_url);?>" method="post" id="myform">
			<fieldset>
			<legend>Input User</legend>
			<table style="width:100%" cellspacing="4">
				<tr>
					<td><dt><label for="username">Username</label></dt></td>
					<td>
						<dl>
							<dd><input id="username" type="text" name="username" value="<?php echo (@$sess->username);?>" /></dd>
						</dl>
					</td>
				</tr>
				<tr>
					<td><dt><label for="password">Password</label></dt></td>
					<td>
						<dl>
							<dd><input id="password" type="password" name="password" value="<?php echo (@$sess->password);?>" />
							<span style="font-size:10px;" class="kosongi">Kosongi jika tidak ingin mengubah</span>
							</dd>
						</dl>
					</td>
				</tr>
				<tr>
					<td><dt><label for="password2">Ulangi Password</label></dt></td>
					<td>
						<dl>
							<dd><input id="password2" type="password" name="password2" value="<?php echo (@$sess->password2);?>" />
							<span style="font-size:10px;" class="kosongi">Kosongi jika tidak ingin mengubah</span>
							</dd>
						</dl>
					</td>
				</tr>
				<tr>
					<td style="font-weight:bold;"><dt><label for="namadepan">Nama Depan</label></dt></td>
					<td style="font-weight:bold;">
						<dl>
							<dd><input id="namadepan" type="text" name="namadepan" value="<?php echo (@$sess->namadepan);?>" /></dd>
						<dl>
					</td>
				</tr>
				<tr>
					<td style="font-weight:bold;"><dt><label for="namabelakang">Nama Belakang</label></dt></td>
					<td style="font-weight:bold;">
						<dl>
							<dd><input id="namabelakang" type="text" name="namabelakang" value="<?php echo (@$sess->namabelakang);?>" /></dd>
						<dl>
					</td>
				</tr>
				<tr>
					<td style="font-weight:bold;"><dt><label for="namabelakang">Email</label></dt></td>
					<td style="font-weight:bold;">
						<dl>
							<dd><input id="email" type="text" name="email" value="<?php echo (@$sess->email);?>" /></dd>
						<dl>
					</td>
				</tr>
				<tr>
					<td style="font-weight:bold;"><dt><label for="status">Status</label></dt></td>
					<td style="font-weight:bold;">
						<dl>
							<dd>
								<select name="status" id="status">
									<option value="">-- Status --</option>
									<?php foreach ($list_status as $id_status=>$status) : ?>
									<option value="<?php echo ($id_status);?>"><?php echo ($status);?></option>
									<?php endforeach; ?>
								</select>
							</dd>
						<dl>
					</td>
				</tr>
				<tr>
					<td style="font-weight:bold;"><dt><label for="privilege">Hak Akses</label></dt></td>
					<td style="font-weight:bold;">
						<dl>
							<dd>
								<select name="privilege" id="privilege">
									<option value="">-- Status --</option>
									<?php foreach ($list_privilege as $id_privilege=>$privilege) : ?>
									<option value="<?php echo ($id_privilege);?>"><?php echo ($privilege);?></option>
									<?php endforeach; ?>
								</select>
							</dd>
						<dl>
					</td>
				</tr>
			</table>
			
			<div class="buttons" style="text-align:right;">
				<button type="button" class="button grey" id="save-button">Simpan</button>
				<button type="button" class="button white" id="cancel-button">Batal</button>
			</div>
			
			<input type="hidden" name="user-id" value="" id="user-id" />
		</form>
		</div>
		<!-- div form layer -->
		
		<div id="list-layer">
			<div class="buttons" style="text-align:right;">
				<button type="button" class="button green" id="new-button">Tambah</button>
			</div><br/>
			<h1>Daftar Pengguna Sistem Informasi Keuangan</h1>
			<table id="tabel" class="gtable">
				<thead>
				<tr>
					<th><div align="left"><strong>No</strong></div></th>
					<th><div align="left"><strong>Username</strong></div></th>
					<th><div align="left"><strong>Nama User</strong></div></th>
					<th><div align="left"><strong>Email</strong></div></th>
					<th><div align="left"><strong>Hak Akses</strong></div></th>
					<th><div align="left"><strong>Status</strong></div></th>
					<th><div align="left"><strong>Login Terakhir</strong></div></th>
					<th><div align="center"><strong>Pilihan</strong></div></th>
				</tr>
				</thead>
				<tbody>
				<?php $counter = 0; foreach ($list_user as $user) : ?>
				<tr id="tbl-<?php echo ($user->get_user_id());?>">
					<td><?php echo (++$counter);?></td>
					<td><?php echo ($user->get_username());?></td>
					<td><?php printf('%s %s', $user->get_user_first_name(), $user->get_user_last_name());?></td>
					<td><?php echo ($user->get_user_email());?></td>
					<td><?php echo ($user->get_user_privilege(TRUE));?></td>
					<td><?php echo ($user->get_user_status(TRUE));?></td>
					<td><?php echo ($user->get_user_last_login(TRUE));?></td>
					<td style="text-align:center;">
						<a title="Edit" href="<?php echo $user->get_user_id(); ?>" class="edit-data"><img alt="Edit" src="images/icons/edit.png"></a>
						<?php if (true) : ?>
						<a title="Delete" href="<?php echo $user->get_user_id();?>" class="delete-data"><img alt="Delete" src="images/icons/cross.png"></a>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<div class="tablefooter clearfix">
							<div class="actions">
								Keterangan: <img alt="Edit" src="images/icons/edit.png"> Ubah data  <img alt="Delete" src="images/icons/cross.png"> Hapus data
							</div>
							<div class="pagination">
								<!--<a href="#">Prev</a>
								<a class="current" href="#">1</a>
								<a href="#">2</a>
								<a href="#">3</a>
								<a href="#">4</a>
								<a href="#">5</a>
								...
								<a href="#">78</a>
								<a href="#">Next</a>-->
							</div>
						</div>
			</div>
		</div>

		<script>
		// response r
		function repop_form(u) {
			jQuery('#user-id').val(u.user_id);
			jQuery('#username').val(u.username);
			jQuery('#namadepan').val(u.user_first_name);
			jQuery('#namabelakang').val(u.user_last_name);
			jQuery('#email').val(u.user_email);
			jQuery('#status').val(u.user_status);
			jQuery('#privilege').val(u.user_privilege);
			
			jQuery('#username').attr('disabled', true);
			jQuery('.kosongi').show();
		}

		jQuery('#new-button').click(function() {
			clear_form();
			jQuery('#form-layer').slideDown();
			jQuery('#list-layer').hide();
		});
		
		jQuery('#cancel-button').click(function() {
			jQuery('#form-layer').slideUp();
			jQuery('#list-layer').show();
		});
		
		jQuery('#save-button').click(function() {
			//flashDialog('err-msg', 'Fitur ini masih dalam pengembangan', 5);
			var url = jQuery('#myform').attr('action');
			var data = jQuery('#myform').serialize();

			jQuery.post(
				url,
				data,
				function (response) {
					if (response.search('berhasil') == -1) {
						// flashDialog('flash-msg', response, 10);
						jQuery('#flash-msg').html(response);
						jQuery('#flash-msg').slideDown();
					} else {
						// jQuery('#flash-msg').hide();
						flashDialog('flash-msg', response, 2);
						setTimeout(function() { document.location.href=document.location.href; }, 5000);
					}
				}
			);
		});
		
		jQuery('a.edit-data').click(function(e) {
			var id = jQuery(this).attr('href');

			jQuery.post(
				"<?php echo site_url('userctl/info'); ?>",
				{"user-id": id},
				function (response) {
					if (response.success == false) {
						flashDialog('flash-msg', response.message, 10);
					} else {
						repop_form(response.item);
						jQuery('#form-layer').slideDown();
						jQuery('#list-layer').hide();
					}
				}
			);
			
			e.preventDefault();
		});
		
		jQuery('a.delete-data').click(function(e) {
			var id = jQuery(this).attr('href');

			if (confirm('Anda yakin akan menghapus user ini?')) {
				jQuery.post(
					"<?php echo site_url('tarif_khusus/delete'); ?>",
					{"id": id},
					function (response) {
						if (! response.search('berhasil') == -1) {
							flashDialog('flash-msg', response, 10);
						} else {
							flashDialog('flash-msg', response, 2);
							jQuery('#tbl-' + id).hide();
							// setTimeout(function() { document.location.href = document.location.href; }, 3000);
						}
					}
				);
			}
			
			e.preventDefault();
		});

		function clear_form() {
			jQuery('#myform')[0].reset();
			jQuery('.kosongi').hide();
			jQuery('#username').attr('disable', false);
		}
		</script>
