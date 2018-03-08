<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $this->config->item('app_name'); ?> | Registration</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<?php
	echo $this->config->item('alte_bs_css')
		. $this->config->item('fontawesome_css')
		. $this->config->item('ionicons_css')
		. $this->config->item('alte_css')
		. $this->config->item('alte_icheck_sb_css')
		. $this->config->item('app_css');
	?>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="#"><?php echo $this->config->item('app_name'); ?></a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>

    <form action="<?php echo $this->config->item('uri_register');?>" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Username as your identity" id="username" name="username" value="<?php echo set_value('username')?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
		<span class="help-block red"><?php echo form_error('username');?></span>
      </div>
	  <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" id="email" name="email" value="<?php echo set_value('email')?>">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		<span class="help-block red"><?php echo form_error('email');?></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="First name" id="first_name" name="first_name" value="<?php echo set_value('first_name')?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
		<span class="help-block red"><?php echo form_error('first_name');?></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Last name" id="last_name" name="last_name" value="<?php echo set_value('last_name')?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
		<span class="help-block red"><?php echo form_error('last_name');?></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" id="password" name="password" value="<?php echo set_value('password')?>">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
		<span class="help-block red"><?php echo form_error('password');?></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Retype password" id="password_confirm" name="password_confirm" value="<?php echo set_value('password_confirm')?>">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
	  <?php $message = '';?>
    <p class="login-box-msg red infoMessage"><?php echo $message;?></p>

	  <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> I agree to the terms
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <div class="social-auth-links text-center">
      <p>- OR -</p>
    </div>

    <a href="<?php echo $this->config->item('uri_login');?>" class="text-center">I already have a membership</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<?php
echo $this->config->item('alte_jq_js')
	. $this->config->item('alte_bs_js')
	. $this->config->item('alte_icheck_js');
?>
<style type="text/css">
.login-box, .register-box {margin:auto;}
div.log-error{color:red;font-size:13px;}
</style>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
