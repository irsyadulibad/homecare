<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>Riwayat Pesanan</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped" id="datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Nama</th>
								<th>Tgl Kunjungan</th>
								<th>Jam Kunjungan</th>
								<th>Tanggal Pesan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php if(empty($histories)): ?>
							<tr>
								<td colspan="6" align="center">Data masih kosong</td>
							</tr>
						<?php
							else:
							$i = 1;
							foreach($histories as $history):
								$pas = $this->user_m->get($history['id_pengguna']);
								$reviewed = $this->ulasan_m->reviewed($history['id_invoice']);
						?>
							<tr>
								<td><?= $i++; ?></td>
								<td><?= $pas['nama_lengkap']; ?></td>
								<td><?= $history['tgl_kunjungan']; ?></td>
								<td><?= $history['jam_kunjungan']; ?></td>
								<td><?= $history['tgl_pesan']; ?></td>
								<td>
									<a href="<?= base_url('riwayat/detail/'.$history['id_riwayat']); ?>?prev=" class="btn btn-sm btn-primary"><i class="fas fa-exclamation-circle"></i> Detail</a>
								<?php if(!$reviewed['status']): ?>
									<?php if($user['status'] == 'user'): ?>
									<a href="<?= base_url('ulasan/tambah/'.$history['id_riwayat']); ?>?prev=" class="btn btn-sm btn-success"><i class="fas fa-star"></i> Ulas</a>
									<?php endif; ?>
								<?php else: ?>
									<a href="<?= base_url('ulasan/detail/'.$reviewed['id']); ?>" class="btn btn-sm btn-success"><i class="fas fa-star"></i> Ulasan</a>
								<?php endif; ?>
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
