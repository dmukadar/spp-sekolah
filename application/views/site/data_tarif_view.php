
				<h1>Daftar Tarif Modul Keuangan </h1>
				<?php ME()->print_flash_message(); ?>	
				
				<form name="frm-filter-cat" id="frm-filter-cat" method="post" action="<?php echo (@$action_url);?>">
				  <label>
				  <strong>Tampilkan Kategori :</strong> 
				  <select name="mn_kategori" id="mn_kategori">
						<option value=''>Semua</option>
						<?php foreach ($list_category as $category) : ?>
						<option <?php echo (mr_selected_if(@$sess->category, $category->get_category()));?> value="<?php echo ($category->get_category());?>"><?php echo ($category->get_category());?></option>
						<?php endforeach; ?>
                  </select>
				  </label>
		      </form>
			
			<br/>
			<table id="tabel" class="gtable">
				<thead>
				<tr>
				  <th><div align="left"><strong>Kategori</strong></div></th>
					<th><div align="left"><strong>Tagihan</strong></div></th>
					<th><div align="right"><strong>Jumlah (Rp)</strong></div></th>
					<th><div align="center"><strong>Pilihan</strong></div></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($list_tarif as $tarif) : ?>	
				<tr>
					<td><?php echo ($tarif->get_category());?></td>
					<td><?php echo ($tarif->get_name());?></td>
					<td style="text-align:right;"><?php echo ($tarif->get_fare(TRUE));?></td>
					<td style="text-align:center;"><a href="#" class="reply">ubah</a></td>
				</tr>
				<?php endforeach; ?>	
				</tbody>
			</table>


			<script>
				document.getElementById('mn_kategori').onchange = function() {
					document.getElementById('frm-filter-cat').submit();
				}
			</script>
