<?php
$user = $this->fungsi->get_user($invoice['id_pengguna']);
$address = $this->fungsi->get_address($user['id_alamat'], 'str');
$address = explode(',', $address);
$bJalan = $this->alamat_m->get_biaya_jalan($medis['id_alamat'], $user['id_alamat']);
$total = $invoice['total'] + $bJalan['biaya'];
?>
<div class="container-fluid">
  <h4>Terima Pesanan <div class="badge badge-sm badge-success">Nomor: <?php echo $invoice['id_invoice'] ?></div></h4>
  <h6 class="text-muted font-weight-bold mt-4">NAMA<span class="ml-3 mr-2">:</span><?= strtoupper($user['nama_lengkap']); ?></h6>
  <h6 class="text-muted font-weight-bold">ALAMAT<span class="ml-2 mr-2">:</span><?= $address[0]; ?></h6>
  <h6 class="text-muted font-weight-bold pl-4"><span class="ml-4 pl-4"><?= trim($address[1]); ?></span></h6>

  <div class="table-responsive">
    <table class="table table-border table-hover table-striped">
      <tr>
        <th>No</th>
        <th>Nama Layanan</th>
        <th>Jumlah</th>
        <th>Harga Satuan</th>
        <th>Sub-Total</th>
      </tr>
      <?php
        $no = 1;
        foreach($pesanans as $pesanan):
        $subtotal = $pesanan['harga'] * $pesanan['jumlah'];
      ?>
        <tr>
          <td><?= $no ?></td>
          <td><?= $pesanan['nama_layanan'] ?></td>
          <td><?= $pesanan['jumlah'] ?></td>
          <td><?= n_format($pesanan['harga']) ?></td>
          <td><?= n_format($subtotal); ?></td>
        </tr>
      <?php 
        $no++;
        endforeach;
      ?>
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
        <td align="right">Rp. <?= n_format($bJalan['biaya']) ?></td>
      </tr>
      <tr>
        <td colspan="4" align="right">Grand Total</td>
        <td align="right">Rp. <?= n_format($total) ?></td>
      </tr>
    </table>
  </div>
  <div id="grand-total-value" data-value="<?= $total; ?>"></div>
<?= form_open(); ?>
  <input type="hidden" value="<?= $invoice['id_invoice']; ?>" name="id">
  <button type="submit" class="btn btn-success float-right text-white"><i class="fas fa-check"></i> Terima</button>
</form>
<a href="<?php echo base_url(); ?>"><div class="btn btn-danger"><i class="fas fa-ban"></i> Batal</div></a>
</div>
