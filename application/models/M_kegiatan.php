<?php
    class M_kegiatan extends CI_Model
    {
        public function insert_kegiatan($data)
        {
           $this->db->insert(TB_KEGIATAN, $data);     
           return ($this->db->affected_rows() != 1) ? false : true;
        }

        public function get_kegiatan()
        {
            if ($this->session->userdata('role') == 0) {
                $data = $this->get_kegiatan_by_superadmin();
            } else {
                
            }

            return $data;
        }

        private function get_kegiatan_by_superadmin()
        {
            return $this->db->get(TB_KEGIATAN)->result_array();
        }


        public function get_kegiatan_by_id($id)
        {
            if($this->session->userdata('role') == 0) {
                $data = $this->get_kegiatan_by_id_superadmin($id);
            } else {

            }

            return $data;
        }

        private function get_kegiatan_by_id_superadmin($id)
        {
            $this->db->from(TB_KEGIATAN);
            $this->db->where('id', $id);

            return $this->db->get()->result_array();
        }


        public function remove_kegiatan($id) {
            if($this->session->userdata('role') == 0) {
                $status = $this->remove_kegiatan_by_superadmin($id);
            } else {

            }

            return $status;
        }

        private function remove_kegiatan_by_superadmin($id)
        {
            $this->db->where('id', $id);
            $this->db->delete(TB_KEGIATAN);

            return ($this->db->affected_rows() != 1) ? false : true;
        }

        public function update_kegiatan($id, $data)
        {
            if($this->session->userdata('role') == 0) {
                $status = $this->update_kegiatan_by_superadmin($id, $data);
            } else {

            }

            return $status;
        }

        private function update_kegiatan_by_superadmin($id, $data)
        {
            $this->db->set($data);
            $this->db->where('id', $id);
            $this->db->update(TB_KEGIATAN);

            return ($this->db->affected_rows() != 1) ? false : true;
        }
    }

?>