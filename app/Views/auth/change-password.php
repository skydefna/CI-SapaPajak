<?= $this->session->flashdata('message'); ?>
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="post" action="<?= base_url('auth/changepassword'); ?>">
					<span class="login100-form-title p-b-26">
						Reset Password
						<p>
						<?= $this->session->userdata('reset_email'); ?>
						</p>
					</span>
					<!-- <span class="login100-form-title p-b-48">
						<i class="zmdi zmdi-email"></i>
					</span> -->

					<div class="wrap-input100 validate-input" data-validate="Masukan password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="password1">
						<span class="focus-input100" data-placeholder="Password baru"></span>
						<!-- <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?> -->
					</div>
					<div class="wrap-input100 validate-input" data-validate="Masukan password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="password2">
						<span class="focus-input100" data-placeholder="Ulang Password baru"></span>
					</div>
					<?= form_error('password2', '<div class="alert-danger notifikasi alert">', '</div>'); ?>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button type="submit" class="login100-form-btn">
								Login
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>