<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<form action="" method="post">
			<div class="card">
				<div class="card-body">
					<h4>Edit Rating</h4>
					<small class="text-danger text-right"><?= form_error('rating'); ?></small>
					<div id='rating' class="text-center rating">
						<input type="radio" class="rate" id="star5" name="rating" value="5" <?= ($ulasan['rating']==5) ? 'checked' : ''; ?>/>
						<label for="star5" title="Sempurna - 5 Bintang"></label>
						<input type="radio" class="rate" id="star4" name="rating" value="4" <?= ($ulasan['rating']==4) ? 'checked' : ''; ?>/>
						<label for="star4" title="Sangat Bagus - 4 Bintang"></label>
						<input type="radio" class="rate" id="star3" name="rating" value="3" <?= ($ulasan['rating']==3) ? 'checked' : ''; ?>/>
						<label for="star3" title="Bagus - 3 Bintang"></label>
						<input type="radio" class="rate" id="star2" name="rating" value="2" <?= ($ulasan['rating']==2) ? 'checked' : ''; ?>/>
						<label for="star2" title="Tidak Buruk - 2 Bintang"></label>
						<input type="radio" class="rate" id="star1" name="rating" value="1" <?= ($ulasan['rating']==1) ? 'checked' : ''; ?>/>
						<label for="star1" title="Buruk - 1 Bintang"></label>
					</div>
					<div class="border-bottom"></div>
					<div class="form-group mt-3">
						<label>Keterangan Ulasan</label>
						<textarea type="text" name="description" class="form-control" style="height: 280px;"><?= $ulasan['deskripsi']; ?></textarea>
						<small class="text-danger"><?= form_error('description'); ?></small>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary float-right"><i class="icon-cursor"></i> Simpan</button>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>  