<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>Riwayat Pesanan</h4>
			</div>
			<div class="card-body">
				<a href="<?= base_url('layanan/add'); ?>" class="btn btn-primary float-right mb-4"><i class="fas fa-plus"></i> Tambah</a>
				<div class="table-responsive">
					<table class="table table-striped" id="datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Nama</th>
								<th>Tgl Kunjungan</th>
								<th>Jam Kunjungan</th>
								<th>Tanggal Pesan</th>
								<th>Total</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php if(is_null($histories)): ?>
							<tr>
								<td colspan="6" align="center">Data masih kosong</td>
							</tr>
						<?php else: $i = 0; ?>
							<?php foreach($histories as $history): $i++; $total = intval($history['total'] + $history['biaya_lain'] + $history['biaya_kirim']); ?>
							<tr>
								<td><?= $i; ?></td>
								<td><?= $this->fungsi->get_user($history['id_pengguna'])->nama_lengkap; ?></td>
								<td><?= $history['tgl_kunjungan']; ?></td>
								<td><?= $history['jam_kunjungan']; ?></td>
								<td><?= $history['tgl_pesan']; ?></td>
								<td>Rp.<?= number_format($total, 0, ',','.'); ?> </td>
								<td>
									<a href="<?= base_url('riwayat/detail/'.$history['id_riwayat']); ?>?prev=" class="btn btn-sm btn-primary"><i class="fas fa-exclamation-circle"></i> Detail</a>
								<?php if(is_null($history['review'])): ?>
									<?php if($user->role != 2): ?>
									<a href="<?= base_url('ulasan/tambah/'.$history['id_riwayat']); ?>?prev=" class="btn btn-sm btn-success"><i class="fas fa-star"></i> Ulas</a>
									<?php endif; ?>
								<?php else: ?>
									<a href="<?= base_url('ulasan/detail/'.$history['review']); ?>" class="btn btn-sm btn-success"><i class="fas fa-star"></i> Ulasan</a>
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
