<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->library('form_validation');
    }

    public function index(){
        if (!$this->session->userdata('is_login')) {
            $this->session->set_flashdata('message', 'Sebelum mengakses halaman Admin, Anda harus login');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('admin/login'));
        }
        $data['total_ulasan'] = $this->Admin_model->total_ulasan();
        $data['total_pengguna'] = $this->Admin_model->total_pengguna();
        $data['total_resep'] = $this->Admin_model->total_resep();
        $data['aktivitas'] = $this->Admin_model->get_aktivitas_by_jenis(null, 6);
        $this->load->view('admin/dashboard', $data);
    }

    public function login(){
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('Admin/login');
        } else {
            $this->_login();
        }
    }

    private function _login(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $admin = $this->Admin_model->get_admin_by_username($username);

        if ($admin && password_verify($password, $admin['password_admin'])) {
            $data = [
                'id_admin' => $admin['id_admin'],
                'nama_admin' => $admin['nama_admin'],
                'password_admin' => $admin['password_admin'],
                'is_login' => true
            ];
            $this->session->set_userdata($data);
            redirect('admin');
        } else {
            $this->session->set_flashdata('message', 'Username atau password salah!');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect('admin/login');
        }
    }

    public function kelola_resep(){

        if (!$this->session->userdata('is_login')) {
            $this->session->set_flashdata('message', 'Sebelum mengakses halaman Kelola Resep, Anda harus login');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('admin/login'));
        }

        $data['resep'] = $this->Admin_model->get_resep();
        $this->load->view('admin/kelola_resep', $data);
    }

    public function kelola_pengguna($id_pengguna=null){
        if (!$this->session->userdata('is_login')) {
            $this->session->set_flashdata('message', 'Sebelum mengakses halaman Kelola Pengguna, Anda harus login');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('admin/login'));
        }

        $data['data_pengguna'] = $this->Admin_model->get_pengguna_dan_pelanggan();  
        $data['pelanggan'] = $this->Admin_model->get_pelanggan($id_pengguna);
        $data['pengguna'] = $this->Admin_model->get_pengguna($id_pengguna);
        $this->load->view('Admin/kelola_pengguna', $data);
    }

    public function tambah_pengguna(){
        if (!$this->session->userdata('is_login')) {
            $this->session->set_flashdata('message', 'Sebelum mengakses halaman Tambah Pengguna, Anda harus login');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('admin/login'));
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[pengguna.nama_pengguna]', [
			'is_unique' => 'Nama pengguna ini sudah terdaftar. Silakan pilih nama lain.'
		]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[pengguna.email]', [
			'is_unique' => 'Email ini sudah digunakan. Silakan pilih email lain.'
		]);
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]', [
			'min_length' => 'Password minimal harus memiliki 6 karakter.'
		]);
		$this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]', [
			'matches' => 'Konfirmasi password tidak sesuai.'
		]);

        if ($this->form_validation->run() == false) {
            $this->load->view('Admin/tambah_pengguna');
        } else {
            $data = [
                'nama_pengguna' => htmlspecialchars($this->input->post('username', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'foto_profil' => 'assets/uploads/default.png', // Atur default
                'tanggal_registrasi' => date('Y-m-d'),
            ];
            $this->Admin_model->tambah_pengguna($data);
            $this->session->set_flashdata('message', 'Tambah pengguna berhasil!');
			$this->session->set_flashdata('alert-class', 'alert-success');
            redirect('admin');
        }
    }

    public function tambah_resep(){

        if (!$this->session->userdata('is_login')) {
            $this->session->set_flashdata('message', 'Sebelum mengakses halaman Tambah Resep, Anda harus login');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('admin/login'));
        }
    
        // Validasi input
        $this->form_validation->set_rules('judul_resep', 'Judul Resep', 'required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
        $this->form_validation->set_rules('bahan', 'Bahan', 'required');
        $this->form_validation->set_rules('bumbu', 'Bumbu', 'required');
        $this->form_validation->set_rules('langkah', 'Langkah', 'required');
        $this->form_validation->set_rules('kategori_resep', 'Kategori Resep', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal
            $data['kategori'] = $this->Admin_model->get_kategori();
            $this->load->view('Admin/tambah_resep', $data);
        } else {    
            $foto = null; // Default jika foto tidak diunggah
            $video = null; // Default jika video tidak diunggah
    
            // Konfigurasi untuk upload foto
            $config_foto['upload_path'] = './assets/recipe/foto/';
            $config_foto['allowed_types'] = 'jpg|jpeg|png';
            $config_foto['max_size'] = 2048; // 2MB untuk foto
            
            $this->load->library('upload', $config_foto, 'upload_foto'); 
            $this->upload->initialize($config_foto);// Load instance baru untuk foto
    
            if ($this->upload_foto->do_upload('foto_resep')) {
                $foto = $this->upload_foto->data('file_name');
            }
    
            // Konfigurasi untuk upload video
            $config_video['upload_path'] = './assets/recipe/video/';
            $config_video['allowed_types'] = 'mp4|avi';
            $config_video['max_size'] = 40960; // 10MB untuk video
            $this->load->library('upload', $config_video, 'upload_video'); 
            $this->upload->initialize($config_video);// Load instance baru untuk video
    
            if ($this->upload_video->do_upload('video_resep')) {
                $video = $this->upload_video->data('file_name');
            }
    
            $data = [
                'id_pengguna' => $this->session->userdata('id_pengguna'),
                'id_kategori' => $this->input->post('kategori_resep'),
                'judul' => $this->input->post('judul_resep'),
                'deskripsi' => $this->input->post('deskripsi'),
                'jumlah_porsi' => $this->input->post('jumlah_porsi'),
                'waktu_masak' => $this->input->post('durasi_masak'),
                'bahan' => $this->input->post('bahan'),
                'bumbu' => $this->input->post('bumbu'),
                'langkah' => $this->input->post('langkah'),
                'foto' => $foto,
                'video' => $video,
                'tanggal_pembuatan' => date('Y-m-d')
            ];
    
            // Simpan ke database
            $this->db->insert('resep', $data);
    
            $this->session->set_flashdata('message', 'Resep berhasil diunggah!');
            $this->session->set_flashdata('alert-class', 'alert-success');
            redirect(base_url('admin/kelola_resep')); // Redirect ke halaman resep saya
            }
    }

    public function edit_resep($id_resep){

        if (!$this->session->userdata('is_login')) {
            $this->session->set_flashdata('message', 'Sebelum mengakses halaman Edit Resep, Anda harus login');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('admin/login'));
        }
    
        // Ambil data resep berdasarkan ID
        $data['resep'] = $this->Admin_model->get_resep_by_id($id_resep);
        if (!$data['resep']) {
            $this->session->set_flashdata('message', 'Resep tidak ditemukan!');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('admin/edit_resep')); // Redirect ke halaman daftar resep
        }
    
        // Validasi input
        $this->form_validation->set_rules('judul_resep', 'Judul Resep', 'required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
        $this->form_validation->set_rules('bahan', 'Bahan', 'required');
        $this->form_validation->set_rules('bumbu', 'Bumbu', 'required');
        $this->form_validation->set_rules('langkah', 'Langkah', 'required');
        $this->form_validation->set_rules('kategori_resep', 'Kategori Resep', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal
            $data['kategori'] = $this->Admin_model->get_kategori();
            $this->load->view('Admin/edit_resep', $data);
        } else {
            $foto = $data['resep']['foto']; // Default foto lama
            $video = $data['resep']['video']; // Default video lama
    
            // Konfigurasi untuk upload foto
            $config_foto['upload_path'] = './assets/recipe/foto/';
            $config_foto['allowed_types'] = 'jpg|jpeg|png';
            $config_foto['max_size'] = 2048; // 2MB untuk foto
            
            $this->load->library('upload', $config_foto, 'upload_foto'); 
            $this->upload->initialize($config_foto);// Load instance baru untuk foto
    
            if ($this->upload_foto->do_upload('foto_resep')) {
                $foto = $this->upload_foto->data('file_name');
            }
    
            // Konfigurasi untuk upload video
            $config_video['upload_path'] = './assets/recipe/video/';
            $config_video['allowed_types'] = 'mp4|avi';
            $config_video['max_size'] = 40960; // 10MB untuk video
            $this->load->library('upload', $config_video, 'upload_video'); 
            $this->upload->initialize($config_video);// Load instance baru untuk video
    
            if ($this->upload_video->do_upload('video_resep')) {
                $video = $this->upload_video->data('file_name');
            }
    
            $data_update = [
                'id_kategori' => $this->input->post('kategori_resep'),
                'judul' => $this->input->post('judul_resep'),
                'deskripsi' => $this->input->post('deskripsi'),
                'jumlah_porsi' => $this->input->post('jumlah_porsi'),
                'waktu_masak' => $this->input->post('durasi_masak'),
                'bahan' => $this->input->post('bahan'),
                'bumbu' => $this->input->post('bumbu'),
                'langkah' => $this->input->post('langkah'),
                'foto' => $foto,
                'video' => $video,
                'tanggal_pembuatan' => date('Y-m-d')
            ];
    
            // Update data ke database
            $this->db->where('id_resep', $id_resep);
            $this->db->update('resep', $data_update);
    
            $this->session->set_flashdata('message', 'Resep berhasil diperbarui!');
            $this->session->set_flashdata('alert-class', 'alert-success');
            redirect(base_url('admin/kelola_resep')); // Redirect ke halaman resep saya
        }
    }

    public function edit_pengguna($id_pengguna){


        if (!$this->session->userdata('is_login')) {
            $this->session->set_flashdata('message', 'Sebelum mengakses halaman Edit Pengguna, Anda harus login');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('admin/login'));
        }

        $data['pengguna'] = $this->Admin_model->get_pengguna($id_pengguna);
        $this->load->view('Admin/edit_pengguna', $data);
    }

    public function hapus_pengguna($id_pengguna){
        //Apakah anda yakin ingin menghapus pengguna ini?
        $this->session->set_flashdata('message', 'Anda telah menghapus pengguna ini.');
        $this->session->set_flashdata('alert-class', 'alert-danger');
        $this->Admin_model->hapus_pengguna($id_pengguna);
        redirect('admin/kelola_pengguna');
    }

    public function laporan_ulasan(){

        if (!$this->session->userdata('is_login')) {
            $this->session->set_flashdata('message', 'Sebelum mengakses halaman Laporan Ulasan, Anda harus login');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('admin/login'));
        }

        $data['total_ulasan'] = $this->Admin_model->total_ulasan();
        $data['total_ulasan_hari_ini'] = $this->Admin_model->total_ulasan_hari_ini();
        $data['rata_rata'] = $this->Admin_model->rata_rata_rating();
        $data['total_pengguna'] = $this->Admin_model->total_pengguna();
        $data['total_resep'] = $this->Admin_model->total_resep();
        $data['ulasan'] = $this->Admin_model->get_ulasan_by_resep();

        $this->load->view('admin/laporan_ulasan', $data);
    }

    public function hapus_ulasan($id_ulasan){
        //Apakah anda yakin ingin menghapus ulasan ini?
        $this->Admin_model->hapus_ulasan($id_ulasan);
        redirect('admin/laporan_ulasan');
    }


    public function logout() {
        // Menghapus semua data sesi
        $this->session->unset_userdata('id_admin');
        $this->session->unset_userdata('nama_admin');
        $this->session->unset_userdata('password_admin');
        
        // Menghapus seluruh data sesi
        $this->session->sess_destroy();
    
        // Menambahkan flash message
        $this->session->set_flashdata('message', 'Anda telah berhasil logout.');
    
        // Redirect ke halaman login
        redirect('admin/login');
        }
}
?>