<?php
    class Home extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('M_site');
        }

        public function index()
        {
            $data_site = $this->M_site->get_home_site();
            $this->load->view('__template/header', $data_site);
            $this->load->view('__template/topbar');
            $this->load->view('__template/leftbar');
            $this->load->view('home/index');
            $this->load->view('__template/footer');
        }
    }
    
?>