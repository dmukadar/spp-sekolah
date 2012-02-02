<div id="list-layer"><?php ME()->print_flash_message(); ?>	
			<h2>Data Siap Impor Kelompok Tagihan<strong> 
	        <?php  echo $ratename;?>
			</strong></h2>
			
<form id="myform" name="myform" method="post" action="<?php 
echo (@$action_url);
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
				    <input name="peserta[]" type="hidden" id="peserta[]_<?php echo $counter_hidden;?>" value="<?php echo $siswa['id']; ?>" />
				 <!-- <input name="tx_induk_<?php echo $counter_hidden;?>" type="hidden" id="tx_induk_<?php echo $counter_hidden;?>" value="<?php echo $siswa['id']; ?>" />-->
					<td><?php echo $siswa['namalengkap']; ?></td>
					<td><?php echo $siswa['kelas']; ?></td>
					<td><?php echo $siswa['jenjang']; ?></td>
				</tr>
			<?php }?>	
				
</tbody>
</table>
		
		<input name="tx_rate" type="hidden" id="tx_rate" value="<?php echo $rate; ?>" />
		<input name="tx_counter" type="hidden" id="tx_counter" value="<?php echo $counter_hidden; ?>" />
		<input id="grouping" name="grouping" value="siswa" type="hidden" />
		<input id="id_rate" name="id_rate" value="<?php echo $rate; ?>" type="hidden" />
		<!--<input type="hidden" name="peserta[]" value="' + item.id + '" />-->
		<div class="tablefooter clearfix">
						<div class="actions">
							Keterangan: OK = data bisa diimpor, Sudah = data sudah ada, Gagal = data siswa tidak ditemukan
						</div>
						<div class="pagination">&nbsp;</div>
  </div>
					<div class="buttons" style="text-align:right; margin-top: 10px;">
					  
						<label>
						  <script>
							function save(){
									var url = jQuery('#myform').attr('action');
									var data = jQuery('#myform').serialize();
									
					
									jQuery.post(url, data, function(response) {
										if (! response.success) {
											flashDialog('err-msg', response.message, 5);
										} else {
											flashDialog('info-msg', response.message, 2);
											setTimeout(function() { document.location.href="<? base_url()?>"+ "index.php/otogroup/index" }, 3000);
										}
									});
							}
						  </script>
						  <button type="button" class="button green" name="save-button2" id="save-button2" onclick="save();">Impor Data Diatas</button>
						</label>
					  
					</div>
			</div>
			</form>
		</div><!--list-layer-->


		<script>
				jQuery('keyword').change(function() {
					//document.getElementById('frm-filter-cat').submit();
					flashDialog('err-msg', 'Fitur ini masih dalam pengembangan', 5);
				});
				jQuery('#new-button').click(function() {
					jQuery('#form-layer').slideDown();
					jQuery('#list-layer').hide();
				});
				jQuery('#cancel-button').click(function() {
					jQuery('#form-layer').slideUp();
					jQuery('#list-layer').show();
				});
				jQuery('#save-button').click(function() {
					alert("oke");
					var url = jQuery('#myform').attr('action');
					var data = jQuery('#myform').serialize();

					jQuery.post(url, data, function(response) {
						if (! response.success) {
							flashDialog('err-msg', response.message, 5);
						} else {
							flashDialog('info-msg', response.message, 2);
							setTimeout(function() { document.location.href=document.location.href; }, 3000);
						}
					});
					alert("oke 2");
				});

			// ---- Auto complete
			jQuery('#siswa').jsonSuggest({
				minCharacters: 3,
				url: '<?php echo ($ajax_siswa_url);?>',
				onSelect: function(item) {
					if (! jQuery('#peserta-container').is(':visible')) jQuery('#peserta-container').toggle();

					peserta = '<li><input type="hidden" name="peserta[]" value="' + item.id + '" /><a title="Delete" href="javascript:void(0);" class="rm-siswa" onclick="remove_siswa(this);"><img alt="Delete" src="images/icons/cross.png"></a> ' + item.nama + ' - ' + item.kelas + ' ( ' + item.jenjang + ' )</li>';
					jQuery('#tmp_siswa').append(peserta);
					jQuery('#siswa').val('');
				},
				onEnter: function() {
					// cegah form submit
					return false;
				}
			});

			function remove_siswa(item) {
				var li = jQuery(item).parent();
				li.fadeOut();
				li.remove();
			};

			jQuery('.select_grouping').focus(function() {
				if (this.id != 'siswa') {
					grouping = 'kelas';
					jQuery('#peserta-container').fadeOut();
				} else {
					grouping = 'siswa';
					jQuery(':checkbox').each(function() {
						this.checked = false;
						jQuery(this).parent().removeClass("checked");
					});
				};
				jQuery('#grouping').val(grouping);
			});

			jQuery('a.paging-leaf').click(function(e) {
				jQuery('#page').val(jQuery(this).attr('href'));
				jQuery('#frm-filter-cat').submit();
				e.preventDefault();
			});

			jQuery('.submit-filter').keypress(function(e){
				if (e.keyCode == 13) jQuery('#frm-filter-cat').submit();
			});

			jQuery('#keyword').keypress(function(e){
				jQuery('#page').val(1);
			});

			jQuery('#checker').click(function() {
				var on = this.checked;
				jQuery(':checkbox').each(function() {
					this.checked = on;
					if (on) {
						jQuery(this).parent().addClass("checked");
					} else {
						jQuery(this).parent().removeClass("checked");
					}
				});
			});

			jQuery('.delete-row').click(function(e) {
				if (confirm('Anda yakin akan menghapus data kelompok tagihan ?')) {
					jQuery.post(jQuery(this).attr('href'), function(response) {
						if (response.search('berhasil') == -1) flashDialog('err-msg', response, 10);
						else {
							flashDialog('info-msg', response, 2);
							setTimeout(function() { document.location.href=document.location.href; }, 3000);
						}
					});
				}
				e.preventDefault();
			});
			</script>
