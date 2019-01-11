<?php
    class User extends CI_Controller
    {
        function __construct()
        {
            parent::__construct();
            $this->load->model('M_user');
        }

        public function index()
        {
            redirect(base_url('login'));
        }

        public function login()
        {
            if ($this->input->post('submit')) {
                $data = array(
                    'email' => $this->input->post('email'),
                    'password' => md5($this->input->post('password'))
                );

                $login_data = $this->M_user->get_login_data($data);
                $login_data_result = $login_data->result();

                if($login_data->num_rows() > 0) {
                    echo "<script>alert('Logged In');
                    window.location.href='". base_url('home') ."';</script>";
                    // redirect(base_url('home'));
                } else {
                    echo "<script>alert('Email Or Password Is Not Match');
                    window.location.href='". base_url('login') ."';</script>";
                }
            } else {
                echo "<script>alert('Email Or Password Is Empty');
                    window.location.href='". base_url('login') ."';</script>";
            }
        }
    }
?>