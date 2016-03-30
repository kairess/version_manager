<div id="main" class="pure-u-1 no-nav">
	<div class="email-content">
		<div class="email-content-header pure-g">
			<div class="pure-u-1-2">
				<h1 class="email-content-title">Settings</h1>
				<!-- <p class="email-content-subtitle">
					Good luck!
				</p> -->
			</div>

			<div class="email-content-controls pure-u-1-2">
				<!-- <button class="secondary-button pure-button">Reply</button>
				<button class="secondary-button pure-button">Forward</button>
				<button class="secondary-button pure-button">Move to</button> -->
			</div>
		</div>

		<div class="email-content-body">
			<form class="pure-form pure-form-aligned" action="<?=base_url('auth/settings_action')?>" method="post" enctype="multipart/form-data">
				<fieldset>
					<div class="pure-control-group">
						<label for="profile" class="pure-u-1-4">Profile picture</label>
						<input id="profile" class="pure-u-3-4" type="file" name="file">
					</div>

					<div class="pure-control-group">
						<label for="password" class="pure-u-1-4">New password</label>
						<input id="password" class="pure-u-3-4" type="password" placeholder="New password" name="password">
					</div>

					<div class="pure-control-group">
						<label for="confirm-password" class="pure-u-1-4">Confirm password</label>
						<input id="confirm-password" class="pure-u-3-4" type="password" placeholder="Confirm password" name="password_confirm">
					</div>

					<div class="pure-control-group">
						<label for="file" class="pure-u-1-4"></label>
						<div class="pure-u-3-4">
							<button type="submit" class="pure-button pure-button-primary">Save changes</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>