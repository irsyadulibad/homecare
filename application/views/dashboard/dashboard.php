<div class="row">
	<div class="col-lg-3 col-md-6 col-sm-6 col-12">
		<div class="card card-statistic-1">
			<a href="<?= base_url('invoice'); ?>" class="card-icon bg-primary">
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
			<a href="<?= base_url('user'); ?>" class="card-icon bg-danger">
				<i class="fas fa-users"></i>
			</a>
			<div class="card-wrap">
				<div class="card-header">
					<h4>Total Pengguna</h4>
				</div>
				<div class="card-body">
					<?= $pengguna; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-6 col-sm-6 col-12">
		<div class="card card-statistic-1">
			<a href="<?= base_url('user/medis'); ?>" class="card-icon bg-warning">
				<i class="fas fa-users"></i>
			</a>
			<div class="card-wrap">
				<div class="card-header">
					<h4>Total Paramedis</h4>
				</div>
				<div class="card-body">
					<?= $paramedis; ?>
				</div>
			</div>
		</div>
	</div>
		<div class="col-lg-3 col-md-6 col-sm-6 col-12">
		<div class="card card-statistic-1">
			<a href="<?= base_url('ulasan'); ?>" class="card-icon bg-success">
				<i class="fas fa-star"></i>
			</a>
			<div class="card-wrap">
				<div class="card-header">
					<h4>Rating Rata-Rata</h4>
				</div>
				<div class="card-body">
					<?= $rateaverage; ?>
				</div>
			</div>
		</div>
	</div>
</div>
