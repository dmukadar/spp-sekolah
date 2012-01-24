
		<h1 align="center">Edit Data Dispensasi </h1>

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
							<dd><input id="siswa" type="text" name="siswa" value="<?php echo (@$sess->nama_siswa);?>" size="30"/></dd>
						<dl>
					</td>
				</tr>
				<tr id="siswa-kelas" style="display:none;">
					<td style="font-weight:bold;"><dt><label for="">Kelas</dt></label></td>
					<td style="font-weight:bold;"><dl><dd id="siswa-kelas-col"><?php echo (@$sess->kelas_jenjang);?></dd></dl></label>
				</tr>
				<tr id="siswa-induk" style="display:none;">
					<td style="font-weight:bold;"><dt><label for="">No. Induk</dt></label></td>
					<td style="font-weight:bold;"><dl><dd id="siswa-induk-col"><?php echo (@$sess->no_induk);?></dd></dl></label></td>
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
			<!-- helper untuk repopulate -->
			<input type="hidden" name="rep-siswa-kelas" id="rep-siswa-kelas" value="<?php echo (@$sess->kelas_jenjang);?>" />
			<input type="hidden" name="rep-siswa-induk" id="rep-siswa-induk" value="<?php echo (@$sess->no_induk);?>" />
			<input type="hidden" name="siswa_id" id="siswa_id" value="<?php echo (@$sess->id);?>" />
			<input type="hidden" name="custom-rate-id" value="<?php echo (@$sess->custom_rate_id);?>" id="custom-rate-id" />
		</form>

		<script>
		jQuery("#jumlah").keydown(function(event) {
			// Allow only backspace, delete, tab, and enter
			if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13) {
				// let it happen, don't do anything
			}
			else {
				// Ensure that it is a number and stop the keypress
				if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
					event.preventDefault(); 
				}   
			}
		});

		jQuery('#siswa').jsonSuggest({
			minCharacters: 3,
			url: '<?php echo ($ajax_siswa_url);?>',
			onSelect: function(item) {
				document.getElementById('siswa').value = item.nama;
				
				// tampilkan hidden row
				document.getElementById('siswa-kelas').style.display = '';
				document.getElementById('siswa-induk').style.display = '';
				
				document.getElementById('rep-siswa-kelas').value = item.kelas + " (" + item.jenjang + ")";
				document.getElementById('rep-siswa-induk').value = item.noinduk;
				document.getElementById('siswa_id').value = item.id;
				
				document.getElementById('siswa-kelas-col').innerHTML = item.kelas + " (" + item.jenjang + ")";
				document.getElementById('siswa-induk-col').innerHTML = item.noinduk;
				document.getElementById('jumlah').focus();
			},
			onEnter: function() {
				// cegah form submit
				return false;
			}
		});
		
		// repopulate jika hidden field rep-siswa-induk tidak kosong
		if (document.getElementById('rep-siswa-induk').value.length > 0) {
			document.getElementById('siswa-kelas').style.display = '';
			document.getElementById('siswa-induk').style.display = '';
		}
		</script>
