<?php
$user = $this->fungsi->get_user($riwayat['id_pengguna']);
$address = explode(',', $this->fungsi->get_address($user->id_pengguna, 'str'));
?>
<div class="container-fluid">
	<h4>Riwayat Pesanan</h4>

	<h6 class="text-muted font-weight-bold mt-4">NAMA<span class="ml-3 mr-2">:</span><?= strtoupper($user->nama_lengkap); ?></h6>
    <h6 class="text-muted font-weight-bold">ALAMAT<span class="ml-2 mr-2">:</span><?= $address[0]; ?></h6>
    <h6 class="text-muted font-weight-bold pl-4"><span class="ml-4 pl-4"><?= trim($address[1]); ?></span></h6>
    <h6 class="text-muted font-weight-bold">MEDIS<span class="ml-2 mr-2">:</span><?= strtoupper($medis['nama_lengkap']); ?></h6>
	<table class="table table-bordered table-striped mt-4">
		<tr>
			<th>TGL Kunjungan</th>
			<th>Jam Kunjungan</th>
			<th>Tanggal Pesan</th>
		</tr>
		<tr>
			<td><?= $riwayat['tgl_kunjungan']; ?></td>
			<td><?= $riwayat['jam_kunjungan']; ?></td>
			<td><?= $riwayat['tgl_pesan']; ?></td>
		</tr>
	</table>
	<table class="table table-bordered table-striped mt-4">
		<tr>
			<th>Nama Layanan</th>
			<th>Jumlah</th>
			<th>Total Harga</th>
		</tr>
	<?php 
	$lyntotal = 0;
	foreach($layanan as $lyn): 
		$lyntotal += $lyn->harga * $lyn->jumlah;
	?>
		<tr>
			<td><?= $lyn->nama_layanan; ?></td>
			<td><?= $lyn->jumlah; ?></td>
			<td>Rp.<?= number_format($lyn->harga * $lyn->jumlah, 0, ',', '.'); ?></td>
		</tr>
	<?php endforeach; ?>
		<tr>
			<th colspan="2">Total Harga</th>
			<td>Rp.<?= number_format($lyntotal, 0, ',', '.'); ?></td>
		</tr>
	</table>
	<table class="table table-bordered table-striped mt-4">
		<tr>
			<th>Nama Obat</th>
			<th>Jumlah</th>
			<th>Total Harga</th>
		</tr>
	<?php 
	$obtotal = 0;
	foreach($obat as $ob):
	$obtotal += $ob['harga'] * $ob['qty'];
	?>
		<tr>
			<td><?= $ob['nama']; ?></td>
			<td><?= $ob['qty']; ?></td>
			<td>Rp.<?= number_format($ob['harga'] * $ob['qty'], 0, ',', '.'); ?></td>
		</tr>
	<?php endforeach; ?>
		<tr>
			<th colspan="2">Total Harga</th>
			<td>Rp.<?= number_format($obtotal, 0, ',', '.'); ?></td>
		</tr>
	</table>
	<table class="table table-bordered table-striped mt-4">
		<tr>
			<th colspan="2">Biaya Kirim</th>
			<td>Rp.<?= number_format($riwayat['biaya_kirim'], 0, ',', '.'); ?></td>
		</tr>
		<tr>
			<th colspan="2">Biaya Lainnya</th>
			<td>Rp.<?= number_format($riwayat['biaya_lain'], 0, ',', '.'); ?></td>
		</tr>
	</table>
	<div class="text-center mt-3">
		<h5 class="mt-4 text-center text-muted">Biaya Total : </h5>
		<h1 class="text-center mb-3" style="color: #7571f9;"><sup style="font-size: 20px;">Rp</sup> <?= number_format($riwayat['total'] + $riwayat['biaya_lain'] + $riwayat['biaya_kirim'],0,',','.'); ?></h1>
	</div>
	<a class="btn btn-primary btn-sm text-white mt-3" href="<?= base_url('/riwayat'); ?>">kembali</a>
	<?php if($user->role == 3): ?>
	<a class="btn btn-success btn-sm text-white float-right mt-3" href="<?= is_null($riwayat['review']) ? base_url('/ulasan/tambah/'.$riwayat['id_riwayat']) : base_url('/ulasan/detail/'.$riwayat['id_riwayat']); ?>">Review</a>
	<?php endif; ?>
</div>
