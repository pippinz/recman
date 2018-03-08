<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $this->config->item('app_name'); ?> | Log in</title>
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
<?php
$bErr = (trim($message) == '') ? false : true;
$sErrIdentity = trim(form_error('identity')); $bErrIdentity = ($sErrIdentity == '') ? false : true;
$sErrPassword = trim(form_error('password')); $bErrPassword = ($sErrPassword == '') ? false : true;
$bErr = ((trim($message) !== '') AND !$sErrIdentity AND !$sErrPassword) ? true : false;
?>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <span nowrap="nowrap"><b>Records Manager Lite</b></span><br />v.00.01
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><?php echo ($bErr) ? '<span class="red">' . strip_tags($message, 'p') . '</span>' : 'Sign in to start your session';?></p>
    <?php echo form_open($this->config->item('uri_login'), array('id' => 'log')) ?>
	  <?php if ($bErrIdentity): ?>	
      <div class="form-group has-feedback has-error">
        <input type="email" class="form-control" placeholder="Email" id="identity" name="identity" value="<?php echo set_value('identity')?>">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		<span class="help-block"><?php echo $sErrIdentity;?></span>
      </div>
	  <?php else: ?>
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" id="identity" name="identity" value="<?php echo set_value('identity')?>">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
	  <?php endif;?>

	  <?php if ($bErrPassword): ?>	
      <div class="form-group has-feedback has-error">
        <input type="password" class="form-control" placeholder="Password" id="password" name="password" value="<?php echo set_value('password')?>">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
		<span class="help-block"><?php echo $sErrPassword;?></span>
      </div>
	  <?php else: ?>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" id="password" name="password" value="<?php echo set_value('password')?>">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
	  <?php endif;?>

      <div class="row">
        <div class="col-xs-8">
          <!--
		  <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
		  -->
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <a href="<?php echo $this->config->item('uri_register');?>" class="text-center">Register a new membership</a><br>
    <a href="#" class="uc">I forgot my password</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<?php
echo $this->config->item('alte_jq_js')
	. $this->config->item('alte_bs_js')
	. $this->config->item('alte_icheck_js');
?>

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
<style>
	div.log-error{color:red;font-size:13px;}
</style>
<?php $this->load->view('modal-under_construction');?>
</body>
</html>
