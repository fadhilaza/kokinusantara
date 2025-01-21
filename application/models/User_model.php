<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    //mengambil data pengguna berdasarkan username
    public function get_user_by_username($username){
        return $this->db->get_where('pengguna', ['nama_pengguna' => $username])->row_array();
    }

    public function get_pengguna($id) {
        return $this->db->get_where('pengguna', ['id_pengguna' => $id])->row_array();
    }

    public function get_pelanggan($id) {
        return $this->db->get_where('pelanggan', ['id_pengguna' => $id])->row();
    }

    public function update_status($id_pengguna, $data) {
        $this->db->where('id_pengguna', $id_pengguna);
        $this->db->update('pelanggan', $data);
    }
    
    public function check_premium() {
        $this->db->set('status_aktif', 0);
        $this->db->where('status_aktif', 1);
        $this->db->where('tanggal_langganan <=', date('Y-m-d', strtotime('-30 days')));
        $this->db->update('pelanggan'); // Ganti 'nama_tabel' dengan nama tabel Anda
    }

    public function get_User($id_pengguna) {
        $this->db->where('id_pengguna', $id_pengguna);
        $query = $this->db->get('pengguna');
        return $query->row(); // row() mengembalikan object
    }
     

    public function get_user_profile($id_pengguna) {
        $this->db->select('foto_profil');
        $this->db->where('id_pengguna', $id_pengguna);
        $query = $this->db->get('pengguna');
        return $query->row(); // Ambil satu baris data
    }

    //insert data user dari tabel pengguna
    public function insert_user($data){
        $this->db->insert('pengguna', $data);
    }

    public function hapus_pengguna($id){
        $this->db->delete('pengguna', ['id_pengguna' => $id]);
    }
    
    //mengambil data resep
    public function get_Resep(){
        return $this->db->get('resep')->result_array();
    }

    public function get_resep_by_id($id){
        return $this->db->get_where('resep', ['id_resep' => $id])->row_array();
    }

    public function get_resep_by_id_and_name($id_resep) {
    $this->db->select('resep.*, pengguna.nama_pengguna AS nama_pengguna, pengguna.foto_profil AS foto_pengguna');
    $this->db->from('resep');
    $this->db->join('pengguna', 'resep.id_pengguna = pengguna.id_pengguna', 'left');
    $this->db->where('resep.id_resep', $id_resep);
    return $this->db->get()->row_array();
    }
    

    public function get_resep_pagination($limit, $offset, $keyword = null) {
    if ($keyword) {
        $this->db->like('judul', $keyword);
        $this->db->or_like('deskripsi', $keyword);
    }
    $this->db->limit($limit, $offset);
    return $this->db->get('resep')->result_array();
    }

    public function getResepByPengguna($id_pengguna) {
        $this->db->where('id_pengguna', $id_pengguna);
        return $this->db->get('resep')->result_array();
    }

    public function getresepbykat($id_kategori) {
        $this->db->where('id_kategori', $id_kategori);
        $query = $this->db->get('resep');
        return $query->result_array();
    }

    public function count_all_resep(){
    return $this->db->count_all('resep');
    }


    public function tambah_resep($data){
        $this->db->insert('resep', $data);
    }

    public function hapus_resep($id){
        $this->db->delete('resep', ['id_resep' => $id]);
    }

    public function get_Kategori(){
        return $this->db->get('kategori')->result_array();
    }

    public function update_pengguna($id, $data) {
        $this->db->where('id_pengguna', $id);
        return $this->db->update('pengguna', $data); // Tabel 'pengguna' adalah contoh
    }

    public function get_ulasan_by_resep($id, $limit = 4) {
        $this->db->select('ulasan.*, pengguna.nama_pengguna AS nama_pengguna, pengguna.foto_profil AS foto_pengguna');
        $this->db->from('ulasan');
        $this->db->join('pengguna', 'pengguna.id_pengguna = ulasan.id_pengguna');
        $this->db->where('ulasan.id_resep', $id);
        $this->db->order_by('tanggal_ulasan', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function tambah_ulasan($data) {
        return $this->db->insert('ulasan', $data);
    }
    
    //hapus akun
    public function delete_User($id){
        return $this->db->where('id_pengguna', $id)->delete('pengguna');
    }

    public function insert_payment($data) {
        $this->db->insert('pelanggan', $data); // Menyimpan ke tabel langganan
    }

    public function add_favorite($id_pengguna, $id_resep) {
        $data = [
            'id_pengguna' => $id_pengguna,
            'id_resep' => $id_resep
        ];
        $this->db->insert('favorite', $data);
    }

    // Mengecek apakah resep sudah ada di favorit
    public function is_favorite_exists($id_pengguna, $id_resep) {
        $this->db->where('id_pengguna', $id_pengguna);
        $this->db->where('id_resep', $id_resep);
        $query = $this->db->get('favorite');
        return $query->num_rows() > 0;
    }

    // Mengambil semua favorit pengguna
    public function get_user_favorites($id_pengguna) {
        $this->db->select('r.judul, r.id_resep, r.waktu_masak, r.jumlah_porsi, r.foto');
        $this->db->from('favorite f');
        $this->db->join('resep r', 'f.id_resep = r.id_resep');
        $this->db->where('f.id_pengguna', $id_pengguna);
        return $this->db->get()->result_array();
    }

    public function hapus_favorite($id_pengguna, $id_resep) {
        $this->db->where('id_pengguna', $id_pengguna);
        $this->db->where('id_resep', $id_resep);
        return $this->db->delete('favorite');
    }
    
    // Hitung total resep berdasarkan kategori
    public function count_resep_by_kategori($kategori) {
        $this->db->join('kategori', 'resep.id_kategori = kategori.id_kategori');
        $this->db->where('kategori.nama', $kategori);
        return $this->db->count_all_results('resep');
    }

    // Ambil data resep berdasarkan kategori dengan pagination
    public function get_resep_by_kategori_pagination($kategori, $limit, $start) {
        $this->db->select('resep.*');
        $this->db->from('resep');
        $this->db->join('kategori', 'resep.id_kategori = kategori.id_kategori');
        $this->db->where('kategori.nama', $kategori);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }

    
}
