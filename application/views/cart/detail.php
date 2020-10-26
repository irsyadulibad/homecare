<?php
$user = $this->user_m->get($invoice['id_pengguna']);
$address = $this->fungsi->get_address($user['id_alamat'], 'str');
$address = explode(',', $address);
$status = null;

if(!is_null($invoice['id_medis'])){
  $medis = $this->medis_m->get($invoice['id_medis']);
}else{
  $medis = ['nama_lengkap' => null];
}

switch ($invoice['status']) {
  case 'pending':
    $status = 'warning';
    break;
  case 'accepted':
    $status = 'success';
    break;
  case 'completed':
    $status = 'primary';
    break;
  default:
    $status = 'success';
    break;
}
?>
<div class="container-fluid">
  <div class="btn btn-sm btn-success">No. Invoice: <?php echo $invoice['id_invoice'] ?></div>
  <h6 class="text-muted font-weight-bold mt-4">NAMA<span class="ml-3 mr-2">:</span><?= strtoupper($user['nama_lengkap']); ?></h6>
  <h6 class="text-muted font-weight-bold">ALAMAT<span class="ml-2 mr-2">:</span><?= $address[0]; ?></h6>
  <h6 class="text-muted font-weight-bold pl-4"><span class="ml-4 pl-4"><?= trim($address[1]); ?></span></h6>

  <h6 class="mt-2 mb-3 text-left">Status: <span class="badge badge-<?= $status; ?> font-weight-bold text-white"><?= $invoice['status']; ?></span> </h6>
  <div class="table-responsive mt-3">
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
        <td align="right">Rp. <?= 0 ?></td>
      </tr>
      <tr>
        <td colspan="4" align="right">Grand Total</td>
        <td align="right">Rp. <?= n_format($invoice['total']) ?></td>
      </tr>
      <tr>
        <td align="left">Nama Medis : <span class="bg-white p-1 rounded"><?= $medis['nama_lengkap']; ?></span></td>
      </tr>
    </table>
  </div>

<a href="<?php echo base_url('invoice/index') ?>"><div class="btn btn-sm btn-primary"> Kembali</div></a>
</div>
