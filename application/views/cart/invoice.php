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
								<th>Tgl Pesanan</th>
								<th>Jam Kunjungan</th>
								<th>Tgl Kunjungan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php if(empty($invoice)): ?>
							<tr>
								<td colspan="6" align="center">Data masih kosong</td>
							</tr>
						<?php else: $i = 0; ?>
							<?php foreach($invoice as $inv): $i++;?>
							<tr>
								<td><?= $i; ?></td>
								<td><?= $inv->nama ?></td>
								<td><?= $inv->alamat ?></td>
								<td><?= $inv->tgl_pesan ?></td>
								<td><?= $inv->jam_kunjungan ?></td>
								<td><?= $inv->tgl_kunjungan ?></td>
								<td>
									<a href="<?= base_url('invoice/detail/'.$inv->id_invoice); ?>?prev=" class="btn btn-sm btn-primary"><i class="fas fa-exclamation-circle"></i> Detail</a>
									<a href="<?= base_url('pesanan/batal/'.$inv->id_invoice); ?>?prev=" class="btn btn-sm btn-danger confirm-href"><i class="fas fa-ban"></i> Batalkan</a>
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
