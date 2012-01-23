
			<h1>Daftar Kelompok Tagih</h1>
			<div id="err-msg" class="error msg" style="display:none">tes</div>
			<div id="info-msg" class="information msg" style="display:none">tes</div>

			<div id="form-layer">
			<form id="myform" class="uniform" action="<?php echo (@$action_url);?>">
				<fieldset>
					<legend>Form Master Kelompok Tagih</legend>
					<dl class="inline">
						<dt><label for="id_rate">Tagihan</label></dt>
						<dd>
							<select id="id_rate" name="id_rate" class="medium">
								<?php foreach ($list_tarif as $r) : ?>
								<option value="<?php echo $r->get_id(); ?>"><?php echo $r->get_name(); ?></option>
								<?php endforeach; ?>
							</select>
						</dd>

						<dt><label for="nama">Peserta</label></dt>
						<dd>
								<p>
								<input id="group_kelas" name="grouping" value="kelas" type="radio" checked="checked"> Kelas <br/>
								<select id="kelas" name="kelas" class="small">
									<option value="99">Semua</option>
									<option value="0">TK</option>
									<option value="1">1 (SD)</option>
									<option value="2">2 (SD)</option>
									<option value="3">3 (SD)</option>
									<option value="4">4 (SD)</option>
									<option value="5">5 (SD)</option>
									<option value="6">5 (SD)</option>
									<option value="7">7 (SMP)</option>
									<option value="8">8 (SMP)</option>
									<option value="9">9 (SMP)</option>
								</select>
								</p>
								<p>
								<input id="group_siswa" name="grouping" value="siswa" type="radio"> Siswa <br/>
								<input id="nama" type="text" name="nama" class="medium" value="<?php echo (@$sess->nama);?>" />
								<div class="success msg">
									Daftar sementara (klik tombol Simpan untuk menyimpan permanen):
									<ol id="tmp_siswa">
										<li><a title="Delete" href="1" class="delete-row"><img alt="Delete" src="images/icons/cross.png"></a> Budiwijaya - SD kelas IV</li>
										<li><a title="Delete" href="2" class="delete-row"><img alt="Delete" src="images/icons/cross.png"></a> Ali Mukadar - SD kelas IV</li>
										<li><a title="Delete" href="3" class="delete-row"><img alt="Delete" src="images/icons/cross.png"></a> Teguh Wijaya - SMP kelas II</li>
										<li><a title="Delete" href="4" class="delete-row"><img alt="Delete" src="images/icons/cross.png"></a> Santi susisan - SD kelas IV</li>
									</ol>
								</div>
								</p>
						</dd>
					</dl>
					
				</fieldset>
				<div class="buttons" style="text-align:right;">
					<button type="button" class="button grey" id="save-button">Simpan</button>
					<button type="button" class="button white" id="cancel-button">Batal</button>
				</div>
			</form>
			</div>

			<div id="list-layer">
			<div class="buttons" style="text-align:right;">
				<button type="button" class="button green" id="new-button">Tambah</button>
			</div>
			<form name="frm-filter-cat" id="frm-filter-cat" method="post" action="<?php echo (@$action_url);?>">
					<div>
						<label for"keyword"><strong>Filter: </strong></label>
						<input type="text" class="medium" name="keyword" id="keyword" value="cari ..." onfocus="if (this.value=='cari ...') this.value='';" />
					</div>
		  </form>
				
			
			<br/>
			<table id="tabel" class="gtable">
				<thead>
				<tr>
					<th><div align="left"><strong>Tagihan</strong></div></th>
				  <th><div align="left"><strong>Peserta</strong></div></th>
					<th><div align="center"><strong>Pilihan</strong></div></th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>Uang Seragam SMP</td>
					<td>Kelas 7 SMP</td>
					<td style="text-align:center;">
						<a title="Edit" href="edit/999"><img alt="Edit" src="images/icons/edit.png"></a>
						<a title="Delete" href="delete/999" class="delete-row"><img alt="Delete" src="images/icons/cross.png"></a>
					</td>
				</tr>
				<tr>
					<td>Uang Seragam SMP</td>
					<td>Kelas 8 SMP</td>
					<td style="text-align:center;">
						<a title="Edit" href="edit/999"><img alt="Edit" src="images/icons/edit.png"></a>
						<a title="Delete" href="delete/999" class="delete-row"><img alt="Delete" src="images/icons/cross.png"></a>
					</td>
				</tr>
				<tr>
					<td>Uang Seragam SMP</td>
					<td>Kelas 9 SMP</td>
					<td style="text-align:center;">
						<a title="Edit" href="edit/999"><img alt="Edit" src="images/icons/edit.png"></a>
						<a title="Delete" href="delete/999" class="delete-row"><img alt="Delete" src="images/icons/cross.png"></a>
					</td>
				</tr>
				<tr>
					<td>Uang Sanggar Pendaftaran Komputer Kids</td>
					<td>Budiwijaya - IV B SD</td>
					<td style="text-align:center;">
						<a title="Edit" href="edit/999"><img alt="Edit" src="images/icons/edit.png"></a>
						<a title="Delete" href="delete/999" class="delete-row"><img alt="Delete" src="images/icons/cross.png"></a>
					</td>
				</tr>
				<tr>
					<td>Uang Sanggar Komputer Kids</td>
					<td>Budiwijaya - IV B SD</td>
					<td style="text-align:center;">
						<a title="Edit" href="edit/999"><img alt="Edit" src="images/icons/edit.png"></a>
						<a title="Delete" href="delete/999" class="delete-row"><img alt="Delete" src="images/icons/cross.png"></a>
					</td>
				</tr>
				</tbody>
			</table>
		<div class="tablefooter clearfix">
						<div class="actions">
							Keterangan: <img alt="Edit" src="images/icons/edit.png"> Ubah data  <img alt="Delete" src="images/icons/cross.png"> Hapus data
						</div>
						<div class="pagination">
							<a href="#">Prev</a>
							<a class="current" href="#">1</a>
							<a href="#">2</a>
							<a href="#">3</a>
							<a href="#">4</a>
							<a href="#">5</a>
							...
							<a href="#">78</a>
							<a href="#">Next</a>
						</div>
					</div>
		</div>
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
					flashDialog('err-msg', 'Fitur ini masih dalam pengembangan', 5);
				});

			</script>
