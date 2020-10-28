<?php
if(isset($pengguna['id_medis'])){
	$idUser = $pengguna['id_medis'];
}else{
	$idUser = $pengguna['id_pengguna'];
}

?>
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-2 text-center">
							<img src="<?= base_url('assets/img/profile/'.$ulasan['foto_medis']); ?>" width="70%" class="rounded-circle m-auto">
						</div>
						<div class="col-md-3">
							<h5 class="mb-0 mt-3 text-center"><?= ucfirst($ulasan['nama_medis']); ?></h5>
							<div id='star' class="text-center m-auto">
								<?php for($i=0; $i<$ulasan['rating']; $i++): ?>
								<label class="star-on"></label>
								<?php endfor; ?>
								<?php for($i=5; $i>$ulasan['rating']; $i--): ?>
								<label class="star-off"></label>
								<?php endfor; ?>
							</div>
							<p class="" style="max-height: 250px; overflow: auto;"><?= nl2br($ulasan['deskripsi']); ?></p>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-4">
							<h4>Ringkasan Pesanan</h4>
							<ol class="mt-2 pl-4">
							<?php foreach ($pesanan as $psn): ?>
								<li style="list-style-type: decimal;"><?= $psn['nama_layanan']; ?></li>
							<?php endforeach; ?>
							</ol>
						</div>
						<div class="col-md-2" style="min-height: 70px;">
						<?php if($ulasan['id_pengguna'] == $idUser && $pengguna['status'] == 'user'): ?>
							<a href="<?= base_url('ulasan/edit/'.$ulasan['id_ulasan']); ?>" class="btn btn-success text-white confirm-href" style="position: absolute; bottom: 5px; right: 5px;"><i class="fas fa-edit"></i> Edit</a>
						<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
