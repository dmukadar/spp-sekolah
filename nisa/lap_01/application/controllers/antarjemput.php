<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Antarjemput extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }
 
/**/
    function tlain2()
    {
        
		$this->load->library('pdf');
        // set document information
        $this->pdf->SetSubject('Laporan Tunggakan Lain-lain');
        $this->pdf->SetKeywords('TCPDF, PDF');      
        $this->pdf->SetFont('times', '', 12);     
        // add a page
        $this->pdf->AddPage();  
		//set auto page breaks
        $this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);    
      // $this->pdf->Cell(0, 14, 'REKAP TUNGGAKAN LAIN-LAIN', 0, 0, 'C');	

$html1 = '<div style="text-align:center"><font size="+1" face="times"><strong>REKAP TUNGGAKAN DAN LAIN-LAIN</strong> </font></div>
';
$html2 = '
<div style="text-align:center"><font size="+1" face="times"><strong>TAHUN AJARAN {TAHUN.PELAJARAN} </strong> </font></div>';
$html3 = '<font size="+1" face="times">UNIT: ANTAR JEMPUT SISWA </font>';
$html4 = '<font size="+1" face="times">UNIT: TK - SD- SMP </font>';
$html5 = '<div style="text-align:right"><font size="+1" face="times">PER TANGGAL : {FILTER.TGL}</font></div>';
$html = $html1.$html2.$html3.'<br />'.$html4.$html5.'<br />';
$this->pdf->writeHTML($html, true, true, true, true, '');
// output the HTML content

$html = '
<table width="100%" border="1">
  <tr>
    <td width="5%"><div align="center"><strong>NO</strong></div></td>
    <td width="19%"><div align="center"><strong>NAMA</strong></div></td>
    <td width="16%"><div align="center"><strong>KELAS</strong></div></td>
    <td width="17%"><div align="center"><strong>BULAN</strong></div></td>
    <td width="27%"><div align="center"><strong>ANT JEMPUT </strong></div></td>
    <td width="16%"><div align="center"><strong>JUMLAH</strong></div></td>
  </tr>
  <tr>
    <td><div align="center">1</div></td>
    <td><div align="center">tes</div></td>
    <td><div align="center">tes</div></td>
    <td><div align="center">tes</div></td>
    <td><div align="center">tes</div></td>
    <td><div align="center">tes</div></td>
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