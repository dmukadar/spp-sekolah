
		<h1 align="center">Data Dispensasi</h1>

		<?php ME()->print_flash_message(); ?>	
		
		<div class="clear"></div>
		<form action="<?php echo (@$action_url);?>" method="post">
			<table style="width:100%" cellspacing="4">
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
							<input type="button" class="button gray" name="showbtn" id="showbtn" value="TAMPILKAN" />
						</p>
					</td>
				</tr>
			</table>
			<!-- helper untuk repopulate -->
			<input type="hidden" name="post-url" id="post-url" value="<?php echo ($action_url);?>" />
			<input type="hidden" name="rep-siswa-kelas" id="rep-siswa-kelas" value="<?php echo (@$sess->kelas_jenjang);?>" />
			<input type="hidden" name="rep-siswa-induk" id="rep-siswa-induk" value="<?php echo (@$sess->no_induk);?>" />
			<input type="hidden" name="siswa_id" id="siswa_id" value="<?php echo (@$sess->id);?>" />
		</form>
		
		<?php if (count($list_tarif_khusus) > 0): ?>	
		<br/>
		<span style="color:#c60000;">Developer Note: Ajax, dialog window, icon ubah dan hapus menyusul</span>
		<table id="tabel" class="gtable">
				<thead>
				<tr>
				  <th><div align="left"><strong>Kategori</strong></div></th>
					<th><div align="left"><strong>Tagihan</strong></div></th>
					<th><div align="right"><strong>Jumlah (Rp)</strong></div></th>
					<th><div align="center"><strong>Pilihan</strong></div></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($list_tarif_khusus as $tarif): ?>
				<tr>
					<td><?php echo ($tarif->rate->get_category());?></td>
					<td><?php echo ($tarif->rate->get_name());?></td>
					<td style="text-align:right;"><?php echo ($tarif->get_fare(TRUE));?></td>
					<td style="text-align:center;">
						<a href="<?php echo (ME()->get_edit_link($tarif));?>" class="reply">ubah</a>
						<a href="<?php echo (ME()->get_delete_link($tarif));?>" class="delete delete-link">Hapus</a>
					</td>
				</tr>
				<?php endforeach; ?>	
				</tbody>
		</table>
		<?php endif; ?>	

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
		
		jQuery('.delete-link').click(function(el) {
			var tanya = confirm("Apakah anda yakin ingin menghapus?");
			if (!tanya) {
				// hentikan event
				return false;
			}
			
			// lanjutkan dengan menuju link sesuai href...
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
		
		document.getElementById('showbtn').onclick = function() {
			// jika input hidden siswa nilainya lebih dari NOL maka, 
			// arahkan ke list tagihan
			var id_siswa = parseInt(document.getElementById('siswa_id').value);
			
			if (id_siswa <= 0 || isNaN(id_siswa)) {
				alert('Mohon masukkan nama siswa terlebih dahulu.');
				return false;
			}
			
			// redirect
			document.location.href = document.getElementById('post-url').value + '/' + id_siswa;
		}
		</script>
