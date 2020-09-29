<div class="container-fluid">
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
						<a class="card" style="width: 18rem;" href="<?= base_url('ulasan/list/'.$review['mid']); ?>" style="text-decoration: none;">
							<div class="card-body">
								<table cellpadding="0" cellspacing="0">
									<tr>
										<td rowspan="2">
											<img src="<?= base_url('assets/img/profile/'.$review['foto_medis']); ?>" alt="img" class="rounded-circle border" width="50" height="50">
										</td>
										<td class="pr-4 pl-4 pt-2 text-center">
											<h5 class="mb-0 text-decoration-none"><?= ucfirst($review['nama_medis']); ?></h5>
										</td>
									</tr>
									<tr>
										<td class="pl-2 pr-2">
											<div id='star' class="text-center">
												<?php for($i=0; $i<floor($review['rating']); $i++): ?>
													<label class="star-on"></label>
												<?php endfor; ?>
												<?php for($i=5; $i>floor($review['rating']); $i--): ?>
													<label class="star-off"></label>
												<?php endfor; ?>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<small class="text-muted m-0">Rata - Rata: <?= ucfirst($review['rating']); ?></small>
										</td>
									</tr>
								</table>
							</div>
						</a>
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
