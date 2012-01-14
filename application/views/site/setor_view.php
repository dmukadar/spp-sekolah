				<h1 align="center">Cetak Rekap Setoran </h1>
			
				<form name="form1" method="post" action="<?php echo site_url("tsetor/pilih_report_tunggakan/");?>">
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
                        <input type="radio" name="bt_laporan" value="1"> 
                        Setoran SPP dan BPPS
</label>
                        <br>
                        <label>
                        <input type="radio" name="bt_laporan" value="2"></label>
                        <label>Setoran Uang Masuk dan Daftar Ulang</label>
<br>
                        <label>
                        <input type="radio" name="bt_laporan" value="3"> 
                        Setoran Uang Kegiatan</label>
                        <br>
                        <label>
                        <input type="radio" name="bt_laporan" value="4"> 
                        Setoran Uang Buku</label>
                        <br>
                        <label>
                        <input type="radio" name="bt_laporan" value="5">
                        </label>
                        Setoran Uang Sanggar <br>
                        <label>
                        <input type="radio" name="bt_laporan" value="6"> 
                        Setoran Uang Antarjemput Siswa</label>
                        <br>
                        <label>
                        <input type="radio" name="bt_laporan" value="7"> 
                        Setoran Uang Seragam </label>
                        <br>
                        <label>
                        <input type="radio" name="bt_laporan" value="8"> 
                        Setoran Uang Alat</label>
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
                        </a><a href="javascript:NewCssCal('ttl','ddmmmyyyy')"></a></td>
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
date_default_timezone_set('UTC');
$bulan= date('F');	
$send_bulan= strtoupper ($bulan) ;
?>
<input name="tx_bulan" type="hidden" id="tx_bulan" value="<? echo $send_bulan; ?>"></td></tr>
<?
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
                        <input type="submit" name="Submit" value="Cetak">
                      </div></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
				  <label></label>
				</form>
			