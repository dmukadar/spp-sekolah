				<h1>Cetak Laporan Pembayaran </h1>
			
				<form name="form1" method="post" action="<?php echo site_url("setoran/cetak");?>" class="uniform">
					<fieldset>
						<legend>Form Cetak Laporan Pembayaran</legend>
						<dl class="inline">
							<dt><label>Jenis Laporan</label></dt>
							<dd>
								<label><input type="radio" name="tipe" value="1" checked="checked" class="toggle-kategori" /> Detil Penerimaan </label><br/>
								<label><input type="radio" name="tipe" value="2" class="toggle-kategori" /> Ringkasan Penerimaan Kas </label>
							</dd>
							<div id="kategori-container">
							<dt><label>Kategori</label></dt>
							<dd>
							<select name="kategori" class="medium">
							<?php foreach ($list_rate_category as $ndx=>$r) : ?>
                   <option value="<?php echo $r; ?>"><?php echo $r; ?></option>
							<?php endforeach; ?>
							</select>
							</dd>
							</div>

							<dt><label>Unit</label></dt>
							<dd>
							<select name="tx_unit" id="tx_unit" class="small">
              <option value="-1">Semua</option>
							<?php foreach($data_unit as $value) : ?>
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
					jQuery(".toggle-kategori").change(function() {
						if (jQuery(this).val() == 2) jQuery('#kategori-container').fadeOut();
						else jQuery('#kategori-container').fadeIn();

					});
				</script>
			
