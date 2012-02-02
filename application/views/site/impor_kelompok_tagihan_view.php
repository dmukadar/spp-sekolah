
			<h1>Salin Data Kelompok Tagih</h1>
			
<? if ($eror==1){?><div id="err-msg" class="error msg" > <?php echo "Format data yang di upload tidak valid atau Tipe data yang anda masukkan bukan xls/csv";?></div><? }?>


			<div id="info-msg" class="information msg">Data yang diupload bisa berupa xls atau csv yang terdiri dari 2 kolom: nomor induk dan nama siswa</div>
<?php ME()->print_flash_message(); ?>	
			<div id="form-layer">
			<form id="myform" enctype="multipart/form-data" method="post" action="<?php 
echo (@$action_url);
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
					<button type="submit" class="button green" name="save-button" id="save-button" onclick="test();">Upload</button>
			        
			</form>
			</div>

<script>
							function test(){
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
							}
 </script>


		