<?php
class Penilaian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_site');
        $this->load->model('M_user');
        $this->load->model('M_kegiatan');
        $this->load->model('M_periode');
        $this->load->model('M_panitia');
        $this->load->model('M_member');
        $this->load->model('M_pengurus');
        $this->load->model('M_sie');

        if (!$this->M_user->get_login_status()) {
            redirect(base_url('login'));
        }
    }

    public function index()
    {
        $data_site = $this->M_site->get_penilaian_site();
        $data_user = $this->session->userdata();

        $data = array();
        $data = array_merge($data_site, $data_user, $data);

        $this->load->view('__template/header', $data);
        $this->load->view('__template/topbar');
        $this->load->view('__template/leftbar');
        $this->load->view('penilaian/index');
        $this->load->view('__template/footer');
    }
}
