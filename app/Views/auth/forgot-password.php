<?= $this->session->flashdata('message'); ?>
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="post" action="<?= base_url('auth/forgotpassword'); ?>">
					<span class="login100-form-title p-b-26">
						Reset Ulang
					</span>
					<!-- <span class="login100-form-title p-b-48">
						<i class="zmdi zmdi-email"></i>
					</span> -->

					<div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
						<input class="input100" type="text" name="email" value="<?= set_value('email'); ?>">
						<span class="focus-input100" data-placeholder="Email"></span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button type="submit" class="login100-form-btn">
								Reset
							</button>
						</div>
					</div>

					<div class="text-center p-t-115">
						<span class="txt1">
							Kembali halaman 
						</span>

						<a class="txt2" href="<?= base_url('auth')?>">
							<u>Login</u>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>