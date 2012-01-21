
		<h1 align="center">Pembayaran Tagihan</h1>

		<?php ME()->print_flash_message(); ?>	
		
		<span style="color:#c60000;">Developer Note: Klik <a href="<?php echo (site_url());?>/pembayaran/dev_reset">reset</a> untuk mereset semua record pada ar_invoice.</span>
		<form name="frm-filter-cat" id="frm-filter-cat" method="post" action="<?php echo (@$action_url);?>">
			<table style="width:80%" cellspacing="4">
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
					<td></td>
					<td>
						<p>
							<input type="submit" class="button gray" name="showbtn" id="showbtn" value="TAMPILKAN TAGIHAN" />
						</p>
					</td>
				</tr>
			</table>
			<!-- helper untuk repopulate -->
			<input type="hidden" name="rep-siswa-kelas" id="rep-siswa-kelas" value="<?php echo (@$sess->kelas_jenjang);?>" />
			<input type="hidden" name="rep-siswa-induk" id="rep-siswa-induk" value="<?php echo (@$sess->no_induk);?>" />
			<input type="hidden" name="siswa_id" id="siswa_id" value="<?php echo (@$sess->id_siswa);?>" />
		</form>
		
		<?php if ($confirm_payment) : ?>
		
		<?php endif ;?>

		<script>
			// ---- Auto complete
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
				},
				onEnter: function() {
					// cegah form submit
					return false;
				}
			});
			
			// ---- Repopulate jika hidden field rep-siswa-induk tidak kosong
			if (document.getElementById('rep-siswa-induk').value.length > 0) {
				document.getElementById('siswa-kelas').style.display = '';
				document.getElementById('siswa-induk').style.display = '';
			}
		</script>
