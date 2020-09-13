<?php
$prov = $this->pesanan_m->getProv($invoice->provinsi)['nama'];
$kota = $this->pesanan_m->getKota($invoice->kota)['nama'];
$kec = $this->pesanan_m->getKec($invoice->kecamatan)['nama'];
$desa = $this->pesanan_m->getDesa($invoice->desa)['nama'];
$total = $invoice->total + $invoice->biaya_lain + $invoice->biaya_kirim;

$status = null;
switch ($invoice->status) {
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
    <div class="btn btn-sm btn-success">No. Invoice: <?php echo $invoice->id_invoice ?></div>
	<h6 class="text-muted font-weight-bold mt-4">NAMA<span class="ml-3 mr-2">:</span><?= strtoupper($invoice->nama); ?></h6>
    <h6 class="text-muted font-weight-bold">ALAMAT<span class="ml-2 mr-2">:</span><?= $invoice->alamat; ?></h6>
    <h6 class="text-muted font-weight-bold pl-4"><span class="ml-4 pl-4"><?= "$desa - $kec - $kota - $prov"; ?></span></h6>

    <h6 class="mt-2 mb-3 text-left">Status: <span class="badge badge-<?= $status; ?> font-weight-bold text-white"><?= $invoice->status; ?></span> <span class="btn btn-sm btn-info float-right" data-toggle="modal" data-target="#modalKondisi"><i class="fas fa-exclamation-circle"></i> Tampilkan Kondisi</span></h6>
	<div class="table-responsive mt-3">
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
    <?php endforeach; ?>

        <tr>
        <td colspan="4" align="right">Biaya Lainnya</td>
            <td align="right">Rp. <?php echo number_format($invoice->biaya_lain,0,',','.') ?> </td>
        </tr>
        <tr>
            <td colspan="4" align="right">Biaya Kirim</td>
            <td align="right">Rp. <?php echo number_format($invoice->biaya_kirim,0,',','.') ?> </td>
        </tr>
        <tr>
            <td colspan="4" align="right">Grand Total</td>
            <td align="right">Rp. <?php echo number_format($total,0,',','.') ?> </td>
            
        </tr>

        <tr>
            <td align="left">Nama Medis : <span class="bg-white p-1 rounded"><?= $medis['nama_lengkap']; ?></span></td>
        </tr>

    </table>
	</div>

<a href="<?php echo base_url('invoice/index') ?>"><div class="btn btn-sm btn-primary"> Kembali</div></a>
</div>
