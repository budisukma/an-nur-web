<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Syariah_model extends CI_Model
{

    public function getUangSyariah($tahun = null)
    {
        $this->db->select('p.*, s.nisn, s.nama, s.kelas');
        $this->db->from('pembayaran_syariah p');
        $this->db->join('santri s', 'p.nisn = s.nisn');

        if ($tahun) {
            $this->db->where('p.tahun', $tahun); // ← filter tahun
        }

        return $this->db->get()->result_array(); // ← hanya 1x return
    }

    // Other methods

    public function update($id, $data)
    {
        // Update the record with the specified ID
        $this->db->where('id', $id);  // Assuming 'id' is the primary key
        return $this->db->update('pembayaran_syariah', $data);
    }

    public function printUS($nisn, $tahun)
    {
        // Query untuk mengambil data pembayaran berdasarkan NISN dan tahun
        $this->db->where('nisn', $nisn);
        $this->db->where('tahun', $tahun);
        $query = $this->db->get('pembayaran_syariah'); // Gantilah 'pembayaran_syariah' dengan nama tabel yang sesuai

        // Mengembalikan hasil query dalam bentuk array
        return $query->result_array();
    }


    public function getUangTambahan($tahun = null)
    {
        $this->db->select('p.*, s.nisn, s.nama, s.kelas');
        $this->db->from('pembayaran_tambahan p');
        $this->db->join('santri s', 'p.nisn = s.nisn');

        if ($tahun) {
            $this->db->where('p.tahun', $tahun);
        }

        return $this->db->get()->result_array();
    }

    public function updateTambahan($id, $data)
    {
        // Update the record with the specified ID
        $this->db->where('id', $id);  // Assuming 'id' is the primary key
        return $this->db->update('pembayaran_tambahan', $data);
    }


    public function getSantri()
    {
        return $this->db->get('santri')->result_array();
    }

    public function insert()
    {
        $data = [
            'nisn' => $this->input->post('nisn'),
            'tahun' => $this->input->post('tahun'),
            'smt1' => $this->input->post('smt1'),
            'smt2' => $this->input->post('smt2'),
            'smt3' => $this->input->post('smt3'),
            'smt4' => $this->input->post('smt4'),
            'smt5' => $this->input->post('smt5'),
            'smt6' => $this->input->post('smt6'),
        ];
        $this->db->insert('pembayaran_syariah', $data);
    }

    public function getPembayaranByNisnTahun($nisn, $tahun)
    {
        return $this->db->get_where('pembayaran_syariah', ['nisn' => $nisn, 'tahun' => $tahun])->row_array();
    }

    public function updatePembayaran($nisn, $tahun)
    {
        $data = [
            'nama' => $this->input->post('nama'),
            'kelas' => $this->input->post('kelas'),
            'juli' => $this->input->post('juli'),
            'agustus' => $this->input->post('agustus'),
            'september' => $this->input->post('september'),
            'oktober' => $this->input->post('oktober'),
            'november' => $this->input->post('november'),
            'desember' => $this->input->post('desember'),
            // tambah lainnya jika ada
        ];

        $this->db->where(['nisn' => $nisn, 'tahun' => $tahun]);
        $this->db->update('pembayaran', $data);
    }

    public function hapusPembayaran($nisn, $tahun)
    {
        $this->db->where(['nisn' => $nisn, 'tahun' => $tahun]);
        $this->db->delete('pembayaran_syariah');

        $this->db->delete('pembayaran_syariah', ['nisn' => $nisn, 'tahun' => $tahun]);
        $this->db->delete('santri', ['nisn' => $nisn]);
    }


    public function getAllPembayaran()
    {
        return $this->db
            ->select('
            p.id,
            s.nisn,
            s.nama,
            s.kelas,
            p.tahun,
            p.smt1,
            p.smt2,
            p.smt3,
            p.smt4,
            p.smt5,
            p.smt6
        ')
            ->from('pembayaran_syariah p')
            ->join('santri s', 'p.nisn = s.nisn') // ✅ pakai nisn
            ->get()
            ->result_array();
    }
}
