<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>Daftar Invoice</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped" id="datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Nama</th>
								<th>Alamat</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php if(empty($invoices)): ?>
							<tr>
								<td colspan="4" align="center">Data masih kosong</td>
							</tr>
						<?php
							else:
							$i = 1;
							foreach($invoices as $inv):
							$user = $this->user_m->get($inv['id_pengguna']);
							$address = $this->fungsi->get_address($user['id_alamat']);
						?>
							<tr>
								<td><?= $i; ?></td>
								<td><?= $user['nama_lengkap'] ?></td>
								<td><?= $address['alamat'] ?></td>
								<td>
									<a href="<?= base_url('invoice/detail/'.$inv['id_invoice']); ?>?prev=" class="btn btn-sm btn-primary"><i class="fas fa-exclamation-circle"></i> Detail</a>
									<a href="<?= base_url('pesanan/batal/'.$inv['id_invoice']); ?>?prev=" class="btn btn-sm btn-danger confirm-href"><i class="fas fa-ban"></i> Batalkan</a>
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
