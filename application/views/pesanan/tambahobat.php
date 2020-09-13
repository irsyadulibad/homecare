<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h6>Tambah Obat Pasien</h6>
			</div>
			<div class="card-body">
				<h6>Jenis Layanan</h6>
				<ol class="">
				<?php foreach($layanans as $layanan): ?>
					<li><?= $layanan['nama_layanan'] ?></li>
				<?php endforeach; ?>
				</ol>
				<?= form_open('', ['id' => 'form-add-obat']); ?>
				<div class="form-group pt-2">
					<label for="obat">Tambah Obat</label>
					<br>
					<select name="obat" id="obat" class="select2 form-control">
					<?php foreach($obats as $obat): ?>
						<option value="<?= $obat['id_obat'] ?>"><?= $obat['nama'] ?></option>
					<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="qty">Jumlah</label>
					<input type="number" class="form-control" name="qty" id="qty">
				</div>
				<div class="form-group text-center">
					<button class="btn btn-success" type="submit"><i class="fas fa-plus"></i> Tambah</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h6>Obat yang Ditambahkan</h6>
			</div>
			<div class="card-body">
				<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Qty</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody id="obat-add-content">
						<?php if(empty($carts)): ?>
						<tr>
							<td colspan="4" align="center">Daftar masih kosong</td>
						</tr>
						<?php else:
							$i = 1; foreach($carts as $id => $qty):
							$nama = $this->db->get_where('obat', ['id_obat' => $id])->row_array()['nama'];
						?>
						<tr>
							<td><?= $i; ?></td>
							<td><?= $nama; ?></td>
							<td><?= $qty; ?></td>
							<td>
								<button class="btn btn-danger btn-del-cart-obat" data-id="<?= $id; ?>"><i class="fas fa-trash-alt"></i> Hapus</button>
							</td>
						</tr>
						<?php $i++; endforeach; endif; ?>
					</tbody>
				</table>
				</div>
				<div class="form-group pt-3 text-center">
					<a href="<?= base_url('pesanan/confirm_obat/'.$invoice['id_invoice']); ?>" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</a>
				</div>
			</div>
		</div>
	</div>
</div>
