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

	public function simpan() {
		$this->load->model('ClassGroup_model');
		$this->load->model('StudentGroup_model');

		$fields = array('grouping', 'id_rate', 'kelas');

		$peserta = $this->input->post('peserta');
		foreach ($fields as $f) $$f = trim($this->input->post($f));

		$errors = array();
		if (! in_array($grouping, array('siswa', 'kelas'))) array_push($errors, 'Jenis peserta harus kelas atau siswa');
		if (empty($id_rate)) array_push($errors, 'Tarif harap diisi');

		if (($grouping == 'siswa') && (empty($peserta))) array_push($errors, 'Peserta belum ada');

		$grades = array();
		if ($grouping == 'kelas') {
			$kelas = (int) $kelas;

			try {
				$rows = $this->ClassGroup_model->get_all_classgroup(array('id_rate'=>$id_rate));

				foreach ($rows as $r) array_push($grades, $r->get_grade());

				if (in_array($kelas, $grades)) array_push($errors, 'Kelompok tagihan sudah ada');
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
			if ($grouping == 'kelas') {
				$kelompok = new ClassGroup;

				$kelompok->set_id_rate($id_rate);
				if (in_array($kelas, range(0,9))) {
					$kelompok->set_grade($kelas);

					$ok = $this->ClassGroup_model->insert($kelompok);
				} else if ($kelas == 99) {
					foreach (range(0,9) as $i) {
						if (in_array($i, $grades)) continue;

						$kelompok->set_grade($i);

						if ($this->ClassGroup_model->insert($kelompok)) $ok++;
					}
				}
			} else {
				//i know, query in a loop, double query
				$ok = array();
				foreach ($peserta as $r) {

					try {
						$this->StudentGroup_model->get_single_studentgroup(array('id_rate'=>$id_rate, 'id_student'=>$r));

					} catch (StudentGroupNotFoundException $e) {
						$student = new StudentGroup();

						$student->set_id_rate($id_rate);
						$student->set_id_student($r);

						if ($this->StudentGroup_model->insert($student)) array_push($ok, $r);
					}
				}

			}
			$response['success'] = (! empty($ok));
			$response['message'] = empty($ok) ? 'gagal menyimpan kelompok tagihan' : 'Kelompok tagih berhasil disimpan';
			$response['extended'] = $ok;

		}

		echo json_encode($response);
	}
}
