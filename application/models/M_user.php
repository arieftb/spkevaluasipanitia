<?php 
    class M_user extends CI_Model {    
        public function get_login_data($data)
        {        
            $this->db->select('*');
            $this->db->from(TB_MEMBER);
            $this->db->join(TB_PENGURUS, TB_PENGURUS.'.id_member='.TB_MEMBER.'.id');
            $this->db->where(TB_MEMBER.'.email', $data['email']);
            $this->db->where(TB_MEMBER.'.password', $data['password']);
            $user_data = $this->db->get()->result_array();

            if(sizeof($user_data) > 0) {
                if($user_data[0]['posisi'] == 'Ketua') {
                    $user_data[0]['role'] = 0;
                } else {
                    $user_data[0]['role'] = 1;
                }
            }

            return $user_data;
        }

        public function get_login_status()
        {
            return $this->session->userdata('id');
        }
    }
?>