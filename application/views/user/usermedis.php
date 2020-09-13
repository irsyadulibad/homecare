<?php
	function role($id){
		switch($id){
			case 1:
				return "Admin";
			break;
			case 2:
				return "Medis";
			break;
			case 3:
				return "User";
			break;
		}
	}
?>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>Daftar Paramedis</h4>
			</div>
			<div class="card-body">
				<a href="<?= base_url('user/add'); ?>" class="btn btn-primary float-right mb-4"><i class="fas fa-plus"></i> Tambah</a>
				<div class="table-responsive">
					<table class="table table-striped" id="datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Username</th>
								<th>Nama Lengkap</th>
								<th>Email</th>
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
								<td><?= $user['nama_pengguna']; ?></td>
								<td><?= $user['nama_lengkap']; ?></td>
								<td><?= $user['email']; ?></td>
								<td>
									<a href="<?= base_url('user/edit/'.$user['id_pengguna']); ?>?prev=medis" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
									<a href="<?= base_url('user/del/'.$user['id_pengguna']); ?>?prev=medis" class="btn btn-sm btn-danger confirm-href"><i class="fas fa-trash-alt"></i> Hapus</a>
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