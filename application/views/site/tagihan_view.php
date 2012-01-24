
		<h1 align="center">Daftar Tagihan Per Siswa</h1>

		<?php ME()->print_flash_message(); ?>	
		
		<span style="color:#c60000;">Untuk melihat tagihan siswa tertentu: Masukkan nama siswa, klik yang sesuai<br/> kemudian klik tombol "Tampilkan Tagihan".</span>
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
							<?php if (count($list_tagihan) > 0) : ?>
							<input type="button" value="INPUT TAGIHAN BARU" name="create-new" id="create-new" class="button green" />
							<?php endif; ?>
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
				<th><div align="left"><strong>Tanggal</strong></div></th>
				<th><div align="left"><strong>No.</strong></div></th>
				<th><div align="left"><strong>Tagihan</strong></div></th>
				<th><div align="right"><strong>Jumlah (Rp)</strong></div></th>
				<th><div align="left"><strong>Status</strong></div></th>
				<th><div align="left"><strong>Pilihan</strong></div></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($list_tagihan as $tagihan) : ?>
			<tr>
				<td><?php echo ($tagihan->get_created_date());?></td>
				<td><?php echo ($tagihan->get_code());?></td>
				<td><a href="#"><?php echo ($tagihan->get_description());?></a></td>
				<td style="text-align:right;"><?php echo ($tagihan->get_amount(TRUE));?></td>
				<td><?php echo ($tagihan->get_status());?></td>
				<td>
					<a title="Edit" href="<?php echo ME()->get_edit_link($tagihan); ?>"><img alt="Edit" src="images/icons/edit.png"></a>
					<?php if ($tagihan->get_status() == 'open') : ?>
					<a title="Delete" href="<?php echo ME()->get_delete_link($tagihan); ?>" class="delete-row"><img alt="Delete" src="images/icons/cross.png"></a>
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
		<br/>
		<input type="hidden" name="siswa-2" value="<?php echo (@$sess->nama_siswa);?>" size="30"/>
		<input type="hidden" name="rep-siswa-kelas-2" value="<?php echo (@$sess->kelas_jenjang);?>" />
		<input type="hidden" name="rep-siswa-induk-2" value="<?php echo (@$sess->no_induk);?>" />
		<input type="hidden" name="siswa_id-2" value="<?php echo (@$sess->id_siswa);?>" />
		</form>
		
		<?php endif;?>

		<script>
			var repopulate = <?php echo $reload; ?>;
			jQuery(document).ready(function() {
				if (repopulate == 1) {
					// tampilkan hidden row
					document.getElementById('siswa-kelas').style.display = '';
					document.getElementById('siswa-induk').style.display = '';
				};
			});
			jQuery("#create-new").click(function() {
				document.location.href = '<?php echo site_url("tagihan/create/" . $sess->id_siswa); ?>';
			});
			jQuery(".delete-row").click(function(e) {
				var okay = confirm('hapus data ini ?');
				if (! okay) {
					e.preventDefault();
				}
			});
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
		</script>
