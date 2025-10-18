<?php
// app/models/User.php

// Pastikan kita memuat file helper Database
require_once '../app/Database.php';

class User {
    private $db;

    public function __construct(){
        // Buat instance dari class Database, bukan PDO langsung
        $this->db = new Database;
    }

    // Cari user berdasarkan email
    public function findUserByEmail($email){
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        
        // Cek apakah baris ditemukan
        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

    // Register user
    public function register($data){
        $this->db->query('INSERT INTO users (name, email, password) VALUES(:name, :email, :password)');
        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // Login user (kode ini tidak berubah, tapi akan berfungsi sekarang)
    public function login($email, $password){
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();
        
        if($row){
            $hashed_password = $row->password;
            if(password_verify($password, $hashed_password)){
                return $row;
            }
        }
        
        return false;
    }
}