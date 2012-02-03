<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Otogroup extends Alazka_Controller {
	public function __construct() {
		parent::__construct();
		// $this->output->enable_profiler(FALSE);
		$this->load->model('Kelas_model');
		$this->load->model('Siswa_model');
		$this->load->model('Rate_model');
	}

	public function index() {
		$this->load->model('Kelas_model');
		$this->load->model('Siswa_model');
		$this->load->model('Rate_model');
		$this->load->model('ClassGroup_model');

		$this->data['sess'] = null;
		$this->data['action_url'] = site_url('otogroup/simpan');
		$this->data['info_url'] = site_url('otogroup/info');
		$this->data['filter_url'] = site_url('otogroup/index');

		$this->data['ajax_siswa_url'] = site_url('tarif_khusus/get_ajax_siswa/10/');

		try {
			$this->data['list_tarif'] = $this->Rate_model->get_all_rate();
		} catch (Exception $e) {
			$this->data['list_tarif'] = array();
		}

		$this->data['list_kelas'] = array();
		try {
			$this->data['list_kelas'] = $this->Kelas_model->get_all_kelas();
		} catch (Exception $e) { }
		$offset = 20;
		$page = $this->input->post('page');
		$keyword = $this->input->post('keyword');
		if ($keyword == 'cari ...') $keyword = '';

		$total_page = ceil($this->ClassGroup_model->get_both_group_count($keyword) / $offset);
		if (empty($page)) $page = 1;
		else if (($page > $total_page) && ($total_page > 0)) $page = $total_page;

		$this->data['list_data'] = $this->ClassGroup_model->get_both_group($keyword, ($page-1) * $offset, $offset);

		$firstRange = floor($page / 5) * 5;
		if (empty($firstRange)) $firstRange = 1;

		if (($firstRange + 4) < $total_page)  $lastRange = $firstRange + 4;
		else $lastRange = $total_page - 1;

		$this->data['total_page'] = $total_page;
		$this->data['offset'] = $offset;
		$this->data['page'] = $page;
		$this->data['next_page'] = ($page >= $total_page) ? $total_page : ($page + 1);
		$this->data['prev_page'] = ($page == 1) ? 1 : ($page - 1);
		$this->data['first_range'] = $firstRange;
		$this->data['last_range'] = $lastRange;
		$this->data['keyword'] = $keyword;

		$this->load->view('site/header_view');
		$this->load->view('site/kelompok_tagihan_view', $this->data);
		$this->load->view('site/footer_view');
	}

	/**
	 * Method untuk menampilkan link edit sesuai dengan ID dari tagihan. Method
	 * biasanya digunakan pada view.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @param Rate $tarif - Instance dari object Custom_Rate
	 * @return string
	 */
	public function get_edit_link($model) {
		return site_url('tagihan/edit/' . $model->get_id());
	}

	/**
	 * Method untuk menampilkan link edit sesuai dengan ID dari tagihan. Method
	 * biasanya digunakan pada view.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @param Rate $tarif - Instance dari object Custom_Rate
	 * @return string
	 */
	public function get_delete_link($model) {
		$token = md5($model->get_id());
		return site_url('tagihan/delete/' . $model->get_id() . '/' . $token);
	}


	/**
	 * Method untuk menambahkan javascript baru pada HEAD
	 *
	 * @author Rio Astamal <me@rioastamal>
	 *
	 * @return void
	 */
	public function add_more_javascript() {
		$script = '
		<script type="text/javascript" src="%s"></script>
		<script type="text/javascript" src="%s"></script>
		';
		printf($script, base_url() . 'js/json.suggest.js', base_url() . 'js/jquery.chained.min.js');
	}

	public function form($loadId=null) {

		$this->load->helper('mr_form');

		$this->data['sess'] = null;
		$this->data['action_url'] = site_url('tagihan/simpan');
		$this->data['info_url'] = site_url('tagihan/info');

		$this->data['ajax_siswa_url'] = site_url('tarif_khusus/get_ajax_siswa/10/');

		try {
			$this->data['list_tarif'] = $this->Rate_model->get_all_rate();
		} catch (Exception $e) {
			$this->data['list_tarif'] = array();
		}

		if (! empty($loadId)) {
			$this->data['sess'] = $this->Siswa_model->find_by_pk($loadId);
		}

		$this->load->view('site/header_view');
		$this->load->view('site/form_kelompok_tagihan', $this->data);
		$this->load->view('site/footer_view');
	}

	public function import() {
		$this->load->model('Kelas_model');
		$this->load->model('Siswa_model');
		$this->load->model('Rate_model');
		$this->load->model('ClassGroup_model');

		$this->data['sess'] = null;
		$this->data['action_url'] = site_url('otogroup/do_upload');
		$this->data['info_url'] = site_url('otogroup/info');
		$this->data['filter_url'] = site_url('otogroup/index');

		try {
			$this->data['list_tarif'] = $this->Rate_model->get_all_rate();
		} catch (Exception $e) {
			$this->data['list_tarif'] = array();
		}
                $data['action_url'] = site_url('otogroup/do_upload');
                $this->data['eror']= "0";
		$this->load->view('site/header_view');
		$this->load->view('site/impor_kelompok_tagihan_view', $this->data);
		$this->load->view('site/footer_view');
	}
//---by puz	-----------------------------------------------
function do_upload()
	{               
		$this->load->helper(array('form', 'url'));
                $config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'csv|xls|txt';
		$this->load->library('upload', $config);
		if ( $this->upload->do_upload('file_import'))
		{
			$upload=$this->upload->data();
			$ext= $upload["file_ext"];
			if($ext==".csv"){
                                $this->loadCSV();
			}
			else if ($ext==".xls"){
				$this->loadExcel();
			}
                        else if ($ext==".txt"){
				$this->loadCSV();
			}                    
		}
		else
		{
                    $this->data['sess'] = null;
		     //$this->upload->display_errors();
                        try {
			$this->data['list_tarif'] = $this->Rate_model->get_all_rate();
		         } catch (Exception $e) {
			$this->data['list_tarif'] = array();
		         }
                        $this->data['eror']= "1";
                        $this->load->view('site/header_view');
		        $this->load->view('site/impor_kelompok_tagihan_view', $this->data);
		        $this->load->view('site/footer_view');
                      
		}
	}

function loadExcel(){
  $this->data['sess'] = null;
  $this->data['action_url'] = site_url('otogroup/simpan');
  $this->data['info_url'] = site_url('otogroup/info');
  $this->data['filter_url'] = site_url('otogroup/index');
  $this->load->model('Siswa_model');
  $this->load->model('Rate_model');
  $this->load->model('StudentGroup_model');
  $rate=$this->input->post('id_rate');
   try {
              $data_rate=$this->Rate_model->get_single_rate(array('id'=>$rate));
              $sess = new stdClass();
              $sess->name = $data_rate->get_name();
              $this->data['sess'] = $sess;
              $data['ratename']= $data_rate->get_name();
              $data['rate']= $rate;
       }
catch (StudentGroupNotFoundException $e)
       {
       }
 $this->load->helper('excel_reader2');
 $import = new Spreadsheet_Excel_Reader($_FILES['file_import']['tmp_name']);
 $baris = $import->rowcount($sheet_index=0);           
 $kolom = $import->colcount($sheet_index=0);
if ($kolom > 2){
                        try {
			$this->data['list_tarif'] = $this->Rate_model->get_all_rate();
		         } catch (Exception $e) {
			$this->data['list_tarif'] = array();
		         }
                        $this->data['eror']= "1";
                        $this->load->view('site/header_view');
		        $this->load->view('site/impor_kelompok_tagihan_view', $this->data);
		        $this->load->view('site/footer_view');
                        $this->import();
}
else if ($kolom==2){
             $counter=0;
             $error_msg="";
             $counter_index=0;
             $status=true;
try {
 for ($i=1; $i<=$baris; $i++)
{
    $id_siswa=$import->val($i, 'A');
    $nama=$import->val($i, 'B');
    try {
         $where = array('sis_siswa.noinduk' => $id_siswa);
         $query = $this->Siswa_model->get_single_siswa($where);
         $sess = new stdClass();
         $sess->id = $query->get_id();
         $sess->nama_siswa = $query->get_namalengkap();
         $sess->no_induk = $id_siswa;
         $sess->kelas_jenjang = sprintf('%s (%s)', $query->kelas->get_kelas(), $query->kelas->get_jenjang());
         $this->data['sess'] = $sess;
         $data['siswa_id']= $query->get_id();
         $array = array($data['siswa_id']);

         $data['id']= $query->get_id();
         $data_siswa[$counter]['id']=$query->get_id();

         $data['noinduk']= $id_siswa;
         $data_siswa[$counter]['noinduk']=$id_siswa;

         $data['namalengkap']= $query->get_namalengkap();
         $data_siswa[$counter]['namalengkap']=$query->get_namalengkap();

         $data['kelas']= $query->kelas->get_kelas();
         $data_siswa[$counter]['kelas']= $query->kelas->get_kelas();

         $data['jenjang']= $query->kelas->get_jenjang();
         $data_siswa[$counter]['jenjang']=$query->kelas->get_jenjang();         
         try {
	 $query2 = $this->StudentGroup_model->get_single_studentgroup(array('id_rate'=>$rate, 'id_student'=>$query->get_id()));
         $data['status']="SUDAH" ;
         $data_siswa[$counter]['status']="SUDAH";
	     }
         catch (StudentGroupNotFoundException $e)
           {	 $data['status']="OK" ;
                 $data_siswa[$counter]['status']="OK";
           }
        }
    catch (SiswaNotFoundException $e){
          $data['status']="GAGAL" ;
          $data_siswa[$counter]['status']="GAGAL";
          $data_siswa[$counter]['noinduk']=$id_siswa;
          $data_siswa[$counter]['id']=" ";
          $data_siswa[$counter]['namalengkap']=$nama;
          $data_siswa[$counter]['kelas']= "-";
          $data_siswa[$counter]['jenjang']="-";
    }
    	$counter++;
 }
}
catch (Exception $e)
  {   
  }
 $data['data_siswa']=$data_siswa;
 $data['action_url'] = site_url('otogroup/simpan');
 $this->load->view('site/header_view');
 $this->load->view('site/tampil_tagihan_view',$data);
 $this->load->view('site/footer_view');
  try
  {
   $this->data['list_tarif'] = $this->Rate_model->get_all_rate();
  }

  catch (Exception $e)
  {
   $this->data['list_tarif'] = array();
  }
 }
}

function loadCSV()
{
$file=fopen($_FILES['file_import']['tmp_name'], "rw");
$fileData = file_get_contents($_FILES['file_import']['tmp_name']);
$fileData = str_replace(";", ",", $fileData);
$fileData = str_replace("'", "", $fileData);
$fileData = str_replace('"', "", $fileData);
$mypath=".\\uploads\\";

$rand = rand(1, 10000000);
$filename = $mypath.$rand.'_dtkelompok.csv';
$handle = fopen($filename,"w");
$somecontent = "$fileData";
fwrite($handle,$somecontent);

  $this->data['sess'] = null;
  $this->data['action_url'] = site_url('otogroup/simpan');
  $this->data['info_url'] = site_url('otogroup/info');
  $this->data['filter_url'] = site_url('otogroup/index');
  $this->load->model('Siswa_model');
  $this->load->model('Rate_model');
  $this->load->model('StudentGroup_model');

$row = 1;
$counter=0;
$file2=fopen("$filename", "rw");
if (($handle =$file2) !== FALSE) {
$delimiter= ",";
	    while (($data2 = fgetcsv($handle, 1000, $delimiter)) !== FALSE )
	  {
             $num = count($data2)/2;
             $row++;
             $error_msg="";
             $counter_index=0;
             $status=true;
    $rate=$this->input->post('id_rate');
    try {
              $data_rate=$this->Rate_model->get_single_rate(array('id'=>$rate));
              $sess = new stdClass();
              $sess->name = $data_rate->get_name();
              $this->data['sess'] = $sess;
              $data['ratename']= $data_rate->get_name();
              $data['rate']= $rate;
       }
   catch (StudentGroupNotFoundException $e)
       {
       }

 for ($c=0; $c < $num; $c++) {
	$id_siswa=$data2[0];
	$nama=$data2[1];
	try {
         $where = array('sis_siswa.noinduk' => $id_siswa);
         $query = $this->Siswa_model->get_single_siswa($where);
         $sess = new stdClass();
         $sess->id = $query->get_id();
         $sess->nama_siswa = $query->get_namalengkap();
         $sess->no_induk = $id_siswa;
         $sess->kelas_jenjang = sprintf('%s (%s)', $query->kelas->get_kelas(), $query->kelas->get_jenjang());
         $this->data['sess'] = $sess;
         $data['siswa_id']= $query->get_id();
         $array = array($data['siswa_id']);

         $data['id']= $query->get_id();
         $data_siswa[$counter]['id']=$query->get_id();

         $data['noinduk']= $id_siswa;
         $data_siswa[$counter]['noinduk']=$id_siswa;

         $data['namalengkap']= $query->get_namalengkap();
         $data_siswa[$counter]['namalengkap']=$query->get_namalengkap();

         $data['kelas']= $query->kelas->get_kelas();
         $data_siswa[$counter]['kelas']= $query->kelas->get_kelas();

         $data['jenjang']= $query->kelas->get_jenjang();
         $data_siswa[$counter]['jenjang']=$query->kelas->get_jenjang();

         try {
	 $query2 = $this->StudentGroup_model->get_single_studentgroup(array('id_rate'=>$rate, 'id_student'=>$query->get_id()));
         $data['status']="SUDAH" ;
         $data_siswa[$counter]['status']="SUDAH";
	     }
         catch (StudentGroupNotFoundException $e)
           {	 $data['status']="OK" ;
                 $data_siswa[$counter]['status']="OK";
           }
        }
    catch (SiswaNotFoundException $e){
          $data['status']="GAGAL" ;
          $data_siswa[$counter]['status']="GAGAL";
          $data_siswa[$counter]['noinduk']=$id_siswa;
          $data_siswa[$counter]['id']=" ";
          $data_siswa[$counter]['namalengkap']=$nama;
          $data_siswa[$counter]['kelas']= "-";
          $data_siswa[$counter]['jenjang']="-";
    }
   }//for
$counter++;
}//while
	   $data['data_siswa']=$data_siswa;
           $data['action_url'] = site_url('otogroup/simpan');
		$this->load->view('site/header_view');
		$this->load->view('site/tampil_tagihan_view',$data);
		$this->load->view('site/footer_view');
		try
			{
			$this->data['list_tarif'] = $this->Rate_model->get_all_rate();
     		}

		catch (Exception $e)
		   {
			$this->data['list_tarif'] = array();
		   }
	 fclose($handle);
   }
}
//--------------------------------------------------------------------------
	public function simpan() {
		$this->load->model('ClassGroup_model');
		$this->load->model('StudentGroup_model');
		$fields = array('grouping', 'id_rate');
		$kelas = $this->input->post('kelas');
		$peserta = $this->input->post('peserta');
		foreach ($fields as $f) $$f = trim($this->input->post($f));

		$errors = array();
		if (! in_array($grouping, array('siswa', 'kelas'))) array_push($errors, 'Jenis peserta harus kelas atau siswa');
		if (empty($id_rate)) array_push($errors, 'Tarif harap diisi');

		if (($grouping == 'siswa') && (empty($peserta))) array_push($errors, 'Peserta belum ada');
		if (($grouping == 'kelas') && (empty($kelas))) array_push($errors, 'Belum memilih kelas');

		$classInGroup = array();
		if ($grouping == 'kelas') {
			try {
				$rows = $this->ClassGroup_model->get_all_classgroup(array('id_rate'=>$id_rate));

				foreach ($rows as $r) {
					array_push($classInGroup, $r->get_id_class());
				}

			} catch (ClassGroupNotFoundException $e) {
				//it's okay
			}
		}


		header('Content-type: application/json');
		$response = array();
		if (! empty($errors)) {
			$response['success'] = 0;
			$response['message'] = sprintf('<span>%s</span>', implode('<span><br/></span>', $errors));
		} else {
			$ok = array();
			$ok['fail'] = array(); $ok['success'] = array();

			if ($grouping == 'kelas') {

				foreach ($kelas as $r) {
					if (in_array($r, $classInGroup)) array_push($ok['fail'], $r);
					else {
						$kelompok = new ClassGroup;
						$kelompok->set_id_rate($id_rate);

						$kelompok->set_id_class($r);

						if ($this->ClassGroup_model->insert($kelompok)) array_push($ok['success'], $r);
						else array_push($ok['fail'], $r);
					}
				}

			} else {
				//i know, query in a loop, double query
				foreach ($peserta as $r) {

					try {
						$this->StudentGroup_model->get_single_studentgroup(array('id_rate'=>$id_rate, 'id_student'=>$r));
						array_push($ok['fail'], $r);

					} catch (StudentGroupNotFoundException $e) {
						$student = new StudentGroup();

						$student->set_id_rate($id_rate);
						$student->set_id_student($r);

						if ($this->StudentGroup_model->insert($student)) array_push($ok['success'], $r);
						else array_push($ok['fail'], $r);
					}
				}

			}
			$response['success'] = (! empty($ok['success']));
			$response['message'] = empty($ok['success']) ? 'gagal menyimpan kelompok tagihan' : 'Kelompok tagih berhasil disimpan';
			$response['extended'] = $ok;

		}

		echo json_encode($response);
	}
	function delete($grouping, $id, $hash) {
		if ($hash != md5($id)) echo 'salah link';
		else {
			if (($grouping != 'siswa') && ($grouping != 'kelas')) echo 'invalid grouping';
			else {
				$this->load->model('ClassGroup_model');
				$this->load->model('StudentGroup_model');

				$ok = false;
				if ($grouping == 'siswa') {
					$kelompok = new StudentGroup;
					$kelompok->set_id($id);

					$ok = $this->StudentGroup_model->delete($kelompok);
				} else {
					$kelompok = new ClassGroup;
					$kelompok->set_id($id);

					$ok = $this->ClassGroup_model->delete($kelompok);
				}

				echo $ok ? 'data berhasil dihapus' : 'data gagal dihapus';
			}
		}
	}
	function suggest($key = 1) {
		$this->load->model('Rate_model');
		$this->load->model('Kelas_model');
		$this->load->model('Siswa_model');

		$limit = 5;
		$response = array();
		$keyword = $this->input->get("search");

		try {
			$list = $this->Kelas_model->get_all_kelas(array('kelas like'=>"%$keyword%"), 3);
			foreach ($list as $l) {
				$line = new StdClass;
				$line->text = sprintf('kelas %s (tingkat %s %s)', $l->get_kelas(), $l->get_angka(), $l->get_jenjang());
				$line->value = $l->get_kelas();
				array_push($response, $line);
			}
		} catch (KelasNotFoundException $e) {}
		try {
			$list = $this->Rate_model->get_all_rate(array('name like'=>strtolower("%$keyword%")), 3);
			foreach ($list as $l) {
				$line = new StdClass;
				$line->text = sprintf('%s - Rp %s', $l->get_name(), $l->get_fare());
				$line->value = $l->get_name();
				array_push($response, $line);
			}
		} catch (RateNotFoundException $e) {}

		try {
			$list = $this->Siswa_model->get_all_siswa_ajax($keyword, $limit);
			foreach ($list as $l) {
				$line = new StdClass;
				$line->text = sprintf('%s - %s (%s)', $l->get_namalengkap(), $l->kelas->get_kelas(), $l->kelas->get_jenjang());
				$line->value = $l->get_namalengkap();
				array_push($response, $line);
			}
		} catch (SiswaNotFoundException $e) {}

		header('Content-type: application/json');
		echo json_encode($response);
	}
}
