<?php
    class M_kriteria extends CI_Model
    {
        public function get_kriteria()
        {
            $this->db->from(TB_KRITERIA);
            return $this->db->get()->result_array();
        }

        public function insert_kriteria($data_kriteria)
        {
            $this->db->insert(TB_KRITERIA, $data_kriteria);     
            return ($this->db->affected_rows() != 1) ? false : true;
        }

        public function get_kriteria_detail($id_periode)
        {
            $this->db->select();
            $this->db->from(TB_KRITERIA_DETAIL);
            $this->db->join(TB_KRITERIA, TB_KRITERIA.'.id_kriteria='.TB_KRITERIA_DETAIL.'.id_kriteria');
            $this->db->join(TB_PERIODE, TB_PERIODE.'.id_periode='.TB_KRITERIA_DETAIL.'.id_periode');
            $this->db->where(TB_KRITERIA_DETAIL.'.id_periode', $id_periode);

            return $this->db->get()->result_array();
        }

        public function get_kriteria_by_id($id_kriteria)
        {
            $this->db->select();
            $this->db->from(TB_KRITERIA);
            $this->db->where(TB_KRITERIA.'.id_kriteria', $id_kriteria);

            return $this->db->get()->result_array();
        }

        public function update_kriteria($id_kriteria, $data_kriteria)
        {
            $this->db->set($data_kriteria);
            $this->db->where('id_kriteria', $id_kriteria);
            $this->db->update(TB_KRITERIA);

            return ($this->db->affected_rows() != 1) ? false : true;
        }
    }
?>