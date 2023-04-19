<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Pdf');
        $this->load->model('M_admin');
    }

    public function pemakai()
    {

        $data = $this->M_admin->pakai_periode('tb_pemakai');


        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // document informasi
        $pdf->SetCreator('Web Aplikasi Gudang');
        $pdf->SetTitle('Laporan Data Operator');
        $pdf->SetSubject('Operator');

        $PDF_HEADER_STRING = "Jl. Jahri Saleh Komp. Pandan Arum No. 96 Rt. 15 Banjarmasin Utara 70122 Banjarmasin \nTelp. (0511) 4315143";

        $pdf->SetHeaderData('logo_wardah.jpg', 15, 'WARDAH SOLUTION', $PDF_HEADER_STRING, array(0, 0, 0), array(0, 0, 0));

        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, 'I', 9));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margin
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP - 5, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER, 5);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM - 5);
        $pdf->SetDisplayMode('fullpage', 'Fit');

        //SET Scaling ImagickPixel
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        //FONT Subsetting
        $pdf->setFontSubsetting(true);

        $pdf->SetFont('helvetica', '', 10, '', true);

        $pdf->AddPage('p');

        $tanggal = date('d-M-Y');

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $html =
            '<div>
              <h1 align="center">Laporan Data Operator</h1>
              
              <table border="1" >
                <tr>
                  <th style="width:25px" align="center">No.</th>
                  <th style="width:150px" align="center">Nama</th>
                  <th style="width:150px" align="center">Alamat</th>
                  <th style="width:150px" align="center">No. Hp</th>
                  <th style="width:150px" align="center">Tanggal Update</th>
    
                </tr>';

        $no = 1;

        foreach ($data as $d) :
            $html .= '<tr>';
            $html .= '<td align="center">' . $no . '</td>';
            $html .= '<td align="center">' . $d->nama . '</td>';
            $html .= '<td align="center">' . $d->alamat . '</td>';
            $html .= '<td align="center">' . $d->no_hp . '</td>';
            $html .= '<td align="center">' . $d->tgl_update . '</td>';
            $html .= '</tr>';
            $no++;
        endforeach;


        $html .= '
                </table><br>
                <p align="right">Mengetahui,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
          <p align="right">Banjarmasin,&nbsp;' . $tanggal . '&nbsp;&nbsp;&nbsp;</p><br><br><br>
          <p align="right">Pimpinan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
              </div>';

        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);

        $pdf->Output('laporan_operator.pdf', 'I');
    }
}
