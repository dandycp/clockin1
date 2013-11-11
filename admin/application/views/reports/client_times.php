<?=$this->load->view('reports/header')?>

<h1>Times</h1>

<?=$this->load->view('reports/grid', array('is_provider'=>true, 'is_pair'=>false))?>

<?=$this->load->view('reports/footer')?>