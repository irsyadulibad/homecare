    <section class="section">
      <div class="container mt-5">
        <?php if($sess = $this->session->flashdata('message')): ?>
          <div class="row justify-content-center">
           <div class="col-md-6 text-center">
            <div class="alert alert-success" role="alert"><?= $sess; ?></div>
          </div>
        </div>
      <?php endif; ?>
      <div class="row justify-content-center">
        <div class="col-md-6">

          <div class="card card-primary">
            <div class="card-header"><h4>Register Home Care</h4></div>

            <div class="card-body">
              <?= form_open(''); ?>

              <div class="form-group">
                <label for="fullname">Nama Lengkap</label>
                <input id="fullname" type="text" class="form-control" name="fullname" value="<?= set_value('fullname'); ?>">
                <small class="text-danger"><?= form_error('fullname'); ?></small>
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control" name="email" value="<?= set_value('email'); ?>">
                <small class="text-danger"><?= form_error('email'); ?></small>
              </div>

              <div class="form-group">
                <label for="gender">Jenis Kelamin</label>
                <select name="gender" id="gender" class="form-control">
                  <option value="1">Laki - Laki</option>
                  <option value="2">Perempuan</option>
                </select>
                <small class="text-danger"><?= form_error('gender') ?></small>
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" class="form-control" name="password">
                <small class="text-danger"><?= form_error('password'); ?></small>
              </div>
              <div class="form-group">
                <label for="password2">Konfirmasi Password</label>
                <input id="password2" type="password" class="form-control" name="password2">
                <small class="text-danger"><?= form_error('password2'); ?></small>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block">
                  Register
                </button>
              </div>
            </form>
          </div>
        </div>

        <div class="mt-5 text-muted text-center">
          Sudah mempunyai akun? <a href="<?= base_url('auth/login'); ?>">Login</a>
        </div>
