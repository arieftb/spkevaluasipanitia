<?php
class Kegiatan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_site');
        $this->load->model('M_user');
        $this->load->model('M_kegiatan');
        $this->load->model('M_periode');

        if (!$this->M_user->get_login_status()) {
            redirect(base_url('login'));
        }
    }

    public function index()
    {

        $data_site = $this->M_site->get_kegiatan_site();
        $data_user = $this->session->userdata();

        $data_periode = $this->M_periode->get_periode_by_id_member($data_user['id_member']);

        $kegiatan = array(
            'kegiatan' => null,
            'edit_kegiatan' => null,
            'id_periode' => null,
            'id_role' => null,
            'periode' => $data_periode
        );
        $data = array_merge($data_site, $data_user, $kegiatan);

        $this->load->view('__template/header', $data);
        $this->load->view('__template/topbar');
        $this->load->view('__template/leftbar');
        $this->load->view('kegiatan/index');
        $this->load->view('__template/footer');

        // print_r(json_encode($data));
    }

    public function periode()
    {
        $data_site = $this->M_site->get_kegiatan_site();
        $data_user = $this->session->userdata();

        $id_periode = trim($this->input->post('id_periode'));

        if ($id_periode != '') {
            $data_kegiatan = $this->M_kegiatan->get_kegiatan($id_periode);

            $kegiatan = array(
                'kegiatan' => $data_kegiatan,
                'edit_kegiatan' => null,
                'id_periode' => $id_periode,
                'id_role' => $this->M_user->get_user_role_by_id_periode($id_periode)[0]['id_role'],
                'periode' => $this->M_periode->get_periode_by_id_member($data_user['id_member'])
            );

            $data = array_merge($data_site, $data_user, $kegiatan);

            $this->load->view('__template/header', $data);
            $this->load->view('__template/topbar');
            $this->load->view('__template/leftbar');
            $this->load->view('kegiatan/index');
            $this->load->view('__template/footer');

            // print_r(json_encode($data));
        } else {
            redirect(base_url('kegiatan'));
        }
    }

    public function add()
    {
        $data = array(
            'id_periode' => $this->input->post('id_periode'),
            'nama_kegiatan' => $this->input->post('nama_kegiatan'),
            'tema_kegiatan' => $this->input->post('tema_kegiatan'),
            'pelaksanaan_kegiatan' => date('Y-m-d', strtotime($this->input->post('pelaksanaan_kegiatan')))
        );


        // print_r(json_encode($data));
        if ($this->M_kegiatan->insert_kegiatan($data)) {
            echo "<script>alert('Tambah Kegiatan Berhasil');
            window.location.href='" . base_url('kegiatan') . "';</script>";
        } else {
            echo "<script>alert('Tambah Kegiatan Gagal');
            window.location.href='" . base_url('kegiatan') . "';</script>";
        }
    }

    public function delete($id_kegiatan)
    {
        if ($this->M_kegiatan->remove_kegiatan($id_kegiatan)) {
            echo "<script>alert('Hapus Kegiatan Berhasil');
            window.location.href='" . base_url('kegiatan') . "';</script>";
        } else {
            echo "<script>alert('Hapus Kegiatan Gagal');
            window.location.href='" . base_url('kegiatan') . "';</script>";
        }
    }

    public function edit($id_kegiatan)
    {
        $data_site = $this->M_site->get_kegiatan_site();
        $data_user = $this->session->userdata();

        $data_kegiatan = $this->M_kegiatan->get_kegiatan();
        $edit_kegiatan = $this->M_kegiatan->get_kegiatan_by_id($id_kegiatan);

        $kegiatan = array(
            'kegiatan' => $data_kegiatan,
            'edit_kegiatan' => $edit_kegiatan[0]
        );
        $data = array_merge($data_site, $data_user, $kegiatan);

        // print_r(json_encode($data));

        $this->load->view('__template/header', $data);
        $this->load->view('__template/topbar');
        $this->load->view('__template/leftbar');
        $this->load->view('kegiatan/index');
        $this->load->view('__template/footer');
    }

    public function update($id)
    {
        $data = array(
            'nama' => $this->input->post('nama'),
            'tema' => $this->input->post('tema'),
            'pelaksanaan' => date('Y-m-d', strtotime($this->input->post('pelaksanaan')))
        );

        if ($this->M_kegiatan->update_kegiatan($id, $data)) {
            echo "<script>alert('Sunting Kegiatan Berhasil');
            window.location.href='" . base_url('kegiatan') . "';</script>";
        } else {
            echo "<script>alert('Sunting Kegiatan Gagal');
            window.location.href='" . base_url('kegiatan') . "';</script>";
        }
    }
}
