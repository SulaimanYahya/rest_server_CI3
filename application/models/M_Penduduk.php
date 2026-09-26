<?php

class M_Penduduk extends CI_Model
{
    public function getPenduduk($id = null, $kd_desa = null)
    {
        if ($id !== null) {
            return $this->db->get_where('penduduk', ['id' => $id])->row_array();
        }

        if ($kd_desa !== null) {
            return $this->db->get_where('penduduk', ['kd_desa' => $kd_desa])->result_array();
        }

        return $this->db->get('penduduk')->result_array();
    }

    public function deletePenduduk($id)
    {
        $this->db->delete('penduduk', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function createPenduduk($data)
    {
        $this->db->insert('penduduk_baru', $data);
        return $this->db->affected_rows();
    }

    public function updatePenduduk($id, $data)
    {
        $this->db->update('penduduk_baru', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}
