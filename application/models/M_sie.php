<?php
    class M_sie extends CI_Model
    {
        public function get_sie()
        {
            $this->db->from(TB_SIE);
            return $this->db->get()->result_array();
        }
    }
    
?>