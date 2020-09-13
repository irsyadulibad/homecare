<?php
$prov = $this->pesanan_m->getProv($invoice->provinsi)['nama'];
$kota = $this->pesanan_m->getKota($invoice->kota)['nama'];
$kec = $this->pesanan_m->getKec($invoice->kecamatan)['nama'];
$desa = $this->pesanan_m->getDesa($invoice->desa)['nama'];
$total = $invoice->total;
?>
<div class="container-fluid">
    <h4>Terima Pesanan <div class="badge badge-sm badge-success">Nomor: <?php echo $invoice->id_invoice ?></div></h4>
	<h6 class="text-muted font-weight-bold mt-4">NAMA<span class="ml-3 mr-2">:</span><?= strtoupper($invoice->nama); ?></h6>
    <h6 class="text-muted font-weight-bold">ALAMAT<span class="ml-2 mr-2">:</span><?= $invoice->alamat; ?></h6>
    <h6 class="text-muted font-weight-bold pl-4"><span class="ml-4 pl-4"><?= "$desa - $kec - $kota - $prov"; ?></span></h6>

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
        foreach($pesanan as $psn) {
                $subtotal = $psn->jumlah * $psn->harga;
        ?>
        <tr>
            <td><?= $psn->id_layanan ?></td>
            <td><?= $psn->nama_layanan ?></td>
            <td><?= $psn->jumlah ?></td>
            <td><?= number_format($psn->harga,0,',','.') ?></td>
            <td><?= number_format($subtotal,0,',','.') ?></td>


        </tr>
        <?php } ?>
        <tr>
            <td colspan="5"></td>
        </tr>
        
        <tr>
            <th>No.</th>
            <th>Nama Obat</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Sub-Total</th>
        </tr>
    <?php $n = 0; foreach($obat as $ob): $n++; ?>
        <tr>
            <td><?= $n; ?></td>
            <td><?= $ob['nama']; ?></td>
            <td><?= $ob['qty']; ?></td>
            <td><?= number_format($ob['harga'], 0, ',', '.'); ?></td>
        <?php $subtotal = $ob['harga'] * $ob['qty'];
            $total += $subtotal; ?>
            <td><?= number_format($subtotal, 0, ',', '.'); ?></td>
        </tr>
    <?php endforeach;?>

       
        <tr>
<form action="" method="post">
        <td colspan="4" align="right">Biaya Lainnya</td>
            <td align="right">Rp. <input type="number" id="biaya-lain" name="biaya_lain" class="form-control-sm p-2" value="0" autofocus>
            <small class="text-danger"><?= form_error('biaya_lain'); ?></small>
            </td>
        </tr>
        <tr>
            <td colspan="4" align="right">Grand Total</td>
            <td align="right">Rp. <span id="grand-total-biaya"><?php echo number_format($total,0,',','.') ?></span> </td>
            
        </tr>

        <tr>
            <td align="left">Nama Medis : <span class="bg-white p-1 rounded"><?= $medis->nama_lengkap; ?></span></td>
        </tr>

    </table>
	</div>
<div id="grand-total-value" data-value="<?= $total; ?>"></div>
<button type="submit" class="btn btn-success float-right text-white"><i class="fas fa-check"></i> Terima</button>
</form>
<a href="<?php echo base_url(); ?>"><div class="btn btn-danger"><i class="fas fa-ban"></i> Batal</div></a>
</div>
