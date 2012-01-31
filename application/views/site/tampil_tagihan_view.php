<div id="list-layer"><?php ME()->print_flash_message(); ?>	
			<h2>Data Siap Impor Kelompok Tagihan<strong> 
	        <?php  echo $ratename;?>
			</strong></h2>
			
<form id="form1" name="form1" method="post" action="<?php 
echo site_url('otogroup/simpan_exc'); 
?>">		
<table id="tabel" class="gtable">
				<thead>
				<tr>
					<th><div align="left"><strong>Status</strong></div></th>
					<th><div align="left"><strong>Nomor Induk</strong></div></th>
				  <th><div align="left"><strong>Nama</strong></div></th>
				  <th><div align="left"><strong>Kelas</strong></div></th>
				  <th><div align="left"><strong>Jenjang</strong></div></th>
				</tr>
				</thead>
				<tbody>
		<?php	
		    
			$counter_hidden=0;
			
			foreach($data_siswa as $siswa){	
					$counter_hidden++;
				?>	
				<tr>
					<td><?php echo $siswa['status']; ?>
				    <input name="tx_status_<?php echo $counter_hidden;?>" type="hidden" id="tx_status_<?php echo $counter_hidden;?>" value="<?php echo $siswa['status']; ?>" /></td>
					<td><?php echo $siswa['noinduk']; ?>
				    <input name="tx_induk_<?php echo $counter_hidden;?>" type="hidden" id="tx_induk_<?php echo $counter_hidden;?>" value="<?php echo $siswa['id']; ?>" /></td>
					<td><?php echo $siswa['namalengkap']; ?></td>
					<td><?php echo $siswa['kelas']; ?></td>
					<td><?php echo $siswa['jenjang']; ?></td>
				</tr>
			<?php }?>	
				
</tbody>
</table>
		
		<input name="tx_rate" type="hidden" id="tx_rate" value="<?php echo $rate; ?>" />
		<input name="tx_counter" type="hidden" id="tx_counter" value="<?php echo $counter_hidden; ?>" />
		
		<div class="tablefooter clearfix">
						<div class="actions">
							Keterangan: OK = data bisa diimpor, Sudah = data sudah ada, Gagal = data siswa tidak ditemukan
						</div>
						<div class="pagination">&nbsp;</div>
  </div>
					<div class="buttons" style="text-align:right; margin-top: 10px;">
					  
						<label>
						  <input type="submit" name="savebtn" id="savebtn" value="Impor data diatas" class="button gray" />
						</label>
					  
					</div>
			</div>
		</div><!--list-layer-->
</form>

			<script>
				jQuery('#upload-button').click(function() {
					jQuery('#list-layer').slideDown();
				});
				
				
				jQuery('#savebtn').click(function() {
			jQuery.post(
				'<?php echo site_url("otogroup/simpan_exc"); ?>',
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
