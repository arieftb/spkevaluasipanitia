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
        $this->load->model('M_kriteria');
        $this->load->model('M_penilaian');
        $this->load->model('M_hasil');

        if (!$this->M_user->get_login_status()) {
            redirect(base_url('login'));
        }
    }

    public function index()
    {
        $data_site = $this->M_site->get_penilaian_site();
        $data_user = $this->session->userdata();
        $data_periode = $this->M_periode->get_periode_by_id_member($data_user['id_member']);

        $data = array(
            'id_periode' => null,
            'id_role' => null,
            'id_kegiatan' => null,
            'data_kegiatan' => null,
            'data_periode' => $data_periode,
            'data_panitia' => null,
            'data_kriteria' => null,
            'data_nilai' => null,
            'data_nilai_table' => null,
            'data_nilai_perkriteria' => null,
            'data_nilai_normalisasi' => null,
            'data_nilai_hasil' => null,
        );

        $data = array_merge($data_site, $data_user, $data);

        $this->load->view('__template/header', $data);
        $this->load->view('__template/topbar');
        $this->load->view('__template/leftbar');
        $this->load->view('penilaian/index');
        $this->load->view('__template/footer');
    }

    public function periode()
    {
        $data_site = $this->M_site->get_penilaian_site();
        $data_user = $this->session->userdata();
        $data_periode = $this->M_periode->get_periode_by_id_member($data_user['id_member']);

        $id_periode = trim($this->input->post('id_periode'));

        if ($id_periode != null && !empty($id_periode) && $id_periode != '') {
            $id_role = $this->M_user->is_superadmin_by_periode($id_periode) ? 1 : 2;
            $data_kegiatan = $this->M_kegiatan->get_kegiatan($id_periode);

            $data = array(
                'id_periode' => $id_periode,
                'id_role' => null,
                'id_kegiatan' => null,
                'data_kegiatan' => $data_kegiatan,
                'data_periode' => $data_periode,
                'data_panitia' => null,
                'data_kriteria' => null,
                'data_nilai' => null,
                'data_nilai_table' => null,
                'data_nilai_perkriteria' => null,
                'data_nilai_normalisasi' => null,
                'data_nilai_hasil' => null,
            );

            $data = array_merge($data_site, $data_user, $data);

            // print_r(json_encode($data));

            $this->load->view('__template/header', $data);
            $this->load->view('__template/topbar');
            $this->load->view('__template/leftbar');
            $this->load->view('penilaian/index');
            $this->load->view('__template/footer');
        } else {
            echo "<script>alert('Belum Memilih Periode');
            window.location.href='" . base_url('penilaian') . "';</script>";
        }

    }

    public function kegiatan()
    {
        $data_site = $this->M_site->get_penilaian_site();
        $data_user = $this->session->userdata();
        $data_periode = $this->M_periode->get_periode_by_id_member($data_user['id_member']);

        $id_kegiatan = trim($this->input->post('id_kegiatan'));

        if ($id_kegiatan != null && !empty($id_kegiatan) && $id_kegiatan != '') {
            $id_periode = $this->M_periode->get_periode_by_id_kegiatan($id_kegiatan)[0]['id_periode'];
            $id_role = $this->M_user->is_superadmin_by_periode($id_periode) ? 1 : ($this->M_panitia->is_user_ketua_panitia($id_kegiatan) ? 3 : ($this->M_panitia->is_user_koor_panitia($id_kegiatan) ? 4 : 5));

            $data_panitia = $id_role == 1 || $id_role == 3 ? $this->M_panitia->get_member_panitia_by_kegiatan($id_kegiatan) : $this->M_panitia->get_member_panitia_by_sie($id_kegiatan);
            $data_kegiatan = $this->M_kegiatan->get_kegiatan($id_periode);
            $data_kriteria = $this->M_kriteria->get_kriteria_detail($id_periode);
            $data_nilai = $id_role == 1 || $id_role == 3 ? $this->M_penilaian->get_nilai_by_kegiatan($id_kegiatan) : $this->M_penilaian->get_nilai_by_sie($id_kegiatan);
            $data_nilai_table = $id_role == 1 || $id_role == 3 ? $this->M_penilaian->get_data_nilai_table($data_panitia, $data_kriteria, $data_nilai) : "";
            // $id_role = $this->M_user->is_superadmin_by_periode($id_periode) ? 1 : ($this->M_panitia->is_user_panitia($data_user['id_member'], $id_periode) ? ($this->M_panitia->is_ketua_panitia($id_kegiatan) ? 3 : ($this->M_panitia->is_koor_panitia($id_kegiatan) ? 4)) : 5);

            $data = array(
                'id_periode' => $id_periode,
                'id_role' => $id_role,
                'id_kegiatan' => $id_kegiatan,
                'data_kegiatan' => $data_kegiatan,
                'data_periode' => $data_periode,
                'data_panitia' => $data_panitia,
                'data_kriteria' => $data_kriteria,
                'data_nilai' => $data_nilai,
                'data_nilai_table' => $data_nilai_table,
                'data_nilai_perkriteria' => null,
                'data_nilai_normalisasi' => null,
                'data_nilai_hasil' => null,
            );

            $data = array_merge($data_site, $data_user, $data);

            // print_r(json_encode($data_nilai_table));

            $this->load->view('__template/header', $data);
            $this->load->view('__template/topbar');
            $this->load->view('__template/leftbar');
            $this->load->view('penilaian/index');
            $this->load->view('__template/footer');
        } else {
            echo "<script>alert('Belum Memilih Kegiatan');
            window.location.href='" . base_url('penilaian') . "';</script>";
        }

    }

    public function process()
    {
        $data_site = $this->M_site->get_penilaian_site();
        $data_user = $this->session->userdata();
        $data_periode = $this->M_periode->get_periode_by_id_member($data_user['id_member']);

        $id_kegiatan = trim($this->input->post('id_kegiatan'));
        if ($id_kegiatan != null && !empty($id_kegiatan) && $id_kegiatan != '') {
            $id_periode = $this->M_periode->get_periode_by_id_kegiatan($id_kegiatan)[0]['id_periode'];
            $id_role = $this->M_user->is_superadmin_by_periode($id_periode) ? 1 : ($this->M_panitia->is_user_ketua_panitia($id_kegiatan) ? 3 : ($this->M_panitia->is_user_koor_panitia($id_kegiatan) ? 4 : 5));

            $data_panitia = $id_role == 1 || $id_role == 3 ? $this->M_panitia->get_member_panitia_by_kegiatan($id_kegiatan) : $this->M_panitia->get_member_panitia_by_sie($id_kegiatan);
            $data_kegiatan = $this->M_kegiatan->get_kegiatan($id_periode);
            $data_kriteria = $this->M_kriteria->get_kriteria_detail($id_periode);
            $data_nilai = $id_role == 1 || $id_role == 3 ? $this->M_penilaian->get_nilai_by_kegiatan($id_kegiatan) : $this->M_penilaian->get_nilai_by_sie($id_kegiatan);
            $data_nilai_table = $id_role == 1 || $id_role == 3 ? $this->M_penilaian->get_data_nilai_table($data_panitia, $data_kriteria, $data_nilai) : "";
            $data_nilai_perkriteria = $id_role == 3 ? $this->M_penilaian->get_data_nilai_perkriteria($data_nilai_table, $data_kriteria) : "";
            $data_nilai_normalisasi = $id_role == 3 ? $this->M_penilaian->get_data_nilai_normalisasi($data_nilai_perkriteria) : "";
            $data_nilai_hasil = $id_role == 3 ? $this->M_penilaian->get_data_nilai_hasil($data_nilai_normalisasi, $data_kriteria, $data_panitia) : ($id_role == 1 ? $this->M_hasil->get_hasil_penilaian_by_kegiatan($id_kegiatan) : "");

            $data_dummy_hasil = $id_role == 1 || $id_role == 3 ? $this->M_hasil->get_hasil_penilaian_by_kegiatan($id_kegiatan) : '';

            // print_r(sizeof($data_dummy_hasil));

            if (sizeof($data_dummy_hasil) == 0) {
                $this->M_hasil->insert_hasil($data_panitia, $data_nilai_hasil);
            }

            // $id_role = $this->M_user->is_superadmin_by_periode($id_periode) ? 1 : ($this->M_panitia->is_user_panitia($data_user['id_member'], $id_periode) ? ($this->M_panitia->is_ketua_panitia($id_kegiatan) ? 3 : ($this->M_panitia->is_koor_panitia($id_kegiatan) ? 4)) : 5);

            $data = array(
                'id_periode' => $id_periode,
                'id_role' => $id_role,
                'id_kegiatan' => $id_kegiatan,
                'data_kegiatan' => $data_kegiatan,
                'data_periode' => $data_periode,
                'data_panitia' => $data_panitia,
                'data_kriteria' => $data_kriteria,
                'data_nilai' => $data_nilai,
                'data_nilai_table' => $data_nilai_table,
                'data_nilai_perkriteria' => $data_nilai_perkriteria,
                'data_nilai_normalisasi' => $data_nilai_normalisasi,
                'data_nilai_hasil' => $data_nilai_hasil,
            );

            $data = array_merge($data_site, $data_user, $data);

            // print_r(json_encode($data_nilai_hasil));
            // print_r($data_nilai_perkriteria);

            $this->load->view('__template/header', $data);
            $this->load->view('__template/topbar');
            $this->load->view('__template/leftbar');
            $this->load->view('penilaian/index');
            $this->load->view('__template/footer');
        } else {
            echo "<script>alert('Belum Memilih Kegiatan');
            window.location.href='" . base_url('penilaian') . "';</script>";
        }
    }

    public function nilai()
    {
        $nilai_kriteria = $this->input->post('nilai_kriteria[]');
        $id_panitia = $this->input->post('id_panitia[]');
        $id_kriteria = $this->input->post('id_kriteria[]');
        $id_periode = $this->input->post('id_periode');
        $id_kegiatan = $this->input->post('id_kegiatan');

        if (sizeof($nilai_kriteria) == (sizeof($id_kriteria) * sizeof($id_panitia))) {
            $data_penilaian = array(
                'id_kriteria' => $id_kriteria,
                'id_panitia' => $id_panitia,
                'nilai_kriteria' => $nilai_kriteria,
            );

            $data_nilai = $this->M_penilaian->manipulate_nilai_from_form($data_penilaian);

            if ($this->M_penilaian->insert_nilai($data_nilai)) {
                echo "<script>alert('Masukkan Nilai Berhasil');
                window.location.href='" . base_url('penilaian') . "';</script>";
            } else {
                echo "<script>alert('Masukkan Nilai Gagal');
                window.location.href='" . base_url('penilaian') . "';</script>";
            }

            // print_r(json_encode($data_nilai));
        } else {
            echo "<script>alert('Belum Memasukan Semua Nilai');
            window.location.href='" . base_url('penilaian') . "';</script>";
        }
    }

    public function update()
    {
        $nilai_kriteria = $this->input->post('nilai_kriteria[]');
        $id_panitia = $this->input->post('id_panitia[]');
        $id_kriteria = $this->input->post('id_kriteria[]');
        $id_periode = $this->input->post('id_periode');
        $id_kegiatan = $this->input->post('id_kegiatan');

        if (sizeof($nilai_kriteria) == (sizeof($id_kriteria) * sizeof($id_panitia))) {
            $data_penilaian = array(
                'id_kriteria' => $id_kriteria,
                'id_panitia' => $id_panitia,
                'nilai_kriteria' => $nilai_kriteria,
            );

            $data_nilai = $this->M_penilaian->manipulate_nilai_from_form($data_penilaian);

            if ($this->M_penilaian->update_nilai($data_nilai)) {
                echo "<script>alert('Perbaharui Nilai Berhasil');
                window.location.href='" . base_url('penilaian') . "';</script>";
            } else {
                echo "<script>alert('Perbaharui Nilai Gagal');
                window.location.href='" . base_url('penilaian') . "';</script>";
            }

            print_r(json_encode($data_nilai));
        } else {
            echo "<script>alert('Belum Memasukan Semua Nilai');
            window.location.href='" . base_url('penilaian') . "';</script>";
        }
    }

    public function reset($id_kegiatan)
    {
        if ($this->M_hasil->delete_hasil_by_kegiatan($id_kegiatan) > 0) {
            echo "<script>alert('Reset Penilaian Berhasil');
            window.location.href='" . base_url('penilaian') . "';</script>";
        } else {
            echo "<script>alert('Reset Penilaian Gagal');
            window.location.href='" . base_url('penilaian') . "';</script>";
        }
    }
}
