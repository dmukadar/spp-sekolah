		<?php ME()->print_flash_message(); ?>	
		
		<div id="flash-msg" style="display:none">tes</div>
			
		<div class="clear"></div>
		
		<div id="form-layer" style="display: none">
		<h1 align="center">Tambah Data Dispensasi </h1>
		<form action="<?php echo (@$action_url);?>" method="post" id="myform">
			<fieldset>
			<legend>Input Dispensasi</legend>
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
							<dd><input id="siswa" type="text" name="siswa" value="<?php echo (@$sess->nama_siswa);?>" style="width:300px;"/></dd>
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
							<dd><input class="angka duit" style="text-align:right;" id="jumlah" type="text" name="jumlah" value="<?php echo (@$sess->jumlah);?>" /></dd>
						<dl>
					</td>
				</tr>
			</table>
			
			<input type="hidden" name="rep-siswa-kelas" id="rep-siswa-kelas" value="<?php echo (@$sess->kelas_jenjang);?>" />
			<input type="hidden" name="rep-siswa-induk" id="rep-siswa-induk" value="<?php echo (@$sess->no_induk);?>" />
			<input type="hidden" name="siswa_id" id="siswa_id" value="<?php echo (@$sess->id);?>" />
			<input type="hidden" name="custom-rate-id" id="custom-rate-id" value="" />
			
			<div class="buttons" style="text-align:right;">
				<button type="button" class="button grey" id="save-button">Simpan</button>
				<button type="button" class="button white" id="cancel-button">Batal</button>
			</div>
		</form>
		</div>
		<!-- div form layer -->
		
		<div id="list-layer">
			<div class="buttons" style="text-align:right;">
				<button type="button" class="button green" id="new-button">Tambah</button>
			</div><br/>
			<h1>Siswa Penerima Dispensasi</h1>
			<table id="tabel" class="gtable">
				<thead>
				<tr>
					<th><div align="left"><strong>Siswa</strong></div></th>
					<th><div align="left"><strong>Kelas</strong></div></th>
					<th><div align="left"><strong>Tagihan</strong></div></th>
					<th><div align="right"><strong>Dispensasi (Rp)</strong></div></th>
					<th><div align="right"><strong>Pilihan</strong></div></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($list_dispensasi as $dispensasi) : ?>
				<tr id="tbl-<?php echo ($dispensasi->get_id());?>">
					<td><?php echo ($dispensasi->siswa->get_namalengkap());?></td>
					<td><?php printf('%s (%s)', $dispensasi->kelas->get_kelas(), $dispensasi->kelas->get_jenjang()); ?></td>
					<td><?php echo ($dispensasi->rate->get_name());?></td>
					<td style="text-align:right;"><?php echo ($dispensasi->get_fare(TRUE));?></td>
					<td style="text-align:center;">
						<a title="Edit" href="<?php echo $dispensasi->get_id(); ?>" class="edit-data"><img alt="Edit" src="images/icons/edit.png"></a>
						<?php if (true) : ?>
						<a title="Delete" href="<?php echo $dispensasi->get_id();?>" class="delete-data"><img alt="Delete" src="images/icons/cross.png"></a>
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
		
		// response r
		function repop_form(r) {
			jQuery('#custom-rate-id').val(r.custom_rate.id);
			jQuery('#tagihan').val(r.custom_rate.id_rate);
			jQuery('#siswa').val(r.siswa.namalengkap);
			jQuery('#siswa_id').val(r.siswa.id);
			jQuery('#jumlah').autoNumericSet(r.custom_rate.fare);

			//jQuery('#notify').val(rate.notification);
			/*
			jQuery(':checkbox').each(function() {
				this.checked = (rate.notification == "1");
			});
			*/
		}
		
		jQuery('.duit').autoNumeric();

		jQuery('#new-button').click(function() {
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
			data += '&jumlah_mask=' + jQuery('#jumlah').autoNumericGet();

			jQuery.post(
				url,
				data,
				function (response) {

					if (response.search('berhasil') == -1) flashDialog('flash-msg', response, 10);
					else {
						flashDialog('flash-msg', response, 2);
						setTimeout(function() { document.location.href=document.location.href; }, 3000);
					}
				}
			);
		});
		
		jQuery('a.edit-data').click(function(e) {
			var id = jQuery(this).attr('href');

			jQuery.post(
				"<?php echo site_url('tarif_khusus/info'); ?>",
				{"id": id},
				function (response) {
					if (response.success == false) {
						flashDialog('flash-msg', response.message, 10);
					} else {
						// alert(response.item);
						repop_form(response);
						jQuery('#new-button').click();
					}
				}
			);
			
			e.preventDefault();
		});
		
		jQuery('a.delete-data').click(function(e) {
			var id = jQuery(this).attr('href');

			if (confirm('Anda yakin akan menghapus data ini ?')) {
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
