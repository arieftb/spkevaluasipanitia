<?php
    class M_sie extends CI_Model
    {
        public function get_sie()
        {
            $this->db->from(TB_SIE);
            return $this->db->get()->result_array();
        }

        public function get_sie_by_kegiatan_and_member($id_kegiatan)
        {
            $this->db->from(TB_PANITIA);
            $this->db->where(TB_PANITIA.'.id_kegiatan', $id_kegiatan);
            $this->db->where(TB_PANITIA.'.id_member', $this->session->userdata('id_member'));

            return $this->db->get()->result_array();
        }
    }
    
?>