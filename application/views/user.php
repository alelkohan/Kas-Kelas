<?php $this->load->view('templates/head'); ?>

<body>

    <?php $this->load->view('templates/topbar'); ?>
    <?php $this->load->view('templates/sidebar'); ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data user Kelas</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">user</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" bis_skin_checked="1">
                <i class="bi bi-check-circle me-1"></i><?= $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">Tabel Data User</h5>
                                <button type="button" class="btn btn-primary mt-3 mb-2" style="margin-right: 10px;" data-bs-toggle="modal" data-bs-target="#tambahModal"><i class="bi bi-clipboard-plus"></i></button>

                                <div class="modal fade" id="tambahModal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tambah User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="<?= site_url('user/tambah') ?>">

                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="" class="col-form-label">Nama user</label>
                                                        <input type="text" class="form-control" id="" name="nama">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="" class="col-form-label">email</label>
                                                        <input type="text" class="form-control" id="" name="email">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="" class="col-form-label">username</label>
                                                        <input type="text" class="form-control" id="" name="username">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="" class="col-form-label">password</label>
                                                        <input type="password" class="form-control" id="" name="password">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Basic Modal-->

                        </div>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($user as $user) { ?>
                                    <tr>
                                        <th scope="row"><?= $no++ ?></th>
                                        <td><?= $user->nama ?></td>
                                        <td><?= $user->username ?></td>
                                        <td><?= $user->email ?></td>
                                        <td>
                                            <a class="btn btn-sm btn-outline-danger" href="<?= site_url('user/hapus/' . $user->id_user)  ?>"><i class="bi bi-trash"></i></a>
                                            <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#editModal<?= $user->id_user ?>">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <div class="modal fade" id="editModal<?= $user->id_user ?>" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit user</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form method="post" action="<?= site_url('user/edit') ?>">
                                                            <input type="hidden" class="form-control" id="" name="id_user" value="<?= $user->id_user ?>">
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="" class="col-form-label">Nama user</label>
                                                                    <input type="text" class="form-control" id="" name="nama" value="<?= $user->nama ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="" class="col-form-label">email</label>
                                                                    <input type="text" class="form-control" id="" name="email" value="<?= $user->email ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="" class="col-form-label">username</label>
                                                                    <input type="text" class="form-control" id="" name="username" value="<?= $user->username ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="" class="col-form-label">password</label>
                                                                    <input type="password" class="form-control" id="" name="password" value="<?= $user->password ?>">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Edit</button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
            </div>
        </section>

    </main><!-- End #main -->

    <?php $this->load->view('templates/footer'); ?>

</body>

</html>