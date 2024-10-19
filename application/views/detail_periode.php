<?php $this->load->view('templates/head'); ?>

<body>

    <?php $this->load->view('templates/topbar'); ?>
    <?php $this->load->view('templates/sidebar'); ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Detail Periode</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= site_url('periode') ?>">Periode</a></li>
                    <li class="breadcrumb-item active">Detail Periode</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <?php if ($this->session->flashdata('alert_reset')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" bis_skin_checked="1">
                <i class="bi bi-exclamation-octagon me-1"></i><?= $this->session->flashdata('alert_reset'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('message')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" bis_skin_checked="1">
                <i class="bi bi-check-circle me-1"></i><?= $this->session->flashdata('message'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title">Detail Periode: <?= $periode->bulan; ?>/<?= $periode->tahun; ?></h5>
                        <button id="resetButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#resetModal" style="margin-top: 10px; margin-bottom: 10px;"><i class="bi bi-arrow-counterclockwise"></i></button>
                    </div>
                    <p>Tenggat: Setiap <?= $periode->tenggat; ?> hari <strong> || </strong>Minimal Bayar: Rp <?= number_format($periode->jumlah_hutang, 0, ',', '.') ?></p>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Siswa</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($siswa as $row) :
                            ?>
                                <tr>
                                    <th scope="row"><?= $no++; ?></th>
                                    <td><?= $row->nama_siswa; ?></td>
                                    <td>
                                        <?php if ($row->status == 'Belum Bayar') : ?>
                                            <span class="badge bg-danger"><?= $row->status; ?></span>
                                        <?php elseif ($row->hutang > 0) : ?>
                                            <span class="badge bg-warning">Hutang Belum Lunas</span>
                                        <?php else : ?>
                                            <span class="badge bg-success"><?= $row->status; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <!-- Aksi untuk pembayaran -->
                                        <button type="button" class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal" data-bs-target="#bayarModal<?= $row->id_siswa ?>"
                                            data-id_periode="<?= $periode->id_periode ?>"
                                            data-nama_siswa="<?= $row->nama_siswa ?>"
                                            data-hutang="<?= $row->hutang ?>">
                                            Bayar
                                        </button>

                                        <div class="modal fade" id="bayarModal<?= $row->id_siswa ?>" tabindex="-1" aria-labelledby="bayarModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="<?= site_url('periode/bayar_kas'); ?>" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="bayarModalLabel">Bayar Kas untuk <?= $row->nama_siswa ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id_periode" id="id_periode" value="<?= $periode->id_periode ?>">
                                                            <input type="hidden" name="nama_siswa" id="nama_siswa" value="<?= $row->nama_siswa ?>">
                                                            <div class="mb-3">
                                                                <label for="tanggal" class="form-label">Tanggal</label>
                                                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="jumlah" class="form-label">Jumlah</label>
                                                                <input type="number" class="form-control" id="jumlah" name="jumlah" min="" required>
                                                                <small id="jumlahHutang" class="form-text text-muted">Jumlah Hutang: Rp <?= number_format($row->hutang, 0, ',', '.'); ?></small>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                                <input type="text" class="form-control" id="keterangan" name="keterangan">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-primary">Bayar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Modal untuk pembayaran -->
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">Kas Masuk Minggu Ini</h5>
                                <button type="button" class="btn btn-primary mt-3 mb-2" data-bs-toggle="modal" data-bs-target="#detailModal"><i class="bi bi-info-square"></i></button>
                            </div>
                            <div class="card-body" style="max-height: 350px; overflow-y: auto;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama Siswa</th>
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Jumlah</th>
                                            <th scope="col">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($kasmasuk as $kas) : ?>
                                            <tr>
                                                <th scope="row"><?= $no++; ?></th>
                                                <td><?= $kas->nama_siswa; ?></td>
                                                <td><?= $kas->tanggal; ?></td>
                                                <td>Rp <?= number_format($kas->jumlah, 0, ',', '.'); ?></td>
                                                <td><?= $kas->keterangan; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div><!-- End Default Card -->

                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">Kas Keluar</h5>
                                <button type="button" class="btn btn-primary mt-3 mb-2" data-bs-toggle="modal" data-bs-target="#tambahKasKeluarModal"><i class="bi bi-clipboard-plus"></i></button>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Nominal</th>
                                            <th scope="col">Keterangan</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($kaskeluar as $kas) : ?>
                                            <tr>
                                                <th scope="row"><?= $no++; ?></th>
                                                <td><?= $kas->tanggal; ?></td>
                                                <td>Rp <?= number_format($kas->nominal, 0, ',', '.'); ?></td>
                                                <td><?= $kas->keterangan; ?></td>
                                                <td>
                                                    <a href="<?= site_url('periode/hapus_kaskeluar/' . $kas->id_kaskeluar . '/' . $periode->id_periode); ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah kamu yakin ingin menghapus kas keluar ini?')"><i class="bi bi-trash"></i></a>
                                                </td>
                                            </tr>

                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                            </div>

                            <!-- Modal Tambah Kas Keluar -->
                            <div class="modal fade" id="tambahKasKeluarModal" tabindex="-1" aria-labelledby="tambahKasKeluarModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="tambahKasKeluarModalLabel">Tambah Kas Keluar</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="<?= site_url('periode/tambah_kaskeluar'); ?>" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_periode" value="<?= $periode->id_periode ?>">
                                                <div class="mb-3">
                                                    <label for="tanggal" class="form-label">Tanggal</label>
                                                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nominal" class="form-label">Nominal</label>
                                                    <input type="number" class="form-control" id="nominal" name="nominal" max="<?= $saldo; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <input type="text" class="form-control" id="keterangan" name="keterangan">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Tambah</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModal" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="tambahKasKeluarModalLabel">Riwayat Kas Masuk</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">Nama Siswa</th>
                                                        <th scope="col">Tanggal</th>
                                                        <th scope="col">Jumlah</th>
                                                        <th scope="col">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    foreach ($detail as $detail) : ?>
                                                        <tr>
                                                            <th scope="row"><?= $no++; ?></th>
                                                            <td><?= $detail->nama_siswa; ?></td>
                                                            <td><?= $detail->tanggal_bayar; ?></td>
                                                            <td>Rp <?= number_format($detail->jumlah, 0, ',', '.'); ?></td>
                                                            <td><?= $detail->status; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="resetModalLabel">Reset Status Siswa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin mereset status siswa?,
                                            <p>Pastikan terlebih dahulu apakah sudah ada alert untuk mereset status siswa?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btm-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <a type="" class="btn btm-sm btn-danger" href="<?= site_url('periode/reset_status/' . $periode->id_periode); ?>">Reset Status</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <?php $this->load->view('templates/footer'); ?>

    <script>
        // Pada JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            var bayarModal = document.getElementById('bayarModal');
            bayarModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var idPeriode = button.getAttribute('data-id_periode');
                var namaSiswa = button.getAttribute('data-nama_siswa');
                var hutang = button.getAttribute('data-hutang');

                var modalTitle = bayarModal.querySelector('.modal-title');
                var modalBodyInputIdPeriode = bayarModal.querySelector('#id_periode');
                var modalBodyInputNamaSiswa = bayarModal.querySelector('#nama_siswa');
                var modalBodyInputJumlah = bayarModal.querySelector('#jumlah');
                var modalBodySmallJumlahHutang = bayarModal.querySelector('#jumlahHutang');

                modalTitle.textContent = 'Bayar Kas untuk ' + namaSiswa;
                modalBodyInputIdPeriode.value = idPeriode;
                modalBodyInputNamaSiswa.value = namaSiswa;
                modalBodySmallJumlahHutang.textContent = 'Jumlah Hutang: Rp ' + new Intl.NumberFormat('id-ID').format(hutang);
            });
        });

        function setBayarModal(id_periode, nama_siswa, hutang) {
            document.getElementById('id_periode').value = id_periode;
            document.getElementById('nama_siswa').value = nama_siswa;
            document.getElementById('jumlah_hutang').value = hutang;
            document.getElementById('jumlah').setAttribute('min', hutang);
        }
    </script>

</body>

</html>