<?php $this->load->view('templates/head'); ?>

<body>

    <?php $this->load->view('templates/topbar'); ?>
    <?php $this->load->view('templates/sidebar'); ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Kas</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Kas</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" bis_skin_checked="1">
                <i class="bi bi-check-circle me-1"></i><?= $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" bis_skin_checked="1">
                <i class="bi bi-check-circle me-1"></i><?= $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <section class="section">
            <div class="card border-primary mb-3">
                <div class="card-header bg-primary text-white">
                    <b>
                        Saldo Saat Ini
                    </b>
                </div>
                <div class="card-body text-center">
                    <h2 class="card-title">Rp <?= number_format($saldo, 0, ',', '.'); ?></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">Kas Siswa</h5>
                                <button type="button" class="btn btn-primary mt-3 mb-2" style="margin-right: 10px;" data-bs-toggle="modal" data-bs-target="#tambahModal"><i class="bi bi-clipboard-plus"></i></button>
                            </div>
                            <div class="card" style="max-height: 350px; overflow-y: auto;">
                                <?php

                                $bulan_mapping = [
                                    'Januari' => '01',
                                    'Februari' => '02',
                                    'Maret' => '03',
                                    'April' => '04',
                                    'Mei' => '05',
                                    'Juni' => '06',
                                    'Juli' => '07',
                                    'Agustus' => '08',
                                    'September' => '09',
                                    'Oktober' => '10',
                                    'November' => '11',
                                    'Desember' => '12'
                                ];

                                foreach ($periode as $row) :
                                    $tanggal_saat_ini = new DateTime();

                                    $bulan_periode = $bulan_mapping[$row->bulan];
                                    $tahun_periode = $row->tahun;

                                    $tanggal_awal_periode = new DateTime("{$tahun_periode}-{$bulan_periode}-01");
                                    $tanggal_akhir_periode = (clone $tanggal_awal_periode)->modify('last day of this month');

                                    if ($tanggal_saat_ini < $tanggal_awal_periode) {
                                        $status_periode = 'Belum Mulai';
                                    } elseif ($tanggal_saat_ini >= $tanggal_awal_periode && $tanggal_saat_ini <= $tanggal_akhir_periode) {
                                        $status_periode = 'Aktif';
                                    } else {
                                        $status_periode = 'Kedaluwarsa';
                                    }

                                    $status_class = ($status_periode == 'Aktif') ? 'success' : ($status_periode == 'Belum Mulai' ? 'secondary' : 'danger');

                                    $status_class = ($status_periode == 'Aktif') ? 'success' : 'danger';
                                    $detail_disabled = ($status_periode == 'Belum Mulai') ? 'disabled' : ''; // Penentuan status tombol Detail

                                ?>
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <h5 class="card-title">Periode: <?= $row->bulan; ?>/<?= $row->tahun; ?></h5>
                                            <p>Tenggat Pembayaran: Setiap <?= $row->tenggat; ?> hari</p>
                                            <p>Minimal Bayar: Rp <?= number_format($row->jumlah_hutang, 0, ',', '.') ?></p>
                                            <p>Status: <span class="badge bg-<?= $status_class ?>"><?= $status_periode ?></span></p>
                                            <a href="<?= site_url('periode/detail/' . $row->id_periode); ?>" class="btn btn-outline-success btn-sm <?= $detail_disabled ?>" <?= $detail_disabled ? 'style="pointer-events: none; opacity: 0.3;"' : '' ?>>Detail</a>
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $row->id_periode ?>"><i class="bi bi-pencil"></i></button>
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $row->id_periode ?>"><i class="bi bi-trash"></i></button>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="hapusModal<?= $row->id_periode ?>" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="resetModalLabel">Hapus Periode</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus periode ini?,
                                                    <p>Dengan menghapus periode ini akan menghapus semua data yang ada di dalamnya</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btm-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <a type="" class="btn btm-sm btn-danger" href="<?= site_url('periode/hapus/' . $row->id_periode); ?>">Hapus</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal<?= $row->id_periode ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Edit Periode</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="<?= site_url('periode/edit/' . $row->id_periode) ?>" method="post">
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="bulan" class="form-label">Bulan</label>
                                                            <select class="form-control" id="bulan" name="bulan" required>
                                                                <option value="januari" <?= ($row->bulan == 'Januari') ? 'selected' : '' ?>>Januari</option>
                                                                <option value="februari" <?= ($row->bulan == 'Februari') ? 'selected' : '' ?>>Februari</option>
                                                                <option value="maret" <?= ($row->bulan == 'Maret') ? 'selected' : '' ?>>Maret</option>
                                                                <option value="april" <?= ($row->bulan == 'April') ? 'selected' : '' ?>>April</option>
                                                                <option value="mei" <?= ($row->bulan == 'Mei') ? 'selected' : '' ?>>Mei</option>
                                                                <option value="juni" <?= ($row->bulan == 'Juni') ? 'selected' : '' ?>>Juni</option>
                                                                <option value="juli" <?= ($row->bulan == 'Juli') ? 'selected' : '' ?>>Juli</option>
                                                                <option value="agustus" <?= ($row->bulan == 'Agustus') ? 'selected' : '' ?>>Agustus</option>
                                                                <option value="september" <?= ($row->bulan == 'September') ? 'selected' : '' ?>>September</option>
                                                                <option value="oktober" <?= ($row->bulan == 'Oktober') ? 'selected' : '' ?>>Oktober</option>
                                                                <option value="november" <?= ($row->bulan == 'November') ? 'selected' : '' ?>>November</option>
                                                                <option value="desember" <?= ($row->bulan == 'Desember') ? 'selected' : '' ?>>Desember</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="tahun" class="form-label">Tahun</label>
                                                            <input type="number" class="form-control" id="tahun" name="tahun" min="2000" max="2100" value="<?= $row->tahun ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="tenggat" class="form-label">Tenggat (Hari)</label>
                                                            <input type="number" class="form-control" id="tenggat" name="tenggat" value="<?= $row->tenggat ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="jumlah_hutang" class="form-label">Jumlah Hutang</label>
                                                            <input type="number" class="form-control" id="jumlah_hutang" name="jumlah_hutang" step="0.01" value="<?= $row->jumlah_hutang ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div><!-- End Modal Edit -->
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div><!-- End Default Card -->

                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">Kas Masuk</h5>
                                <button type="button" class="btn btn-primary mt-3 mb-2" style="margin-right: 10px;" data-bs-toggle="modal" data-bs-target="#tambahmasukModal"><i class="bi bi-clipboard-plus"></i></button>
                            </div>
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nominal</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($kasmasuk as $kasmasuk) { ?>
                                        <tr>
                                            <th scope="row"><?= $no++ ?></th>
                                            <td>Rp <?= number_format($kasmasuk->nominal, 0, ',', '.'); ?></td>
                                            <td><?= $kasmasuk->keterangan ?></td>
                                            <td>
                                                <button href="" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $kasmasuk->id_kasmasuk_luar ?>"><i class=" bi bi-trash"></i></button>
                                                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#editModal<?= $kasmasuk->id_kasmasuk_luar ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <div class="modal fade" id="hapusModal<?= $kasmasuk->id_kasmasuk_luar ?>" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="resetModalLabel">Hapus Kas Masuk</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus Kas Masuk ini?,
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btm-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <a type="" class="btn btm-sm btn-danger" href="<?= site_url('kasmasuk/hapus/' . $kasmasuk->id_kasmasuk_luar) ?>">Hapus</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="editModal<?= $kasmasuk->id_kasmasuk_luar ?>" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit kasmasuk</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="post" action="<?= site_url('kasmasuk/edit/' . $kasmasuk->id_kasmasuk_luar) ?>">
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="" class="col-form-label">Nominal</label>
                                                                        <input type="number" class="form-control" id="" name="nominal" value="<?= $kasmasuk->nominal ?>">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="" class="col-form-label">Keterangan</label>
                                                                        <input type="text" class="form-control" id="" name="keterangan" value="<?= $kasmasuk->keterangan ?>">
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
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Tambah -->
            <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahModalLabel">Tambah Periode</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= site_url('periode/tambah') ?>" method="post">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="bulan" class="form-label">Bulan</label>
                                    <select class="form-control" id="bulan" name="bulan" required>
                                        <option value="januari">Januari</option>
                                        <option value="februari">Februari</option>
                                        <option value="maret">Maret</option>
                                        <option value="april">April</option>
                                        <option value="mei">Mei</option>
                                        <option value="juni">Juni</option>
                                        <option value="juli">Juli</option>
                                        <option value="agustus">Agustus</option>
                                        <option value="september">September</option>
                                        <option value="oktober">Oktober</option>
                                        <option value="november">November</option>
                                        <option value="desember">Desember</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <input type="number" class="form-control" id="tahun" name="tahun" min="2000" max="2100" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tenggat" class="form-label">Tenggat (Hari)</label>
                                    <input type="number" class="form-control" id="tenggat" name="tenggat" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jumlah_hutang" class="form-label">Jumlah Hutang</label>
                                    <input type="number" class="form-control" id="jumlah_hutang" name="jumlah_hutang" step="0.01" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- End Modal Tambah -->

            <!-- Modal Tambah -->
            <div class="modal fade" id="tambahmasukModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahModalLabel">Tambah Kas Masuk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= site_url('kasmasuk/tambah') ?>" method="post">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nominal" class="form-label">Nominal</label>
                                    <input type="number" class="form-control" id="nominal" name="nominal" min="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Keterangan</label>
                                    <input type="text" class="form-control" id="deskripsi" name="keterangan" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- End Modal Tambah -->

        </section>

    </main><!-- End #main -->

    <?php $this->load->view('templates/footer'); ?>

</body>

</html>