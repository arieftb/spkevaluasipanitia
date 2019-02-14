<?php
class M_penilaian extends CI_Model
{

    public function get_nilai_by_sie($id_kegiatan)
    {
        $this->load->model('M_sie', 'M_sie');
        $id_sie = $this->M_sie->get_sie_by_kegiatan_and_member($id_kegiatan)[0]['id_sie'];

        $this->db->from(TB_PENILAIAN);
        $this->db->join(TB_PANITIA, TB_PANITIA . '.id_panitia=' . TB_PENILAIAN . '.id_panitia');
        $this->db->join(TB_MEMBER, TB_MEMBER . '.id_member=' . TB_PANITIA . '.id_member');
        $this->db->join(TB_KRITERIA, TB_KRITERIA . '.id_kriteria=' . TB_PENILAIAN . '.id_kriteria');
        $this->db->where(TB_PANITIA . '.id_kegiatan', $id_kegiatan);
        $this->db->where(TB_PANITIA . '.id_sie', $id_sie);

        return $this->db->get()->result_array();
    }

    public function get_nilai_by_kegiatan($id_kegiatan)
    {
        $this->db->from(TB_PENILAIAN);
        $this->db->join(TB_PANITIA, TB_PANITIA . '.id_panitia=' . TB_PENILAIAN . '.id_panitia');
        $this->db->join(TB_MEMBER, TB_MEMBER . '.id_member=' . TB_PANITIA . '.id_member');
        $this->db->join(TB_KRITERIA, TB_KRITERIA . '.id_kriteria=' . TB_PENILAIAN . '.id_kriteria');
        $this->db->where(TB_PANITIA . '.id_kegiatan', $id_kegiatan);

        return $this->db->get()->result_array();
    }

    public function get_data_nilai_table($data_panitia, $data_kriteria, $data_nilai)
    {
        $data_nilai_table = array();

        for ($i = 0; $i <= sizeof($data_panitia); $i++) {
            for ($j = 0; $j <= sizeof($data_kriteria); $j++) {
                if ($i == 0 && $j == 0) {
                    $data_nilai_table[$i][$j] = '';
                } else if ($i == 0 && $j > 0) {
                    $data_nilai_table[$i][$j] = $data_kriteria[$j - 1]['nama_kriteria'];
                } else {
                    if ($i > 0 && $j == 0) {
                        $data_nilai_table[$i][$j] = $data_panitia[$i - 1]['nama_member'];
                    } else {
                        for ($k = 0; $k < sizeof($data_nilai); $k++) {
                            if ($data_nilai[$k]['id_kriteria'] == $data_kriteria[$j - 1]['id_kriteria'] && $data_nilai[$k]['id_panitia'] == $data_panitia[$i - 1]['id_panitia']) {
                                $data_nilai_table[$i][$j] = $data_nilai[$k]['nilai_penilaian'];
                                break;
                            }
                        }
                    }
                }
            }
        }

        return $data_nilai_table;
    }

    public function get_data_nilai_perkriteria($data_nilai_table, $data_kriteria)
    {
        $data_nilai_perkriteria = array();
        $data_nilai_pasangan = array();

        for ($i = 1; $i < sizeof($data_nilai_table[0]); $i++) {
            for ($j = 0; $j <= sizeof($data_nilai_table); $j++) {
                for ($k = 0; $k < sizeof($data_nilai_table); $k++) {
                    if ($j == 0 && $k == 0) {
                        $data_nilai_pasangan[$j][$k] = $data_nilai_table[0][$i];
                    } else if ($j == 0 && $k > 0 && $j != sizeof($data_nilai_table)) {
                        $data_nilai_pasangan[$j][$k] = $data_nilai_table[$k][0];
                    } else if ($j > 0 && $k == 0 && $j != sizeof($data_nilai_table)) {
                        $data_nilai_pasangan[$j][$k] = $data_nilai_table[$j][0];
                    } else if ($j != sizeof($data_nilai_table)) {
                        // echo 'urutan k : '.$k.'<br/>';
                        // echo 'urutan i : '.$i.'<br/>';
                        // echo 'urutan j : '.$j.'<br/>';
                        // echo $data_nilai_table[$k][$i]." / ".$data_nilai_table[$j][$i].'</br>';
                        // echo 'hasilnya '.$data_nilai_table[$k][$i]/$data_nilai_table[$j][$i].'</br>';
                        $data_nilai_pasangan[$j][$k] = (float) $data_nilai_table[$k][$i] / $data_nilai_table[$j][$i];
                    } else {
                        if ($k == 0) {
                            $data_nilai_pasangan[$j][$k] = 'Jumlah';
                        } else {
                            $sum_nilai = 0;
                            for ($l = 0; $l < sizeof($data_nilai_pasangan) - 1; $l++) {
                                if ($l > 0) {
                                    $sum_nilai = $sum_nilai + $data_nilai_pasangan[$l][$k];
                                }
                            }

                            // $data_compared_matrix[$i][$j] = round($sum_nilai, 14);

                            $data_nilai_pasangan[$j][$k] = (float) $sum_nilai;
                        }
                    }
                }
            }

            $data_nilai_perkriteria[$i - 1] = $data_nilai_pasangan;
        }

        return $data_nilai_perkriteria;
    }

    public function get_data_nilai_normalisasi($data_nilai_perkriteria)
    {
        $data_nilai_pasangan = array();
        $data_nilai_normalisasi = array();

        for ($i = 0; $i < sizeof($data_nilai_perkriteria); $i++) {
            for ($j = 0; $j < sizeof($data_nilai_perkriteria[$i]) - 1; $j++) {
                for ($k = 0; $k <= sizeof($data_nilai_perkriteria[$i][$j]); $k++) {
                    if ($k < sizeof($data_nilai_perkriteria[$i][$j])) {
                        if ($j == 0) {
                            $data_nilai_pasangan[$j][$k] = $data_nilai_perkriteria[$i][$j][$k];
                        } else if ($k == 0) {
                            $data_nilai_pasangan[$j][$k] = $data_nilai_perkriteria[$i][$j][$k];
                        } else {

                            $data_nilai_pasangan[$j][$k] = (float) $data_nilai_perkriteria[$i][$j][$k] / $data_nilai_perkriteria[$i][sizeof($data_nilai_perkriteria[$i]) - 1][$k];
                        }
                    } else {
                        if ($j == 0 && $k == sizeof($data_nilai_perkriteria[$i][$j])) {
                            $data_nilai_pasangan[$j][$k] = 'Bobot';
                        } else {
                            if ($k == sizeof($data_nilai_perkriteria[$i][$j])) {
                                $sum_eigen = 0;
                                for ($l = 1; $l < sizeof($data_nilai_pasangan[$j]); $l++) {
                                    $sum_eigen = (float) ($sum_eigen + $data_nilai_pasangan[$j][$l]);
                                }

                                $data_nilai_pasangan[$j][$k] = (float) ($sum_eigen / (sizeof($data_nilai_perkriteria[$i][0]) - 1));
                            }
                        }
                    }
                }
            }

            $data_nilai_normalisasi[$i] = $data_nilai_pasangan;
        }

        return $data_nilai_normalisasi;
    }

    public function get_data_nilai_hasil($data_nilai_normalisasi, $data_kriteria, $data_panitia)
    {
        $data_nilai_hasil = array();

        for ($i = 0; $i <= sizeof($data_nilai_normalisasi[0]); $i++) {
            for ($j = 0; $j <= sizeof($data_kriteria) + 1; $j++) {
                if ($i == 0 && $j == 0) {
                    $data_nilai_hasil[$i][$j] = '';
                } else if ($i == 0 && $j > 0 && $j < sizeof($data_kriteria) + 1) {
                    $data_nilai_hasil[$i][$j] = $data_kriteria[$j - 1]['nama_kriteria'];
                } else if ($i == 0 && $j == sizeof($data_kriteria) + 1) {
                    $data_nilai_hasil[$i][$j] = 'Hasil';
                } else if ($i == 1) {
                    if ($j == 0) {
                        $data_nilai_hasil[$i][$j] = 'Bobot Kriteria';
                    } else if ($j < sizeof($data_kriteria) + 1) {
                        $data_nilai_hasil[$i][$j] = $data_kriteria[$j - 1]['bobot_kriteria'];
                    } else {
                        $data_nilai_hasil[$i][$j] = '';
                    }
                } else {
                    if ($j == 0) {
                        $data_nilai_hasil[$i][$j] = $data_panitia[$i - 2]['nama_member'];
                    } else if ($j > 0 && $j <= sizeof($data_kriteria)) {
                        $data_nilai_hasil[$i][$j] = $data_nilai_normalisasi[$j - 1][$i - 1][sizeof($data_panitia) + 1];
                    } else {
                        // $data_nilai_hasil[$i][$j] = 'v';

                        $sum_hasil = 0;
                        for ($k=2; $k < sizeof($data_nilai_hasil); $k++) { 
                            for ($l=1; $l < sizeof($data_nilai_hasil[0]) - 1; $l++) { 
                                $sum_hasil = $sum_hasil + ($data_nilai_hasil[1][$l] * $data_nilai_hasil[$k][$l]);
                            }
                        }

                        $data_nilai_hasil[$i][$j] = $sum_hasil;
                    }
                }
            }
        }
        return $data_nilai_hasil;
    }

    // echo 'urutan k : '.$k.'<br/>';
    // echo 'urutan i : '.$i.'<br/>';
    // echo $data_nilai_table[$k][$i]." / ".$data_nilai_table[$j][$i].'</br>';
    // echo 'hasilnya '.$data_nilai_table[$k][$i]/$data_nilai_table[$j][$i].'</br>';

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
        for ($i = 0; $i < sizeof($data_nilai['id_kriteria']); $i++) {
            for ($j = 0; $j < sizeof($data_nilai['id_panitia']); $j++) {
                for ($k = $l; $k < sizeof($data_nilai['nilai_kriteria']); $k++) {
                    $data = array(
                        'id_panitia' => $data_nilai['id_panitia'][$j],
                        'id_kriteria' => $data_nilai['id_kriteria'][$i],
                        'nilai_penilaian' => $data_nilai['nilai_kriteria'][$k],
                    );

                    $data_penilaian[$k] = $data;
                    $l++;
                    break;
                }
            }
        }

        return $data_penilaian;
    }
}
