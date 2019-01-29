<?php 
    class M_member extends CI_Model
    {
        public function get_member_by_periode($id_periode)
        {
            $this->db->select();
            $this->db->from(TB_MEMBER);
            $this->db->where(TB_MEMBER.'.id_periode', $id_periode-1);
            $this->db->where(TB_MEMBER.'.id_member NOT IN (SELECT pengurus.id_member FROM pengurus)');

            return $this->db->get()->result_array();
        }
    }
    
?>