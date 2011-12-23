<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Antarjemput extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }
 

    function tlain2()
    {
        
		$this->load->library('pdf');
        // set document information
        $this->pdf->SetSubject('Laporan Tunggakan Lain-lain');
        $this->pdf->SetKeywords('TCPDF, PDF');      
        $this->pdf->SetFont('times', '', 12);   
		$this->pdf->setHeaderFont(Array('times', '', '14'));
		$this->pdf->setFooterFont(Array('times', '', '12'));
		
       
		//set auto page breaks
        $this->pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);    
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		// add a page
        $this->pdf->AddPage();  
  
$html = '<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center"><font size="+1" face="times">REKAP TUNGGAKAN DAN LAIN-LAIN </font></div></td>
  </tr>
  <tr>
    <td><div align="center"><font size="+2"><strong>TAHUN AJARAN {TAHUN.PELAJARAN} </strong></font></div></td>
  </tr>
</table>
';
$this->pdf->writeHTML($html, true, true, true, true, '');
//---midle
$html = '<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="62%">UNIT: ANTAR JEMPUT SISWA</td>
    <td width="38%">&nbsp;</td>
  </tr>
  <tr>
    <td>UNIT: TK - SD- SMP</td>
    <td>PER TANGGAL : {FILTER.TGL}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
';
$this->pdf->writeHTML($html, true, true, true, true, '');		

// output the HTML content
$judul = array(
            'id' => ' ',
            'nama' => ' ',
            'kelas' => '  ',
            'bulan' => ' ',	
			'ant_jemput' => ' ',
            'jumlah' => ' '
        ); 
$html = '
            <table width="100%" border="1">
              <tr>
                <td width="5%" height="30"><div align="center"><strong>NO</strong></div></td>
                <td width="19%"><div align="center"><strong>NAMA</strong></div></td>
                <td width="16%"><div align="center"><strong>KELAS</strong></div></td>
                <td width="17%"><div align="center"><strong>BULAN</strong></div></td>
                <td width="27%"><div align="center"><strong>ANT JEMPUT </strong></div></td>
                <td width="16%"><div align="center"><strong>JUMLAH</strong></div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td height="28"><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td><div align="center">'.$judul["nama"].'</div></td>
                <td><div align="center">'.$judul["kelas"].'</div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
              <tr>
                <td height="28"><div align="center"> '.$judul["id"].'</div></td>
                <td colspan="2"><div align="center">TOTAL JUMLAH </div>                  <div align="center"></div></td>
                <td><div align="center">'.$judul["bulan"].'</div></td>
                <td><div align="center">'.$judul["ant_jemput"].'</div></td>
                <td><div align="center">'.$judul["jumlah"].'</div></td>
              </tr>
            </table>
';
$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekap_tunggakan.pdf", 'I');       
    }
	
	
}  


 
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */