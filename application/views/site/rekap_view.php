
				<h1 align="center">Cetak Daftar Tunggakan </h1>
			
				<form name="form1" method="post" action="<?php echo site_url("tlain2/pilih_report_tunggakan/");?>">
				  <label>				  </label>
				  <table width="100%" border="0" align="center">
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td height="28" colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="6" rowspan="2">&nbsp;</td>
                      <td width="202"><label><strong>Jenis Laporan </strong></label></td>
                      <td width="1" rowspan="2"><label></label>
                        <p>
                          <label></label>
                          <br>
                        </p>
                      <label>                        </label></td>
                      <td height="28" colspan="4" rowspan="2"><label>
                        <input type="radio" name="bt_laporan" value="1" checked> 
                        Tunggakan SPP dan BPPS
</label>
                        <br>
                        <label>
                        <input type="radio" name="bt_laporan" value="2"></label>
                        <label>Tunggakan Uang Masuk dan Daftar Ulang</label>
<br>
                        <label>
                        <input type="radio" name="bt_laporan" value="3"> 
                        Tunggakan Uang Kegiatan</label><br>
                        <label>
                        <input type="radio" name="bt_laporan" value="4"> 
                        Tunggakan Uang Buku</label><br>
                        <label>
                        <input type="radio" name="bt_laporan" value="5">
                        </label>
                        Tunggakan Uang Sanggar <br>
                        <label>
                        <input type="radio" name="bt_laporan" value="6"> 
                        Tunggakan Uang Antarjemput Siswa</label>
                        <br>
                        <label>
                        <input type="radio" name="bt_laporan" value="7"> 
                        Tunggakan Uang Seragam </label>
                        <br>
                        <label>
                        <input type="radio" name="bt_laporan" value="8"> 
                        Tunggakan Uang Alat</label>
                        <br>
                        <label></label>
                      <label></label></td>
                    </tr>
                    <tr>
                      <td height="149">&nbsp;</td>
                    </tr>
                    
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><strong>Unit</strong></td>
                      <td>&nbsp;</td>
                      <td colspan="4"><select name="tx_unit" id="tx_unit">
                        <option value='0'>TK/SD/SMP</option>
                        <?php 
						foreach($data_unit->result() as $value){
							echo "<option value='".$value->id."'>".$value->nama."</option>";
						}
				  ?>
                      </select></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td colspan="2">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><strong>Tanggal </strong></td>
                      <td colspan="2"><div align="center"></div></td>
                      <td width="211"><a href="javascript:NewCssCal('tx_mulai','yyyymmdd')">
                        <input type="Text" name="tx_mulai" id="tx_mulai" maxlength="25" size="20">
                        <img src="<?php echo base_url();?>datepicker/images/cal.gif" width="16" height="16" alt="Pick a date"></a><a href="javascript:NewCssCal('tx_akhir','yyyymmdd')">
                        <input name="tx_mulai2" type="hidden" id="tx_mulai2">
                        </a></td>
                      <td width="113"><div align="center">s.d </div></td>
                      <td width="395"><a href="javascript:NewCssCal('tx_akhir','yyyymmdd')">
                        <input type="Text" name="tx_akhir" id="tx_akhir" maxlength="25" size="20">
                        <img src="<?php echo base_url();?>datepicker/images/cal.gif" width="16" height="16" alt="Pick a date"></a></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td colspan="4"><?
$date = getdate();
$year = $date['year'];
$month = $date['mon'];

if ($month=1|2|3|4|5|6){
$thn_ajaran=($year-1)."-".$year;
//echo $thn_ajaran;
?>
<input name="tx_ajaran" type="hidden" id="tx_ajaran" value="<? echo $thn_ajaran; ?>"></td></tr>
<? }
else if($month=7|8|9|10|11|12){
$thn_ajaran= ($year)."-".($year+1);
//echo $thn_ajaran;
?>
<input name="tx_ajaran" type="hidden" id="tx_ajaran" value="<? echo $thn_ajaran; ?>"></td></tr><?
}
?>
                    <tr>
                      <td>&nbsp;</td>
                      <td><label></label></td>
                      <td>&nbsp;</td>
                      <td colspan="2">
                        
                      <div align="left">
                        <input name="bt_cetak" type="submit" id="bt_cetak" value="Cetak">
                      </div></td>
                      <td><img src="images/loading.gif" id="loading" style="display:none"></td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
				  <label></label>
				</form>