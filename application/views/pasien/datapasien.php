<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>Daftar Pasien</h4>
			</div>
			<div class="card-body">
				<a href="<?= base_url('pasien/add'); ?>" class="btn btn-primary float-right mb-4"><i class="fas fa-plus"></i> Tambah</a>
				<div class="table-responsive">
					<table class="table table-striped" id="datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Nama</th>
								<th>Alamat</th>
								<th>No. Darurat</th>
								<th>Tgl Lahir</th>
								<th>Jenis Kelamin</th>
								<th>Nama Pengguna</th>
								<th>Keterangan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php if(is_null($pasiens)): ?>
							<tr>
								<td colspan="6" align="center">Data masih kosong</td>
							</tr>
						<?php else: $i = 0; ?>
							<?php foreach($pasiens as $pasien): $i++;?>
							<tr>
								<td><?= $i; ?></td>
								<td><?= $pasien['nama_lengkap']; ?></td>
								<td><?= $pasien['alamat']; ?></td>
								<td><?= $pasien['no_darurat']; ?></td>
								<td><?= $pasien['tgl_lahir']; ?></td>
								<td><?= $pasien['jenis_kelamin'] == 1 ? 'Laki-Laki' : 'Perempuan'; ?></td>
								<td><?= $pasien['nama_user']; ?></td>
								<td><?= $pasien['keterangan']; ?></td>
								<td>
									<a href="<?= base_url('pasien/update/'.$pasien['id_pasien']); ?>?prev=" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
									<a href="<?= base_url('pasien/delpas/'.$pasien['id_pasien']); ?>?prev=" class="btn btn-sm btn-danger confirm-href"><i class="fas fa-trash-alt"></i> Hapus</a>
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