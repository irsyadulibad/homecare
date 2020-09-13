<?php
$prov = $this->pesanan_m->getProv($invoice->provinsi)['nama'];
$kota = $this->pesanan_m->getKota($invoice->kota)['nama'];
$kec = $this->pesanan_m->getKec($invoice->kecamatan)['nama'];
$desa = $this->pesanan_m->getDesa($invoice->desa)['nama'];
$role = $this->fungsi->user_login()->role;
$total = $invoice->total + $invoice->biaya_obat + $invoice->biaya_kirim;
?>
<div class="container-fluid">

	<h6 class="text-muted font-weight-bold mt-4">NAMA<span class="ml-3 mr-2">:</span><?= strtoupper($invoice->nama); ?></h6>
    <h6 class="text-muted font-weight-bold">ALAMAT<span class="ml-2 mr-2">:</span><?= $invoice->alamat; ?></h6>
    <h6 class="text-muted font-weight-bold pl-4"><span class="ml-4 pl-4"><?= "$desa - $kec - $kota - $prov"; ?></span></h6>
    <h6 class="text-muted font-weight-bold">MEDIS<span class="ml-2 mr-2">:</span><?= strtoupper($medis['nama_lengkap']); ?></h6>
	<div class="table-responsive">
	<table class="table table-bordered table-striped mt-4">
		<tr>
			<th>Nama Layanan</th>
			<th>Jumlah</th>
			<th>Sub-Total</th>
		</tr>
	<?php foreach ($pesanan as $psn): ?>
		<?php
			$subtotal = $psn->jumlah * $psn->harga;
    	?>
		<tr>
			<td><?= $psn->nama_layanan; ?></td>
			<td><?= $psn->jumlah; ?></td>
			<td>Rp.<?= number_format($subtotal,0,',','.'); ?></td>
		</tr>
	<?php endforeach;
	 $total = $total + intval($invoice->biaya_lain);
	?>
		<tr>
			<td colspan="3"></td>
		</tr>
		<tr>
			<th>Nama Obat</th>
			<th>Jumlah</th>
			<th>Sub-Total</th>
		</tr>
	<?php foreach($obat as $ob): ?>
		<tr>
			<td><?= $ob['nama']; ?></td>
			<td><?= $ob['qty']; ?></td>
		<?php $subtotal_obat = $ob['harga'] * $ob['qty']; ?>
			<td><?= $subtotal_obat; ?></td>
		</tr>
	<?php endforeach; ?>
		<tr>
			<td colspan="3" align="right">Biaya Kirim : Rp.<?= number_format($invoice->biaya_kirim,0,',','.'); ?></td>
		</tr>
		<tr>
			<td colspan="3" align="right">Biaya Lain : Rp.<?= number_format($invoice->biaya_lain,0,',','.'); ?></td>
		</tr>
		<tr>
			<td colspan="3" align="right">Total : Rp.<?= number_format($total,0,',','.'); ?></td>
		</tr>
	</table>
	</div>
	<div class="text-center">
	<?php if($role == 2): ?>
		<h6 class="mt-4 text-center text-muted">Jika pasien sudah membayar, tekan tombol konfirmasi</h6>
	<?php else: ?>
		<h5 class="mt-4 text-center text-muted">Silahkan lakukan pembayaran sebesar : </h5>
	<?php endif; ?>
		<h1 class="text-center mb-3" style="color: #7571f9;"><sup style="font-size: 20px;">Rp</sup> <?= number_format($total,0,',','.'); ?></h1>
	</div>
	<?php if($role == 2): ?>
	<a class="btn btn-success btn-sm text-white float-right mt-3 confirm-href" href="<?= base_url('/pembayaran/bayar/'.$invoice->id_invoice); ?>">Konfirmasi</a>
	<?php endif; ?>
</div>
