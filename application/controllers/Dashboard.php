<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('User_model');
        $this->load->model('Admin_model');
		$this->load->library('form_validation');
        $this->load->config('midtrans');
        require_once(APPPATH . 'third_party/Midtrans.php');

        \Midtrans\Config::$serverKey = $this->config->item('midtrans')['server_key'];
        \Midtrans\Config::$isProduction = $this->config->item('midtrans')['is_production'];
        \Midtrans\Config::$is3ds = true;

	}

	public function index()
	{
        // Kirim data ke view
        $data['resep'] = $this->db->get('resep', 3)->result_array();
        $data['pengguna'] = $this->User_model->get_pengguna($this->session->userdata('id_pengguna'));
		$this->load->view('User/dashboard', $data);
	}

	// Halaman login
    public function login(){
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('User/login');
        } else {
            $this->_login();
        }
    }

    private function _login(){
			// Ambil data dari form
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		// Cek di database untuk username dan password
		$user = $this->User_model->get_user_by_username($username);

		if ($user && password_verify($password, $user['password'])) {
            $pelanggan = $this->User_model->get_pelanggan($user['id_pengguna']);

            $pelanggan = $this->User_model->get_pelanggan($user['id_pengguna']);
            if ($pelanggan) {
                log_message('debug', 'Pelanggan ditemukan: ' . json_encode($pelanggan));
            } else {
                log_message('debug', 'Pelanggan tidak ditemukan untuk id_pengguna: ' . $user['id_pengguna']);
            }

            if ($pelanggan && strtotime($pelanggan->tanggal_kadaluarsa) < time()) {
                // Langganan sudah kedaluwarsa, update status ke 0
                $this->User_model->update_status($user['id_pengguna'], ['status_aktif' => 0]);
                $pelanggan->status_aktif = 0;
            }

			// Login berhasil, set session
			$data = [
				'id_pengguna' => $user['id_pengguna'],
				'nama_pengguna' => $user['nama_pengguna'],
				'email' => $user['email'],
                'foto_profil' => $user['foto_profil'],
                'status_aktif' => $pelanggan ? $pelanggan->status_aktif : 0,
                'tanggal_langganan' => $pelanggan ? $pelanggan->tanggal_langganan : null,
                'tanggal_kadaluarsa' => $pelanggan ? $pelanggan->tanggal_kadaluarsa : null,
				'is_logged_in' => true,  // Flag untuk status login
			];
			$this->session->set_userdata($data);
			// Redirect ke halaman dashboard
			redirect('dashboard');
		} else {
			// Jika username/password salah
			$this->session->set_flashdata('message', 'Username atau password salah');
            $this->session->set_flashdata('alert-class', 'alert-danger');
			redirect('dashboard/login');
		}
    }

    // Halaman register
    public function register(){
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
            $this->load->view('User/register');
        } else {
            $data = [
                'nama_pengguna' => htmlspecialchars($this->input->post('username', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'foto_profil' => 'assets/uploads/default.png', // Atur default
                'tanggal_registrasi' => date('Y-m-d'),
            ];
            $this->User_model->insert_user($data);
            $this->session->set_flashdata('message', 'Pendaftaran berhasil! Silakan login.');
			$this->session->set_flashdata('alert-class', 'alert-success');
            redirect('dashboard/login');
        }
    }

    public function pencarian(){

        if($this->input->post('submit')) { // Jika tombol pencarian diklik
            $data['keyword'] = $this->input->post('keyword');
            $this->session->set_userdata('keyword', $data['keyword']);
        } else {
            $data['keyword'] = $this->session->userdata('keyword'); 
        }

        $this->load->library('pagination');
        $config['base_url'] = base_url('dashboard/kategori');
        $config['total_rows'] = $this->User_model->count_all_resep(); // Method untuk menghitung total data
        $config['per_page'] = 9; // 3 baris x 3 kolom
        $config['uri_segment'] = 3;

        // Konfigurasi tampilan pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['attributes'] = ['class' => 'page-link'];

        $config['display_pages'] = TRUE;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['resep'] = $this->User_model->get_resep_pagination($config['per_page'], $page, $data['keyword']); // Query dengan limit
        $data['pagination'] = $this->pagination->create_links();

        $data['kategori'] = $this->User_model->get_Kategori();
        $data['pengguna'] = $this->User_model->get_pengguna($this->session->userdata('id_pengguna'));
        
        $this->load->view('User/pencarian', $data);
    }

    public function kategori() {
        // Cek sesi login
        if (!$this->session->userdata('is_logged_in')) {
            $this->session->set_flashdata('message', 'Sebelum mengakses halaman Kategori Resep, Anda harus login');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('dashboard/login'));
        }
    
        // Load library dan model
        $this->load->library('pagination');
        $this->load->model('User_model');
    
        // Tangkap input kategori dari GET
        $kategori = $this->input->get('kategori', true); // Nama kategori dari form
    
        // Konfigurasi pagination
        $config['base_url'] = base_url('dashboard/kategori');
        $config['per_page'] = 9; // 3 baris x 3 kolom
        $config['uri_segment'] = 3;
    
        // Hitung total resep berdasarkan kategori (jika ada)
        if ($kategori) {
            $config['total_rows'] = $this->User_model->count_resep_by_kategori($kategori);
        } else {
            $config['total_rows'] = $this->User_model->count_all_resep();
        }
    
        // Konfigurasi tampilan pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['attributes'] = ['class' => 'page-link'];
    
        $this->pagination->initialize($config);
    
        // Ambil data resep sesuai kategori
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        if ($kategori) {
            $data['resep'] = $this->User_model->get_resep_by_kategori_pagination($kategori, $config['per_page'], $page);
        } else {
            $data['resep'] = $this->User_model->get_resep_pagination($config['per_page'], $page);
        }
    
        // Data tambahan
        $data['pagination'] = $this->pagination->create_links();
        $data['kategori'] = $this->User_model->get_Kategori();
        $data['pengguna'] = $this->User_model->get_pengguna($this->session->userdata('id_pengguna'));
        $data['selected_kategori'] = $kategori;
    
        // Load view
        $this->load->view('User/kategori', $data);
    }
    
    public function cari_kategori(){
        $id_kategori = $this->input->get('kategori');

        $data['resep'] = $this->User_model->getresepbykat($id_kategori);

        $data['kategori'] = $this->User_model->get_Kategori();

        $this->load->view('User/kategori', $data);
    }

    public function halaman_resep($id){
        $data['ulasan'] = $this->User_model->get_ulasan_by_resep($id, 4);
        $data['resep'] = $this->User_model->get_resep_by_id($id);
        $data['recipe'] = $this->User_model->get_resep_by_id_and_name($id);
        $data['pengguna'] = $this->User_model->get_pengguna($this->session->userdata('id_pengguna'));
        $this->load->view('User/halaman_resep', $data);
    }

    public function favorit(){
        if (!$this->session->userdata('is_logged_in')) {
            // Set flash message
            $this->session->set_flashdata('message', 'Sebelum mengakses halaman Favorit Resep, Anda harus login');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('dashboard/login')); // Redirect ke halaman login
        }
        $id_pengguna = $this->session->userdata('id_pengguna');

        // Ambil data favorit dari database
        $data['favorites'] = $this->User_model->get_user_favorites($id_pengguna);
        $data['pengguna'] = $this->User_model->get_pengguna($this->session->userdata('id_pengguna'));
        $this->load->view('User/favorit', $data);
    }

    public function hapus_favorit($id_resep){
        if (!$this->session->userdata('is_logged_in')) {
            // Set flash message
            $this->session->set_flashdata('message', 'Sebelum mengakses halaman Favorit Resep, Anda harus login');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('dashboard/login')); // Redirect ke halaman login
        }
        $id_pengguna = $this->session->userdata('id_pengguna');
        $hapus = $this->User_model->hapus_favorite($id_pengguna, $id_resep);

        if ($hapus) {
            $this->session->set_flashdata('message', 'Resep berhasil dihapus dari favorit.');
            $this->session->set_flashdata('alert-class', 'alert-success');
        } else {
            $this->session->set_flashdata('message', 'Gagal menghapus resep.');
            $this->session->set_flashdata('alert-class', 'alert-danger');
        }

        redirect('dashboard/favorit');;
    }

    public function premium(){

        if (!$this->session->userdata('is_logged_in')) {
            // Set flash message
            $this->session->set_flashdata('message', 'Sebelum mengakses halaman PREMIUM, Anda harus login');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('dashboard/login')); // Redirect ke halaman login
        }

        $data['pengguna'] = $this->User_model->get_pengguna($this->session->userdata('id_pengguna'));
        $this->load->view('User/premium', $data);
    }

    public function payment(){
        if (!$this->session->userdata('is_logged_in')) {
            // Set flash message
            $this->session->set_flashdata('message', 'Sebelum mengakses halaman PAYMENT, Anda harus login');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('dashboard/login')); // Redirect ke halaman login
        }
        // Load Midtrans library
        \Midtrans\Config::$serverKey = 'SB-Mid-server-ZpkeOfIOnUg_oz0Qv_G9ClQ2';
        \Midtrans\Config::$isProduction = false; // Ubah ke true jika production
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Ambil data pengguna
        $user = $this->User_model->get_User($this->session->userdata('id_pengguna'));

        // Data pembayaran
        $transaction_details = array(
            'order_id' => uniqid() . '-' . $this->session->userdata('id_pengguna'),
            'gross_amount' => 49000, // Harga langganan
        );

        $customer_details = array(
            'first_name' => $user->nama_pengguna,
            'email' => $user->email,
            'phone' => '08123456789',
        );

        $transaction = array(
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
        );

        // Token Snap Midtrans
        $snapToken = \Midtrans\Snap::getSnapToken($transaction);
        
        // Kirim token ke view
        $this->Admin_model->log_pending($this->session->userdata('id_pengguna'), 'Menunggu Pembayaran (Premium)');

        $data['snapToken'] = $snapToken;
        $data['pengguna'] = $this->User_model->get_pengguna($this->session->userdata('id_pengguna'));
        $this->load->view('User/payment', $data);
    }

    public function callback() {
        // Ambil raw data dari Midtrans
        $json_result = file_get_contents('php://input');
        $result = json_decode($json_result, true);
        $order_parts = explode('-', $result['order_id']);
        $id_pengguna = $order_parts[1];


        // Validasi transaksi
        if ($result) {
            $order_id = $result['order_id'];
            $status = $result['transaction_status'];
            $payment_type = $result['payment_type'];
            $gross_amount = $result['gross_amount'];

            if ($status === 'settlement') {
                $masa_aktif_hari = 30; // Durasi langganan premium
                $tanggal_kadaluarsa = date('Y-m-d', strtotime("+$masa_aktif_hari days"));
            } else {
                $tanggal_kadaluarsa = null; // Tidak ada tanggal kadaluarsa untuk transaksi gagal
            }

            // Simpan ke database
            $data = [
                'id_pengguna' => $id_pengguna,
                'order_id' => $result['order_id'],
                'tanggal_langganan' => date('Y-m-d'),
                'tanggal_kadaluarsa' => $tanggal_kadaluarsa,
                'status_aktif' => ($status === 'settlement') ? 1 : 0,
                'gross_amount' => $gross_amount,
                'payment_type' => $payment_type,
                'transaction_status' => $status
            ];
            $this->User_model->insert_payment($data);

            if ($status === 'settlement') {
                $this->session->set_userdata([
                    'status_aktif' => 1,
                    'tanggal_langganan' => date('Y-m-d'),
                    'tanggal_kadaluarsa' => $tanggal_kadaluarsa
                ]);
            } else {
                $this->session->set_userdata('status_aktif', 0);
            }
            
        }
    }

    public function profile(){
        if (!$this->session->userdata('is_logged_in')) {
            // Set flash message
            $this->session->set_flashdata('message', 'Sebelum mengakses halaman Favorit Resep, Anda harus login');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('dashboard/login')); // Redirect ke halaman login
        }
        $data['pengguna'] = $this->User_model->get_pengguna($this->session->userdata('id_pengguna'));
        $this->load->view('User/profile', $data);
    }

    public function profile_edit(){
        if (!$this->session->userdata('is_logged_in')) {
            $this->session->set_flashdata('message', 'Sebelum mengakses halaman ini, Anda harus login!');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('dashboard/login'));
        }

        $this->load->model('User_model'); // Pastikan Anda memiliki model untuk tabel pengguna.

        if ($this->input->post()) {
            $this->load->library('form_validation');
            
            // Validasi input
            $this->form_validation->set_rules('username', 'Nama/Username', 'required');
            $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');

            if ($this->form_validation->run() == TRUE) {
                $data = [
                    'nama_pengguna' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                ];

                if ($this->input->post('password')) {
                    $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                }

                // Upload foto profil
                if (!empty($_FILES['foto_profil']['name'])) {
                    $id_pengguna = $this->session->userdata('id_pengguna');
                    $config['upload_path'] ="./assets/uploads/";
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 2048; // Maksimal ukuran file 2MB
                    $config['file_name'] = uniqid() . '_' . $_FILES['foto_profil']['name'];

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $this->Admin_model->log_aktivitas($this->session->userdata('id_pengguna'), 'Update foto profil');

                    if ($this->upload->do_upload('foto_profil')) {
                        $data['foto_profil'] = $config['upload_path'] . $this->upload->data('file_name');

                    } else {
                        $this->session->set_flashdata('message', $this->upload->display_errors());
                        $this->session->set_flashdata('alert-class', 'alert-danger');
                        redirect(current_url());
                    }
                }

                // Update data di database
                $this->User_model->update_pengguna($this->session->userdata('id_pengguna'), $data);

                $this->session->set_flashdata('message', 'Profil berhasil diperbarui!');
                $this->session->set_flashdata('alert-class', 'alert-success');
                redirect(current_url());
            } else {
                $this->session->set_flashdata('message', validation_errors());
                $this->session->set_flashdata('alert-class', 'alert-danger');
            }
        }

        $data['pengguna'] = $this->User_model->get_pengguna($this->session->userdata('id_pengguna'));
        $this->load->view('User/profile_edit', $data);
    }

    public function profile_hapus(){
        if (!$this->session->userdata('is_logged_in')) {
            $this->session->set_flashdata('message', 'Sebelum mengakses halaman ini, Anda harus login!');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('dashboard/login'));
        }

        $this->User_model->hapus_pengguna($this->session->userdata('id_pengguna'));
        $this->session->sess_destroy();
        $this->session->set_flashdata('message', 'Profil berhasil dihapus!');
        $this->session->set_flashdata('alert-class', 'alert-success');
        redirect(base_url('dashboard'));
    }

    public function unggah_resep(){
    // Validasi input
    $this->form_validation->set_rules('judul_resep', 'Judul Resep', 'required');
    $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
    $this->form_validation->set_rules('bahan', 'Bahan', 'required');
    $this->form_validation->set_rules('bumbu', 'Bumbu', 'required');
    $this->form_validation->set_rules('langkah', 'Langkah', 'required');
    $this->form_validation->set_rules('kategori_resep', 'Kategori Resep', 'required');

    if ($this->form_validation->run() == FALSE) {
        // Jika validasi gagal
        $data['kategori'] = $this->User_model->get_kategori();
        $data['pengguna'] = $this->User_model->get_pengguna($this->session->userdata('id_pengguna'));
        $this->load->view('User/unggah_resep', $data);
    } else {
        $this->Admin_model->log_aktivitas($this->session->userdata('id_pengguna'), 'Mengunggah Resep');

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
        redirect(base_url('dashboard/unggah_resep')); // Redirect ke halaman resep saya
        }
        }

    public function kelola_resep(){
    // Cek apakah pengguna sudah login
    if (!$this->session->userdata('is_logged_in')) {
        $this->session->set_flashdata('message', 'Sebelum mengakses halaman Kelola Resep, Anda harus login');
        $this->session->set_flashdata('alert-class', 'alert-danger');
        redirect(base_url('dashboard/login')); // Redirect ke halaman Login
        }
// Ambil id pengguna yang login
        $data['resep'] = $this->User_model->getResepByPengguna($this->session->userdata('id_pengguna'));
        $data['pengguna'] = $this->User_model->get_pengguna($this->session->userdata('id_pengguna'));
        $this->load->view('User/kelola_resep', $data);
    }

    public function edit_resep($id_resep){
        // Cek apakah pengguna sudah login
        if (!$this->session->userdata('is_logged_in')) {
            $this->session->set_flashdata('message', 'Sebelum mengakses halaman Edit Resep, Anda harus login');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('dashboard/login')); // Redirect ke halaman Login
        }
    
        // Ambil data resep berdasarkan ID
        $data['resep'] = $this->User_model->get_resep_by_id($id_resep);
        if (!$data['resep']) {
            $this->session->set_flashdata('message', 'Resep tidak ditemukan!');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('dashboard/resep_saya')); // Redirect ke halaman daftar resep
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
            $data['kategori'] = $this->User_model->get_kategori();
            $data['pengguna'] = $this->User_model->get_pengguna($this->session->userdata('id_pengguna'));
            $this->load->view('User/edit_resep', $data);
        } else {
            $this->Admin_model->log_aktivitas($this->session->userdata('id_pengguna'), 'Update Data Resep');

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
            redirect(base_url('dashboard/kelola_resep')); // Redirect ke halaman resep saya
        }
    }

    public function hapus_resep($id_resep){
        // Cek apakah pengguna sudah login
        if (!$this->session->userdata('is_logged_in')) {
            $this->session->set_flashdata('message', 'Sebelum mengakses halaman Hapus Resep, Anda harus login');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('dashboard/login')); // Redirect ke halaman Login
        }
        
        $this->Admin_model->log_aktivitas($this->session->userdata('id_pengguna'), 'Hapus Data Resep');
        $this->User_model->hapus_resep($id_resep);
        $this->session->set_flashdata('message', 'Resep berhasil dihapus!');
        $this->session->set_flashdata('alert-class', 'alert-success');
        redirect(base_url('dashboard/kelola_resep')); // Redirect ke halaman resep saya
    }

    public function tambah_ulasan() {
        // Cek apakah pengguna sudah login
        if (!$this->session->userdata('is_logged_in')) {
            $this->session->set_flashdata('message', 'Sebelum memberikan Ulasan, Anda harus login terlebih dahulu');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('dashboard/login')); // Redirect ke halaman Login
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('rating', 'Rating', 'required');
        $this->form_validation->set_rules('bahan', 'Komentar', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('dashboard/halaman_resep/' . $this->input->post('id_resep'));
        } else {
            $data = [
                'id_resep' => $this->input->post('id_resep'),
                'id_pengguna' => $this->session->userdata('id_pengguna'), // Pastikan ada session pengguna
                'penilaian' => $this->input->post('rating'),
                'komentar' => $this->input->post('bahan'),
                'tanggal_ulasan' => date('Y-m-d')
            ];

            $this->User_model->tambah_ulasan($data);
            $this->session->set_flashdata('success', 'Ulasan berhasil ditambahkan!');
            redirect('dashboard/halaman_resep/' . $this->input->post('id_resep'));
        }
    }

    

    public function logout() {
    // Menghapus semua data sesi
    $this->session->unset_userdata('is_logged_in');
    $this->session->unset_userdata('nama_pengguna');
    $this->session->unset_userdata('email');
    
    // Menghapus seluruh data sesi
    $this->session->sess_destroy();

    // Menambahkan flash message
    $this->session->set_flashdata('message', 'Anda telah berhasil logout.');

    //Log aktivitas
    $this->Admin_model->log_inactive($this->session->userdata('id_pengguna'), 'User telah Logout');

    // Redirect ke halaman login
    redirect('dashboard');
    }

    public function add_to_favorite($id_resep) {
        
        // Cek apakah user sudah login
        if (!$this->session->userdata('is_logged_in')) {
            $this->session->set_flashdata('message', 'Sebelum mengakses halaman Simpan Resep, Anda harus login');
            $this->session->set_flashdata('alert-class', 'alert-danger');
            redirect(base_url('dashboard/login')); // Redirect ke halaman Login
        }
        
        $id_pengguna = $this->session->userdata('id_pengguna');
        
        // Cek apakah sudah ada di favorit
        if ($this->User_model->is_favorite_exists($id_pengguna, $id_resep)) {
            $this->session->set_flashdata('message', 'Resep sudah ada di Favorit Resep Anda.');
        } else {
            $this->User_model->add_favorite($id_pengguna, $id_resep);
            $this->session->set_flashdata('message', 'Resep berhasil ditambahkan ke favorit.');
        }
        
        redirect('dashboard/halaman_resep/' . $id_resep);
    }

}
?>
