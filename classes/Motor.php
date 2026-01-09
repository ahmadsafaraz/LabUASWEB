<?php
// classes/Motor.php

class Motor {
    private $db;
    
    // Properties
    public $id;
    public $brand;
    public $model;
    public $year;
    public $price;
    public $color;
    public $status;

    // Constructor
    public function __construct() {
        $this->db = new Database();
    }

    // CREATE - Tambah motor baru
    public function create() {
        $sql = "INSERT INTO motors (brand, model, year, price, color, status) 
                VALUES (:brand, :model, :year, :price, :color, :status)";
        
        $params = [
            ':brand' => $this->brand,
            ':model' => $this->model,
            ':year' => $this->year,
            ':price' => $this->price,
            ':color' => $this->color,
            ':status' => $this->status
        ];
        
        return $this->db->query($sql, $params);
    }

    // READ - Get all motors dengan filter dan pagination
    public function getAll($filters = [], $limit = null, $offset = 0) {
        $sql = "SELECT * FROM motors WHERE 1=1";
        $params = [];
        
        // Filter search
        if (!empty($filters['search'])) {
            $sql .= " AND (brand LIKE :search OR model LIKE :search)";
            $params[':search'] = '%' . $filters['search'] . '%';
        }
        
        // Filter brand
        if (!empty($filters['brand'])) {
            $sql .= " AND brand = :brand";
            $params[':brand'] = $filters['brand'];
        }
        
        // Filter status
        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
            $params[':status'] = $filters['status'];
        }
        
        $sql .= " ORDER BY id DESC";
        
        // Pagination
        if ($limit) {
            $sql .= " LIMIT :limit OFFSET :offset";
            $stmt = $this->db->getConnection()->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        
        return $this->db->resultSet($sql, $params);
    }

    // READ - Get single motor by ID
    public function getById($id) {
        $sql = "SELECT * FROM motors WHERE id = :id";
        return $this->db->single($sql, [':id' => $id]);
    }

    // UPDATE - Update motor
    public function update() {
        $sql = "UPDATE motors 
                SET brand = :brand, 
                    model = :model, 
                    year = :year, 
                    price = :price, 
                    color = :color, 
                    status = :status 
                WHERE id = :id";
        
        $params = [
            ':id' => $this->id,
            ':brand' => $this->brand,
            ':model' => $this->model,
            ':year' => $this->year,
            ':price' => $this->price,
            ':color' => $this->color,
            ':status' => $this->status
        ];
        
        return $this->db->query($sql, $params);
    }

    // DELETE - Hapus motor
    public function delete($id) {
        $sql = "DELETE FROM motors WHERE id = :id";
        return $this->db->query($sql, [':id' => $id]);
    }

    // Get total count dengan filter
    public function getCount($filters = []) {
        $sql = "SELECT COUNT(*) as total FROM motors WHERE 1=1";
        $params = [];
        
        if (!empty($filters['search'])) {
            $sql .= " AND (brand LIKE :search OR model LIKE :search)";
            $params[':search'] = '%' . $filters['search'] . '%';
        }
        
        if (!empty($filters['brand'])) {
            $sql .= " AND brand = :brand";
            $params[':brand'] = $filters['brand'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
            $params[':status'] = $filters['status'];
        }
        
        $result = $this->db->single($sql, $params);
        return $result ? $result['total'] : 0;
    }

    // Get all brands untuk filter
    public function getAllBrands() {
        $sql = "SELECT DISTINCT brand FROM motors ORDER BY brand";
        return $this->db->resultSet($sql);
    }

    // Get statistics
    public function getStats() {
        $stats = [];
        
        // Total motors
        $sql = "SELECT COUNT(*) as total FROM motors";
        $result = $this->db->single($sql);
        $stats['total'] = $result['total'];
        
        // Available motors
        $sql = "SELECT COUNT(*) as total FROM motors WHERE status = 'Tersedia'";
        $result = $this->db->single($sql);
        $stats['available'] = $result['total'];
        
        // Total brands
        $sql = "SELECT COUNT(DISTINCT brand) as total FROM motors";
        $result = $this->db->single($sql);
        $stats['brands'] = $result['total'];
        
        return $stats;
    }
}
?>