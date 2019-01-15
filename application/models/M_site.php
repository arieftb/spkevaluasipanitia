<?php 
    class M_site extends CI_Model {
        
        public function get_login_site()
        {
            $data = array(
                'title' => LOGIN_TITLE            
            );

            return $data;
        }

        public function get_home_site()
        {
            $data = array(
                'title' => HOME_TITLE        
            );

            return $data;
        }

        public function get_kegiatan_site()
        {
            $data = array(
                'title' => KEGIATAN_TITLE        
            );

            return $data;
        }
    }
?>