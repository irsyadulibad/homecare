<div class="row">
	<div class="col-lg-3 col-md-6 col-sm-6 col-12">
		<div class="card card-statistic-1">
			<a href="<?= base_url('pesanan'); ?>" class="card-icon bg-primary">
				<i class="fas fa-cart-plus"></i>
			</a>
			<div class="card-wrap">
				<div class="card-header">
					<h4>Total Pesanan</h4>
				</div>
				<div class="card-body">
					<?= $pesanan; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-6 col-sm-6 col-12">
		<div class="card card-statistic-1">
			<a href="<?= base_url('pasien/user'); ?>" class="card-icon bg-danger">
				<i class="fas fa-user"></i>
			</a>
			<div class="card-wrap">
				<div class="card-header">
					<h4>Total Pasien</h4>
				</div>
				<div class="card-body">
					<?= $pasien; ?>
				</div>
			</div>
		</div>
	</div>
</div>
