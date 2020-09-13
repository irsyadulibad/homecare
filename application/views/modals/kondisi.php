<!-- Modal -->
<div class="modal fade" id="modalKondisi" tabindex="-1" role="dialog" aria-labelledby="modalKondisiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalKondisiLabel">Kondisi Pasien</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="<?= base_url('assets/img/kondisi/'.$invoice->kondisi); ?>" alt="Kondisi" width="100%">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fas fa-cancel"></i>Tutup</button>
      </div>
    </div>
  </div>
</div>
