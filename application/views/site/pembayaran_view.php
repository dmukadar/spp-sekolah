
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
      
		<?php if (count($list_tagihan) > 0) : ?>
		<br/>
		<form action="<?php echo ($action_url);?>" method="post">
		<table id="tabel" class="gtable">
			<thead>
			<tr>
				<th><input type="checkbox" id="check-all" /></th>
				<th><div align="left"><strong>Deskripsi</strong></div></th>
				<th><div align="left"><strong>Jatuh Tempo</strong></div></th>
				<th><div align="right"><strong>Cicilan ke</strong></div></th>
				<th><div align="right"><strong>Jumlah (Rp)</strong></div></th>
				<th><div align="right"><strong>Sisa (Rp)</strong></div></th>
				<th><div align="right"><strong>Bayar (Rp)</strong></div></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($list_tagihan as $tagihan) : ?>
			<tr>
				<td><input class="tagihan-check" type="checkbox" id="tagihan-<?php echo ($tagihan->get_id());?>" name="tagihan[]" value="<?php echo ($tagihan->get_id());?>" /></td>
				<td><a href="#"><?php echo ($tagihan->get_description());?></a></td>
				<td><?php echo ($tagihan->get_due_date());?></td>
				<td style="text-align:right;"><?php echo ($tagihan->get_last_installment() + 1);?> dari <?php echo ($tagihan->rate->get_installment());?></td>
				<td style="text-align:right;"><?php echo ($tagihan->get_amount(TRUE));?></td>
				<td style="text-align:right;"><?php echo (number_format($tagihan->sisa_bayar));?></td>
				<td style="text-align:right;"><input <?php (ME()->installment_read_only($tagihan));?> style="text-align:right;font-weight:bold;" size="8" type="textbox" name="bayar[<?php echo ($tagihan->get_id());?>]" value="<?php echo (number_format($tagihan->sisa_bayar));?>" /></td>
			</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<br/>
		<input type="checkbox" id="confirm-bayar" value="yes" /><label for="confirm-bayar">Centang jika sudah yakin dengan data yang akan dibayarkan</label><br/>
		<input type="submit" value="BAYAR" name="paybtn" id="paybtn" class="button gray" />
		
		<input type="hidden" name="siswa-2" value="<?php echo (@$sess->nama_siswa);?>" size="30"/></dd>
		<input type="hidden" name="rep-siswa-kelas-2" value="<?php echo (@$sess->kelas_jenjang);?>" />
		<input type="hidden" name="rep-siswa-induk-2" value="<?php echo (@$sess->no_induk);?>" />
		<input type="hidden" name="siswa_id-2" value="<?php echo (@$sess->id_siswa);?>" />
		</form>
		
		<script>
			// ---- Form submit pembayaran
			document.getElementById('paybtn').onclick = function(el) {
				// pastikan user mencentang
				var status = document.getElementById('confirm-bayar').checked;
				if (status == false) {
					alert('Mohon centang dulu.');
					return false;
				}
			};
		</script>
		<?php endif;?>

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
			
			// ---- Form Submit
			document.getElementById('showbtn').onclick = function(el) {				
				// jika input hidden siswa nilainya lebih dari NOL maka, 
				// form dapat disubmit
				var id_siswa = parseInt(document.getElementById('siswa_id').value);
				
				if (id_siswa <= 0 || isNaN(id_siswa)) {
					alert('Mohon masukkan nama siswa terlebih dahulu.');
					return false;
				}
				
				document.forms[0].submit();
			}
			
			// ---- Check all tagihan
			document.getElementById('check-all').onclick = function(el) {
				var status = this.checked;
				jQuery('.tagihan-check').attr('checked', status);
			}
		</script>
