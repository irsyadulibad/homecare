<div class="row">
<div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h4>Data Pasien</h4>
                                </div>
	<?php echo form_open('pasien/search') ?>
		<input type="text" name="keyword" placeholder="search">
		<input type="submit" name="search_submit" value="Cari">
	<?php echo form_close() ?>
 
                     <div class="pull-right">
                        <a href="<?=site_url('pasien/add') ?>" class="btn btn-primary">
                        <i class="fa fa-user"></i>Tambah Pasien</a> </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name Pasien</th>
                                                <th>Alamat</th>
                                                <th>No Darurat</th>
                                                <th>tgl lahir</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Nama User</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $no = 1;
                                             foreach($row as $data) { ?>
                                            <tr>
                                                <td><?=$no++ ?> </td>
                                                <td><?=$data->nama_lengkap ?> </td>
                                                <td><?=$data->alamat ?> </td>
                                                <td><?=$data->no_darurat ?> </td>
                                                <td><?=$data->tgl_lahir ?> </td>
                                                <td> <?=$data->jenis_kelamin == 1 ? "Laki Laki" : "Perempuan" ?></td>
                                                <td><?=$data->nama_user ?> </td>
                                                <td><?=$data->keterangan ?> </td>
                                                
                                                </td>
                                                <td class="text-center" width="160px">
                                                <a href="<?=site_url('pasien/update/'.$data->id_pasien) ?>" class="btn btn-xs">
                                                     <i class="fa fa-edit"></i>Update</a> 
                                                     <form action="<?=site_url('pasien/delpas')?>" method="post">
                                                     <input type="hidden" name="id_pasien" value="<?=$data->id_pasien?>">
                                                     <button onclick="return confirm('Apa anda yakin ?')"class="btn btn-danger btn-xs">
                                                     <i class="fa fa-trash"></i>Delete</a> 
                                                     </button> 
                                                     </form>
                                                 </td>
                                            </tr>
                                                <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>