<?php 
    class M_user extends CI_Model {    
        public function get_login_data($data)
        {        
            return $this->db->get_where(TB_MEMBER, $data);
        }
    }
?>