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

        public function get_panitia_site()
        {
            $data = array(
                'title' => PANITIA_TITLE        
            );

            return $data;
        }

        public function get_kriteria_site()
        {
            $data = array(
                'title' => KRITERIA_TITLE        
            );

            return $data;
        }

        public function get_penilaian_site()
        {
            $data = array(
                'title' => PENILAIAN_TITLE        
            );

            return $data;
        }
    }
?>