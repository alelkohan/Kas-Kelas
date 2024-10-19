<?php $this->load->view('templates/head'); ?>

<body>

    <?php $this->load->view('templates/topbar'); ?>
    <?php $this->load->view('templates/sidebar'); ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Siswa Kelas</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Siswa</li>
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
                                <h5 class="card-title">Tabel Data Siswa</h5>
                                <button type="button" class="btn btn-primary mt-3 mb-2" style="margin-right: 10px;" data-bs-toggle="modal" data-bs-target="#tambahModal"><i class="bi bi-clipboard-plus"></i></button>

                                <div class="modal fade" id="tambahModal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tambah Siswa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="<?= site_url('siswa/tambah') ?>">

                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="" class="col-form-label">Nama Siswa</label>
                                                        <input type="text" class="form-control" id="" name="nama">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="" class="col-form-label">Alamat</label>
                                                        <input type="text" class="form-control" id="" name="alamat">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="" class="col-form-label">Nomor Telefon</label>
                                                        <input type="text" class="form-control" id="" name="no_telepon">
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
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Nomor Telefon</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($siswa as $siswa) { ?>
                                    <tr>
                                        <th scope="row"><?= $no++ ?></th>
                                        <td><?= $siswa->nama_siswa ?></td>
                                        <td><?= substr($siswa->alamat, 0, 20); ?><?= strlen($siswa->alamat) > 20 ? '...' : ''; ?></td>
                                        <td><?= $siswa->nomor_telfon ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-danger" href="#" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $siswa->id_siswa ?>"><i class="bi bi-trash"></i></button>
                                            <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#editModal<?= $siswa->id_siswa ?>">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <div class="modal fade" id="hapusModal<?= $siswa->id_siswa ?>" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="resetModalLabel">Hapus Siswa</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus siswa ini?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btm-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <a type="" class="btn btm-sm btn-danger" href="<?= site_url('siswa/hapus/' . $siswa->id_siswa); ?>">Hapus</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="editModal<?= $siswa->id_siswa ?>" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Siswa</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form method="post" action="<?= site_url('siswa/edit') ?>">
                                                            <input type="hidden" class="form-control" id="" name="id_siswa" value="<?= $siswa->id_siswa ?>">
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="" class="col-form-label">Nama Siswa</label>
                                                                    <input type="text" class="form-control" id="" name="nama" value="<?= $siswa->nama_siswa ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="" class="col-form-label">Alamat</label>
                                                                    <textarea class="form-control" name="alamat" id="" value=""><?= htmlspecialchars($siswa->alamat) ?></textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="" class="col-form-label">Nomor Telefon</label>
                                                                    <input type="text" class="form-control" id="" name="no_telepon" value="<?= $siswa->nomor_telfon ?>">
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