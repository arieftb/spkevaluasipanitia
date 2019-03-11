<?php
class User extends CI_Controller
{
    public function __construct()
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
                'password' => md5($this->input->post('password')),
            );

            $login_data = $this->M_user->get_login_data($data);

            if (sizeof($login_data) > 0) {
                $login_role = $this->M_user->get_login_role($login_data[0]['id_member']);
                $login_data[0]['user_role'] = $login_role;
                $this->session->set_userdata($login_data[0]);

                echo "<script>alert('Logged In');
                    window.location.href='" . base_url('kegiatan') . "';</script>";
            } else {
                echo "<script>alert('Email Or Password Is Not Match');
                    window.location.href='" . base_url('login') . "';</script>";
            }
        } else {
            echo "<script>alert('Email Or Password Is Empty');
                    window.location.href='" . base_url('login') . "';</script>";

            // print_r($login_data);
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }
}
