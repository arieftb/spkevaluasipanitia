<?php
    class M_hasil extends CI_model
    {
        public function get_hasil_penilaian_by_kegiatan($id_kegiatan)
        {
            $this->db->from(TB_HASIL);
            $this->db->join(TB_PANITIA, TB_PANITIA.'.id_panitia='.TB_HASIL.'.id_panitia');
            $this->db->join(TB_MEMBER, TB_MEMBER.'.id_member='.TB_PANITIA.'.id_member');
            $this->db->where(TB_PANITIA.'.id_kegiatan', $id_kegiatan);
            $this->db->order_by(TB_HASIL.'.nilai_hasil', 'desc');

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

        public function delete_hasil_by_kegiatan($id_kegiatan)
        {
            // $this->db->join(TB_PANITIA, TB_PANITIA.'.id_panitia='.TB_HASIL.'.id_panitia');
            // $this->db->where(TB_PANITIA.'.id_kegiatan', $id_kegiatan);
            // $this->db->delete(TB_HASIL);
            $sql = 'DELETE '.TB_HASIL.'.* FROM '.TB_HASIL.' JOIN '.TB_PANITIA.' ON '.TB_PANITIA.'.id_panitia='.TB_HASIL.'.id_panitia WHERE '.TB_PANITIA.'.id_kegiatan = ?';

            $this->db->query($sql, array($id_kegiatan));

            return $this->db->affected_rows() > 0;
        }
    }
    
?>