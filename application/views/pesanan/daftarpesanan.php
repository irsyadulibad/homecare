<div class="row">
<div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h4>Pesanan Layanan</h4>
                                </div>
                     <div class="pull-right">
                        <a href="<?=site_url('pesanan/tambahdatanya') ?>" class="btn btn-primary">
                        <i class="fa fa-user"></i>Tambah Pesanan</a> </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name Pasien</th>
                                                <th>Tanggal Kunjungan</th>
                                                <th>Jam Kunjungan</th>
                                                <th>Kondisi Terkini</th>
                                                <th>Alamat</th>
                                                <th>Keterangan</th>
                                                <th>Paramedis</th>
                                                <th>Status</th>



                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $no = 1;
                                                foreach($row->result() as $key => $data ) { ?>
                                            <tr>
                                                <td><?=$no++ ?> </td>
                                                <td><?=$data->pasien ?> </td>
                                                <td><?=$data->tgl_kunjungan ?> </td>
                                                <td><?=$data->jam_kunjungan ?> </td>
                                                <td><?=$data->kondisi_terkini ?> </td>
                                                <td><?=$data->alamat_pasien ?> </td>
                                                <td><?=$data->keterangan ?> </td>
                                                <td><?=$data->keterangan ?> </td>
                                                <td>
                                             
                                             
                                             </td>
                                             <td> <?=$data->status== 0 ? "Pending" : "Selesai" ?>
                                                </td>
                                                <td class="text-center" width="160px">
                                                <a href="<?=site_url('pesanan/update/'.$data->id_pesanan) ?>" class="btn btn-primary">
                                                     <i class="fa fa-edit"></i>Pilih Medis</a> 
                                                     <form action="<?=site_url('pesanan/delpes')?>" method="post">
                                                     <input type="hidden" name="id_pesanan" value="<?=$data->id_pesanan?>">
                                                     <button onclick="return confirm('Apa anda yakin ?')"class="btn btn-danger btn-secondary">
                                                     <i class="fa fa-trash"></i>Tolak</a> 
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