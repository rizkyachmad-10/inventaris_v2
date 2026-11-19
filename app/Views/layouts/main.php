<?= $this->include('layouts/partials/header') ?>

<body data-sidebar="dark">

    <div id="layout-wrapper">

        <?= $this->include('layouts/partials/topbar') ?>
        <?= $this->include('layouts/partials/sidebar') ?>

        <!-- ============ Main Content ============ -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <?= $this->renderSection('content') ?>

                </div>
            </div>

            <?= $this->include('layouts/partials/footer') ?>
        </div>

    </div>

    <?= $this->include('layouts/partials/scripts') ?>
    <?= $this->renderSection('scripts') ?>
</body>

</html>