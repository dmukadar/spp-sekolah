				<h1>Cetak Rekap Pembayaran </h1>
			
				<form name="form1" method="post" action="<?php echo site_url("setoran/cetak");?>" class="uniform">
					<fieldset>
						<legend>Form Cetak Laporan Pembayaran</legend>
						<dl class="inline">
							<dt><label>Jenis Laporan</label></dt>
							<?php foreach ($list_rate_category as $ndx=>$r) : ?>
									 <?php if (!empty($ndx)) : ?>
									 <dt>&nbsp;</dt>
									 <?php endif; ?>
                   <dd><label><input type="radio" name="tipe" value="<?php echo $r; ?>" <?php echo empty($ndx) ? 'checked="checked"' : ''; ?>> Penerimaan <?php echo $r; ?> Siswa</label></dd>
							<?php endforeach; ?>

							<dt><label>Unit</label></dt>
							<dd>
							<select name="tx_unit" id="tx_unit" class="medium">
              <option value="-1">Semua</option>
							<?php foreach($data_unit->result() as $value) : ?>
								<option value="<?php echo $value->id; ?>"><?php echo $value->nama; ?></option>;
							<?php endforeach; ?>
							</select>
							</dd>
							<dt><label>Pada Tanggal</label></dt>
							<dd>
								<input type="text" class="small" id="o-tgl-mulai" value="<?php echo date('d/m/Y'); ?>" /> sampai <input type="text" class="small" id="o-tgl-selesai" />
								<input type="hidden" id="tgl-mulai" name="tgl-mulai" value="<?php echo date('Y-m-d'); ?>" />
								<input type="hidden" id="tgl-selesai" name="tgl-selesai" />
							</dd>
						</dl>
					</fieldset>
					<div class="buttons">
						<button class="button" type="submit">Cetak</button>
					</div>
				</form>

				<script language="javascript">
					jQuery("#o-tgl-mulai").datepicker({'altField': '#tgl-mulai', 'altFormat': 'yy-mm-dd', 'dateFormat':'dd/mm/yy'});
					jQuery("#o-tgl-selesai").datepicker({'altField': '#tgl-selesai', 'altFormat': 'yy-mm-dd', 'dateFormat':'dd/mm/yy'});
				</script>
			
