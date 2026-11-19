<?php

namespace App\Controllers;

use App\Models\PenggunaModel;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseController
{
    /**
     * Key session yang diisi saat login dan dihapus saat logout.
     *
     * @var list<string>
     */
    private const SESSION_KEYS = ['logged_in', 'id_pengguna', 'nama_pengguna', 'username', 'jenis'];

    /**
     * GET /login : tampilkan form login.
     */
    public function index(): RedirectResponse|string
    {
        if ($this->session->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    /**
     * POST /login : proses login.
     */
    public function attempt(): RedirectResponse
    {
        $rules = [
            'username' => 'required|max_length[50]',
            'password' => 'required|max_length[255]',
        ];

        $messages = [
            'username' => [
                'required'   => 'Username wajib diisi.',
                'max_length' => 'Username maksimal 50 karakter.',
            ],
            'password' => [
                'required'   => 'Password wajib diisi.',
                'max_length' => 'Password terlalu panjang.',
            ],
        ];

        $username = trim((string) $this->request->getPost('username'));

        if (! $this->validate($rules, $messages)) {
            return $this->backToLogin(implode(' ', $this->validator->getErrors()), $username);
        }

        $password = (string) $this->request->getPost('password');
        $user     = model(PenggunaModel::class)->findByUsername($username);

        // Pesan sengaja sama untuk "username tidak ada" dan "password salah"
        // supaya orang luar tidak bisa menebak username yang terdaftar.
        if ($user === null || ! password_verify($password, $user['password'])) {
            return $this->backToLogin('Username atau password salah.', $username);
        }

        // Buat ID session baru setelah login (mencegah session fixation).
        $this->session->regenerate();
        $this->session->set([
            'logged_in'     => true,
            'id_pengguna'   => (int) $user['id_pengguna'],
            'nama_pengguna' => $user['nama_pengguna'],
            'username'      => $user['username'],
            'jenis'         => $user['jenis'],
        ]);

        return redirect()->to('/dashboard');
    }

    /**
     * POST /logout : keluar dari aplikasi.
     */
    public function logout(): RedirectResponse
    {
        $this->session->remove(self::SESSION_KEYS);
        $this->session->regenerate();

        return redirect()->to('/login')->with('success', 'Anda berhasil logout.');
    }

    /**
     * Kembali ke form login membawa pesan error.
     * Hanya username yang dikirim balik; password tidak pernah disimpan ke session.
     */
    private function backToLogin(string $error, string $username): RedirectResponse
    {
        return redirect()->to('/login')
            ->with('error', $error)
            ->with('old_username', $username);
    }
}