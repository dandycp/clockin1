<?=$this->load->view('reports/header')?>

<h1>Durations</h1>


<?=$this->load->view('reports/grid', array('is_provider'=>true, 'is_pair'=>true))?>

<?=$this->load->view('reports/footer')?>