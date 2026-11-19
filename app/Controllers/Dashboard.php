<?php

namespace App\Controllers;

use CodeIgniter\Database\BaseConnection;

class Dashboard extends BaseController
{
    private BaseConnection $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    /**
     * GET /dashboard (dilindungi filter 'auth' di Routes.php)
     */
    public function index(): string
    {
        return view('dashboard', [
            'title'          => 'Dashboard',
            'tanggal'        => $this->tanggalHariIni(),
            'stat'           => $this->ringkasan(),
            'kondisi'        => $this->stokPerKondisi(),
            'perKategori'    => $this->stokPerKategori(),
            'peminjamanBaru' => $this->peminjamanTerbaru(),
            'barangTerbaru'  => $this->barangTerbaru(),
        ]);
    }

    /**
     * Tanggal hari ini dalam bahasa Indonesia, mis. "Kamis, 19 November 2026".
     */
    private function tanggalHariIni(): string
    {
        $hari  = [1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
            'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return $hari[(int) date('N')] . ', ' . date('j') . ' ' . $bulan[(int) date('n')] . ' ' . date('Y');
    }

    /**
     * Angka-angka untuk kartu ringkasan di bagian atas.
     *
     * @return array<string, int>
     */
    private function ringkasan(): array
    {
        $barang = $this->db->table('barang')
            ->select('COUNT(*) AS jenis, COALESCE(SUM(jumlah), 0) AS unit', false)
            ->get()->getRowArray();

        $dipinjam = $this->db->table('peminjaman_barang')
            ->select('COUNT(*) AS transaksi, COALESCE(SUM(jumlah), 0) AS unit', false)
            ->where('status', 'Dipinjam')
            ->get()->getRowArray();

        $terlambat = $this->db->table('peminjaman_barang')
            ->where('status', 'Dipinjam')
            ->where('tanggal_rencana_kembali <', date('Y-m-d'))
            ->countAllResults();

        return [
            'barang_jenis'       => (int) $barang['jenis'],
            'barang_unit'        => (int) $barang['unit'],
            'kategori'           => $this->db->table('kategori_barang')->countAllResults(),
            'ruangan'            => $this->db->table('ruangan')->countAllResults(),
            'pengguna'           => $this->db->table('pengguna')->countAllResults(),
            'dipinjam_transaksi' => (int) $dipinjam['transaksi'],
            'dipinjam_unit'      => (int) $dipinjam['unit'],
            'terlambat'          => $terlambat,
        ];
    }

    /**
     * Total unit barang menurut kondisi. Ketiga kondisi selalu ada (0 bila kosong).
     *
     * @return array<string, int>
     */
    private function stokPerKondisi(): array
    {
        $hasil = ['Baik' => 0, 'Rusak Ringan' => 0, 'Rusak Berat' => 0];

        $rows = $this->db->table('barang')
            ->select('kondisi, SUM(jumlah) AS total', false)
            ->groupBy('kondisi')
            ->get()->getResultArray();

        foreach ($rows as $row) {
            $hasil[$row['kondisi']] = (int) $row['total'];
        }

        return $hasil;
    }

    /**
     * Total unit barang per kategori, dari yang terbanyak.
     * Kategori tanpa barang tetap tampil dengan total 0.
     *
     * @return list<array{nama: string, total: int}>
     */
    private function stokPerKategori(): array
    {
        $rows = $this->db->table('kategori_barang k')
            ->select('k.nama_kategori AS nama, COALESCE(SUM(b.jumlah), 0) AS total', false)
            ->join('barang b', 'b.id_kategori = k.id_kategori', 'left')
            ->groupBy('k.id_kategori, k.nama_kategori')
            ->orderBy('total', 'DESC')
            ->orderBy('k.nama_kategori', 'ASC')
            ->get()->getResultArray();

        return array_map(
            static fn (array $r): array => ['nama' => $r['nama'], 'total' => (int) $r['total']],
            $rows
        );
    }

    /**
     * Lima transaksi peminjaman terbaru.
     *
     * @return list<array<string, mixed>>
     */
    private function peminjamanTerbaru(): array
    {
        return $this->db->table('peminjaman_barang p')
            ->select('p.id_peminjaman, p.tanggal_pinjam, p.tanggal_rencana_kembali, p.jumlah, p.status, '
                . 'u.nama_pengguna, b.nama_barang')
            ->join('pengguna u', 'u.id_pengguna = p.id_pengguna')
            ->join('barang b', 'b.id_barang = p.id_barang')
            ->orderBy('p.tanggal_pinjam', 'DESC')
            ->orderBy('p.id_peminjaman', 'DESC')
            ->limit(5)
            ->get()->getResultArray();
    }

    /**
     * Lima barang yang terakhir didaftarkan.
     *
     * @return list<array<string, mixed>>
     */
    private function barangTerbaru(): array
    {
        return $this->db->table('barang b')
            ->select('b.kode_barang, b.nama_barang, b.jumlah, b.kondisi, '
                . 'k.nama_kategori, r.nama_ruangan')
            ->join('kategori_barang k', 'k.id_kategori = b.id_kategori')
            ->join('ruangan r', 'r.id_ruangan = b.id_ruangan')
            ->orderBy('b.id_barang', 'DESC')
            ->limit(5)
            ->get()->getResultArray();
    }
}