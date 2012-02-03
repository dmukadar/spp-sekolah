<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Alazka_Controller {
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Method untuk menampilkan data yang digunakan pada autocomplete siswa.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @return string - JSON
	 */
	public function get_siswa($limit=10) {
		$limit = (int)$limit;
		$this->load->model('Kelas_model');
		$this->load->model('Siswa_model');
		
		// ?search=namasiswa yang dipanggil oleh AJAX
		$nama = $this->input->get('search');
		try {
			$daftar_siswa = $this->Siswa_model->get_all_siswa_ajax($nama, $limit);
			$json = array();
			foreach ($daftar_siswa as $siswa) {
				$sis = new stdClass();
				$sis->id = $siswa->get_id();
				$sis->text = sprintf('%s &raquo; %s (%s)', $siswa->get_namalengkap(), $siswa->kelas->get_kelas(), $siswa->kelas->get_jenjang());
				$sis->nama = $siswa->get_namalengkap();
				$sis->noinduk = $siswa->get_noinduk();
				$sis->kelas = $siswa->kelas->get_kelas();
				$sis->jenjang = $siswa->kelas->get_jenjang();
				$json[] = $sis;
			}
			$json = json_encode($json);
			print($json);
		} catch (SiswaNotFoundException $e) {
		}
	}
}
