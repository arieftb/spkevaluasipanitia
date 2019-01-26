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
                $login_role = $this->M_user->get_login_role($login_data[0]['id_member']);
                $login_data[0]['user_role'] = $login_role;

                if(sizeof($login_data) > 0) {
                    $this->session->set_userdata($login_data[0]);                
                    // print_r(json_encode($login_data(0)));

                    echo "<script>alert('Logged In');
                    window.location.href='". base_url('home') ."';</script>";
                } else {
                    echo "<script>alert('Email Or Password Is Not Match');
                    window.location.href='". base_url('login') ."';</script>";
                }
            } else {
                echo "<script>alert('Email Or Password Is Empty');
                    window.location.href='". base_url('login') ."';</script>";
            }
        }

        public function logout()
        {
            $this->session->sess_destroy();
            redirect(base_url('login'));
        }
    }
?>