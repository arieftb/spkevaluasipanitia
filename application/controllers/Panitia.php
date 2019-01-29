<?php
    class Panitia extends CI_Controller
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
            $data_site = $this->M_site->get_panitia_site();
            $data_user = $this->session->userdata();
            
            $data_periode = $this->M_periode->get_periode_by_id_member($data_user['id_member']);

            $data = array(
                'id_periode' => null,
                'id_role' => null,
                'data_kegiatan' => null,
                'data_periode' => $data_periode,
                'edit_panitia' => null
            );
            $data = array_merge($data_site, $data_user, $data);

            //  print_r(json_encode($data_periode));

            $this->load->view('__template/header', $data);
            $this->load->view('__template/topbar');
            $this->load->view('__template/leftbar');
            $this->load->view('panitia/index');
            $this->load->view('__template/footer');    
        }

        public function periode()
        {
            $data_site = $this->M_site->get_panitia_site();
            $data_user = $this->session->userdata();

            $id_periode = trim($this->input->post('id_periode'));

            if ($id_periode != '') {
                $data_kegiatan = $this->M_kegiatan->get_kegiatan($id_periode);
    
                $data = array(
                    'data_kegiatan' => $data_kegiatan,
                    'data_periode' => $this->M_periode->get_periode_by_id_member($data_user['id_member']),
                    'data_panitia' => null,
                    'id_kegiatan' => null,
                    'id_periode' => $id_periode,
                    'id_role' => null,
                    'edit_panitia' => null
                );
    
                $data = array_merge($data_site, $data_user, $data);
    
                $this->load->view('__template/header', $data);
                $this->load->view('__template/topbar');
                $this->load->view('__template/leftbar');
                $this->load->view('panitia/index');
                $this->load->view('__template/footer');
    
                // print_r(json_encode($id_periode));
            } else {
                redirect(base_url('panitia'));
            }
        }

        public function kegiatan()
        {
            $data_site = $this->M_site->get_panitia_site();
            $data_user = $this->session->userdata();

            $id_kegiatan = trim($this->input->post('id_kegiatan'));

            if ($id_kegiatan != '') {
                $id_periode = $this->M_periode->get_periode_by_id_kegiatan($id_kegiatan);
                $data_panitia = $this->M_panitia->get_panitia_by_id_kegiatan($id_kegiatan);

                $member = $this->M_member->get_member_by_periode($id_periode[0]['id_periode']);
                $pengurus = $this->M_pengurus->get_pengurus_by_periode($id_periode[0]['id_periode']);

                $data_calon_panitia = array_merge($member, $pengurus);

                $data_sie = $this->M_sie->get_sie();

                $data = array(
                    'data_kegiatan' => $this->M_kegiatan->get_kegiatan($id_periode[0]['id_periode']),
                    'data_periode' => $this->M_periode->get_periode_by_id_member($data_user['id_member']),
                    'data_panitia' => $data_panitia,
                    'data_calon_panitia' => $data_calon_panitia,
                    'data_sie' => $data_sie,
                    'id_kegiatan' => $id_kegiatan,
                    'id_periode' => $id_periode[0]['id_periode'],
                    'id_role' => $this->M_user->get_user_role_by_id_periode($id_periode[0]['id_periode'])[0]['id_role'] == 1 ? $this->M_user->get_user_role_by_id_periode($id_periode[0]['id_periode'])[0]['id_role'] : $this->M_user->get_role_by_kegiatan_and_member($id_kegiatan, $data_user['id_member']),
                    'id_member' => null,
                    'id_sie' => null,
                    'edit_panitia' => null
                );
                $data = array_merge($data_site, $data_user, $data);
            
                $this->load->view('__template/header', $data);
                $this->load->view('__template/topbar');
                $this->load->view('__template/leftbar');
                $this->load->view('panitia/index');
                $this->load->view('__template/footer');

                // print_r(json_encode($data));
            } else {
                redirect(base_url('panitia'));
            }
        }

        public function add()
        {
            $data_site = $this->M_site->get_panitia_site();
            $data_user = $this->session->userdata();

            $id_periode = trim($this->input->post('id_periode'));
            $id_kegiatan = trim($this->input->post('id_kegiatan'));
            $id_member = trim($this->input->post('id_member'));
            $id_sie = trim($this->input->post('id_sie'));
            $jabatan_panitia = trim($this->input->post('jabatan_panitia'));

            if ($id_periode != '' && $id_kegiatan != '' && $id_member != '' && $id_sie != '' && $jabatan_panitia != '') {
                $data = array(
                    'id_member' => $id_member,
                    'id_kegiatan' => $id_kegiatan,
                    'id_sie' => $id_sie,
                    'jabatan_panitia' => $jabatan_panitia
                );

                // print_r(json_encode($data));

                if ($this->M_panitia->insert_panitia($data)) {
                    echo "<script>alert('Tambah Panitia Berhasil');
                    window.location.href='" . base_url('Panitia') . "';</script>";
                } else {
                    echo "<script>alert('Tambah Panitia Gagal');
                    window.location.href='" . base_url('Panitia') . "';</script>";
                }
                
            } else {
                echo "<script>alert('Data Tidak Lengkap');
                window.location.href='" . base_url('panitia') . "';</script>";
            }
        }

        public function edit($id_panitia)
        {
            $data_site = $this->M_site->get_panitia_site();
            $data_user = $this->session->userdata();
            $edit_panitia = $this->M_panitia->get_panitia_by_id($id_panitia);

            $member = $this->M_member->get_member_by_periode($edit_panitia[0]['id_periode']);
            $pengurus = $this->M_pengurus->get_pengurus_by_periode($edit_panitia[0]['id_periode']);
            $data_calon_panitia = array_merge($member, $pengurus);

            $data_sie = $this->M_sie->get_sie();

            $data = array(
                'data_kegiatan' => $this->M_kegiatan->get_kegiatan($edit_panitia[0]['id_periode']),
                'data_periode' => $this->M_periode->get_periode_by_id_member($data_user['id_member']),
                'data_panitia' => $this->M_panitia->get_panitia_by_id_kegiatan($edit_panitia[0]['id_kegiatan']),
                'data_calon_panitia' => $data_calon_panitia,
                'data_sie' => $data_sie,
                'id_kegiatan' => $edit_panitia[0]['id_kegiatan'],
                'id_periode' => $edit_panitia[0]['id_periode'],
                'id_role' => $this->M_user->get_user_role_by_id_periode($edit_panitia[0]['id_periode'])[0]['id_role'] == 1 ? $this->M_user->get_user_role_by_id_periode($edit_panitia[0]['id_periode'])[0]['id_role'] : $this->M_user->get_role_by_kegiatan_and_member($edit_panitia[0]['id_kegiatan'], $data_user['id_member']),
                'id_member' => $edit_panitia[0]['id_member'],
                'id_sie' => $edit_panitia[0]['id_sie'],
                'edit_panitia' => $edit_panitia[0]
            );
            $data = array_merge($data_site, $data_user, $data);

            $this->load->view('__template/header', $data);
            $this->load->view('__template/topbar');
            $this->load->view('__template/leftbar');
            $this->load->view('panitia/index');
            $this->load->view('__template/footer');

            // print_r(json_encode($data));
        }

        public function update($id_panitia)
        {
            $data_site = $this->M_site->get_panitia_site();
            $data_user = $this->session->userdata();

            $id_periode = trim($this->input->post('id_periode'));
            $id_kegiatan = trim($this->input->post('id_kegiatan'));
            $id_member = trim($this->input->post('id_member'));
            $id_sie = trim($this->input->post('id_sie'));
            $jabatan_panitia = trim($this->input->post('jabatan_panitia'));

            if ($id_periode != '' && $id_kegiatan != '' && $id_member != '' && $id_sie != '' && $jabatan_panitia != '') {
                $data = array(
                    'id_member' => $id_member,
                    'id_kegiatan' => $id_kegiatan,
                    'id_sie' => $id_sie,
                    'jabatan_panitia' => $jabatan_panitia
                );

                // print_r(json_encode($data));

                if ($this->M_panitia->update_panitia($id_panitia, $data)) {
                    echo "<script>alert('Sunting Panitia Berhasil');
                    window.location.href='" . base_url('Panitia') . "';</script>";
                } else {
                    echo "<script>alert('Sunting Panitia Gagal');
                    window.location.href='" . base_url('Panitia') . "';</script>";
                }
                
            } else {
                echo "<script>alert('Data Tidak Lengkap');
                window.location.href='" . base_url('panitia') . "';</script>";
            }
        }

        public function delete($id_panitia)
        {
            if ($this->M_panitia->remove_panitia($id_panitia)) {
                echo "<script>alert('Hapus Panitia Berhasil');
                window.location.href='" . base_url('Panitia') . "';</script>";
            } else {
                echo "<script>alert('Hapus Panitia Gagal');
                window.location.href='" . base_url('Panitia') . "';</script>";
            }
        }
    }
    
?>