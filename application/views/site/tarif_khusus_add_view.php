				<h1 align="center">Form Rekam  Tarif Khusus </h1>

				
				<form name="form1" method="post" action="<?php echo site_url("tarif_khusus_add/act_insert_data/");?>">
				  <label>				  </label>
				  <table width="376" border="0">
                    <tr>
                      <td width="16" height="31">&nbsp;</td>
                      <td width="99"><label><strong>Tarif</strong></label></td>
                      <td width="247"><label>
		<select name="tx_id_rate" id="tx_id_rate">
          <option value=''>Semua</option>
          <?php 
						foreach($data_mas02_tarif->result() as $value){
							echo "<option value='".$value->id."'>".$value->name."</option>";
						}
				  ?>
        </select><strong>
        <input name="tx_modif" type="hidden" id="tx_modif" value="11">
		</strong></label></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><strong>Siswa</strong></td>
                      <td height="28"><input name="tx_nama" type="text" id="tx_nama" size="30">
                        <strong>
                        <input name="tx_id_siswa" type="hidden" id="tx_id_siswa" >
                      </strong></td>
                    </tr>
                    <tr>
                      <td height="28">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td height="28"><input name="tx_kelas" type="text" id="tx_kelas" style="background-color:#CCCCCC" readonly="true" ></td>
                    </tr>
                    <tr>
                      <td height="28">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td height="28"><input name="tx_induk" type="text" id="tx_induk" style="background-color:#CCCCCC" readonly="true"></td>
                    </tr>
                    
                    <tr>
                      <td>&nbsp;</td>
                      <td><strong>Jumlah</strong></td>
                      <td height="28"><input name="tx_jml" type="text" id="tx_jml"></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><label></label></td>
                      <td><input name="Submit" type="submit" id="Submit" value="Simpan"></td>
                    </tr>
                  </table>
				  <label></label>
				</form>
				
				