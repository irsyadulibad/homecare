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
$address = explode(',', $this->fungsi->get_address($user->id_pengguna, 'str'));
?>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>Daftar Pesanan</h4>
			</div>
			<div class="card-body">
				<a href="<?= base_url('cart'); ?>" class="btn btn-primary float-right mb-4"><i class="fas fa-plus"></i> Tambah</a>
				<div class="table-responsive">
					<table class="table table-striped" id="datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Nama Pasien</th>
								<th>Tgl Kunjungan</th>
								<th>Jam Kunjungan</th>
								<th>Alamat</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php if(is_null($pesanans)): ?>
							<tr>
								<td colspan="6" align="center">Data masih kosong</td>
							</tr>
						<?php else: $i = 0; ?>
							<?php foreach($pesanans as $pesanan): $i++;?>
							<tr>
								<td><?= $i; ?></td></td>
								<td><?= $user->nama_lengkap; ?></td>
								<td><?= $pesanan['tgl_kunjungan']; ?></td>
								<td><?= $pesanan['jam_kunjungan']; ?></td>
								<td><?= trim($address[0]); ?></td>
								<td><div class="badge badge-<?= badge($pesanan['status']); ?>"><?= $pesanan['status']; ?></div></td>
								<td>
									<a href="<?= base_url('invoice/detail/'.$pesanan['id_invoice']); ?>?prev=" class="btn btn-sm btn-primary"><i class="fas fa-exclamation-circle"></i> Detail</a>
								<?php if($pesanan['status'] == 'paying'): ?>
									<a href="<?= base_url('pembayaran/konfirmasi/'.$pesanan['id_invoice']); ?>?prev=" class="btn btn-sm btn-success"><i class="fas fa-exclamation-circle"></i> Tagihan</a>
								<?php endif; ?>
								<?php if($pesanan['status'] != 'paying'): ?>
									<a href="<?= base_url('pesanan/batal/'.$pesanan['id_invoice']); ?>?prev=diuser" class="btn btn-sm btn-danger confirm-href"><i class="fas fa-ban"></i> Batalkan</a>
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
