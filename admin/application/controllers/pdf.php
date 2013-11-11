<?php 

class Pdf extends MY_Controller {
	
	
	
	private function _gen_pdf($html,$paper='A4')
    {
        $this->load->library('mpdf/mpdf'); // Load mPDF library
        
        $company = $this->account->company_name; // Grabs company name
        $acc = $this->account->account_number; // Grabs account number
        $gen = $company.' Report - Account '.$acc; // Stores company name and account number
        
                       
        $mpdf=new mPDF('utf-8', 'A4');
        $mpdf->setFooter('These times have been verified by Clockin Point | www.clockinpoint.com | {PAGENO}');
        $mpdf->SetWatermarkImage('images/summary-sheet-bg.png');
		$mpdf->showWatermarkImage = true;
		$mpdf->watermarkImageAlpha = 0.2;
        $mpdf->WriteHTML($html);
        
        $mpdf->Output($gen.'.pdf','D');
    } 
	public function report($pdf = false)
	{
		ini_set('memory_limit', '-1');
		
		$html = $_REQUEST['html'];
		//error_reporting(E_ALL);
		
		$this->load->helper('date');
		
		$root = dirname(__FILE__).'/../../';
		$html = $this->load->view('pdf/report', compact('html','root'), true);
		//$filename = 'Report';
		//die($html);
		
		//$this->dompdf_lib->create($html, $filename,'portrait', TRUE);
		//var_dump($_REQUEST['html']);
		$this->_gen_pdf($html); 

	}
	// generate a summary sheet for a batch of code entries
	public function summary($batch_ref, $pdf = false)
	{
		ini_set('memory_limit', '-1');
		$this->load->model('model_batch', 'batch');
		$this->load->helper('string');
		$this->batch->init($batch_ref);
		$codes = $this->batch->get_codes();
		
		if (!$codes) die('No codes found for this batch reference');
		
		$codes = array_values($codes);
		$code1 = $codes[0];
		if ($code1->account_id != $this->account->id) $Auth->access_restricted();
		
		$total_seconds = $this->batch->total_duration();
		$total_duration = ($total_seconds ? timespan(0, $total_seconds) : '');
		$rand_number = random_string('alnum', 5);
		
		$html = $_REQUEST['html'];
		$root = dirname(__FILE__).'/../../';
		$html = $this->load->view('pdf/summary', compact('codes','batch_ref','root','total_duration','rand_number'), true);
		//$filename = 'Batch Summary: ' . $batch_ref;
		
		//$this->dompdf_lib->create($html, $filename);
		$this->_gen_pdf($html, $filename); 
	}
		
}