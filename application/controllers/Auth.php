<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->form_validation = $this->form_validation;

      
    }



    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }


        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
            'required' => 'Email tidak boleh kosong !',
            'valid_email' => 'Email tidak valid !'
        ]);

        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required' => 'Password tidak boleh kosong !'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Halaman Login ';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            // validasi sukses
            $this->_login();
        }
    }

    private function _login()
    {

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();


            //user ada
            if ($user['is_active'] == 1) {

                if(password_verify($password, $user['password'])) {
                    // password benar
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    // jika role_id = 1 redirect ke admin
                    // jika role_id = 2 redirect ke user
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else if ($user['role_id'] == 2) {
                        redirect('user');
                    }
                } else {
                    // password salah
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password salah !</div>');
                    redirect('auth');
                }

            } else {
                
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email tidak terdaftar !</div>');
            redirect('auth');
        }
    
}

    public function register()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('name', 'Name', 'required|trim', [
            'required' => 'Nama tidak boleh kosong !'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'Email sudah ada !',
            'required' => 'Email tidak boleh kosong !',
            'valid_email' => 'Email tidak valid !'
        ]);

        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]', [
            'matches' => 'Password tidak sama !',
            'min_length' => 'Password harus lebih dari 6 karakter !',
            'required' => 'Password tidak boleh kosong !'
        ]);

        $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[6]|matches[password1]', [
            'matches' => 'Password tidak sama !',
            'min_length' => 'Password harus lebih dari 6 karakter !',
            'required' => 'Password tidak boleh kosong !'
        ]);



        if ($this->form_validation->run() == false) {
            $data['title'] = 'Halaman Register';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/register');
            $this->load->view('templates/auth_footer');
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 1,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Akun anda sudah terdaftar, silahkan login !</div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Anda sudah logout !</div>');
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }

    public function profile()
    {

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['title'] = 'Profile';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/footer');

        $this->load->view('auth/profile', $data);
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


        $this->form_validation->set_rules('name', 'Name', 'required|trim', [
            'required' => 'Nama Harus Diisi!'
        ]);

        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);

            $this->load->view('auth/edit', $data);

            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');


            $upload_image = $_FILES['image']['name'];
            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']     = '2048';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {

                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }


                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }
            $this->db->set('name', $name);

            $this->db->where('email', $email);
            $this->db->update('user');


            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Profile Sudah Di Edit !</div>');
            redirect('auth/profile');
        }
    }

    public function changePassword()
    {
        $data['title'] = 'Change Password';

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim', [
            'required' => 'Password Lama Harus Diisi!'
        ]);
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[6]|matches[new_password2]', [
            'required' => 'Password Baru Harus Diisi!',
            'matches' => 'Password Tidak Sama!',
            'min_length' => 'Password Minimal 6 Karakter!',
        ]);
        $this->form_validation->set_rules('new_password2', 'New Password', 'required|trim|min_length[6]|matches[new_password1]', [
            'required' => 'Password Baru Harus Diisi!',
            'matches' => 'Password Tidak Sama!',
            'min_length' => 'Password Minimal 6 Karakter!',
        ]);


        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('auth/changepassword', $data);

            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');


            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password Lama Salah !</div>');
                redirect('user/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password Baru Tidak Boleh Sama Dengan Password Lama !</div>');
                    redirect('menu/changepassword');
                } else {
                    // password ok, update to new password
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password Berhasil Diubah !</div>');
                    redirect('auth/changepassword');
                }
            }
        }
    }
}
