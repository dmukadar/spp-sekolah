
			<h1>Daftar Seluruh Tagihan</h1>

			<?php ME()->print_flash_message(); ?>	

			<div id="err-msg" class="error msg" style="display:none">tes</div>
			<div id="info-msg" class="information msg" style="display:none">tes</div>

			<div id="list-layer">
			<form name="frm-filter-cat" id="frm-filter-cat" method="post" action="<?php echo (@$filter_url);?>" class="uniform">
				<fieldset>
					<legend>Cari data</legend>
					<dl class="inline">
						<dt><label for"keyword"><strong>Kata kunci</strong></label></dt>
						<dd>
							<input type="text" class="medium submit-filter" name="keyword" id="keyword" value="<?php echo empty($keyword) ? 'cari ...' : $keyword; ?>" onfocus="if (this.value=='cari ...') this.value='';" />
							<input type="hidden" name="field_name" id="field_name" value="<?php echo empty($field_name) ? 'rate': $field_name; ?>" />
							<input type="hidden" name="search_id" id="search_id" value="<?php echo empty($search_id) ? '': $search_id; ?>" />
						</dd>

						<dt><label for"status"><strong>Status tagihan</strong></label></dt>
						<dd>
							<select type="text" class="small submit-filter" name="status" id="status">
								<?php foreach ($list_status as $s_id=>$s_value) : ?>
								<option value="<?php echo $s_id; ?>" <?php echo ($s_id == $search_status ? 'selected="selected"' : ''); ?>><?php echo $s_value; ?></option>
								<?php endforeach; ?>
							</select>
						</dd>
					</dl>
				</fieldset>
				
			<div class="buttons">
				<button type="button" class="button" id="filter-button">Filter</button>
				<button type="button" class="button green" id="new-button">Buat Tagihan</button>
			</div>
			
			<br/>
			<table id="tabel" class="gtable">
				<thead>
				<tr>
					<th><div align="left"><strong>Tanggal</strong></div></th>
				  <th><div align="left"><strong>No.</strong></div></th>
				  <th><div align="left"><strong>Siswa</strong></div></th>
				  <th><div align="left"><strong>Tagihan</strong></div></th>
				  <th><div align="left"><strong>Jumlah</strong></div></th>
					<th><div align="center"><strong>Pilihan</strong></div></th>
				</tr>
				</thead>
				<tbody>
				<?php if (empty($list_data)) : ?>
				<tr>
					<td colspan="7">Data tidak ditemukan</td>
				</tr>
				<?php else : ?>
				<?php foreach ($list_data as $row) : ?>
				<tr>
					<td><?php echo date('d/m/Y', strtotime($row->get_created_date())); ?></td>
					<td><?php echo $row->get_code(); ?></td>
					<td><?php echo $row->namalengkap; ?></td>
					<td><?php echo $row->get_description(); ?></td>
					<td><?php echo $row->get_amount(true); ?></td>
					<td style="text-align:center;">
						<a title="Edit" href="<?php echo ME()->get_edit_link($row); ?>"><img alt="Edit" src="images/icons/edit.png"></a>
						<?php if ($row->get_status() == 'open') : ?>
						<a title="Delete" href="<?php echo ME()->get_delete_link($row); ?>" class="delete-row"><img alt="Delete" src="images/icons/cross.png"></a>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		<div class="tablefooter clearfix">
						<div class="actions">
							Keterangan: <img alt="Edit" src="images/icons/edit.png"> Ubah data  <img alt="Delete" src="images/icons/cross.png"> Hapus data
						</div>
						<div class="pagination">
							<a href="<?php echo $prev_page; ?>" class="paging-leaf">Prev</a>
							<?php if ($total_page > 1) : ?>
							<?php foreach (range($first_range, $last_range) as $p) : ?>
							<a <?php echo ($p==$page ? 'class="current"' : ''); ?> href="<?php echo $p; ?>" class="paging-leaf"><?php echo $p; ?></a>
							<?php endforeach; ?>
							...
							<?php endif; ?>
							<input type="text" title="loncat ke halaman ..." name="page" value="<?php echo $total_page; ?>" id="page" style="width: 25px; text-align: right;" class="submit-filter" />
							<a href="<?php echo $next_page; ?>" class="paging-leaf">Next</a>
						</div>
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
					document.location.href = "<?php echo $action_url; ?>";
				});
				jQuery('#save-button').click(function() {
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

			jQuery('#keyword').jsonSuggest({
				minCharacters: 2,
				url: '<?php echo site_url("tagihan/suggest/keyword") ;?>',
				onSelect: function(item) {

					jQuery('#keyword').val(item.value);
					jQuery('#field_name').val(item.field);
					jQuery('#search_id').val(item.id);
					jQuery('#keyword').focus();
					//do nothing
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
				if (! confirm('Anda yakin akan menghapus data tagihan ?')) {
					e.preventDefault();
				}
			});

			jQuery('#filter-button').click(function(e){
				 jQuery('#frm-filter-cat').submit();
			});
			</script>
