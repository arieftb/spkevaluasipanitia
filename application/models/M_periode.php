<?php 
    class M_periode extends CI_Model
    {
        public function get_periode_by_id_member($id_member)
        {
            $this->db->select(TB_PENGURUS.'.id_periode,'.TB_PERIODE.'.tahun_periode');
            $this->db->from(TB_PENGURUS);
            $this->db->join(TB_PERIODE, TB_PERIODE.'.id_periode='.TB_PENGURUS.'.id_periode');
            $this->db->where(TB_PENGURUS.'.id_member', $id_member);

            return $this->db->get()->result_array();
        }

        public function get_periode_by_id_kegiatan($id_kegiatan)
        {
            $this->db->select();
            $this->db->from(TB_PERIODE);
            $this->db->join(TB_KEGIATAN, TB_KEGIATAN.'.id_periode='.TB_PERIODE.'.id_periode');
            $this->db->where(TB_KEGIATAN.'.id_kegiatan', $id_kegiatan);

            return $this->db->get()->result_array();
        }
    }
    
?>