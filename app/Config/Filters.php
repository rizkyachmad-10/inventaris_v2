<?php

namespace Config;

use App\Filters\AuthFilter;
use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    /**
     * Daftar nama pendek (alias) untuk class filter.
     *
     * @var array<string, class-string|list<class-string>>
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
        'auth'          => AuthFilter::class, // cek login, dipasang per-route di Routes.php
    ];

    /**
     * Filter khusus bawaan framework. Jangan dihapus.
     *
     * @var array{before: list<string>, after: list<string>}
     */
    public array $required = [
        'before' => [
            'forcehttps', // Paksa HTTPS bila diaktifkan di App.php
            'pagecache',  // Web page caching
        ],
        'after' => [
            'pagecache',   // Web page caching
            'performance', // Performance metrics
            'toolbar',     // Debug toolbar
        ],
    ];

    /**
     * Filter yang selalu dijalankan di setiap request.
     *
     * 'csrf' melindungi semua request POST (termasuk form login dan logout).
     * Setiap <form method="post"> wajib memuat <?= csrf_field() ?>.
     *
     * @var array{
     *     before: array<string, array{except: list<string>|string}>|list<string>,
     *     after: array<string, array{except: list<string>|string}>|list<string>
     * }
     */
    public array $globals = [
        'before' => [
            'csrf',
        ],
        'after' => [
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * Filter berdasarkan HTTP method.
     *
     * @var array<string, list<string>>
     */
    public array $methods = [];

    /**
     * Filter berdasarkan pola URI. Kosong karena 'auth' dipasang lewat Routes.php.
     *
     * @var array<string, array<string, list<string>>>
     */
    public array $filters = [];
}