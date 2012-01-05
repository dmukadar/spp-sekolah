
				<h1 align="center">Daftar Tarif Khusus </h1>

				
				<form name="form1" method="post" action="">
				  <label>				  </label>
				  <table width="376" border="0">
                    <tr>
                      <td width="16">&nbsp;</td>
                      <td width="99"><label><strong>Nama Siswa </strong></label></td>
                      <td height="28"><input name="tx_nama" type="text" id="tx_nama" size="30">
                          <strong>
                          <input name="tx_id_siswa" type="hidden" id="tx_id_siswa" >
                        </strong></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Kelas</td>
                      <td height="28"><input name="tx_kelas" type="text" id="tx_kelas" style="background-color:#CCCCCC" readonly="true" ></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Nomor Induk </td>
                      <td height="28"><input name="tx_induk" type="text" id="tx_induk" style="background-color:#CCCCCC" readonly="true"></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><label>
                        <input type="submit" name="Submit" value="Tampilkan">
                      </label></td>
                      <td><input type="submit" name="Submit2" value="Tambah" onClick=" <?php echo site_url("m_vtarif_khusus/index");?>"></td>
                    </tr>
                  </table>
				  <label></label>
				</form>
				<?php if($view=='data'){ 
					?>
							
					<table width="100%">
					
						<tr>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
					  </tr>
						<tr>
						  <td width="38%" bgcolor="#EAEAEA"><div align="center"><strong>Kategori</strong></div></td>
							<td width="1%" bgcolor="#EAEAEA">&nbsp;</td>
						  <td width="38%" bgcolor="#EAEAEA"><div align="center"><strong>Tagihan</strong></div></td>
							<td width="1%" bgcolor="#EAEAEA">&nbsp;</td>
						  <td width="11%" bgcolor="#EAEAEA"><div align="center"><strong>Jumlah</strong></div></td>
						  <td width="11%" bgcolor="#EAEAEA"><div align="center"><strong>Pilihan</strong></div></td>
						</tr>
					
<?php 
		foreach($data_mas03->result() as $row){
		?>						<tr>
							<td><div align="justify"><?php echo $row->name;?></div></td>
							<td>&nbsp;</td>
							<td><div align="justify"><?php echo $row->description;?></div></td>
							<td>&nbsp;</td>
							<td><div align="justify"><?php echo $row->fare;?></div></td>
							<td><div align="center"><a href="<?php echo site_url("m_vtarif_khusus/update_data/")."/".$row->id;?>">Ubah</a> <a href="<?php echo site_url(" ")."/".$row->id;?>">Hapus</a> </div></td>
						</tr>
						   <?php }?>
			  </table>
				
				<?php }?>
				<?
				if($view!='data'){echo "Tagihan Kosong";}
				?>
								
				    <div class="clear">
				      <section></section>
			</div>
				
		  </article>
		</section>
		<aside id="sidebar" class="grid_3 pull_9"></aside>
	</section>
</section>

<script type="text/javascript">
  function findValue(li) {
  	if( li == null ) return alert("No match!");

  	// ----
  	if( !!li.extra ) var sValue = li.extra[0];
  	else var sValue = li.selectValue;
	jQuery('#tx_id_siswa').val(sValue);
  	//----
	if( !!li.extra ) var sValue1 = li.extra[1];
  	else var sValue1 = li.selectValue;
	jQuery('#tx_kelas').val(sValue1);
	//----
	if( !!li.extra ) var sValue2 = li.extra[2];
  	else var sValue2 = li.selectValue;
	jQuery('#tx_induk').val(sValue2);
  }

  function selectItem(li) {
    	findValue(li);
    	
  }

  function formatItem(row) {
	  
    	return row[0];
  }

  function lookupAjax(){
  	var oSuggest = jQuery("#tx_nama")[0].autocompleter;
    oSuggest.findValue();
  	return false;
  }

  function lookupLocal(){
    	var oSuggest = jQuery("#tx_nama")[0].autocompleter;

    	oSuggest.findValue();

    	return false;
  }
  
  
    jQuery("#tx_nama").autocomplete(
      "<?php echo site_url("tarif_khusus/ajax_get_siswa/");?>",
      {
  			delay:5,
  			minChars:2,
  			matchSubset:1,
  			matchContains:1,
  			cacheLength:10,
  			onItemSelect:selectItem,
  			onFindValue:findValue,
  			formatItem:formatItem,
  			autoFill:true
  		}
    );
  
</script>
