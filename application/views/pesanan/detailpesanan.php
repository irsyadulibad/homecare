<?php
$prov = $this->pesanan_m->getProv($invoice->provinsi)['nama'];
$kota = $this->pesanan_m->getKota($invoice->kota)['nama'];
$kec = $this->pesanan_m->getKec($invoice->kecamatan)['nama'];
$desa = $this->pesanan_m->getDesa($invoice->desa)['nama'];
?>
<div class="container-fluid">
    <h4>Detail Pesanan</h4>

    <h6 class="text-muted font-weight-bold mt-4">NAMA<span class="ml-3 mr-2">:</span><?= strtoupper($invoice->nama); ?></h6>
    <h6 class="text-muted font-weight-bold">ALAMAT<span class="ml-2 mr-2">:</span><?= $invoice->alamat; ?></h6>
    <h6 class="text-muted font-weight-bold pl-4"><span class="ml-4 pl-4"><?= "$desa - $kec - $kota - $prov"; ?></span></h6>
    <table class="table table-border table-hover table-striped mt-4">
        <tr>
            <th>No</th>
            <th>Nama Layanan</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Sub-Total</th>

        </tr>
       
       <?php
        $total = 0;
        foreach($pesanan as $psn) {
                $subtotal = $psn->jumlah * $psn->harga;
                $total += $invoice->biaya_lain + $subtotal;
       
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
        <td colspan="4" align="right">Biaya Lainnya</td>
            <td align="right">Rp. <?php echo number_format($invoice->biaya_lain,0,',','.') ?> </td>
        </tr>
        <tr>
            <td colspan="4" align="right">Grand Total</td>
            <td align="right">Rp. <?php echo number_format($total,0,',','.') ?> </td>
            
        </tr>

        <tr>
            <td align="left">Nama Medis : <span class="bg-white p-1 rounded"><?= $medis['nama_lengkap']; ?></span></td>
        </tr>

    </table>

<a href="<?php echo base_url('pesanan/dimedis') ?>" class="btn btn-sm btn-primary">Kembali</a>
<a href="<?= base_url('pesanan/selesai/'.$invoice->id_invoice); ?>" class="btn btn-sm btn-success float-right text-white">Selesai</a>