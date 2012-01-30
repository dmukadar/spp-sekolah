
			<h1>Salin Data Kelompok Tagih</h1>
			<div id="err-msg" class="error msg" style="display:none">tes</div>
			<div id="info-msg" class="information msg">Data yang diupload bisa berupa xls atau csv yang terdiri dari 2 kolom: nomor induk dan nama siswa</div>

			<div id="form-layer">
			<form id="myform" enctype="multipart/form-data" class="uniform" method="post" action="
			<?php 
			//echo site_url("otogroup/loadExcel/");
			echo site_url("otogroup/do_upload/");
			?>">
				<fieldset>
					<legend>Form Impor Kelompok Tagih</legend>
					<dl class="inline">
						<dt><label for="id_rate">Tagihan</label></dt>
						<dd>
							<select id="id_rate" name="id_rate" class="medium">
								<?php foreach ($list_tarif as $r) : ?>
								<option value="<?php echo $r->get_id(); ?>"><?php echo $r->get_name(); ?></option>
								<?php endforeach; ?>
							</select>
						</dd>
                       
						<dt><label for="nama">Daftar Siswa</label></dt>
						<dd>
							<input type="file" name="file_import" />
						</dd>
					</dl>
					
				</fieldset>
				<div class="buttons" style="text-align:right;">
					<input type="submit" value="Upload" class="button gray"/>
			</form>
			</div>

			<div id="list-layer" style="display: none">
			<h2>Data Siap Impor Kelompok Tagihan "Uang Sanggar Komputer Kids"</h2>
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
				<tr>
					<td>OK</td>
					<td>11.111.222.33</td>
					<td>Budiwijaya</td>
					<td>IV B</td>
					<td>SD</td>
				</tr>
				<tr>
					<td>OK</td>
					<td>22.111.222.33</td>
					<td>Alina Yudhistira</td>
					<td>IV B</td>
					<td>SD</td>
				</tr>
				<tr>
					<td>OK</td>
					<td>33.111.222.33</td>
					<td>Bambang Triharjo</td>
					<td>V A</td>
					<td>SD</td>
				</tr>
				<tr>
					<td>Sudah</td>
					<td>11.888.222.33</td>
					<td>Ali Mukadar</td>
					<td>IV B</td>
					<td>SD</td>
				</tr>
				<tr>
					<td>OK</td>
					<td>11.777.222.33</td>
					<td>Susi Susanti</td>
					<td>IV B</td>
					<td>SD</td>
				</tr>
				<tr>
					<td>Gagal</td>
					<td>&nbsp;</td>
					<td>John doe</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				</tbody>
			</table>
		<div class="tablefooter clearfix">
						<div class="actions">
							Keterangan: OK = data bisa diimpor, Sudah = data sudah ada, Gagal = data siswa tidak ditemukan
						</div>
						<div class="pagination">&nbsp;</div>
					</div>
				<div class="buttons" style="text-align:right; margin-top: 10px;">
					<button type="button" class="button" id="save-button">Impor data diatas</button>
				</div>
		</div>
		</div><!--list-layer-->


			<script>
				jQuery('#upload-button').click(function() {
					jQuery('#list-layer').slideDown();
				});
				jQuery('#save-button').click(function() {
					flashDialog('err-msg', 'Fitur ini masih dalam pengembangan', 5);
				});

			</script>
