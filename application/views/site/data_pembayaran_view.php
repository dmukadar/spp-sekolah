
		<h1 align="center">Daftar Pembayaran Tagihan</h1>

		<?php ME()->print_flash_message(); ?>	
		
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
							<input type="submit" class="button gray" name="showbtn" id="showbtn" value="TAMPILKAN PEMBAYARAN" />
						</p>
					</td>
				</tr>
			</table>
			<!-- helper untuk repopulate -->
			<input type="hidden" name="rep-siswa-kelas" id="rep-siswa-kelas" value="<?php echo (@$sess->kelas_jenjang);?>" />
			<input type="hidden" name="rep-siswa-induk" id="rep-siswa-induk" value="<?php echo (@$sess->no_induk);?>" />
			<input type="hidden" name="siswa_id" id="siswa_id" value="<?php echo (@$sess->id_siswa);?>" />
		</form>
      
		<?php if (count($list_payments) > 0) : ?>
		<br/>
		<table id="tabel" class="gtable">
			<thead>
			<tr>
				<th><div align="center"><strong># Pembayaran</strong></div></th>
				<th><div align="center"><strong>Tanggal</strong></div></th>
				<th><div align="right"><strong>Jumlah (Rp)</strong></div></th>
				<th><div align="left"><strong>Siswa</strong></div></th>
				<th><div align="left"><strong>Kelas</strong></div></th>
				<th><div align="left"><strong>Pilihan </strong></div></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($list_payments as $payment) : ?>
			<tr>
				<td style="text-align:center"><?php echo (pad_zero($payment->get_id(), 6));?></td>
				<td style="text-align:center;"><?php echo ($payment->get_received_date());?></td>
				<td style="text-align:right"><?php echo ($payment->get_amount(TRUE));?></td>
				<td style=""><?php echo ($payment->siswa->get_namalengkap());?></td>
				<td style=""><?php echo ($payment->kelas->kelas_lengkap);?></td>
				<td><?php ME()->payment_detail_link($payment);?></td>
			</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<?php endif;?>
		
		<div id="basic-modal-content"></div>
		
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
			
			function ajax_payment_detail(payment_id) {
				var url = '<?php echo ($ajax_payment_detail_url);?>/' + payment_id;
				var modal = document.getElementById('basic-modal-content');
				modal.innerHTML = '<h3>Mohon tunggu...</h3>';
				jQuery('#basic-modal-content').modal({
					dataCss: {
						width: '800px'
					},
					minWidth: 820
				});
				
				jQuery.ajax({
					url: url,
					cache: false,
					success: function(data) {
						// console.log(data);
						modal.innerHTML = data;
					}
				});
				
				return false;
			}
		</script>
