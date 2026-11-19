<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Melindungi halaman yang hanya boleh dibuka setelah login.
 * Dipasang di Routes.php dengan: ['filter' => 'auth']
 */
class AuthFilter implements FilterInterface
{
    /**
     * Jika belum login, arahkan ke halaman login.
     *
     * @param list<string>|null $arguments
     *
     * @return ResponseInterface|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('logged_in')) {
            return redirect()->to('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }
    }

    /**
     * Cegah browser menyimpan halaman terproteksi di cache,
     * agar tombol Back setelah logout tidak menampilkan isi halaman.
     *
     * @param list<string>|null $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return $response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }
}