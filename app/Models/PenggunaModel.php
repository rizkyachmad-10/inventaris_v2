<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggunaModel extends Model
{
    protected $table            = 'pengguna';
    protected $primaryKey       = 'id_pengguna';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'nama_pengguna',
        'jenis',
        'no_identitas',
        'username',
        'password',
    ];

    /**
     * Cari satu pengguna berdasarkan username.
     * Mengembalikan null bila tidak ditemukan.
     *
     * @return array<string, mixed>|null
     */
    public function findByUsername(string $username): ?array
    {
        return $this->where('username', $username)->first();
    }
}