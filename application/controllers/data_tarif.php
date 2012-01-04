<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_tarif extends Alazka_Controller {
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Method untuk menampilkan daftar tarif. Ini adalah hasil modifikasi agar
	 * sesuai dengan konvensi, mulai model dan viewnya.
	 *
	 * @author Rio Astamal <me@rioastamal>
	 *
	 * @param int $id - ID dari tarif yang akan diedit
	 * @return void
	 */
	public function index() {
		$this->load->model('Rate_model');
		
		// helper untuk melakukan repopulate checkbox, radio atau select
		$this->load->helper('mr_form');
		
		// Page title untuk HTML
		$this->data['page_title'] = 'Daftar Tarif';
		
		try {
			// selalu gunakan try akan setiap model akan melempar exception
			// jika record tidak ditemukan
			$this->data['list_category'] = $this->Rate_model->get_all_category();
		} catch (Exception $e) {
			$this->data['list_category'] = array();
		}
		
		// digunakan pada form action
		// membiarkan form action kosong bukanlah ide yang baik, dan itu
		// tergantung masing-masing browser implementasinya
		$this->data['action_url'] = site_url('data_tarif/index');
		
		// untuk repopulate combo box filter
		$sess = new stdClass();
		$sess->category = $this->input->post('mn_kategori');
		$this->data['sess'] = $sess;
		
		try {
			// cek apakah ini adalah proses filter (form post)
			if ($sess->category != FALSE) {
				$this->db->like('ar_rate.category', $sess->category);
			}
			$this->data['list_tarif'] = $this->Rate_model->get_all_rate();
		} catch (Exception $e) {
			$this->data['list_tarif'] = array();
		}
		
		$this->load->view('site/header_view');
		$this->load->view('site/data_tarif_view', $this->data);
		$this->load->view('site/footer_view');
	}
	
	/**
	 * Method untuk menampilkan form edit tarif. 
	 *
	 * @author Rio Astamal <me@rioastamal>
	 *
	 * @param int $id - ID dari tarif yang akan diedit
	 * @return void
	 */
	public function edit($id=0) {
		$id = (int)$id;
		$this->load->model('Rate_model');
		
		try {
			// apakah tarif dengan ID yang dicari ada atau tidak
			// jika tidak ada maka otomatis dilempar ke Exception
			$where = array('ar_rate.id' => $id);
			$tarif = $this->Rate_model->get_single_rate($where);
			
			// jika bukan proses submit tampilkan data default dari database
			if ($this->input->post('updatebtn') == FALSE) {
				$sess = new stdClass();
				$sess->category = $tarif->get_category();
				$sess->nama = $tarif->get_name();
				$sess->jumlah = round($tarif->get_fare());
				// escape semua HTML agar tampilan tidak berantakan
				$sess->keterangan = htmlentities($tarif->get_description());
				$sess->id = $id;
				
				$this->data['sess'] = $sess;
			} else {
				$this->proses_edit($tarif);
				
				// jika tidak ada kesalahan maka tidak akan dilempar ke Exception
				// jadi dapat disimpulkan penyimpanan berhasil
				// kembali ke index
				$this->index();
				
				// berhenti sampai disini agar view edit dibawah tidak diload.
				return FALSE;
			}
		
		} catch (RateNotFoundException $e) {
			// oops, something bad... kenapa kok datanya tidak ada?
			$mesg = sprintf('Mohon maaf data tarif yang akan diubah tidak ditemukan ID: %d', $id);
			$this->set_flash_message($mesg, 'error msg');
			
			// kembalikan ke index karena tidak ada gunanya kita menampilkan
			// form edit untuk tarif yang tidak ada.
			$this->index();
			
			// berhenti sampai disini agar code dibawah exception tidak
			// ikut dieksekusi
			return FALSE;
			
		} catch (Exception $e) {
			// oops ada error lain, form validasi?
			$this->set_flash_message($e->getMessage(), 'error msg');
		}
		
		// view edit
		$this->load->view('site/header_view');
		$this->load->view('site/data_tarif_update_view', $this->data);
		$this->load->view('site/footer_view');
	}
	
	/**
	 * Method untuk melakukan proses update tarif. 
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 * @todo: - Gunakan bahasa indonesia pada error form_validation
	 *
	 * @param Rate $tarif - instance dari object Rate
	 * @return void
	 * @thrown Exception
	 */
	private function proses_edit($tarif) {
		// lakukan form validasi
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('tarif_id', 'Tarif ID', 'required|numeric');
		$this->form_validation->set_rules('nama', 'Tagihan', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
		
		$id = (int)$this->input->post('tarif_id');
		
		$sess = new stdClass();
		$sess->category = $tarif->get_category();
		$sess->nama = $this->input->post('nama');
		$sess->jumlah = $this->input->post('jumlah');
		$sess->keterangan = $this->input->post('keterangan');
		$sess->id = $id;
		$this->data['sess'] = $sess;
		
		// jalankan pengecekan
		if ($this->form_validation->run() == FALSE) {
			// ada salah satu field yang tidak sesuai aturan
			// dapatkan error dengan fungsi validation_errors
			throw new Exception(validation_errors('<span>', '</span><br/>'));
		}
		
		// jika sampai disini maka semua field sesuai aturan
		// jadi aman untuk dilakukan insert
		
		// ubah object $tarif agar sesuai dengan perubahan terbaru yang dikirim
		// oleh user
		$tarif->set_name($sess->nama);
		$tarif->set_fare($sess->jumlah);
		$tarif->set_description($sess->keterangan);
		
		// OK, let's save it baby...
		$this->Rate_model->update($tarif);
		
		$this->set_flash_message('Data tarif berhasil diubah.', 'information msg');
	}
	
	/**
	 * Method untuk menampilkan link edit sesuai dengan ID dari tarif. Method
	 * biasanya digunakan pada view.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @param Rate $tarif - Instance dari object Rate
	 * @return string
	 */
	public function get_edit_link($tarif) {
		return site_url('data_tarif/edit/' . $tarif->get_id());
	}
	
	function update_data($id=0){
	$this->load->model('M_data_tarif');
		$data['data_mas01']=$this->M_data_tarif->get_all(array('id'=>$id));
		 $data['page']='v_up_data_tarif';
		$this->load->view('site/data_tarif_update_view',$data);		
	}
	
	 
	public function act_update_data($id=0){
	$this->load->model('M_data_tarif');
		$data=array(			
			'category'=>$this->input->post('tx_kategori'), 
			'name'=>$this->input->post('tx_tagihan'), 
			'fare'=>$this->input->post('tx_jumlah'), 
			'description'=>$this->input->post('tx_ket'), 		
		);
		$status=$this->M_data_tarif->update($id,$data);
		redirect("Data_tarif");
	}
	
 
	
	public function ajax_get_unit(){
	$this->load->model('M_data_tarif');
		$get_data=$this->input->get("text");
		$data_mas01=$this->M_data_tarif->get_unit($get_data);
		$data=array();
		$index=0;
		foreach($data_mas01->result() as $row){
			
			echo $row->nama_unit."|".$row->id_unit."\n";
		}
		
	}
	
	public function ajax_get_data()
	{
		$this->load->model('M_data_tarif');
		$aColumns = array('category');
		$start_limit=0;
		$end_limit=0;
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
        {
        	$start_limit=$_GET['iDisplayStart'];
			$end_limit=$_GET['iDisplayLength'];
		}
		
		$array_filter=array();
		
		$array_search=array();
		if ( $_GET['sSearch'] != "" )
        {
			for($i = 0; $i < count($aColumns); $i++) {
				$array_search[$aColumns[$i]]=mysql_real_escape_string($_GET['sSearch']);
			}
		}
		
		$sOrder = "";
		
		$data=$this->M_data_tarif->get_many($array_filter,$array_search,$sOrder,$start_limit,$end_limit);	
		
		$total=0;
		$output = array(
				"sEcho" => intval($_GET['sEcho']),
				"iTotalRecords" => $total,
				"iTotalDisplayRecords" => $total,
				"aaData" => array()
        );
		
		foreach($data as $value){
			
			$edit_url='<a href='.site_url('data_tarif/update_data').'/'.$value->id.' class=button>Edit</a>';  
			          
			$rows[] = array(
								$value->category
								,$value->name
								,$value->fare
								,$edit_url
			);
            $output['aaData'] = $rows; 
			$total++;                   
        }
		$output['iTotalRecords'] = $total; 
		$output['iTotalDisplayRecords'] = $total; 
		echo json_encode($output);
	}
}

