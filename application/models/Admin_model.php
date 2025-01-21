<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model{
    
    //Model ketika admin login & menyimpanan data admin di session
    public function get_admin_by_username($username){
        return $this->db->get_where('admin', ['nama_admin' => $username])->row_array();
    }

    public function tambah_pengguna($data){
        $this->db->insert('pengguna', $data);
    }

    //Model untuk menghitung total data
    public function total_resep(){
        return $this->db->count_all('resep');
    }

    public function total_pengguna(){
        return $this->db->count_all('pengguna');
    }

    public function total_ulasan(){
        return $this->db->count_all('ulasan');
    }

    public function total_ulasan_hari_ini() {
        $tanggal_hari_ini = date('Y-m-d'); // Format tanggal hari ini
        $this->db->where('tanggal_ulasan', $tanggal_hari_ini); // Filter berdasarkan tanggal
        $this->db->from('ulasan'); // Tabel ulasan
        return $this->db->count_all_results(); // Menghitung total baris
    }

    public function rata_rata_rating() {
        $query = $this->db->query("SELECT AVG(penilaian) as avg_rating FROM ulasan");
        return $query->row()->avg_rating ?? 0; // Kembalikan rata-rata atau 0 jika NULL
    }

    public function get_ulasan_by_resep() {
        $this->db->select('ulasan.*, pengguna.nama_pengguna AS nama_pengguna, pengguna.foto_profil AS foto_pengguna, resep.judul AS judul');
        $this->db->from('ulasan');
        $this->db->join('pengguna', 'pengguna.id_pengguna = ulasan.id_pengguna');
        $this->db->join('resep', 'resep.id_resep = ulasan.id_resep');
        $this->db->order_by('tanggal_ulasan', 'DESC');
        return $this->db->get()->result_array();
    }
    
    
    //Model untuk menyimpan aktivitas user
    public function log_aktivitas($id_pengguna, $aktivitas, $status = 'Active') {
        $data = [
            'id_pengguna' => $id_pengguna,
            'aktivitas' => $aktivitas,
            'status' => $status,
        ];
        $this->db->insert('aktivitas', $data);
    }

    public function log_pending($id_pengguna, $aktivitas, $status = 'Pending') {
        $data = [
            'id_pengguna' => $id_pengguna,
            'aktivitas' => $aktivitas,
            'status' => $status,
        ];
        $this->db->insert('aktivitas', $data);
    }

    public function log_inactive($id_pengguna, $aktivitas, $status = 'Inactive') {
        $data = [
            'id_pengguna' => $id_pengguna,
            'aktivitas' => $aktivitas,
            'status' => $status,
        ];
        $this->db->insert('aktivitas', $data);
    }

     // Tampilkan aktivitas berdasarkan jenis atau semua aktivitas
     public function get_aktivitas_by_jenis($jenis = null,$limit = 6) {
        $this->db->select('aktivitas.*, pengguna.nama_pengguna');
        $this->db->from('aktivitas');
        $this->db->join('pengguna', 'pengguna.id_pengguna = aktivitas.id_pengguna');
        
        if ($jenis) {
            $this->db->like('aktivitas.aktivitas', $jenis);
        }

        $this->db->order_by('aktivitas.tanggal', 'DESC');
        $this->db->limit($limit); 
        return $this->db->get()->result_array();
    }

    public function get_pengguna($id_pengguna = null) {
        if ($id_pengguna === null) {
            return $this->db->get('pengguna')->result_array(); // Mengambil semua data pengguna
        } else {
            return $this->db->get_where('pengguna', ['id_pengguna' => $id_pengguna])->row_array(); // Mengambil data pengguna berdasarkan ID
        }
    }

    public function get_pelanggan($id_pengguna = null) {
        if ($id_pengguna === null) {
            return $this->db->get('pelanggan')->result_array(); // Mengambil semua data pelanggan
        } else {
            return $this->db->get_where('pelanggan', ['id_pengguna' => $id_pengguna])->row_array(); // Mengambil data pelanggan berdasarkan ID
        }
    }

    public function get_kategori(){
        return $this->db->get('kategori')->result_array();
    }

    public function get_resep() {
        return $this->db->get('resep')->result_array();
    }

    public function get_resep_by_id($id){
        return $this->db->get_where('resep', ['id_resep' => $id])->row_array();
    }

    public function get_pengguna_dan_pelanggan() {
        $this->db->select('pengguna.*, pelanggan.status_aktif');
        $this->db->from('pengguna');
        $this->db->join('pelanggan', 'pelanggan.id_pengguna = pengguna.id_pengguna', 'left');
        return $this->db->get()->result_array();
    }

    public function hapus_ulasan($id_ulasan){
        $this->db->delete('ulasan', ['id_ulasan' => $id_ulasan]);
    }

    public function hapus_pengguna($id_pengguna){
        $this->db->delete('pengguna', ['id_pengguna' => $id_pengguna]);
        $this->db->delete('pelanggan', ['id_pengguna' => $id_pengguna]);    
    }
}
?>