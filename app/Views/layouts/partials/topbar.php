        <!-- ============ Topbar ============ -->
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">

                    <!-- Logo -->
                    <div class="navbar-brand-box">
                        <a href="<?= base_url('dashboard') ?>" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="<?= base_url('assets/images/logo-sm.png') ?>" alt="Inventaris Sekolah" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url('assets/images/logo-dark.png') ?>" alt="Inventaris Sekolah" height="20">
                            </span>
                        </a>

                        <a href="<?= base_url('dashboard') ?>" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="<?= base_url('assets/images/logo-sm.png') ?>" alt="Inventaris Sekolah" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url('assets/images/logo-light.png') ?>" alt="Inventaris Sekolah" height="20">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </div>

                <div class="d-flex">
                    <!-- Menu pengguna -->
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user"
                                src="<?= base_url('assets/images/users/avatar-2.jpg') ?>" alt="Foto profil">
                            <span class="d-none d-xl-inline-block ms-1"><?= esc(session()->get('nama_pengguna')) ?></span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- Logout memakai POST + CSRF -->
                            <form action="<?= base_url('logout') ?>" method="post" class="m-0">
                                <?= csrf_field() ?>
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>