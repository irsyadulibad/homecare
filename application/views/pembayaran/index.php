<div class="container-fluid">
	<h4>Daftar Pembayaran</h4>
	<div class="table-responsive">
	<table class="table table-bordered table-striped mt-4">
		<tr>
			<th>No.</th>
			<th>Nama</th>
			<th>Tgl Kunjungan</th>
			<th>Total</th>
			<th>Aksi</th>
		</tr>
		<?php if(empty($invoices)): ?>
		<tr>
			<td colspan="5" class="text-center">Daftar Kosong</td>
		</tr>
		<?php else: $i=1?>
			<?php foreach ($invoices as $invoice): ?>
				<tr>
					<td><?= $i++; ?></td>
					<td><?= $this->fungsi->get_user($invoice['id_pengguna'])->nama_lengkap; ?></td>
					<td><?= $invoice['tgl_kunjungan']; ?></td>
					<td>Rp.<?= number_format($invoice['total'] + $invoice['biaya_lain'] + $invoice['biaya_obat'] + $invoice['biaya_kirim'], 0, ',', '.'); ?></td>
					<td>
						<a href="<?= base_url('pembayaran/konfirmasi/'.$invoice['id_invoice']); ?>" class="btn btn-sm btn-success text-white confirm-href">Konfirmasi</a>
						<a href="<?= base_url('pembayaran/batalkan/'.$invoice['id_invoice']); ?>" class="btn btn-sm btn-danger text-white confirm-href">Batalkan</a>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</table>
	</div>
</div>
