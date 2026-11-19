<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Session\Session;
use Psr\Log\LoggerInterface;

/**
 * BaseController menjadi tempat berbagi komponen untuk semua controller.
 * Controller lain cukup meng-extend class ini:
 *
 *     class Auth extends BaseController
 */
abstract class BaseController extends Controller
{
    /**
     * Helper yang otomatis dimuat di semua controller turunan.
     * - url  : base_url(), site_url(), redirect()
     * - form : csrf_field(), set_value()
     *
     * @var list<string>
     */
    protected $helpers = ['url', 'form'];

    /**
     * Service session, siap dipakai di semua controller.
     */
    protected Session $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Jangan ubah baris ini.
        parent::initController($request, $response, $logger);

        $this->session = service('session');
    }
}