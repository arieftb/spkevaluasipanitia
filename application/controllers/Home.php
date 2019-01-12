<?php
    class Home extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('M_site');
            $this->load->model('M_user');

            if(!$this->M_user->get_login_status()) {
                redirect(base_url('login'));
            }
        }

        public function index()
        {
            $data_site = $this->M_site->get_home_site();
            $data_user = $this->session->userdata();
            $data = array_merge($data_site, $data_user);
            
            $this->load->view('__template/header',$data);
            $this->load->view('__template/topbar');
            $this->load->view('__template/leftbar');
            $this->load->view('home/index');
            $this->load->view('__template/footer');
        }
    }
    
?>