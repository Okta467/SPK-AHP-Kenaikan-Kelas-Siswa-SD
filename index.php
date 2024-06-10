<!DOCTYPE html>
<html lang="en">

<head>
  <?php session_start() ?>
  <?php include 'config/config.php' ?>
  <?php include 'head_login.php' ?>

  <meta name="Description" content="Halaman Login">
  <title>Login - <?= SITE_NAME ?></title>
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">

              <div class="row mb-3">
                <div class="brand-logo mb-0 mr-3">
                  <img src="<?= base_url('assets/images/logo-mini.svg') ?>" alt="logo" style="width: 80px">
                </div>
                <div class="d-flex flex-column justify-content-center">
                  <h4>Helllo!</h4>
                  <h6 class="font-weight-light">Silakan Sign In untuk melanjutkan.</h6>
                </div>
              </div>

              <form class="pt-3" action="login_verification.php" method="post">

                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ti-user"></i></span>
                    </div>
                    <input name="xusername" type="text" class="form-control" placeholder="Username" aria-label="Username" autocomplete="username">
                  </div>
                </div>

                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ti-key"></i>
                      </span>
                    </div>
                    <input name="xpassword" type="password" class="form-control" placeholder="Password" aria-label="Password" autocomplete="current-password">
                  </div>
                </div>

                <div class="mt-3">
                  <button name="xsubmit" type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                </div>
                  
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                      <i class="input-helper"></i></label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div>

                <div class="text-center mt-4 font-weight-light">
                  Copyright © <?= date('Y') ?>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <?php include 'script_login.php' ?>
  <?php include 'login_sweetalert.php' ?>

</body>

</html>