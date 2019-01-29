<?php 
    class M_user extends CI_Model {    
        public function get_login_data($data)
        {        
            $this->db->select(TB_MEMBER.'.id_member,'. TB_MEMBER.'.nama_member,'. TB_MEMBER.'.email_member,'. TB_MEMBER.'.nim_member');
            $this->db->from(TB_MEMBER);
            $this->db->join(TB_PENGURUS, TB_PENGURUS.'.id_member='.TB_MEMBER.'.id_member');
            $this->db->where(TB_MEMBER.'.email_member', $data['email']);
            $this->db->where(TB_MEMBER.'.password_member', $data['password']);
            $this->db->limit(1);
            $user_data = $this->db->get()->result_array();

            return $user_data;
        }

        public function get_login_role($id_member)
        {
            $this->db->select(TB_DEPTDIVISI.'.id_deptdivisi,'.TB_DEPTDIVISI.'.id_role');
            $this->db->from(TB_DEPTDIVISI);
            $this->db->join(TB_PENGURUS, TB_PENGURUS.'.id_deptdivisi='.TB_DEPTDIVISI.'.id_deptdivisi');
            $this->db->where(TB_PENGURUS.'.id_member', $id_member);

            $login_deptdivisi = $this->db->get()->result_array();

            $role_user =  $this->get_login_role_by_deptdivisi($login_deptdivisi);

            return $role_user;
        }

        public function get_login_role_by_deptdivisi($id_deptdivisi)
        {
            if(sizeof($id_deptdivisi) == 2) {
                if ($id_deptdivisi[0]['id_role'] == 1 && $id_deptdivisi[1]['id_role'] == 1) {
                    $user_role = 1;
                } else if ($id_deptdivisi[0]['id_role'] != 1 && $id_deptdivisi[1]['id_role'] != 1) {
                    $user_data = 2;
                } else {
                    $user_role = 3;
                }
            } else {
                $user_role = $id_deptdivisi[0]['id_role'];
            }

            return $user_role;
        }

        public function get_user_role_by_id_periode($id_periode)
        {
            $this->db->select(TB_ROLE.'.id_role');
            $this->db->from(TB_PENGURUS);
            $this->db->join(TB_DEPTDIVISI, TB_DEPTDIVISI.'.id_deptdivisi='.TB_PENGURUS.'.id_deptdivisi');
            $this->db->join(TB_ROLE, TB_ROLE.'.id_role='.TB_DEPTDIVISI.'.id_role');
            $this->db->where(TB_PENGURUS.'.id_periode', $id_periode);

            return $this->db->get()->result_array();
        }

        public function get_role_by_kegiatan_and_member($id_kegiatan, $id_member)
        {
            $this->db->select();
            $this->db->from(TB_KEGIATAN);
            $this->db->join(TB_PANITIA, TB_PANITIA.'.id_kegiatan='.TB_KEGIATAN.'.id_kegiatan');
            $this->db->where(TB_PANITIA.'.id_member', $id_member);
            $this->db->where(TB_KEGIATAN.'.id_kegiatan', $id_kegiatan);

            $data_user_role = $this->db->get()->result_array();

            if ($data_user_role[0]['id_sie'] == 1) {
                return '3';
            } else {
                return '4';
            }
        }

        public function is_super_admin_by_id_kegiatan($id_kegiatan)
        {
            $this->db->select(TB_ROLE.'.id_role');
            $this->db->from(TB_ROLE);
            $this->db->join(TB_DEPTDIVISI, TB_DEPTDIVISI.'.id_role='.TB_ROLE.'.id_role');
            $this->db->join(TB_PENGURUS, TB_PENGURUS.'.id_deptdivisi='.TB_DEPTDIVISI.'.id_deptdivisi');
            $this->db->join(TB_PERIODE, TB_PERIODE.'.id_periode='.TB_PENGURUS.'.id_periode');
            $this->db->join(TB_KEGIATAN, TB_KEGIATAN.'.id_periode='.TB_PERIODE.'.id_periode');
            $this->db->join(TB_MEMBER, TB_MEMBER.'.id_member='.TB_PENGURUS.'.id_member');
            $this->db->where(TB_KEGIATAN.'.id_kegiatan',$id_kegiatan);
            $this->db->where(TB_MEMBER.'.id_member', $this->session->userdata('id_member'));

            $user_role = $this->db->get()->result_array();
            // print_r($user_role);

            if ($user_role[0]['id_role'] == 1) {
                return true;
            } else {
                return false;
            }
        }

        public function is_ketua_by_id_kegiatan($id_kegiatan)
        {
            $this->db->select(TB_SIE.'.id_sie');
            $this->db->from(TB_SIE);
            $this->db->join(TB_PANITIA, TB_PANITIA.'.id_sie='.TB_SIE.'.id_sie');
            $this->db->join(TB_MEMBER, TB_MEMBER.'.id_member='.TB_PANITIA.'.id_member');
            $this->db->join(TB_KEGIATAN, TB_KEGIATAN.'.id_kegiatan='.TB_PANITIA.'.id_kegiatan');
            $this->db->where(TB_KEGIATAN.'.id_kegiatan', $id_kegiatan);
            $this->db->where(TB_MEMBER.'.id_member', $this->session->userdata('id_member'));

            $user_role = $this->db->get()->result_array();

            // print_r($user_role);

            if ($user_role[0]['id_sie'] == 1) {
                return true;
            } else {
                return false;
            }
        }

        public function get_login_status()
        {
            return $this->session->userdata('id_member');
        }
    }
?>