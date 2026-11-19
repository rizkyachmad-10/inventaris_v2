        <!-- ============ Sidebar ============ -->
        <div class="vertical-menu">
            <div data-simplebar class="h-100">

                <div class="user-sidebar text-center">
                    <div class="dropdown">
                        <div class="user-img">
                            <img src="<?= base_url('assets/images/users/avatar-7.jpg') ?>" alt="Foto profil" class="rounded-circle">
                            <span class="avatar-online bg-success"></span>
                        </div>
                        <div class="user-info">
                            <h5 class="mt-3 font-size-16 text-white"><?= esc(session()->get('nama_pengguna')) ?></h5>
                            <span class="font-size-13 text-white-50"><?= esc(session()->get('jenis')) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Menu -->
                <div id="sidebar-menu">
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Menu</li>

                        <li>
                            <a href="<?= base_url('dashboard') ?>" class="waves-effect">
                                <i class="dripicons-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <!-- Menu di bawah ini baru placeholder, halamannya dibuat di tahap berikutnya. -->
                        <li class="menu-title">Data Master</li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="dripicons-suitcase"></i>
                                <span>Barang</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="javascript: void(0);">Data Barang</a></li>
                                <li><a href="javascript: void(0);">Kategori Barang</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="dripicons-graph-pie"></i>
                                <span>Ruangan</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="javascript: void(0);">Data Ruangan</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="dripicons-toggles"></i>
                                <span>Pengguna</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="javascript: void(0);">Data Pengguna</a></li>
                            </ul>
                        </li>

                        <li class="menu-title">Transaksi</li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="dripicons-user-group"></i>
                                <span>Menu Utama</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="javascript: void(0);">Peminjaman</a></li>
                                <li><a href="javascript: void(0);">Pengembalian</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </div>
        </div>