
		<h1 align="center">Form <?php echo $page_title; ?></h1>

		<?php ME()->print_flash_message(); ?>	
		
		<div class="clear"></div>
		<form action="<?php echo (@$action_url);?>" method="post" class="uniform" id="myform">
			<fieldset>
			<dl class="inline">
					<?php if (!empty($model)) : ?>
					<dt><label for="code">Nomor</label></dt>
					<dd><strong><?php echo $model->get_code(); ?></strong></dd>
					<?php endif; ?>

					<?php if (empty($sess)) : ?>
					<dt><label for="siswa">Siswa</label></dt>
					<dd><input id="siswa" type="text" name="siswa" value="cari nama..." size="30" /></dd>

					<dt><label for="">Kelas</label></dt>
					<dd id="siswa-kelas-col">&nbsp;</dd>

					<dt><label for="">No. Induk</label></dt>
					<dd id="siswa-induk-col">&nbsp;</dd>

					<?php else : ?>

					<dt><label for="siswa">Siswa</label></dt>
					<dd><input id="siswa" type="text" name="siswa" value="<?php echo (@$sess->get_namalengkap());?>" size="30" /></dd>

					<dt><label for="">Kelas</label></dt>
					<dd id="siswa-kelas-col"><?php echo sprintf('%s (%s)', @$sess->kelas->get_kelas(), @$sess->kelas->get_jenjang());?>&nbsp;</dd>

					<dt><label for="">No. Induk</label></dt>
					<dd id="siswa-induk-col"><?php echo (@$sess->get_noinduk());?>&nbsp;</dd>

					<?php endif; ?>

					<dt><label for="tagihan">Tagihan</label></dt>
					<dd>
						<select name="tagihan" id="tagihan" class="medium" <?php echo empty($model) ? '' : ' disabled="disabled"'; ?>>
							<option value=''>-- Pilih --</option>
							<?php $id_rate = empty($model) ? 0 : $model->get_id_rate(); ?>
							<?php foreach ($list_tarif as $tarif) : ?>
								<option <?php echo (mr_selected_if($id_rate, $tarif->get_id()));?> value="<?php echo ($tarif->get_id());?>"><?php echo ($tarif->get_name());?></option>
							<?php endforeach; ?>
						</select>
					</dd>

					<dt><label for="keterangan">Keterangan</label></dt>
					<dd><input id="keterangan" type="text" class="medium" name="keterangan" value="<?php echo (empty($model) ? '' : $model->get_description());?>" readonly="readonly" /></dd>

					<dt><label for="jumlah">Jumlah</label></dt>
					<dd><input style="text-align:right;" id="jumlah" type="text" name="jumlah" value="<?php echo (empty($model) ? '' : $model->get_amount());?>" readonly="readonly" /></dd>

					<dt><label for="catatan">Catatan</label></dt>
					<dd><textarea id="catatan" class="medium" name="catatan"><?php echo (empty($model) ? '' : $model->get_notes());?> </textarea></dd>
			</dl>
			<div class="buttons">
							<?php if (empty($model) || ($model->get_status() != 'closed')) : ?>
							<button type="button" class="button gray" name="savebtn" id="savebtn">Simpan</button>
							<?php endif; ?>
							<button type="button" class="button white" name="cancel-button" id="cancel-button">Batal</button>
			</div>
			</fieldset>
			<!-- helper untuk repopulate -->
			<input type="hidden" name="id" value="<?php echo (empty($model) ? null : $model->get_id()); ?>" />
			<input type="hidden" name="action" value="<?php echo $action; ?>" />
			<input type="hidden" name="number" value="<?php echo (empty($model) ? null : $model->get_code()); ;?>" />
			<input type="hidden" name="siswa_id" id="siswa_id" value="<?php echo (empty($sess) ? null : @$sess->get_id());?>" />
		</form>

		<script>
		var modified = 0;
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

		jQuery('#siswa').focus(function() {
			if (jQuery('#siswa').val() == 'cari nama...') {
				jQuery('#siswa').val('');
			};
		});
		jQuery('#siswa').jsonSuggest({
			minCharacters: 3,
			url: '<?php echo ($ajax_siswa_url);?>',
			onSelect: function(item) {
				document.getElementById('siswa').value = item.nama;
				
				// tampilkan hidden row
				document.getElementById('siswa_id').value = item.id;
				document.getElementById('siswa-kelas-col').innerHTML = item.kelas + " (" + item.jenjang + ")";
				document.getElementById('siswa-induk-col').innerHTML = item.noinduk;
				document.getElementById('tagihan').focus();
			},
			onEnter: function() {
				// cegah form submit
				return false;
			}
		});

		jQuery('#tagihan').change(function() {
			jQuery.post(
				'<?php echo $info_url; ?>', 
				{
					id: jQuery('#siswa_id').val(), 
					rate: jQuery('#tagihan').val()
				},
				function(data) {
					console.log(data);
					jQuery('#keterangan').val(data.tagihan + ' ' +  data.waktu);
					jQuery('#jumlah').val(data.jumlah);
					jQuery('#catatan').focus();
			});
			modified++;
		});
		jQuery('#jumlah').change(function() {
			modified++;
		});

		jQuery('#myform').submit(function() {
			var stat = '<?php echo empty($model) ? 0 : $model->get_status(); ?>';
			var go = (modified > 0);

			if ((stat == 'paid') && (modified)) {
				go = confirm('Tagihan ini sudah mulai dicicil.\nSimpan perubahan?');
			}

			return go;
		});

		jQuery('#cancel-button').click(function() {
			history.go(-1);
		});
		jQuery('#savebtn').click(function() {
			jQuery.post(
				'<?php echo site_url("tagihan/simpan/1"); ?>',
				jQuery('#myform').serialize(),
				function (response) {
					if (response.search('SUCCESS') > -1) {
						jQuery('#myform').submit();
					} else {
						jQuery('h1').after('<div class="error msg" id="msg-box">' + response + '</div>');
						setTimeout(function() { 
							jQuery('#msg-box').fadeOut(); 
							jQuery('#msg-box').remove(); 
						}
						, 10000);
					}
				}
			);
		});
		
		</script>
