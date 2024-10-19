<?php $this->load->view('templates/head'); ?>

<body>

    <?php $this->load->view('templates/topbar'); ?>
    <?php $this->load->view('templates/sidebar'); ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Setting</h1>

            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Setting</li>
                </ol>
            </nav>

        </div>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert" bis_skin_checked="1">
                <?= $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" bis_skin_checked="1">
                <i class="bi bi-check-circle me-1"></i><?= $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informasi Akun <b><?php echo $this->session->userdata('nama'); ?></b></h5>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Email:</strong> <?php echo $this->session->userdata('email'); ?></li>
                        <li class="list-group-item"><strong>Username:</strong> <?php echo $this->session->userdata('username'); ?></li>
                        <li class="list-group-item"><strong>Terakhir Login:</strong> <?php echo $this->session->userdata('last_login'); ?></li>
                    </ul>

                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#resetModal">Ganti Password</button>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- Modal Ganti Password -->
    <div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetModalLabel">Ganti Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updatePasswordForm" action="<?= base_url('user/update_password'); ?>" method="post">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Lama</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" pattern="(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}" title="Password must be at least 8 characters long and contain at least one uppercase letter and one special character (#, @, $, etc.)" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('templates/footer'); ?>
</body>

</html>