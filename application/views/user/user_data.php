<?php
$users = [];

foreach($user as $usr){
	$users[] = $usr;
}

foreach($medis as $mds){
	$users[] = $mds;
}

?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>Daftar Semua Pengguna</h4>
			</div>
			<div class="card-body">
				<a href="<?= base_url('user/add'); ?>" class="btn btn-primary float-right mb-4"><i class="fas fa-plus"></i> Tambah</a>
				<div class="table-responsive">
					<table class="table table-striped" id="datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Nama Lengkap</th>
								<th>No HP</th>
								<th>Email</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php if(is_null($users)): ?>
							<tr>
								<td colspan="6" align="center">Data masih kosong</td>
							</tr>
						<?php else: $i = 0; ?>
							<?php foreach($users as $user): $i++;?>
							<tr>
								<td><?= $i; ?></td>
								<td><?= $user['nama_lengkap']; ?></td>
								<td><?= $user['no_hp']; ?></td>
								<td><?= $user['email']; ?></td>
								<td><?= $user['status']; ?></td>
								<td>
								<?php if($user['status'] == 'admin' || $user['status'] == 'user'): ?>
									<a href="<?= base_url('user/edit/'.$user['id_pengguna']); ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
									<a href="<?= base_url('user/del/'.$user['id_pengguna']); ?>" class="btn btn-sm btn-danger confirm-href"><i class="fas fa-trash-alt"></i> Hapus</a>
								<?php else: ?>
									<a href="<?= base_url('user/editmedis/'.$user['id_medis']); ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
									<a href="<?= base_url('user/delmedis/'.$user['id_medis']); ?>" class="btn btn-sm btn-danger confirm-href"><i class="fas fa-trash-alt"></i> Hapus</a>
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
