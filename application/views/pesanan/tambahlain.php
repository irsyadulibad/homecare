<div class="row">
	<div class="col-md-7">
		<div class="card">
			<div class="card-header">
				<h4>Pesanan Lain</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>Harga</th>
								<th>Jumlah</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php if(empty($pesanans)): ?>
							<tr align="center">
								<td colspan="5">Pesanan Masih Kosong</td>
							</tr>
						<?php else: ?>
						<?php
							$i = 1;
							foreach($pesanans as $pesanan):
						?>
							<tr>
								<td><?= $i ?></td>
								<td><?= $pesanan['nama'] ?></td>
								<td><?= n_format($pesanan['harga_satuan']) ?></td>
								<td><?= $pesanan['jumlah'] ?></td>
								<td>
									<a href="<?= base_url('pesanan/del_lainnya/'.$pesanan['id'].'?prev='.$invoice['id_invoice']) ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
								</td>
							</tr>
						<?php
							$i++;
							endforeach;
						?>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="card">
			<div class="card-header">
				<h6>Tambah Pesanan Lain</h6>
			</div>
			<?= form_open(''); ?>
			<div class="card-body">
				<div class="form-group">
					<label for="name">Nama</label>
					<input type="text" class="form-control" name="name">
					<small class="text-danger"><?= form_error('name') ?></small>
				</div>
				<div class="form-group row">
					<div class="col-md-6">
						<label for="price">Harga</label>
						<input type="number" class="form-control" name="price">
						<small class="text-danger"><?= form_error('price') ?></small>
					</div>
					<div class="col-md-6">
						<label for="qty">Jumlah</label>
						<input type="number" class="form-control" name="qty">
						<small class="text-danger"><?= form_error('qty') ?></small>
					</div>
				</div>
				<div class="form-group text-center">
					<button class="btn btn-success" type="submit">Tambah</button>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 text-left">
		<a href="<?= base_url('pesanan/selesai/'.$invoice['id_invoice']) ?>" class="btn btn-sm btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
	</div>
</div>
