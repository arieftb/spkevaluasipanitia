<?php
    class M_panitia extends CI_Model
    {
        public function get_panitia_by_id_kegiatan($id_kegiatan)
        {
            $this->db->select();
            $this->db->from(TB_PANITIA);
            $this->db->join(TB_MEMBER, TB_MEMBER.'.id_member='.TB_PANITIA.'.id_member');
            $this->db->join(TB_KEGIATAN, TB_KEGIATAN.'.id_kegiatan='.TB_PANITIA.'.id_kegiatan');
            $this->db->join(TB_SIE, TB_SIE.'.id_sie='.TB_PANITIA.'.id_sie');
            $this->db->where(TB_KEGIATAN.'.id_kegiatan', $id_kegiatan);
            $this->db->order_by(TB_PANITIA.'.id_sie', 'asc');

            return $this->db->get()->result_array();
        }

        public function get_member_panitia_by_sie($id_kegiatan)
        {
            $this->load->model('M_sie', 'M_sie');
            $id_sie = $this->M_sie->get_sie_by_kegiatan_and_member($id_kegiatan)[0]['id_sie'];

            $this->db->from(TB_PANITIA);
            $this->db->join(TB_MEMBER, TB_MEMBER.'.id_member='.TB_PANITIA.'.id_member');
            $this->db->where(TB_PANITIA.'.id_sie', $id_sie);
            $this->db->where(TB_PANITIA.'.id_kegiatan', $id_kegiatan);
            $this->db->where(TB_PANITIA.'.jabatan_panitia', '1');

            return $this->db->get()->result_array();
        }

        public function get_panitia_by_id($id_panitia)
        {
            $this->db->select();
            $this->db->from(TB_PANITIA);
            $this->db->join(TB_MEMBER, TB_MEMBER.'.id_member='.TB_PANITIA.'.id_member');
            $this->db->join(TB_KEGIATAN, TB_KEGIATAN.'.id_kegiatan='.TB_PANITIA.'.id_kegiatan');
            $this->db->join(TB_SIE, TB_SIE.'.id_sie='.TB_PANITIA.'.id_sie');
            $this->db->where(TB_PANITIA.'.id_panitia', $id_panitia);
        
            return $this->db->get()->result_array();
        }

        public function insert_panitia($data)
        {
            $this->db->insert(TB_PANITIA, $data);     
            return ($this->db->affected_rows() != 1) ? false : true;
        }

        public function is_user_panitia($id_member, $id_periode)
        {
            $this->db->select();
            $this->db->from(TB_PANITIA);
            $this->db->join(TB_KEGIATAN, TB_KEGIATAN.'.id_kegiatan='.TB_PANITIA.'.id_kegiatan');
            $this->db->where(TB_KEGIATAN.'.id_periode', $id_periode);
            $this->db->where(TB_PANITIA.'.id_member', $id_member);
            $this->db->where(TB_PANITIA.'.jabatan_panitia', '0');

            $is_panitia = $this->db->get()->result_array();

            if(sizeof($is_panitia) > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function is_user_ketua_panitia($id_kegiatan)
        {
            $this->db->from(TB_PANITIA);
            $this->db->where(TB_PANITIA.'.id_kegiatan', $id_kegiatan);
            $this->db->where(TB_PANITIA.'.id_member', $this->session->userdata('id_member'));
            $this->db->where(TB_PANITIA.'.id_sie', 1);
            
            $is_ketua_panitia = $this->db->get()->result_array();

            return sizeof($is_ketua_panitia) > 0 ? true : false; 
        }

        public function is_user_koor_panitia($id_kegiatan)
        {
            $this->db->from(TB_PANITIA);
            $this->db->where(TB_PANITIA.'.id_kegiatan', $id_kegiatan);
            $this->db->where(TB_PANITIA.'.id_member', $this->session->userdata('id_member'));
            $this->db->where(TB_PANITIA.'.jabatan_panitia', '0');
            $this->db->where(TB_PANITIA.'.id_sie != ', 1);
            
            $is_koor_panitia = $this->db->get()->result_array();

            return sizeof($is_koor_panitia) > 0 ? true : false; 
        }

        public function update_panitia($id_panitia, $data)
        {
            $this->db->set($data);
            $this->db->where('id_panitia', $id_panitia);
            $this->db->update(TB_PANITIA);

            return ($this->db->affected_rows() != 1) ? false : true;
        }

        public function remove_panitia($id_panitia)
        {
            $this->db->where('id_panitia', $id_panitia);
            $this->db->delete(TB_PANITIA);

            return ($this->db->affected_rows() != 1) ? false : true;
        }
    }

?>