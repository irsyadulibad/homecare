<?php 
$rating = intval($this->input->get('rating', true));
?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
            <div class="sorting-container text-center">
                <a href="<?= base_url('ulasan'); ?>" class="btn <?= ($rating == 0)?'btn-primary':'btn-outline-primary' ?> mb-2 mr-3">Semua</a>
            <?php for($i=1; $i<=5; $i++): ?>
                <a href="<?= base_url('ulasan?rating='.$i); ?>" class="btn <?= ($i == $rating)?'btn-primary':'btn-outline-primary' ?> mb-2 mr-3">
                <?php for($s=1; $s<=$i; $s++): ?>
                    <span><i class="fas fa-star"></i></span>
                <?php endfor; ?>
                </a>
            <?php endfor; ?>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <?php if(empty($reviews)): ?>
        <div class="col-md-10">
            <div class="card m-auto">
                <div class="card-body text-center">
                    <h5 style="color: #7571f9;" class="mt-2">Data tidak tersedia</h5>
                </div>
            </div>
        </div>
        <?php else: ?>
        <?php foreach ($reviews as $review): ?>
        <div class="col-md-4">
            <div class="card" style="max-height: 350px; min-height: 350px; width: 18rem;">
                <div class="card-body">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td rowspan="2">
                                <img src="<?= base_url('assets/img/profile/'.$review['foto_medis']); ?>" alt="img" class="rounded-circle border" width="50" height="50">
                            </td>
                            <td class="pr-4 pl-4 pt-2 text-center">
                                <h5 class="mb-0"><?= ucfirst($review['nama_medis']); ?></h5>
                            </td>
                        </tr>
                        <tr>
                            <td class="pl-2 pr-2">
                                <div id='star' class="text-center">
                                <?php for($i=0; $i<$review['rating']; $i++): ?>
                                    <label class="star-on"></label>
                                <?php endfor; ?>
                                <?php for($i=5; $i>$review['rating']; $i--): ?>
                                    <label class="star-off"></label>
                                <?php endfor; ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <small class="text-muted m-0">Reviewer: <?= ucfirst($review['nama_user']); ?></small>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p style="overflow-wrap: break-word; max-width: 14rem; max-height: 180px; overflow: auto;"><?= nl2br($review['deskripsi']); ?></p>
                            </td>
                        </tr>
                    </table>
                    <a href="<?= base_url('ulasan/detail/'.$review['id_ulasan']); ?>" class="btn btn-primary position-absolute" style="bottom: 10px; right: 30px;">Detail</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="row justify-content-center border-top mt-3 pt-2">
        <div class="col-md-6 text-center">
            <?= $this->pagination->create_links(); ?>
        </div>
    </div>
</div>
