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
<div class="row justify-content-center">
	<div class="col-md-10">
		<div class="card">
			<div class="card-header">
				<h4>Pending Invoice</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="datatable" class="table table-striped">
						<thead>
							<th>#</th>
							<th>Nama Pasien</th>
							<th>Alamat</th>
							<th>Aksi</th>
						</thead>
						<tbody>
							<?php if(empty($pending_invoice)): ?>
							<tr>
								<td colspan="7">Data masih kosong</td>
							</tr>
							<?php else: $i=0; ?>
								<?php foreach($pending_invoice as $pi): $i++; ?>
									<?php $user = $this->fungsi->get_user($pi['id_pengguna']); ?>
									<tr>
										<td><?= $i; ?></td>
										<td><?= $user['nama_lengkap']; ?></td>
										<td><?= $user['alamat']['alamat']; ?></td>
										<td>
											<a href="<?= base_url('invoice/detail/'.$pi['id_invoice']); ?>?prev=" class="btn btn-sm btn-primary"><i class="fas fa-exclamation-circle"></i> Detail</a>
											<a href="<?= base_url('invoice/accept/'.$pi['id_invoice']); ?>?prev=diuser" class="btn btn-sm btn-success confirm-href"><i class="fas fa-check"></i> Terima</a
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
