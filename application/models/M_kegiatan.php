<?php
    class M_kegiatan extends CI_Model
    {
        public function insert_kegiatan($data)
        {
           $this->db->insert(TB_KEGIATAN, $data);     
           return ($this->db->affected_rows() != 1) ? false : true;
        }

        public function get_kegiatan($id_periode)
        {
            $this->load->model('M_user', 'M_user');
            $user_role = $this->M_user->get_user_role_by_id_periode($id_periode)[0]['id_role'];
            if ($user_role == 1) {
                $data = $this->get_kegiatan_by_superadmin($id_periode);
            } else {            
                $data = $this->get_kegiatan_by_admin($id_periode);
            }

            return $data;
        }

        public function get_kegiatan_by_superadmin($id_periode)
        {
            $this->db->select(TB_KEGIATAN.'.*,');
            $this->db->from(TB_KEGIATAN);
            $this->db->where(TB_KEGIATAN.'.id_periode', $id_periode);
            $data = $this->db->get()->result_array();
            $data_kegiatan = $this->manipulate_kegiatan_by_super_admin($data);
            return $data_kegiatan;
        }

        public function manipulate_kegiatan_by_super_admin($data)
        {
            $data_kegiatan = $data;

            $i = 0;
            foreach ($data as $DATA) {
                $data_kegiatan[$i]['nama_member'] = '';
                $data_kegiatan[$i]['id_member'] = '';
                $data_kegiatan[$i]['id_sie'] = '';

                $i++;
            }

            return $data_kegiatan;
        }

        public function get_kegiatan_by_admin($id_periode)
        {
            $this->db->select(TB_KEGIATAN.'.*,'.TB_MEMBER.'.nama_member,'.TB_MEMBER.'.id_member,'.TB_SIE.'.id_sie');
            $this->db->from(TB_KEGIATAN);
            $this->db->join(TB_PANITIA, TB_PANITIA.'.id_kegiatan='.TB_KEGIATAN.'.id_kegiatan');
            $this->db->join(TB_MEMBER, TB_MEMBER.'.id_member='.TB_PANITIA.'.id_member');
            $this->db->join(TB_SIE, TB_SIE.'.id_sie='.TB_PANITIA.'.id_sie');
            $this->db->where(TB_KEGIATAN.'.id_periode', $id_periode);
            $this->db->where(TB_PANITIA.'.id_member', $this->session->userdata('id_member'));

            return $this->db->get()->result_array();
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