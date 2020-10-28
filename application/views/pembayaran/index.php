<div class="container-fluid">
	<h4>Daftar Pembayaran</h4>
	<div class="table-responsive">
		<table class="table table-bordered table-striped mt-4">
			<tr>
				<th>No.</th>
				<th>Nama</th>
				<th>Total</th>
				<th>Aksi</th>
			</tr>
		<?php if(empty($invoices)): ?>
			<tr>
				<td colspan="5" class="text-center">Daftar Kosong</td>
			</tr>
		<?php
			else:
			$i=1
		?>
		<?php
			foreach($invoices as $invoice):
			$user = $this->user_m->get($invoice['id_pengguna']);
			$bJalan = $this->alamat_m->get_biaya_byid($invoice['id_biayajalan']);
		?>
			<tr>
				<td><?= $i++; ?></td>
				<td><?= $user['nama_lengkap'] ?></td>
				<td>Rp. <?= n_format($invoice['total'] + $bJalan['biaya']) ?></td>
				<td>
					<a href="<?= base_url('pembayaran/konfirmasi/'.$invoice['id_invoice']); ?>" class="btn btn-sm btn-success text-white confirm-href">
						<i class="fas fa-check"></i> Konfirmasi
					</a>
					<a href="<?= base_url('pembayaran/batalkan/'.$invoice['id_invoice']); ?>" class="btn btn-sm btn-danger text-white confirm-href">Batalkan</a>
				</td>
			</tr>
		<?php endforeach; ?>
		<?php endif; ?>
		</table>
	</div>
</div>
