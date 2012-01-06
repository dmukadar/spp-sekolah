
		<h1 align="center">Daftar Tarif Khusus </h1>

		<?php ME()->print_flash_message(); ?>	
		
		<div class="clear"></div>
		<form action="<?php echo (@$action_url);?>" method="post">
			<table style="width:100%" cellspacing="4">
				<tr>
					<td><dt><label for="tagihan">Tagihan</label></dt></td>
					<td>
						<dl>
							<dd>
								<select name="tagihan" id="tagihan">
									<option value=''>-- Pilih --</option>
									<?php foreach ($list_tarif as $tarif) : ?>
									<option <?php echo (mr_selected_if(@$sess->tagihan, $tarif->get_id()));?> value="<?php echo ($tarif->get_id());?>"><?php echo ($tarif->get_name());?></option>
									<?php endforeach; ?>
								</select>
							</dd>
						</dl>
					</td>
				</tr>
				<tr>
					<td style="font-weight:bold;"><dt><label for="siswa">Siswa</label></dt></td>
					<td style="font-weight:bold;">
						<dl>
							<dd><input id="siswa" type="text" name="siswa" value="<?php echo (@$sess->nama_siswa);?>" /></dd>
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
					<td></td>
					<td>
						<p>
							<input type="submit" class="button gray" name="savebtn" id="savebtn" value="SIMPAN" />
						</p>
					</td>
				</tr>
			</table>
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
		

		// var data_unit = ['Foo', 'Bar', 'Shit'];
		var data_unit = [{"nama":"Achmad Abdul Rohim","noinduk":"10.03.259","kelas":"VIII","jenjang":"SMP"},{"nama":"Achmad Fasya Dwiana Adwifya","noinduk":"09.02.501","kelas":"III A","jenjang":"SD"},{"nama":"Achmad Rozaq R. Hadju","noinduk":"11.01.338","kelas":"A2","jenjang":"TK"},{"nama":"Achmad Tsani","noinduk":"09.02.502","kelas":"III B","jenjang":"SD"}];
		jQuery('#siswa').autocomplete({data: data_unit});
		</script>
