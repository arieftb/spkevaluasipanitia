<?php
class Kriteria extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_site');
        $this->load->model('M_user');
        $this->load->model('M_periode');
        $this->load->model('M_kriteria');

        if (!$this->M_user->get_login_status()) {
            redirect(base_url('login'));
        }
    }

    public function index()
    {
        $data_site = $this->M_site->get_kriteria_site();
        $data_user = $this->session->userdata();

        $data_periode = $this->M_periode->get_periode_by_id_member($data_user['id_member']);

        $data = array(
            'id_periode' => null,
            'id_role' => null,
            'data_kriteria' => null,
            'data_periode' => $data_periode,
            'edit_kriteria' => null,
        );

        $data = array_merge($data_site, $data_user, $data);

        $this->load->view('__template/header', $data);
        $this->load->view('__template/topbar');
        $this->load->view('__template/leftbar');
        $this->load->view('kriteria/index');
        $this->load->view('__template/footer');
    }

    public function periode()
    {
        $data_site = $this->M_site->get_kriteria_site();
        $data_user = $this->session->userdata();

        $id_periode = trim($this->input->post('id_periode'));

        if ($id_periode != '') {
            $data = array(
                'data_kriteria' => $this->M_kriteria->get_kriteria(),
                'data_periode' => $this->M_periode->get_periode_by_id_member($data_user['id_member']),
                'data_kriteria_detail' => $this->M_kriteria->get_kriteria_detail($id_periode),
                'id_periode' => $id_periode,
                'id_role' => $this->M_user->get_user_role_by_id_periode($id_periode)[0]['id_role'] == 1 ? $this->M_user->get_user_role_by_id_periode($id_periode)[0]['id_role'] : 2,
                'edit_kriteria' => null,
            );

            $data = array_merge($data_site, $data_user, $data);

            $this->load->view('__template/header', $data);
            $this->load->view('__template/topbar');
            $this->load->view('__template/leftbar');
            $this->load->view('kriteria/index');
            $this->load->view('__template/footer');

            // print_r(json_encode($data));
        } else {
            redirect(base_url('kriteria'));
        }
    }

    public function add()
    {
        $data_kriteria = array(
            'nama_kriteria' => $this->input->post('name_kriteria'),
        );

        if ($this->input->post('name_kriteria') != '') {
            if ($this->M_kriteria->insert_kriteria($data_kriteria)) {
                echo "<script>alert('Tambah Kriteria Berhasil');
                window.location.href='" . base_url('kriteria') . "';</script>";
            } else {
                echo "<script>alert('Tambah Kegiatan Gagal');
                window.location.href='" . base_url('kriteria') . "';</script>";
            }
        } else {
            redirect(base_url('kriteria'));
        }
    }

    public function edit($id_kriteria, $id_periode)
    {
        $data_site = $this->M_site->get_kriteria_site();
        $data_user = $this->session->userdata();

        $data_periode = $this->M_periode->get_periode_by_id_member($data_user['id_member']);

        $data = array(
            'id_periode' => $id_periode,
            'id_role' => $this->M_user->get_user_role_by_id_periode($id_periode)[0]['id_role'] == 1 ? $this->M_user->get_user_role_by_id_periode($id_periode)[0]['id_role'] : 2,
            'data_kriteria' => $this->M_kriteria->get_kriteria(),
            'data_periode' => $data_periode,
            'data_kriteria_detail' => $this->M_kriteria->get_kriteria_detail($this->input->post('id_periode')),
            'edit_kriteria' => $this->M_kriteria->get_kriteria_by_id($id_kriteria)[0],
        );

        $data = array_merge($data_site, $data_user, $data);

        // print_r(json_encode($data));

        $this->load->view('__template/header', $data);
        $this->load->view('__template/topbar');
        $this->load->view('__template/leftbar');
        $this->load->view('kriteria/index');
        $this->load->view('__template/footer');
    }

    public function update($id_kriteria)
    {
        $nama_kriteria = $this->input->post('name_kriteria');

        $data_kriteria = array(
            'nama_kriteria' => $this->input->post('name_kriteria'),
        );

        if ($this->M_kriteria->update_kriteria($id_kriteria, $data_kriteria)) {
            echo "<script>alert('Sunting Kriteria Berhasil');
                window.location.href='" . base_url('kriteria') . "';</script>";
        } else {
            echo "<script>alert('Sunting Kriteria Gagal');
                window.location.href='" . base_url('kriteria') . "';</script>";
        }
        
    }

    public function insert($id_periode)
    {
        $data_kriteria = $this->input->post('kriteria[]');

        print_r(json_encode($data_kriteria));
    }
}
