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
		try {
			$this->data['list_tarif'] = $this->Rate_model->get_all_rate();
		} catch (Exception $e) {
			$this->data['list_tarif'] = array();
		}

		$this->load->view('site/header_view');
		$this->load->view('site/impor_kelompok_tagihan_view', $this->data);
		$this->load->view('site/footer_view');
	}

//---by puz	-----------------------------------------------
    function loadExcel()
	{	
		
			 $rate=$this->input->post('id_rate');	
			 $data['rate']=$rate;
		     $this->load->helper('excel_reader2');
		
			 $import = new Spreadsheet_Excel_Reader($_FILES['file_import']['tmp_name']);
             $baris = $import->rowcount($sheet_index=0);
             $counter=0;
             $error_msg="";
             $counter_index=0;
             $status=true;
			 
			for ($i=1; $i<=$baris; $i++)
		    {
				$id_siswa=$import->val($i, 'A');
				$nama=$import->val($i, 'B');
				$this->load->model('Keltagih_model');		
				$check_siswa=$this->Keltagih_model->check_siswa($id_siswa);		
				$check_group=$this->Keltagih_model->check_group($id_siswa);	
				
			if ($check_siswa > 0&& $check_group > 0)
			{
			  $data['status']="SUDAH";
			  $data['induk']=$id_siswa;
			  $data['nama']=$nama;
			  $data_siswa[$counter]['status']="SUDAH";
			  $data_siswa[$counter]['induk']=$id_siswa;
			  $data_siswa[$counter]['nama']=$nama;
			  
			   $data['kelas']="";		
			  $data_siswa[$counter]['kelas']=" ";
			  
			  $data['jenjang']="";		
			  $data_siswa[$counter]['jenjang']=" ";	
			  
			}
			else if($check_siswa > 0&& $check_group==0)
			{
			  $data['status']="OK";
			  $data['induk']=$id_siswa;
			  $data['nama']=$nama;
			  $data_siswa[$counter]['status']="OK";
			  $data_siswa[$counter]['induk']=$id_siswa;
			  $data_siswa[$counter]['nama']=$nama;	  	
			  $data['kelas']=" ";	
			  $data_siswa[$counter]['kelas']=" ";	
			  
			  $data['jenjang']="";		
			  $data_siswa[$counter]['jenjang']=" "; 
			}
			
			else if ($check_siswa==0 && $check_group==0)		
			{
			  $data['status']="GAGAL";
			  $data['induk']="  ";
			  $data['nama']=$nama;
			  $data_siswa[$counter]['status']="GAGAL";
			  $data_siswa[$counter]['induk']="  ";
			  $data_siswa[$counter]['nama']=$nama;
			  
			  $data['kelas']="";		
			  $data_siswa[$counter]['kelas']=" ";
			  
			  $data['jenjang']="";		
			  $data_siswa[$counter]['jenjang']=" ";	
			}
		$counter++;

		}
		
		$data['data_siswa']=$data_siswa;
		
		$this->load->view('site/header_view');		
		$this->load->view('site/tampil_tagihan_view',$data);
		$this->load->view('site/footer_view');
		try 
			{
			$this->data['list_tarif'] = $this->Rate_model->get_all_rate();		
     		} 
		
		catch (Exception $e) {
			$this->data['list_tarif'] = array();
		}

		
	}

	public function insert_data_from_excel(){
		
		$counter=$this->input->post('tx_counter');
		$this->load->model("Keltagih_model");
		for($i=1;$i<=$counter;$i++){
			$status=$this->input->post('tx_status_'.$i);
			if($status=="OK"){
				$data=array(
				'id_rate' =>$this->input->post('tx_rate'), 
				'id_student'=>$this->input->post('tx_induk_'.$i)
				);
				$status=$this->Keltagih_model->insert($data);
			}
		}
		
			try {
			$this->data['list_tarif'] = $this->Rate_model->get_all_rate();
			
		} catch (Exception $e) {
			$this->data['list_tarif'] = array();
		}
		$this->load->view('site/header_view');
		$this->load->view('site/impor_kelompok_tagihan_view', $this->data);
		$this->load->view('site/footer_view');
	}

public function insert_data(){
		
		$data=array(
			'id_rate' =>$this->input->post('rate'), 
			'id_student'=>$this->input->post('tx_induk')
		);
		$status=$this->Keltagih_model->insert($data);
		$this->load->view('site/header_view');
		$this->load->view('site/form_kelompok_tagihan', $this->data);
		$this->load->view('site/footer_view');
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
}
