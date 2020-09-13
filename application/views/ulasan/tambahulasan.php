<?php
$rate = $this->input->post('rating', true);
?>
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<form action="" method="post">
			<div class="card">
				<div class="card-body">
					<h4>Beri Rating</h4>
					<small class="text-danger text-right"><?= form_error('rating'); ?></small>
					<div id='rating' class="text-center rating">
						<input type="radio" class="rate" id="star5" name="rating" value="5" <?= ($rate==5) ? 'checked' : ''; ?>/>
						<label for="star5" title="Sempurna - 5 Bintang"></label>
						<input type="radio" class="rate" id="star4" name="rating" value="4" <?= ($rate==4) ? 'checked' : ''; ?>/>
						<label for="star4" title="Sangat Bagus - 4 Bintang"></label>
						<input type="radio" class="rate" id="star3" name="rating" value="3" <?= ($rate==3) ? 'checked' : ''; ?>/>
						<label for="star3" title="Bagus - 3 Bintang"></label>
						<input type="radio" class="rate" id="star2" name="rating" value="2" <?= ($rate==2) ? 'checked' : ''; ?>/>
						<label for="star2" title="Tidak Buruk - 2 Bintang"></label>
						<input type="radio" class="rate" id="star1" name="rating" value="1" <?= ($rate==1) ? 'checked' : ''; ?>/>
						<label for="star1" title="Buruk - 1 Bintang"></label>
					</div>
					<div class="border-bottom"></div>
					<div class="form-group mt-3">
						<label>Keterangan Ulasan</label>
						<textarea type="text" name="description" class="form-control"></textarea>
						<small class="text-danger"><?= form_error('description'); ?></small>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary float-right"><i class="fas fa-star"></i> Ulas</button>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>          