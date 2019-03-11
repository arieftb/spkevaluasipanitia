<?php
class M_kriteria extends CI_Model
{
    public function get_kriteria()
    {
        $this->db->from(TB_KRITERIA);
        return $this->db->get()->result_array();
    }

    public function get_kriteria_detail($id_periode)
    {
        $this->db->select();
        $this->db->from(TB_KRITERIA_DETAIL);
        $this->db->join(TB_KRITERIA, TB_KRITERIA . '.id_kriteria=' . TB_KRITERIA_DETAIL . '.id_kriteria');
        $this->db->join(TB_PERIODE, TB_PERIODE . '.id_periode=' . TB_KRITERIA_DETAIL . '.id_periode');
        $this->db->where(TB_KRITERIA_DETAIL . '.id_periode', $id_periode);

        return $this->db->get()->result_array();
    }

    public function get_kriteria_detail_by_priority($id_periode)
    {
        $this->db->select();
        $this->db->from(TB_KRITERIA_DETAIL);
        $this->db->join(TB_KRITERIA, TB_KRITERIA . '.id_kriteria=' . TB_KRITERIA_DETAIL . '.id_kriteria');
        $this->db->join(TB_PERIODE, TB_PERIODE . '.id_periode=' . TB_KRITERIA_DETAIL . '.id_periode');
        $this->db->where(TB_KRITERIA_DETAIL . '.id_periode', $id_periode);
        $this->db->order_by(TB_KRITERIA_DETAIL.'.bobot_kriteria', "desc");

        return $this->db->get()->result_array();
    }

    public function get_kriteria_by_id($id_kriteria)
    {
        $this->db->select();
        $this->db->from(TB_KRITERIA);
        $this->db->where(TB_KRITERIA . '.id_kriteria', $id_kriteria);

        return $this->db->get()->result_array();
    }

    public function get_kriteria_pasangan_by_periode($id_periode)
    {
        $this->db->select(TB_KRITERIA_PASANGAN . '.*,' . 'KRITERIA_1.id_kriteria as id_kriteria_1, KRITERIA_1.nama_kriteria as nama_kriteria_1, KRITERIA_2.id_kriteria as id_kriteria_2, KRITERIA_2.nama_kriteria as nama_kriteria_2,' . TB_PERIODE . '.*');
        $this->db->from(TB_KRITERIA_PASANGAN);
        $this->db->join(TB_KRITERIA . ' as KRITERIA_1', 'KRITERIA_1.id_kriteria=' . TB_KRITERIA_PASANGAN . '.id_kriteria_1');
        $this->db->join(TB_KRITERIA . ' as KRITERIA_2', 'KRITERIA_2.id_kriteria=' . TB_KRITERIA_PASANGAN . '.id_kriteria_2');
        $this->db->join(TB_PERIODE, TB_PERIODE . '.id_periode=' . TB_KRITERIA_PASANGAN . '.id_periode');
        $this->db->where(TB_KRITERIA_PASANGAN . '.id_periode', $id_periode);

        return $this->db->get()->result_array();
    }

    public function get_kriteria_compared_matrix($data_kriteria_pasangan, $data_kriteria_detail)
    {
        $data_compared_matrix = array();

        for ($i = 0; $i < sizeof($data_kriteria_detail) + 2; $i++) {
            for ($j = 0; $j < sizeof($data_kriteria_detail) + 1; $j++) {
                if ($i == 0) {
                    if ($j == 0) {
                        $data_compared_matrix[$i][$j] = 'Kriteria';
                    } else {
                        $data_compared_matrix[$i][$j] = $data_kriteria_detail[$j - 1]['nama_kriteria'];
                    }
                } else if ($i > 0 && $j == 0 && $i < sizeof($data_kriteria_detail) + 1) {
                    $data_compared_matrix[$i][$j] = $data_kriteria_detail[$i - 1]['nama_kriteria'];
                } else if ($i > 0 && $j > 0 && $i < sizeof($data_kriteria_detail) + 1) {
                    for ($k = 0; $k < sizeof($data_kriteria_pasangan); $k++) {
                        if ($data_kriteria_detail[$i - 1]['id_kriteria'] == $data_kriteria_pasangan[$k]['id_kriteria_1'] && $data_kriteria_detail[$j - 1]['id_kriteria'] == $data_kriteria_pasangan[$k]['id_kriteria_2']) {
                            $data_compared_matrix[$i][$j] = round($data_kriteria_pasangan[$k]['nilai_pasangan_1'], 6);
                            break;
                        } else if ($data_kriteria_detail[$i - 1]['id_kriteria'] == $data_kriteria_pasangan[$k]['id_kriteria_2'] && $data_kriteria_detail[$j - 1]['id_kriteria'] == $data_kriteria_pasangan[$k]['id_kriteria_1']) {
                            $data_compared_matrix[$i][$j] = round($data_kriteria_pasangan[$k]['nilai_pasangan_2'], 6);
                            break;
                        } else {
                            $data_compared_matrix[$i][$j] = (float) 1;
                        }
                    }
                } else {
                    if ($j == 0) {
                        $data_compared_matrix[$i][$j] = 'Jumlah';
                    } else {
                        $sum_nilai = 0;
                        for ($l = 0; $l < sizeof($data_compared_matrix) - 1; $l++) {
                            if ($l > 0) {
                                $sum_nilai = $sum_nilai + $data_compared_matrix[$l][$j];
                            }
                        }

                        $data_compared_matrix[$i][$j] = round($sum_nilai, 6);
                    }
                }
            }
        }

        return $data_compared_matrix;
    }

    public function get_kriteria_normaliasi($data_compared_matrix)
    {
        $data_normalisasi_matrix = array();
        for ($i = 0; $i < sizeof($data_compared_matrix) - 1; $i++) {
            for ($j = 0; $j <= sizeof($data_compared_matrix[$i]) + 1; $j++) {
                if ($j < sizeof($data_compared_matrix[$i])) {
                    if ($i == 0) {
                        $data_normalisasi_matrix[$i][$j] = $data_compared_matrix[$i][$j];
                    } else {
                        if ($j == 0) {
                            $data_normalisasi_matrix[$i][$j] = $data_compared_matrix[$i][$j];
                        } else {
                            $data_normalisasi_matrix[$i][$j] = round($data_compared_matrix[$i][$j] / $data_compared_matrix[sizeof($data_compared_matrix) - 1][$j], 6);
                        }
                    }

                } else {
                    if ($i == 0) {
                        if ($j == sizeof($data_compared_matrix[$i])) {
                            $data_normalisasi_matrix[$i][$j] = 'Bobot';
                        } else {
                            $data_normalisasi_matrix[$i][$j] = 'AX';
                        }
                    } else {
                        if ($j == sizeof($data_compared_matrix[$i])) {
                            $sum_eigen = 0;
                            for ($l = 1; $l < sizeof($data_normalisasi_matrix[$i]); $l++) {
                                $sum_eigen = $sum_eigen + $data_normalisasi_matrix[$i][$l];
                            }

                            $data_normalisasi_matrix[$i][$j] = round($sum_eigen / (sizeof($data_compared_matrix[0]) - 1), 6);
                        }
                    }
                }
            }
        }

        for ($i = 1; $i < sizeof($data_normalisasi_matrix); $i++) {
            $sum_prioritas = 0;
            for ($j = 1; $j < sizeof($data_compared_matrix[0]); $j++) {
                if ($i != sizeof($data_normalisasi_matrix)) {
                    $sum_prioritas = $sum_prioritas + ($data_compared_matrix[$i][$j] * $data_normalisasi_matrix[$j][sizeof($data_normalisasi_matrix[0]) - 2]);
                }
            }
            $data_normalisasi_matrix[$i][sizeof($data_normalisasi_matrix[0]) - 1] = round($sum_prioritas, 6);
        }

        return $data_normalisasi_matrix;
    }

    public function get_kriteria_status($data_normalisasi_matrix, $id_periode)
    {

        $total_kriteria = sizeof($data_normalisasi_matrix[0]) - 3;

        $t = $this->get_t_kriteria($data_normalisasi_matrix);
        $CI = $this->get_ci_kriteria($t, $total_kriteria);
        $RI = $this->get_ri_kriteria($total_kriteria);
        $nilai_konsistensi = round($CI/$RI,6);
        $is_consist = $nilai_konsistensi < 0.1 ? true : false;

        $data_consistency = array(
            array('t', $this->get_t_kriteria($data_normalisasi_matrix)),
            array('CI',$CI),
            array('RI'.$total_kriteria, $RI),
            array('Nilai Konsistensi', $nilai_konsistensi),
            array('Status', $is_consist ? 'Konsisten': 'Tidak Konsisten'),
        );

        if($is_consist) {
            $this->update_kriteria_bobot($data_normalisasi_matrix, $id_periode);
        }

        return $data_consistency;
    }

    public function get_t_kriteria($data_normalisasi_matrix)
    {
        $sum_t = 0;
        for ($j = 1; $j < sizeof($data_normalisasi_matrix); $j++) {
            $sum_t = $sum_t + ($data_normalisasi_matrix[$j][sizeof($data_normalisasi_matrix[0]) - 1] / $data_normalisasi_matrix[$j][sizeof($data_normalisasi_matrix[0]) - 2]);
        }

        $data_t = $sum_t / (sizeof($data_normalisasi_matrix[0]) - 3);

        return round($data_t, 6);
    }

    public function get_ci_kriteria($t, $total_kriteria)
    {
        return round(($t - $total_kriteria) / $total_kriteria, 6);
    }

    public function get_ri_kriteria($total_kriteria)
    {
        $data_ri = array(0,0,0,0,0.58,0.9,1.12,1.32,1.41,1.45,1.49);

        return $data_ri[$total_kriteria];
    }

    public function insert_kriteria($data_kriteria)
    {
        $this->db->insert(TB_KRITERIA, $data_kriteria);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function insert_kriteria_detail($data_kriteria_detail)
    {
        $status = true;
        for ($i = 0; $i < sizeof($data_kriteria_detail); $i++) {
            $this->db->insert(TB_KRITERIA_DETAIL, $data_kriteria_detail[$i]);

            if ($this->db->affected_rows() != 1) {
                $status = false;
            } else {
                // $status = false;
            }

        }

        return $status;
    }

    public function insert_kriteria_pasangan($data_kriteria_pasangan)
    {
        $status = true;
        for ($i = 0; $i < sizeof($data_kriteria_pasangan); $i++) {
            $this->db->insert(TB_KRITERIA_PASANGAN, $data_kriteria_pasangan[$i]);

            if ($this->db->affected_rows() != 1) {
                $status = false;
            } else {
                // $status = false;
            }
        }

        return $status;
    }

    public function update_kriteria_bobot($data_normalisasi_matrix, $id_periode)
    {
        $data_kriteria_detail= $this->get_kriteria_detail($id_periode);

        for ($i=1; $i < sizeof($data_normalisasi_matrix); $i++) { 
            $update_kriteri_detail = array(
                'bobot_kriteria' => $data_normalisasi_matrix[$i][sizeof($data_normalisasi_matrix[0]) - 2],
                'ax_kriteria' => $data_normalisasi_matrix[$i][sizeof($data_normalisasi_matrix[0]) - 1],
            );

            $id_kriteria_detail = $data_kriteria_detail[$i - 1]['id_kriteria_detail'];

            $this->update_kriteria_detail($id_kriteria_detail, $update_kriteri_detail);
        }
    }

    public function update_kriteria_detail($id_kriteria_detail, $data_kriteria_detail)
    {
        $this->db->set($data_kriteria_detail);
        $this->db->where('id_kriteria_detail', $id_kriteria_detail);
        $this->db->update(TB_KRITERIA_DETAIL);
    }

    public function update_kriteria($id_kriteria, $data_kriteria)
    {
        $this->db->set($data_kriteria);
        $this->db->where('id_kriteria', $id_kriteria);
        $this->db->update(TB_KRITERIA);

        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function reset_kriteria_detail($id_periode)
    {
        $this->db->where('id_periode', $id_periode);

        return $this->db->delete(TB_KRITERIA_DETAIL);
    }

    public function reset_kriteria_pasangan($id_periode)
    {
        $this->db->where('id_periode', $id_periode);

        return $this->db->delete(TB_KRITERIA_PASANGAN);
    }

    public function update_kriteria_pasangan($data_kriteria_pasangan, $id_kriteria_pasangan)
    {
        $status = true;
        for ($i = 0; $i < sizeof($id_kriteria_pasangan); $i++) {
            $this->db->set($data_kriteria_pasangan[$i]);
            $this->db->where('id_kriteria_pasangan', $id_kriteria_pasangan[$i]);
            $this->db->update(TB_KRITERIA_PASANGAN);

            if ($this->db->affected_rows() != 1) {
                $status = false;
            } else {
                // $status = false;
            }
        }

        return $status;
    }
}
