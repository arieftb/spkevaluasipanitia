<?php 
    class M_site extends CI_Model {
        
        public function get_login_site()
        {
            $data = array(
                'title' => 'Login'            
            );

            return $data;
        }

        public function get_home_site()
        {
            $data = array(
                'title' => 'Home'            
            );

            return $data;
        }
    }
?>