
		<h1 align="center">Pembayaran Tagihan</h1>

		<?php ME()->print_flash_message(); ?>	
		
		<!-- <span style="color:#c60000;">Developer Note: Klik <a href="<?php echo (site_url());?>/pembayaran/dev_reset">reset</a> untuk mereset semua record pada ar_invoice.</span> -->
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
		<h3 style="border-bottom:1px solid #ccc;">Operator: <?php echo ME()->get_current_user()->get_user_full_name();?></h3>
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
				<td><label for="tagihan-<?php echo $tagihan->get_id(); ?>"><a href="javascript:void(0);"><?php echo ($tagihan->get_description());?></a></label></td>
				<td><?php echo ($tagihan->get_due_date());?></td>
				<td style="text-align:right;"><?php echo ($tagihan->get_last_installment() + 1);?> dari <?php echo ($tagihan->rate->get_installment());?></td>
				<td style="text-align:right;"><?php echo ($tagihan->get_amount(TRUE));?></td>
				<td style="text-align:right;" id="sisa-<?php echo ($tagihan->get_id());?>"><?php echo (number_format($tagihan->sisa_bayar));?></td>
				<td style="text-align:right;"><input <?php ME()->print_cicilan($tagihan); ?> readonly="readonly" style="text-align:right;font-weight:bold;" size="8" type="textbox" class="uang" id="bayar-<?php echo ($tagihan->get_id());?>" name="bayar[<?php echo ($tagihan->get_id());?>]" value="<?php echo (number_format($tagihan->sisa_bayar));?>" /></td>
			</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<br/>
		<div style="float:left;width:400px;">
			<input type="submit" value="BAYAR" name="paybtn" id="paybtn" class="button gray" />
		</div>
		<div id="div-total-bayar" style="width:350px;float:right;">
			<div style="text-align:right;">
				<div style="display:block;margin-bottom:5px;font-size:18px;font-weight:bold;"><label>Total</label> <input style="font-size:18px;font-weight:bold;text-align:right;" type="textbox" value="0" id="total-bayar" size="10" readonly="readonly" /></div>
				<div style="display:block;margin-bottom:5px;font-size:18px;font-weight:bold;"><label>Terima Pembayaran</label> <input style="font-size:18px;font-weight:bold;text-align:right;" type="textbox" value="0" id="total-pembayaran" size="10" /></div>
				<div style="display:block;margin-bottom:5px;font-size:18px;font-weight:bold;"><label>Uang Kembali</label> <input style="font-size:18px;font-weight:bold;text-align:right;" type="textbox" value="0" id="total-kembalian" size="10" readonly="readonly" /></div>
			</div>
		</div>
		<div style="clear:both;"></div>
		<input type="hidden" name="siswa-2" value="<?php echo (@$sess->nama_siswa);?>" size="30"/></dd>
		<input type="hidden" name="rep-siswa-kelas-2" value="<?php echo (@$sess->kelas_jenjang);?>" />
		<input type="hidden" name="rep-siswa-induk-2" value="<?php echo (@$sess->no_induk);?>" />
		<input type="hidden" name="siswa_id-2" value="<?php echo (@$sess->id_siswa);?>" />
		</form>
		
		<script>
			// ---- Form submit pembayaran
			document.getElementById('paybtn').onclick = function(el) {
				var totalbayar = jQuery('#total-bayar').autoNumericGet();
				var pembayaran = jQuery('#total-pembayaran').autoNumericGet();
				
				if (parseFloat(totalbayar) <= 0) {
					alert('Mohon pilih tagihan terlebih dulu.');
					return false;
				}
				if (parseFloat(pembayaran) <= 0) {
					alert('Mohon isikan pembayaran terlebih dulu.');
					jQuery('#total-pembayaran').focus();
					jQuery('#total-pembayaran').select();
					return false;
				}
				
				if (parseFloat(pembayaran) < parseFloat(totalbayar)) {
					alert('Mohon maaf, Uang pembayaran kurang!');
					jQuery('#total-pembayaran').focus();
					jQuery('#total-pembayaran').select();
					return false;
				}
				
				var tanya = confirm('Menerima pembayaran sebesar Rp' + totalbayar + '.-\n\nTekan OK untuk melanjutkan atau Cancel untuk batal.');
				if (!tanya) {
					return false;
				}
				
				return true;
			}
			
			// ---- Check all tagihan
			document.getElementById('check-all').onclick = function(el) {
				var status = this.checked;
				jQuery('.tagihan-check').attr('checked', status);
				hitung_total();
				hitung_kembalian();
			}
			
			jQuery('.uang, #total-bayar, #total-pembayaran, #total-kembalian').autoNumeric();
			
			jQuery('.tagihan-check').click(function() {
				var id = this.id.substring('tagihan-'.length);
				var jmlbox = jQuery('#bayar-' + id);
				var jml_tagihan = jmlbox.attr('value');
				var cicilan = jmlbox.attr('el');
				var status_checkbox = this.checked;
				
				// jika tagihan bukan langsung lunas maka hilangkan
				// tanda disabled pada textbox agar user dapat menginput
				// jumlah baru
				if (status_checkbox == false) {
					// tanpa perlu dipikir langsung saja disabled
					jmlbox.attr('readonly', true);
				} else {
					if (cicilan == 'cicil') {
						jmlbox.removeAttr('readonly');
					}
				}
				hitung_total();
				hitung_kembalian();
			});
			
			function hitung_total() {
				var total = 0.0;
				jQuery('.tagihan-check').each(function() {
					if (this.checked) {
						var id = this.id.substring('tagihan-'.length);
						total += parseFloat(jQuery('#bayar-' + id).autoNumericGet());
					}
				});
				
				jQuery('#total-bayar').autoNumericSet(total);
			}
			
			function hitung_kembalian() {
				var total = parseFloat(jQuery('#total-bayar').autoNumericGet());
				var pembayaran = parseFloat(jQuery('#total-pembayaran').autoNumericGet());
				
				if (pembayaran < total) {
					jQuery('#total-kembalian').val('0');
					return -1;
				}
				
				var kembalian = pembayaran - total;
				jQuery('#total-kembalian').autoNumericSet(kembalian);
			}
			
			jQuery('.uang').keyup(function() {
				var id = this.id.substring('bayar-'.length);
				var sisa = jQuery('#sisa-' + id).html().replace(',', '');
				var myval = parseFloat(jQuery(this).autoNumericGet());
				
				// angka yang diinputkan seharusnya tidak lebih besar daripada sisa
				if (myval > sisa) {
					this.value = sisa;
				}
				hitung_total();
				hitung_kembalian();
			});
			
			jQuery('#total-pembayaran').keyup(function() {
				hitung_kembalian();
			});
			
			jQuery('#total-pembayaran').focus(function() {
				this.select();
			});
			
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
		</script>
