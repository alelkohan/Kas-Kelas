<?php $this->load->view('templates/head'); ?>

<body>

	<?php $this->load->view('templates/topbar'); ?>
	<?php $this->load->view('templates/sidebar'); ?>

	<main id="main" class="main">

		<div class="pagetitle">
			<h1>Dashboard</h1>
		</div><!-- End Page Title -->
		<?php if ($this->session->flashdata('error')) : ?>
			<div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert" bis_skin_checked="1">
				<?= $this->session->flashdata('error'); ?>
				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		<?php endif; ?>

		<section class="section dashboard">
			<div class="row">

				<!-- Left side columns -->
				<div class="col">
					<div class="row">


						<div class="row">
							<div class="col">
								<div class="card info-card sales-card">

									<div class="card-body">
										<h5 class="card-title">Saldo Kas<span></span></h5>

										<div class="d-flex align-items-center">
											<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
												<i class="bi bi-cash"></i>
											</div>
											<div class="ps-3">
												<h6>Rp <?= number_format($saldo, 0, ',', '.'); ?></h6>
											</div>
										</div>
									</div>

								</div>
							</div>

							<div class="col">
								<div class="card info-card revenue-card">

									<div class="card-body">
										<h5 class="card-title">Kas Masuk <span></span></h5>

										<div class="d-flex align-items-center">
											<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
												<i class="bi bi-currency-dollar"></i>
											</div>
											<div class="ps-3">
												<h6>Rp <?= number_format($total_kas_masuk, 0, ',', '.'); ?></h6>
											</div>
										</div>
									</div>

								</div>
							</div>

							<div class="col">

								<div class="card info-card customers-card">

									<div class="card-body">
										<h5 class="card-title">Jumlah Siswa <span></span></h5>

										<div class="d-flex align-items-center">
											<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
												<i class="bi bi-people"></i>
											</div>
											<div class="ps-3">
												<h6><?= $total_siswa; ?></h6>
											</div>
										</div>

									</div>
								</div>

							</div>
						</div>

					</div><!-- End Right side columns -->

				</div>
		</section>

	</main><!-- End #main -->

	<?php $this->load->view('templates/footer'); ?>

</body>

</html>