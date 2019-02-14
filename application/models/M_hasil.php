<?php
    class M_hasil extends CI_model
    {
        public function get_hasil_penilaian_by_kegiatan($id_kegiatan)
        {
            $this->db->from(TB_HASIL);
            $this->db->join(TB_PANITIA, TB_PANITIA.'.id_panitia='.TB_HASIL.'.id_panitia');
            $this->db->where(TB_PANITIA.'.id_kegiatan', $id_kegiatan);

            return $this->db->get()->result_array();
        }

        public function insert_hasil($data_panitia, $data_hasil)
        {
            $data_hasil_input = array();
            for ($i=2; $i < sizeof($data_hasil) ; $i++) { 
                $data = array(
                    'id_panitia' => $data_panitia[$i-2]['id_panitia'],
                    'nilai_hasil' => $data_hasil[$i][sizeof($data_hasil[$i]) - 1]
                );

                $data_hasil_input[$i - 2] = $data;
            }

            for ($i = 0; $i < sizeof($data_hasil_input); $i++) {
                $this->db->insert(TB_HASIL, $data_hasil_input[$i]);
            }
        }
    }
    
?>