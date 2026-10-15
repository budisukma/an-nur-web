<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        
    }

    public function index()
    {

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $data['title'] = 'Menu Management';

        $this->form_validation->set_rules('menu', 'Menu', 'required|trim|is_unique[user_menu.menu]', [
            'is_unique' => 'This menu already exists!'
        ]);




        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/footer');

            $this->load->view('menu/index', $data);
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu Berhsil Di Tambah!</div>');
            redirect('menu');
        }
    }

    public function delete($id)
    {
        $this->db->delete('user_menu', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu Berhasil Di Hapus!</div>');
        redirect('menu');
    }
    
    public function deletesubmenu($id)
    {
        $this->db->delete('user_sub_menu', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Submenu Berhasil Dihapus!</div>');
        redirect('menu/submenu');
    }

    public function editsubmenu($id)
    {
        $this->load->model('Menu_model', 'menu');
    
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Submenu Management';
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['subMenu'] = $this->menu->getSubMenu();
    
        // Cek apakah form di-submit
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('menu_id', 'Menu', 'required');
            $this->form_validation->set_rules('url', 'URL', 'required');
            $this->form_validation->set_rules('icon', 'Icon', 'required');
    
            if ($this->form_validation->run() == false) {
                $data['editSubmenu'] = $this->menu->getSubMenuById($id);
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('menu/submenu', $data);
                $this->load->view('templates/footer');
            } else {
                // Kalau validasi OK, update submenu
                $is_active = $this->input->post('is_active') ? 1 : 0;
                $updateData = [
                    'title' => $this->input->post('title'),
                    'menu_id' => $this->input->post('menu_id'),
                    'url' => $this->input->post('url'),
                    'icon' => $this->input->post('icon'),
                    'is_active' => $is_active
                ];
    
                $this->db->where('id', $id);
                $this->db->update('user_sub_menu', $updateData);
    
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Submenu berhasil diupdate!</div>');
                redirect('menu/submenu');
            }
        } else {
            // Pertama kali tampilkan modal edit
            $data['editSubmenu'] = $this->menu->getSubMenuById($id);
    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        }
    }
    



    public function submenu()
    {
        $data['user'] = $this->db
            ->get_where('user', ['email' => $this->session->userdata('email')])
            ->row_array();

        $data['title'] = 'Submenu Management';

        // Load model terlebih dahulu
        $this->load->model('Menu_model', 'menu');
        $data['subMenu'] = $this->menu->getSubMenu(); 
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'icon', 'required');


        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];

            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Submenu Berhasil Di Tambah!</div>');
            redirect('menu/submenu');
        }
    }

    public function role()
    {
        $data['title'] = 'Role Management';

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/footer');

        $this->load->view('menu/role', $data);
    }
    
    public function roleaccess($role_id)
    {
        $data['title'] = 'Role Access Management';

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

      
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/footer');

        $this->load->view('menu/role-access', $data);
    }

    public function changeaccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Berhasil Di Ganti!</div>');
    }

    
}
