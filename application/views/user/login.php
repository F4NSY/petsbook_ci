<?php
  if($this->session->userdata('isLoggedIn')) {
    redirect('home');
  }
?>
<div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
  <div class="container">
    <div class="row">
      <div class="col-xl-6 d-none d-xl-flex align-items-center justify-content-center">
        <img src="<?= base_url(); ?>assets/images/pets_logo.png" class="img-fluid" alt="">
      </div>
      <div class="col-xl-6 d-flex align-items-center justify-content-center">
        <?php $attribute = array('id' => 'loginForm', 'class' => 'form shadow-lg rounded p-5 w-100', 'novalidate' => 'novalidate');
          echo form_open('', $attribute); ?>
          <div class="form-header text-center mb-3">
            Login
          </div>
          <div id="loginError" class="mb-3">
          </div>
          <div class="form-floating has-validation mb-3">
            <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
            <label for="email" class="form-label">Email</label>
          </div>
          <div class="form-floating has-validation mb-3">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
            <label for="password" class="form-label">Password</label>
          </div>
          <div class="d-flex justify-content-end mb-3">
            <a href="/forgot-password">Forgot Password?</a>
          </div>
          <div class="d-grid mb-3">
            <button id="loginButton" type="submit" class="btn btn-primary">
                <span>Sign
                in</span>
            </button>
          </div>
          <hr />
          <div class="d-grid">
            <button id="createAccountButton" type="button" class="btn btn-success" data-mdb-toggle="modal" data-mdb-target="#registerModal">
              Create a new account
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include APPPATH . 'views/user/modals/register-modal.php' ;?>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/login.js"></script>