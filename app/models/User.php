<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /** Ambil semua user */
    public function getAll()
    {
        $this->db->query("SELECT * FROM users ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    /** Cari user berdasarkan ID */
    public function findById($id)
    {
        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /** Cari user berdasarkan email */


    /** Tambah user baru */
    public function create($data)
    {
        $this->db->query("
            INSERT INTO users (name, email, password, role, created_at)
            VALUES (:name, :email, :password, :role, NOW())
        ");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':role', $data['role']);
        return $this->db->execute();
    }

    /** Update user (biasa untuk admin/edit profile) */
    public function update($data)
    {
        $this->db->query("
            UPDATE users 
            SET name = :name, email = :email, role = :role
            WHERE id = :id
        ");
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':role', $data['role']);
        return $this->db->execute();
    }

    /** Hapus user */
    public function delete($id)
    {
        $this->db->query("DELETE FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    /** Set reset token dan expire time */

    public function findByEmail($email)
    {
        $this->db->query("SELECT * FROM users WHERE email = :email LIMIT 1");
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    // Simpan reset token + expired
    public function setResetToken($userId, $token, $expires)
    {
        $this->db->query("
            UPDATE users 
            SET reset_token = :token, reset_expires = :expires 
            WHERE id = :id
        ");
        $this->db->bind(':token', $token);
        $this->db->bind(':expires', $expires);
        $this->db->bind(':id', $userId);
        return $this->db->execute();
    }

    // Cari user berdasarkan reset token (yang belum expired)
public function findByResetToken($token)
{
    // Ambil user berdasarkan token saja
    $this->db->query("SELECT * FROM users WHERE reset_token = :token LIMIT 1");
    $this->db->bind(':token', $token);
    $user = $this->db->single();

    // Cek expire menggunakan PHP, bukan MySQL
    if ($user && strtotime($user['reset_expires']) >= time()) {
        return $user;
    }

    return false; // token expired
}


    // Update password + hapus token
    public function updatePassword($userId, $hashedPassword)
    {
        $this->db->query("
            UPDATE users 
            SET password = :password, reset_token = NULL, reset_expires = NULL 
            WHERE id = :id
        ");
        $this->db->bind(':password', $hashedPassword);
        $this->db->bind(':id', $userId);
        return $this->db->execute();
    }
    
}
