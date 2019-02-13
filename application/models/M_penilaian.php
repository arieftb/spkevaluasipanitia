<?php
    class M_penilaian extends CI_Model
    {

        public function get_nilai_by_kegiatan($id_kegiatan)
        {
            $this->db->from(TB_PENILAIAN);
            $this->db->join(TB_PANITIA, TB_PANITIA.'.id_panitia='.TB_PENILAIAN.'.id_panitia');
            $this->db->join(TB_MEMBER, TB_MEMBER.'.id_member='.TB_PANITIA.'.id_member');
            $this->db->join(TB_KRITERIA, TB_KRITERIA.'.id_kriteria='.TB_PENILAIAN.'.id_kriteria');
            $this->db->where(TB_PANITIA.'.id_kegiatan', $id_kegiatan);

            return $this->db->get()->result_array();
        }

        public function insert_nilai($data_nilai)
        {
            $status = true;
            for ($i = 0; $i < sizeof($data_nilai); $i++) {
                $this->db->insert(TB_PENILAIAN, $data_nilai[$i]);
    
                if ($this->db->affected_rows() != 1) {
                    $status = false;
                } else {
                    // $status = false;
                }
    
            }
    
            return $status;
        }

        public function update_nilai($data_nilai)
        {
            $status = true;
            for ($i = 0; $i < sizeof($data_nilai); $i++) {
                $this->db->trans_start();
                $this->db->set($data_nilai[$i]);
                $this->db->where('id_panitia', $data_nilai[$i]['id_panitia']);
                $this->db->where('id_kriteria', $data_nilai[$i]['id_kriteria']);
                $this->db->update(TB_PENILAIAN);
                $this->db->trans_complete();
    
                if ($this->db->trans_status() == false) {
                    $status = false;
                } else {
                    // $status = false;
                }
            }
    
            return $status;
        }

        public function manipulate_nilai_from_form($data_nilai)
        {
            $l = 0;
            $data_penilaian = array();
            for ($i=0; $i < sizeof($data_nilai['id_kriteria']) ; $i++) { 
                for ($j=0; $j < sizeof($data_nilai['id_panitia']); $j++) { 
                    for ($k=$l; $k < sizeof($data_nilai['nilai_kriteria']); $k++) { 
                        $data = array(
                            'id_panitia' => $data_nilai['id_panitia'][$j],
                            'id_kriteria' => $data_nilai['id_kriteria'][$i],
                            'nilai_penilaian' => $data_nilai['nilai_kriteria'][$k],
                        );

                        $data_penilaian[$k] = $data;
                        $l ++;
                        break;
                    }
                }
            }

            return $data_penilaian;
        }
    }
?>