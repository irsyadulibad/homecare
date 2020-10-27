<?php 
function badge($status){
	switch ($status) {
		case 'pending':
		return 'warning';
		break;
		case 'accepted':
		return 'success';
		break;
		case 'rejected':
		return 'danger';
		break;
		case 'paying':
		return 'success';
		break;
	}
}
?>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>Daftar Pesanan</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped" id="datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Nama Pasien</th>
								<th>Alamat</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_null($invoices)): ?>
								<tr>
									<td colspan="6" align="center">Data masih kosong</td>
								</tr>
							<?php else:
								$i = 1;
								foreach($invoices as $inv):
								$user = $this->user_m->get($inv['id_pengguna']);
								$addr = $this->fungsi->get_address($user['id_alamat']);
							?>
								<tr>
									<td><?= $i; ?></td>
									<td><?= $user['nama_lengkap']; ?></td>
									<td><?= $addr['alamat']; ?></td>
									<td><div class="badge badge-<?= badge($inv['status']); ?>"><?= $inv['status']; ?></div></td>
									<td>
										<a href="<?= base_url('invoice/detail/'.$inv['id_invoice']); ?>?prev=" class="btn btn-sm btn-primary"><i class="fas fa-exclamation-circle"></i> Detail</a>
										<a href="<?= base_url('pesanan/selesai/'.$inv['id_invoice']); ?>?prev=dimedis" class="btn btn-sm btn-success confirm-href"><i class="fas fa-check"></i> Selesai</a>
										<a href="<?= base_url('pesanan/batal/'.$inv['id_invoice']); ?>?prev=dimedis" class="btn btn-sm btn-danger confirm-href"><i class="fas fa-ban"></i> Batalkan</a>
									</td>
								</tr>
							<?php 
								$i++;
								endforeach;
								endif;
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
