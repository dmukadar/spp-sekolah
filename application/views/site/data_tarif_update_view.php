		<h1 align="center">Form Ubah Tarif</h1>
		
		<?php ME()->print_flash_message(); ?>	
		
		<div class="clear"></div>
		<form action="<?php echo (@$action_url);?>" method="post">
			<table style="width:100%" cellspacing="4">
				<tr>
					<td><dt><label for="">Kategori</label></dt></td>
					<td style="font-weight:bold;"><?php echo (@$sess->category);?></td>
				</tr>
				<tr>
					<td><dt><label for="nama">Tagihan</label></dt></td>
					<td style="font-weight:bold;">
						<dl>
							<dd><input id="nama" type="text" name="nama" size="35" value="<?php echo (@$sess->nama);?>" /></dd>
						<dl>
					</td>
				</tr>
				<tr>
					<td style="font-weight:bold;"><dt><label for="jumlah">Jumlah</label></dt></td>
					<td style="font-weight:bold;">
						<dl>
							<dd><input style="text-align:right;" id="jumlah" type="text" name="jumlah" value="<?php echo (@$sess->jumlah);?>" /></dd>
						<dl>
					</td>
				</tr>
				<tr>
					<td style="vertical-align:top;"><dt><label for="">Keterangan</label></dt></td>
					<td style="font-weight:bold;">
						<dl>
							<dd>
							<textarea id="keterangan" name="keterangan" style="width:90%;height:100px;"><?php echo (@$sess->keterangan);?></textarea>
							</dd>
						<dl>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<p>
							<input type="submit" class="button gray" name="updatebtn" id="updatebtn" value="SIMPAN" />
						</p>
					</td>
				</tr>
			</table>
			<input type="hidden" name="tarif_id" value="<?php echo (@$sess->id);?>" id="tarif_id" />
		</form>
		
		<script>
		jQuery(document).ready(function() {
			jQuery("#jumlah").keydown(function(event) {
				// Allow only backspace and delete
				if ( event.keyCode == 46 || event.keyCode == 8 ) {
					// let it happen, don't do anything
				}
				else {
					// Ensure that it is a number and stop the keypress
					if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
						event.preventDefault(); 
					}   
				}
			});
		});
		</script>
