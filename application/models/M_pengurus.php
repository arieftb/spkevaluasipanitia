<?php
    class M_pengurus extends CI_Model
    {
        public function get_pengurus_by_periode($id_periode)
        {
            $this->db->select(TB_MEMBER.'.*');
            $this->db->from(TB_MEMBER);
            $this->db->join(TB_PENGURUS, TB_PENGURUS.'.id_member='.TB_MEMBER.'.id_member');
            $this->db->where(TB_PENGURUS.'.id_periode', $id_periode);

            return $this->db->get()->result_array();
        }
    }
    
?>