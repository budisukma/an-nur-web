<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Syariah_model');
        is_logged_in();
    }

    public function delete($id)
    {
        $this->db->delete('user_menu', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu Berhasil Di Hapus!</div>');
        redirect('menu');
    }


    public function index()
    {

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['title'] = 'Dashboard';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/footer');

        $this->load->view('admin/index', $data);
    }

    public function pembayaransyariah()
    {

        $tahun = $this->input->get('tahun');

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['title'] = 'Pembayaran Syariah';
        $data['pembayaran'] = $this->Syariah_model->getUangSyariah($tahun);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/footer');

        $this->load->view('admin/pembayaransyariah', $data);
    }

    public function tambah()
    {
        $nisn = $this->input->post('nisn');
        $smt1 = $this->input->post('smt1');
        $smt2 = $this->input->post('smt2');
        $smt3 = $this->input->post('smt3');
        $smt4 = $this->input->post('smt4');
        $smt5 = $this->input->post('smt5');
        $smt6 = $this->input->post('smt6');
        $tahun = $this->input->post('tahun');

        // Ambil data santri berdasarkan nama dan kelas (pastikan kombinasi unik)
        $santri = $this->db->get_where('santri', ['nisn' => $nisn])->row();

        if ($santri) {
            $data = [
                'nisn'   => $santri->nisn,
                'smt1'  => $smt1,
                'smt2'  => $smt2,
                'smt3'  => $smt3,
                'smt4'  => $smt4,
                'smt5'  => $smt5,
                'smt6'  => $smt6,
                'tahun' => $tahun
            ];
            $this->db->insert('pembayaran_syariah', $data);
            $this->session->set_flashdata('success', 'Data pembayaran syariah berhasil ditambahkan.');
        } else {
            $this->session->set_flashdata('error', 'Santri tidak ditemukan. Pastikan nisn dengan benar.');
        }

        redirect('admin/pembayaransyariah');
    }

    public function edit()
    {
        $id = $this->input->post('id');
        $data = [
            'smt1' => $this->input->post('smt1'),
            'smt2' => $this->input->post('smt2'),
            'smt3' => $this->input->post('smt3'),
            'smt4' => $this->input->post('smt4'),
            'smt5' => $this->input->post('smt5'),
            'smt6' => $this->input->post('smt6'),
            'tahun' => $this->input->post('tahun')
        ];

        $this->Syariah_model->update($id, $data);
        $this->session->set_flashdata('message', 'Data berhasil diperbarui!');
        redirect('admin/pembayaransyariah');
    }



    public function print($nisn, $tahun)
    {
        $data['title'] = 'Print Pembayaran';
        // Ambil data berdasarkan nisn dan tahun
        $data['pembayaran'] = $this->Syariah_model->printUS($nisn, $tahun);

        // Menambahkan flag untuk proses cetak
        $data['is_print'] = true;

        // Load view yang sama untuk proses print
        $this->load->view('admin/pembayaransyariah', $data);
    }





    public function hapus($id)
    {
        $this->db->delete('pembayaran_syariah', ['id' => $id]);
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">Data pembayaran berhasil dihapus!</div>'
        );
        redirect('admin/pembayaransyariah');
    }




    public function pembayarantambahan()
    {
        $tahun = $this->input->get('tahun');

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Pembayaran Tambahan';
        $data['pembayaran'] = $this->Syariah_model->getUangTambahan($tahun); // Pastikan ini dikirim!

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/pembayarantambahan', $data);
        $this->load->view('templates/footer');
    }

    public function tambahPembayarTambahan()
    {

        $data['pembayaran'] = $this->Syariah_model->getUangTambahan($tahun);

        $nisn = $this->input->post('nisn');
        $daful = $this->input->post('daful');
        $qurban = $this->input->post('qurban');
        $ifthar = $this->input->post('ifthar');
        $tahun = $this->input->post('tahun');

        // Ambil data santri berdasarkan nama dan kelas (pastikan kombinasi unik)
        $santri = $this->db->get_where('santri', ['nisn' => $nisn])->row();

        if ($santri) {
            $data = [
                'nisn'   => $santri->nisn,  // Akses objek dengan ->
                'daful'  => $daful,
                'qurban' => $qurban,
                'ifthar' => $ifthar,
                'tahun' => $tahun
            ];
            $this->db->insert('pembayaran_tambahan', $data);
            $this->session->set_flashdata('success', 'Data pembayaran tambahan berhasil ditambahkan.');
        } else {
            $this->session->set_flashdata('error', 'Santri tidak ditemukan. Pastikan nisn dengan benar.');
        }

        redirect('admin/pembayarantambahan');
    }

    public function editTambahan()
    {
        
        $nisn = $this->input->post('nisn');
        $daful = $this->input->post('daful');
        $qurban = $this->input->post('qurban');
        $ifthar = $this->input->post('ifthar');
        $tahun = $this->input->post('tahun');

        $data = [
            'nisn' => $nisn,
            'daful' => $daful,
            'qurban' => $qurban,
            'ifthar' => $ifthar,
            'tahun' => $tahun
        ];

        $this->db->where('nisn', $nisn);
        $this->db->update('pembayaran_tambahan', $data); // Pastikan nama tabelnya benar

        $this->session->set_flashdata('success', 'Data pembayaran tambahan berhasil diperbarui.');
        redirect('admin/pembayarantambahan');
    }


    public function tambahIuran()
    {
        // Ambil input dari form
        $nama = $this->input->post('nama', true); // true untuk XSS filter

        // Simpan ke database
        $data = [
            'nama' => $nama
        ];

        $this->db->insert('pembayaran_tambahan', $data);

        // Set flash message jika perlu
        $this->session->set_flashdata('pesan', '<div class="alert alert-success">Iuran berhasil ditambahkan!</div>');

        // Redirect kembali ke halaman admin/index
        redirect('admin');
    }



    public function updateIuran($id)
    {
        $nama = $this->input->post('nama', true);
        $old = $this->db->get_where('pembayaran_tambahan', ['id' => $id])->row_array();

        $old_column = strtolower(str_replace(' ', '_', $old['nama']));
        $new_column = strtolower(str_replace(' ', '_', $nama));

        $this->db->where('id', $id)->update('pembayaran_tambahan', ['nama' => $nama]);

        if ($old_column !== $new_column && $this->db->field_exists($old_column, 'pembayaran')) {
            $this->db->query("ALTER TABLE pembayaran CHANGE `$old_column` `$new_column` DATE DEFAULT '0000-00-00'");
        }
    }


    public function hapusPembayarTambahan($id)
    {
        $this->db->delete('pembayaran_tambahan', ['id' => $id]);
        $this->session->set_flashdata('success', 'Data pembayaran tambahan berhasil dihapus!.');
        redirect('admin/pembayarantambahan');
    }



    public function printr($nisn, $tahun)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['title'] = 'Print Pembayaran';
        $data['pembayaran'] = $this->Syariah_model->getPembayaranByNisnTahun($nisn, $tahun);

        if (!$data['pembayaran']) {
            show_404(); // Jika data tidak ditemukan
        }

        $this->load->view('admin/print', $data);
    }



    public function buktitransfer()
    {

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['title'] = 'Bukti Transfer';
        $data['pembayaran'] = $this->Syariah_model->getAll();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/footer');

        $this->load->view('admin/buktitransfer', $data);
    }

    public function informasiiuran()
    {

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['title'] = 'Informasi Iuran';
        $data['pembayaran'] = $this->Syariah_model->getAll();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/footer');

        $this->load->view('admin/informasiiuran', $data);
    }

    public function syaratpulang()
    {

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['title'] = 'Persyaratan Pulang';
        $data['bukti_transfer'] = $this->db->get('bukti_transfer')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/footer');

        $this->load->view('admin/syaratpulang', $data);
    }

    public function role()
    {

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        $data['title'] = 'Role Management';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/footer');

        $this->load->view('menu/role', $data);
    }

    public function roleaccess($role_id)
    {

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $data['title'] = 'Role Access Management';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/footer');

        $this->load->view('menu/role-access', $data);
    }
}
