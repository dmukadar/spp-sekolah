				<h1>Cetak Laporan Tunggakan </h1>
			
				<form name="form1" method="post" action="<?php echo site_url("rekap/cetak");?>" class="uniform">
					<fieldset>
						<legend>Form Cetak Daftar Tunggakan Siswa</legend>
						<dl class="inline">
							<dt><label>Kategori</label></dt>
							<dd>
								<select name="tipe" class="medium">
							<?php foreach ($list_rate_category as $ndx=>$r) : ?>
                   <option value="<?php echo $r; ?>"> <?php echo $r; ?> </option>
							<?php endforeach; ?>
								</select>
							</dd>

							<dt><label>Unit</label></dt>
							<dd>
							<select name="tx_unit" id="tx_unit" class="small">
              <option value="-1">Semua</option>
							<?php foreach($data_unit as $value) : ?>
								<option value="<?php echo $value->id; ?>"><?php echo $value->nama; ?></option>;
							<?php endforeach; ?>
							</select>
							</dd>
							<dt><label>Per Tanggal</label></dt>
							<dd>
								<input type="text" class="small" id="o-tgl-mulai" value="<?php echo date('d/m/Y', (time() - (24*60*60*30))); ?>" />
								<input type="hidden" id="tgl-mulai" name="tgl-mulai" value="<?php echo date('Y-m-d', (time() - (24*60*60*30))); ?>" />
							</dd>
						</dl>
					</fieldset>
					<div class="buttons">
						<button class="button" type="submit">Cetak</button>
					</div>
				</form>

				<script language="javascript">
					jQuery("#o-tgl-mulai").datepicker({'altField': '#tgl-mulai', 'altFormat': 'yy-mm-dd', 'dateFormat':'dd/mm/yy'});
				</script>
			
