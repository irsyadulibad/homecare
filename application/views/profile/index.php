<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <a href="<?= base_url('profile/edit'); ?>" class="btn btn-success text-white p-2 float-right"><i class="icon-note font-weight-bold"></i> Edit Profile</a>
                </div>
                <div class="card-body mt-0">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-12 text-center">
                                <img src="<?= base_url('assets/img/profile/'.$user->foto); ?>" width="150" height="150" class="rounded-circle">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <ul class="list-group mt-3">
                                    <li class="list-group-item">
                                        <h5 class="text-muted">NAMA : <?= $user->nama_lengkap; ?></h5>
                                    </li>
                                    <li class="list-group-item">
                                    <?php if($user->role == "1"): ?>
                                        <h5 class="text-muted">TIPE AKUN : <span class="badge badge-primary"><i class="icon-wrench"></i> ADMIN</span></h5>
                                    <?php elseif($user->role == "2"): ?>
                                        <h5 class="text-muted">TIPE AKUN : <span class="badge badge-danger"><i class="icon-shield"></i> MEDIS</span></h5>
                                    <?php elseif($user->role == "3"): ?>
                                        <h5 class="text-muted">TIPE AKUN : <span class="badge badge-success text-white"><i class="icon-user"></i> USER</span></h5>
                                    <?php else: ?>
                                        <h5 class="text-muted">TIPE AKUN : <span class="badge badge-danger text-white"><i class="icon-shield"></i> Dokter</span></h5>
                                    <?php endif; ?>
                                    </li>
                                    <li class="list-group-item">
                                        <h5 class="text-muted">EMAIL : <?= $user->email; ?></h5>
                                    </li>
                                    <li class="list-group-item">
                                        <h5 class="text-muted">NO HP : <?= $user->no_hp; ?></h5>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
