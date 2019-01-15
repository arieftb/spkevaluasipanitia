<?php
class Kegiatan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_site');
        $this->load->model('M_user');
        $this->load->model('M_kegiatan');

        if(!$this->M_user->get_login_status()) {
            redirect(base_url('login'));
        }
    }

    public function index()
    {
        $data_site = $this->M_site->get_kegiatan_site();
        $data_user = $this->session->userdata();
        
        $data_kegiatan = $this->M_kegiatan->get_kegiatan();

        $kegiatan = array(
            'kegiatan' => $data_kegiatan,
            'edit_kegiatan' => null
        );
        $data = array_merge($data_site, $data_user, $kegiatan);

        $this->load->view('__template/header',$data);
        $this->load->view('__template/topbar');
        $this->load->view('__template/leftbar');
        $this->load->view('kegiatan/index');
        $this->load->view('__template/footer');

        // print_r(json_encode($data));
    }

    public function add()
    {
        $data = array(
            'nama' => $this->input->post('nama'),
            'tema' => $this->input->post('tema'),
            'pelaksanaan' => date('Y-m-d', strtotime($this->input->post('pelaksanaan')))
        );

        if($this->M_kegiatan->insert_kegiatan($data)) {
            echo "<script>alert('Tambah Kegiatan Berhasil');
            window.location.href='". base_url('kegiatan') ."';</script>";
        } else {
            echo "<script>alert('Tambah Kegiatan Gagal');
            window.location.href='". base_url('kegiatan') ."';</script>";
        }
    }

    public function delete($id_kegiatan)
    {
        if($this->M_kegiatan->remove_kegiatan($id_kegiatan)) {
            echo "<script>alert('Hapus Kegiatan Berhasil');
            window.location.href='". base_url('kegiatan') ."';</script>";
        } else {
            echo "<script>alert('Hapus Kegiatan Gagal');
            window.location.href='". base_url('kegiatan') ."';</script>";
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

        $this->load->view('__template/header',$data);
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

        if($this->M_kegiatan->update_kegiatan($id, $data)){
            echo "<script>alert('Sunting Kegiatan Berhasil');
            window.location.href='". base_url('kegiatan') ."';</script>";
        } else {
            echo "<script>alert('Sunting Kegiatan Gagal');
            window.location.href='". base_url('kegiatan') ."';</script>";
        }
    }
}

?>