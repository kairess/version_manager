<div class="pure-u no-sidebar">
	<div class="logo">
		<img src="<?=base_url('static/img/e_logo.png')?>">
	</div>
	<form class="pure-form pure-form-stacked" action="<?=base_url('auth/login_action')?>" method="post">
		<fieldset>
			<legend>Login</legend>

			<label for="username">Username</label>
			<input id="username" type="text" name="username" placeholder="Username">

			<label for="password">Password</label>
			<input id="password" type="password" name="password" placeholder="Password">

			<button type="submit" class="pure-button pure-button-primary">Sign in</button>
			<a href="<?=base_url('auth/register')?>" class="button-error pure-button">Register</a>
		</fieldset>
	</form>
</div>

<style type="text/css">
.logo img {
	margin:300px auto 0px auto;
	display:block;
}
</style>

<script type="text/javascript">
$(function() {
	var top = $(window).height() / 2 - 260;
	$('.logo img').css('margin-top', top);
	var left = $(window).width() / 2;
	$('.no-sidebar').css('margin-left', left-620);
});
</script>