<?php
$pasien = $this->fungsi->get_user($invoice->id_pengguna);
$address = explode(',', $this->fungsi->get_address($pasien->id_pengguna, 'str'));
$total = 0;
?>
<div class="container-fluid">
	<h4>Selesaikan Pesanan</h4>

	<h6 class="text-muted font-weight-bold mt-4">NAMA<span class="ml-3 mr-2">:</span><?= strtoupper($pasien->nama_lengkap); ?></h6>
    <h6 class="text-muted font-weight-bold">ALAMAT<span class="ml-2 mr-2">:</span><?= $address[0]; ?></h6>
    <h6 class="text-muted font-weight-bold pl-4"><span class="ml-4 pl-4"><?= trim($address[1]); ?></span></h6>
    <h6 class="text-muted font-weight-bold">MEDIS<span class="ml-2 mr-2">:</span><?= strtoupper($medis['nama_lengkap']); ?></h6>
    <form action="" method="post">
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
        	$total += $subtotal;
    	?>
		<tr>
			<td><?= $psn->nama_layanan; ?></td>
			<td><?= $psn->jumlah; ?></td>
			<td>Rp.<?= number_format($subtotal,0,',','.'); ?></td>
		</tr>
	<?php endforeach; ?>

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
		<?php $subtotal_obat = $ob['harga'] * $ob['qty'];
			$total += $subtotal_obat; ?>
			<td><?= number_format($subtotal_obat, 0, ',', '.'); ?></td>
		</tr>
	<?php endforeach; 
		$total += $invoice->biaya_lain + $invoice->biaya_kirim; ?>
		<tr>
			<td colspan="3"></td>
		</tr>
		<tr>
			<td colspan="3" align="right">Ongkos Kirim: Rp.<?= number_format($invoice->biaya_kirim,0,',','.'); ?></td>
		</tr>
		<tr>
			<td colspan="3" align="right">Total : Rp.<?= number_format($total,0,',','.'); ?></td>
		</tr>
	</table>
	</div>
	<div class="text-center">
		<h6 class="text-muted mt-4">Biaya Lainnya (ex. transport, obat, dll)</h6>
		<span style="font-size: 25px;">Rp. </span><input type="number" name="biaya_lain" class="border rounded p-2" value="<?= $invoice->biaya_lain; ?>" autofocus>
		<br><br><small>*Biaya lainnya akan ditambahkan pada total</small>
	</div>
	<a class="btn btn-primary btn-sm mt-3" href="<?= base_url('pesanan/tambah_obat/'.$invoice->id_invoice); ?>">Tambah Obat</a>
	<button class="btn btn-success btn-sm text-white float-right mt-3" type="submit">Konfirmasi</button>
	</form>
</div>
