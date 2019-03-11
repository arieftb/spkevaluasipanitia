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

        public function get_member_all()
        {
            $this->db->select();
            $this->db->from(TB_MEMBER);
            $this->db->where(TB_MEMBER.'.id_member NOT IN (SELECT pengurus.id_member FROM pengurus)');
            $this->db->order_by(TB_MEMBER.'.nim_member', "DESC");
            $this->db->order_by(TB_MEMBER.'.nama_member', "ASC");


            return $this->db->get()->result_array();
        }
    }
    
?>