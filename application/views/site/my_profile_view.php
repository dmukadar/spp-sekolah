
			<h1>Update Profile</h1>
			<?php ME()->print_flash_message(); ?>	
			<form action="<?php echo (@$action_url);?>" method="post">
			<table style="width:80%" cellspacing="4">
				<tr>
					<td style="font-weight:bold;"><dt><label for="namadepan">Nama Depan</label></dt></td>
					<td style="font-weight:bold;">
						<dl>
							<dd><input id="namadepan" type="text" name="namadepan" value="<?php echo (@$sess->namadepan);?>" size="30"/></dd>
						<dl>
					</td>
				</tr>
				<tr>
					<td style="font-weight:bold;"><dt><label for="namabelakang">Nama Belakang</label></dt></td>
					<td style="font-weight:bold;">
						<dl>
							<dd><input id="namabelakang" type="text" name="namabelakang" value="<?php echo (@$sess->namabelakang);?>" size="30"/></dd>
						<dl>
					</td>
				</tr>
				<tr>
					<td style="font-weight:bold;"><dt><label for="passwordbaru2">Password Baru</label></dt></td>
					<td style="font-weight:bold;">
						<dl>
							<dd><input id="passwordbaru" type="password" name="passwordbaru" value="" size="30"/><em style="font-weight:normal;font-size:11px;">Kosongi jika tidak ingin mengubah password.</em></dd>
						<dl>
					</td>
				</tr>
				<tr>
					<td style="font-weight:bold;"><dt><label for="passwordbaru2">Ulangi Password Baru</label></dt></td>
					<td style="font-weight:bold;">
						<dl>
							<dd><input id="passwordbaru2" type="password" name="passwordbaru2" value="" size="30"/><em style="font-weight:normal;font-size:11px;">Kosongi jika tidak ingin mengubah password.</em></dd>
						<dl>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<p>
							<input type="submit" class="button gray" name="updatebtn" id="updatebtn" value="UBAH" />
						</p>
					</td>
				</tr>
			</table>
			</form>

			<script>
				document.getElementById('namadepan').focus();
			</script>
