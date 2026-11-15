<?php
class AdminModel {
    private $db;
    private $table = "admins";

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Cek login: cari admin berdasarkan username
    public function findByUsername($username) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        return $stmt->fetch(); // Mengembalikan array data admin atau false
    }

    // --- TAMBAHAN BARU UNTUK PORTOFOLIO ---

    // 1. Cek ketersediaan slug (Memanggil Function MySQL)
    public function cekSlug($slug) {
        $query = "SELECT cek_slug_tersedia(:slug) AS tersedia";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['tersedia']; // Return 1 (true) atau 0 (false)
    }

    // 2. Simpan data portofolio baru (Memanggil Stored Procedure)
    public function tambahPortofolio($data) {
        try {
            // Panggil Stored Procedure yang sudah kita buat di database
            $query = "CALL tambah_website(:admin_id, :nama_usaha, :slug, :deskripsi)";
            $stmt = $this->db->prepare($query);
            
            $stmt->bindParam(':admin_id', $data['admin_id']);
            $stmt->bindParam(':nama_usaha', $data['nama_usaha']);
            $stmt->bindParam(':slug', $data['slug']);
            $stmt->bindParam(':deskripsi', $data['deskripsi']);
            
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // 3. Ambil semua portofolio milik admin yang login (Berdasarkan Many-to-Many)
    public function getPortofolioByAdmin($admin_id) {
        $query = "SELECT w.* FROM websites w 
                  JOIN admin_website aw ON w.id = aw.website_id 
                  WHERE aw.admin_id = :admin_id 
                  ORDER BY w.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':admin_id', $admin_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // 4. Ubah status Publish/Draft
    public function ubahStatus($website_id, $status) {
        $query = "UPDATE websites SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $website_id);
        return $stmt->execute();
    }

    // Method untuk mengambil data website publik (HANYA YANG PUBLISH)
    public function getWebsiteBySlug($slug) {
        $query = "SELECT * FROM websites WHERE slug = :slug AND status = 'publish' LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        return $stmt->fetch(); 
    }
}
?>