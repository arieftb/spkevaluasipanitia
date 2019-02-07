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
            'data_pasangan' => null,
            'data_matrix_perbandingan' => null,
            'data_matrix_normalisasi' => null,
            'data_kriteria_detail' => null,
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
                'data_pasangan' => null,
                'data_matrix_perbandingan' => null,
                'data_matrix_normalisasi' => null,
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
            'data_pasangan' => null,
            'data_matrix_perbandingan' => null,
            'data_matrix_normalisasi' => null,
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
        $data_kriteria_detail;

        for ($i = 0; $i < sizeof($data_kriteria); $i++) {
            $data = array(
                'id_periode' => $id_periode,
                'id_kriteria' => $data_kriteria[$i],
            );

            $data_kriteria_detail[$i] = $data;
        }

        if ($this->M_kriteria->insert_kriteria_detail($data_kriteria_detail)) {
            echo "<script>alert('Sisipkan Kriteria Berhasil');
            window.location.href='" . base_url('kriteria') . "';</script>";
        } else {
            echo "<script>alert('Sisipkan Kriteria Gagal');
                window.location.href='" . base_url('kriteria') . "';</script>";
        }

    }

    public function reset($id_periode)
    {
        if ($this->M_kriteria->reset_kriteria_detail($id_periode)) {
            echo "<script>alert('Reset Kriteria Berhasil');
            window.location.href='" . base_url('kriteria') . "';</script>";
        } else {
            echo "<script>alert('Reset Kriteria Gagal');
            window.location.href='" . base_url('kriteria') . "';</script>";
        }
    }

    public function process($id_periode)
    {
        $data_site = $this->M_site->get_kriteria_site();
        $data_user = $this->session->userdata();

        $data_periode = $this->M_periode->get_periode_by_id_member($data_user['id_member']);
        $data_pasangan = $this->M_kriteria->get_kriteria_pasangan_by_periode($id_periode);

        if (!empty($data_pasangan)) {
            $data_compared_matrix = $this->M_kriteria->get_kriteria_compared_matrix($data_pasangan, $this->M_kriteria->get_kriteria_detail($id_periode));
            $data_normalisasi_matrix = $this->M_kriteria->get_kriteria_normaliasi($data_compared_matrix);

            $data = array(
                'id_periode' => $id_periode,
                'id_role' => $this->M_user->get_user_role_by_id_periode($id_periode)[0]['id_role'] == 1 ? $this->M_user->get_user_role_by_id_periode($id_periode)[0]['id_role'] : 2,
                'data_kriteria' => $this->M_kriteria->get_kriteria(),
                'data_periode' => $data_periode,
                'data_kriteria_detail' => $this->M_kriteria->get_kriteria_detail($this->input->post('id_periode')),
                'data_matrix_perbandingan' => $data_compared_matrix,
                'data_matrix_normalisasi' => $data_normalisasi_matrix,
                'data_pasangan' => $data_pasangan,
                'edit_kriteria' => null,
            );

            $data = array_merge($data_site, $data_user, $data);

            // print_r(json_encode($data_compared_matrix));
            // print_r(json_encode($this->M_kriteria->get_kriteria_normaliasi($data_compared_matrix)));
            // print_r($this->M_kriteria->get_kriteria_normaliasi($data_compared_matrix));

            $this->load->view('__template/header', $data);
            $this->load->view('__template/topbar');
            $this->load->view('__template/leftbar');
            $this->load->view('kriteria/index');
            $this->load->view('__template/footer');
        } else {
            $data_kriteria = $this->input->post('id_kriteria[]');
            $data_kriteria_pasangan;

            $k = 0;

            for ($i = 0; $i < sizeof($data_kriteria); $i++) {
                for ($j = 0; $j < sizeof($data_kriteria); $j++) {
                    if ($j > $i) {
                        $data = array(
                            'id_kriteria_1' => $data_kriteria[$i],
                            'id_kriteria_2' => $data_kriteria[$j],
                            'id_periode' => $id_periode,
                        );

                        $data_kriteria_pasangan[$k] = $data;
                        $k++;
                    }
                }
            }

            if ($this->M_kriteria->insert_kriteria_pasangan($data_kriteria_pasangan)) {
                $this->process($id_periode);
            } else {
                echo "<script>alert('Process Kriteria Gagal');
                window.location.href='" . base_url('kriteria') . "';</script>";
            }
        }
    }

    public function compare($id_periode)
    {
        $id_kriteria_pasangan = $this->input->post('id_kriteria_pasangan[]');
        $data_kriteria_pasangan;
        for ($i = 0; $i < sizeof($id_kriteria_pasangan); $i++) {
            $nilai_pasangan = $this->input->post('nilai_pasang' . $i);
            if ($nilai_pasangan > 1) {
                $nilai_pasangan_1 = number_format(1.0 / $nilai_pasangan, 10);
                $nilai_pasangan_2 = $nilai_pasangan;
            } elseif ($nilai_pasangan < 1) {
                $nilai_pasangan_1 = abs($nilai_pasangan);
                $nilai_pasangan_2 = number_format(1.0 / abs($nilai_pasangan), 10);
            } else {
                $nilai_pasangan_1 = 1;
                $nilai_pasangan_2 = 1;
            }

            $data = array(
                'nilai_pasangan_1' => $nilai_pasangan_1,
                'nilai_pasangan_2' => $nilai_pasangan_2,
            );

            $data_kriteria_pasangan[$i] = $data;
        }

        if ($this->M_kriteria->update_kriteria_pasangan($data_kriteria_pasangan, $id_kriteria_pasangan)) {
            redirect(base_url('kriteria/process/' . $id_periode));
        } else {
            echo "<script>alert('Bandingkan Kriteria Gagal');
                window.location.href='" . base_url('kriteria') . "';</script>";
        }
        // print_r(json_encode($data_kriteria_pasangan));
    }
}
