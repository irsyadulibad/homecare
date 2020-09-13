
<section class="section">
  <div class="container mt-5">
    <div class="row">
      <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="card card-primary">
          <div class="text-center mt-1">
            <img src="<?= base_url('assets/img/logo.jpg'); ?>" alt="Logo App" width="97%">
          </div>
          <div class="card-header text-center">
            <div class="row align-items-center">
              <div class="col-12">
                <h4 style="font-size: 1.7em;">Login Homecare</h4>
              </div>
            </div>
          </div>
          <div class="card-body">
            <?= form_open('auth/process'); ?>
            <div class="form-group">
              <label for="username">Username</label>
              <input id="username" type="username" class="form-control" name="username" tabindex="1" required autofocus>
              <div class="invalid-feedback">
                Please fill in your email
              </div>
            </div>

            <div class="form-group">
              <div class="d-block">
               <label for="password" class="control-label">Password</label>
             </div>
             <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
             <div class="invalid-feedback">
              please fill in your password
            </div>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" name="login">
              Login
            </button>
          </div>
        </form>

      </div>
    </div>
    <div class="mt-5 text-muted text-center">
      Tidak mempunyai akun? <a href="<?= base_url('auth/register'); ?>">Daftar</a>
    </div>
