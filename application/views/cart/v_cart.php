<div class="row justify-content-center">
  <?php foreach($services as $service): ?>
    <?php $id = $service['id_layanan']; ?>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="text-center font-weight-bold"><?= ucfirst($service['jenis_layanan']); ?></h5>
          <h6 class="text-center mt-4">Biaya: Rp.<?= number_format($service['harga'], 0, ',', '.'); ?></h6>
          <button class="btn btn-info rounded-pill add-cart" data-id="<?= $id; ?>" data-rowid="<?= isset($rowids[$id]) ? $rowids[$id] : ''; ?>"><i class="fas fa-plus"></i> Tambah Layanan</button>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<div class="row mt-3">
  <div class="col-12 text-center">
    <button class="btn btn-lg btn-primary" id="btn-cart-checkout" data-toggle="modal" data-target="#modalCart"><i class="fas fa-check"></i> Checkout Pesanan</button>
  </div>
</div>
