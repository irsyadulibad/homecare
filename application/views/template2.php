<?php
$user = $this->fungsi->user_login();
$uri = $this->uri->segment(1);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Home Care</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" /> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" integrity="sha256-nbyata2PJRjImhByQzik2ot6gSHSU4Cqdz5bNYL2zcU=" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/components.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/custom.css'); ?>">
</head>

<body>
  <div id="baseUrl" data-url="<?= base_url(); ?>"></div>
  <?php if($swal = $this->session->flashdata('swal')): ?>
    <div id="swal" data-type="<?= $swal['type'] ; ?>" data-msg="<?= $swal['msg']; ?>"></div>
    <?php else: ?>
      <div id="swal" data-type="" data-msg=""></div>
    <?php endif; ?>
    <div id="app">
      <div class="main-wrapper">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
          <form class="form-inline mr-auto">
            <ul class="navbar-nav mr-3">
              <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
              <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
            </ul>
            <div class="search-element">
              
            </div>
          </form>
          
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="<?= base_url('assets/img/profile/'.$user->foto); ?>" class="rounded-circle" width="30" height="30">
            <div class="d-sm-none d-lg-inline-block">Hi, <?= $user->nama_lengkap ?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="<?= base_url('profile'); ?>" class="dropdown-item has-icon">
                <ion-icon name="person-outline"></ion-icon> Profil Saya
              </a>
              <a href="<?= base_url('profile/editpass'); ?>" class="dropdown-item has-icon">
                <ion-icon name="lock-closed-outline"></ion-icon> Kata Sandi
              </a>
              <div class="dropdown-divider"></div>
              <a href="<?= base_url('auth/logout'); ?>" class="dropdown-item has-icon text-danger">
                <ion-icon name="log-out-outline"></ion-icon> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="<?= base_url(); ?>">Home Care</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?= base_url(); ?>">Hc</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="<?= ($uri=="homecare")?'active':''; ?>"><a class="nav-link" href="<?= base_url('homecare'); ?>"><ion-icon name="speedometer" class="mr-4 ml-2"></ion-icon> <span>Dashboard</span></a></li>
            <?php if($user->role == 1): ?>
              <li class="menu-header">Pengguna</li>
              <li class="nav-item dropdown <?= ($uri=="user")?'active':''; ?>">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i><span>Manajemen Data Pengguna</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="<?= base_url('user/add'); ?>">Tambah Pengguna</a></li>
                  <li><a class="nav-link" href="<?= base_url('user'); ?>">Semua Pengguna</a></li>
                  <li><a class="nav-link" href="<?= base_url('user/medis'); ?>">Paramedis</a></li>
                  <li><a class="nav-link" href="<?= base_url('user/pengguna'); ?>">Akun Pengguna</a></li>
                </ul>
              </li>
            <?php endif; ?>
            <?php if($user->role == 1): ?>
              <li class="menu-header">Obat</li>
              <li class="nav-item dropdown <?= ($uri=="obat")?'active':''; ?>">
                <a href="#" class="nav-link has-dropdown"><ion-icon name="medkit" class="mr-4 ml-2"></ion-icon><span>Manajemen Obat</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="<?= base_url('obat'); ?>">Daftar Obat</a></li>
                  <li><a class="nav-link" href="<?= base_url('obat/default'); ?>">Obat Default</a></li>
                </ul>
              </li>
            <?php endif; ?>
            <li class="menu-header">Invoices</li>
            <?php if($user->role == 1): ?>
              <li class="nav-item dropdown <?= ($uri=="layanan")?'active':''; ?>">
                <a href="#" class="nav-link has-dropdown"><ion-icon name="reorder-four" class="mr-4 ml-2"></ion-icon><span>Manajemen Layanan</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="<?= base_url('layanan/add'); ?>">Tambah Layanan</a></li>
                  <li><a class="nav-link" href="<?= base_url('layanan'); ?>">Daftar Layanan</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown <?= ($uri=="ongkir")?'active':''; ?>">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-shipping-fast"></i> <span>Ongkos Kirim</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="<?= base_url('ongkir'); ?>">Daftar Ongkir</a></li>
                </ul>
              </li>
            <?php endif; ?>
            <li class="nav-item dropdown <?= ($uri=="pesanan")?'active':''; ?>">
              <a href="#" class="nav-link has-dropdown"><ion-icon name="mail" class="mr-4 ml-2"></ion-icon><span>Pesanan</span></a>
              <ul class="dropdown-menu">
                <?php if($user->role == 3): ?>
                  <li><a class="nav-link" href="<?= base_url('cart'); ?>">Tambah Pesanan</a></li>
                <?php endif; ?>
                <li><a class="nav-link" href="<?= base_url('pesanan'); ?>">Daftar Pesanan</a></li>
              </ul>
            </li>
            <?php if($user->role == 2): ?>
              <li class="<?= ($uri=="pembayaran")?'active':''; ?>"><a class="nav-link" href="<?= base_url('pembayaran'); ?>"><ion-icon name="reorder-four" class="mr-4 ml-2"></ion-icon> <span>Pembayaran</span></a></li>
            <?php endif; ?>
            <li class="<?= ($uri=="riwayat")?'active':''; ?>"><a class="nav-link" href="<?= base_url('riwayat'); ?>"><ion-icon name="sync" class="mr-4 ml-2"></ion-icon> <span>Riwayat</span></a></li>
            <li class="menu-header">Ulasan</li>
            <li class="nav-item dropdown <?= ($uri=="ulasan")?'active':''; ?>">
              <a href="#" class="nav-link has-dropdown"><ion-icon name="star" class="mr-4 ml-2"></ion-icon><span>Ulasan</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="<?= base_url('ulasan'); ?>">Daftar Ulasan</a></li>
              </ul>
            </li>
          </ul>

          <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            
          </div>
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?= isset($head) ? $head : "Home Care"; ?></h1>
          </div>

          <div class="section-body">
           <?= $contents; ?>
         </div>
       </section>
     </div>
     <footer class="main-footer">
      <div class="footer text-center">
        Copyright &copy; <?= date('Y'); ?> <div class="bullet"></div> Developed By <a href="">Antos Fery</a>
      </div>
    </footer>
  </div>
</div>
<?php if (isset($modal)) {
  $this->load->view("modals/$modal");
} ?>

<!-- General JS Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-chained/1.0.1/jquery.chained.js" integrity="sha256-d0sQauu0SjMeA9n9U4ceDvED7pxvslcUR9eQSu9fsts=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-chained/1.0.1/jquery.chained.remote.js" integrity="sha256-2QQaXjcYtWlSj1+05+Lp60L2zhAnr4/HgH/KMNMo0Dc=" crossorigin="anonymous"></script>
<script src="<?= base_url('assets/js/stisla.js'); ?>"></script>

<!-- JS Libraies -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<!-- Template JS File -->
<script src="<?= base_url('assets/js/scripts.js'); ?>"></script>
<script src="<?= base_url('assets/js/custom.js'); ?>"></script>

<!-- Page Specific JS File -->
</body>
</html>
