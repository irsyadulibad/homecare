<?php
$user = $this->user_m->get($invoice['id_pengguna']);
$address = $this->fungsi->get_address($user['id_alamat'], 'str');
$address = explode(',', $address);
$bJalan = $this->alamat_m->get_biaya_byid($invoice['id_biayajalan']);
$total = $invoice['total'] + $bJalan['biaya'];
?>
<div class="container-fluid">
	<h4>Selesaikan Pesanan</h4>

	<h6 class="text-muted font-weight-bold mt-4">NAMA<span class="ml-3 mr-2">:</span><?= strtoupper($user['nama_lengkap']); ?></h6>
    <h6 class="text-muted font-weight-bold">ALAMAT<span class="ml-2 mr-2">:</span><?= $address[0]; ?></h6>
    <h6 class="text-muted font-weight-bold pl-4"><span class="ml-4 pl-4"><?= trim($address[1]); ?></span></h6>
    <h6 class="text-muted font-weight-bold">MEDIS<span class="ml-2 mr-2">:</span><?= strtoupper($medis['nama_lengkap']); ?></h6>
    <form action="" method="post">
	<div class="table-responsive">
	<table class="table table-border table-hover table-striped">
      <tr>
        <th>No</th>
        <th>Nama Layanan</th>
        <th>Jumlah</th>
        <th>Harga Satuan</th>
        <th>Sub-Total</th>
      </tr>
    <?php foreach($pesanans as $pesanan):
      $subtotal = $pesanan['harga'] * $pesanan['jumlah'];
    ?>
      <tr>
        <td><?= $pesanan['id_layanan'] ?></td>
        <td><?= $pesanan['nama_layanan'] ?></td>
        <td><?= $pesanan['jumlah'] ?></td>
        <td><?= n_format($pesanan['harga']) ?></td>
        <td><?= n_format($subtotal); ?></td>
      </tr>
    <?php endforeach; ?>
      <tr>
        <td colspan="5"></td>
      </tr>
      <tr>
        <td colspan="4" align="right">Biaya Obat</td>
        <td align="right">Rp. <?= n_format($invoice['biaya_obat']) ?></td>
      </tr>
      <tr>
        <td colspan="4" align="right">Biaya Lainnya</td>
        <td align="right">Rp. <?= n_format($invoice['biaya_lain']) ?></td>
      </tr>
      <tr>
        <td colspan="4" align="right">Biaya Jalan</td>
        <td align="right">Rp. <?= $bJalan['biaya']; ?></td>
      </tr>
      <tr>
        <td colspan="4" align="right">Grand Total</td>
        <td align="right">Rp. <?= n_format($total) ?></td>
      </tr>
    </table>
	</div>

	<div class="text-center mt-3">
		<small class="d-block mb-2">*Untuk biaya lain, misal oksigen silahkan menambahkannya melalui tombol dibawah</small>
		<a href="<?= base_url('pesanan/tambah/'.$invoice['id_invoice']); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
	</div>

	<button class="btn btn-success btn-sm text-white float-right mt-3" type="submit">Konfirmasi</button>
	</form>
</div>
