<!-- Modal -->
<div class="modal fade" id="modalCart" tabindex="-1" role="dialog" aria-labelledby="modalCartLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCartLabel">Keranjang Belanja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="cart-content">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fas fa-bars"></i> Pilih Layanan Lainnya</button>
        <a href="<?= base_url('cart/checkout'); ?>" class="btn btn-success"><i class="fa fa-check"></i> Checkout</a>
      </div>
    </div>
  </div>
</div>
