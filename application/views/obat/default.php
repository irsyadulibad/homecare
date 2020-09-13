<?php if($errs = $this->session->flashdata('form_err')): ?>
<div class="row">
	<div class="col-md-6">
		<div class="alert alert-danger" role="alert">
			<?= $errs; ?>
		</div>
	</div>
</div>
<?php endif; ?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>Daftar Obat</h4>
			</div>
			<div class="card-body">
				<div class="row justify-content-center">
					<div class="col-md-9 text-center">
						<div class="table-responsive">
							<table class="table table-striped" id="datatable">
								<thead>
									<tr>
										<th>#</th>
										<th>Layanan</th>
										<th>Obat Default</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
								<?php if(is_null($layanans)): ?>
									<tr>
										<td colspan="6" align="center">Data masih kosong</td>
									</tr>
								<?php else: $i = 0; ?>
									<?php foreach($layanans as $layanan): $i++;?>
									<tr>
										<td><?= $i; ?></td>
										<td><?= $layanan['jenis_layanan']; ?></td>
									<?php $obats = $this->obat_m->get_default_relation($layanan['id_layanan']); ?>
									<?php if(empty($obats)): ?>
										<td>Masih Kosong</td>
									<?php else: ?>
										<td>
										<?php foreach($obats as $obat): ?>
											<a href="<?= base_url('obat/edit/'.$obat['id_obat']); ?>">
												<?= $obat['nama']; ?>
											</a>, 
										<?php endforeach; ?>
										</td>
									<?php endif; ?>
										<td>
											<a href="<?= base_url('obat/set_default/'.$layanan['id_layanan']); ?>?prev=" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
											<a href="<?= base_url('obat/del_default/'.$layanan['id_layanan']); ?>?prev=" class="btn btn-sm btn-danger confirm-href"><i class="fas fa-trash-alt"></i> Hapus</a>
										</td>
									</tr>
									<?php endforeach; ?>
								<?php endif; ?>
								</tbody>
							</table>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
