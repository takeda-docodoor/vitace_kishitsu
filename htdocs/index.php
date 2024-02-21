<?php
//
session_set_cookie_params(365 * 24 * 3600);
session_start();
//

require('config.php');
require('lib.php');

$nyear = date('Y');
$nmonth = date('m');
$nday = date('d');
$nhour = date('H');
$nmin = date('i');
$nsec = date('s');

$now_date = $nyear . '-' . $nmonth . '-' . $nday . ' ' . $nhour . ':' . $nmin . ':' . $nsec;

$now_ymd = $nyear . '-' . $nmonth . '-' . $nday;


// db connect
$link1 = db_connect1();


//
if (isset($_POST['passwd'])) {
  if ($_POST['passwd'] == '') $_POST['passwd'] = time();
} else {
  $_POST['passwd'] = time();
}

//
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'login') {


    //	$where41 = '';
    //	$sql41 = '';
    //	$result41 = '';
    //	$where41 .= "mbr_loginid = '" . $_POST['login_id'] . "' and ";
    //	$where41 .= "mbr_dpt = '" . '0' . "' and ";
    //	$where41 .= '1 = 1';
    //	$sql41 = "select * from member where $where41";
    //	$result41 = mysqli_query( $link1, $sql41 ) ;
    //	$member = mysqli_fetch_array( $result41 );

    //	$sql = "select * from skmember where skm_loginid = '" . mysqli_real_escape_string( $link1, $_POST['login_id'] ) . "' and skm_status = '0'";
    //	$result = mysqli_query( $link1, $sql ) or die('query error' . mysql_error());
    //	$skmember = mysqli_fetch_array( $result );

    if ($_POST['passwd'] == $passwd || $_POST['passwd'] == $passwd_mng || $_POST['passwd'] == $passwd_img) {
      $_SESSION['passwd'] = $_POST['passwd'];
      //		$_SESSION['memberid'] = $member['member_id'];
      //		$_SESSION['companyid'] = $member['mbr_companyid'];
      //		$_SESSION['login_id'] = $member['mbr_loginid'];
      //		$_SESSION['auth_code'] = md5( $magic_code . $member['mbr_loginid'] );
      //		$_SESSION['mbr_kanji'] = $member['mbr_kanji'];
      //		$_SESSION['mbr_dpt'] = $member['mbr_dpt'];
      $_SESSION['mbr_dpt'] = '0';
      //
      //		$sql = "update member set
      //			mbr_logindt = '" . date( 'Y-m-d H:i:s' ) . "',
      //			mbr_status = '" . '0' . "'
      //			where mbr_loginid = '" . mysqli_real_escape_string( $link1, $_POST['login_id'] ) . "'";
      //	  	$result = mysqli_query( $link1, $sql );

      if ($_GET['redirect'] != '') {
        header('Location: ' . $_GET['redirect']);
        exit;
      } else {
        if ($_SESSION['mbr_dpt'] == '0') {
          if ($_SESSION['passwd'] == $passwd) {
            $_SESSION['home_url'] = $csctm_url;
            header('Location: ' . $csctm_url); //
            exit;
          } elseif ($_SESSION['passwd'] == $passwd_img) {
            $_SESSION['home_url'] = $csctm_url_img;
            header('Location: ' . $csctm_url_img); //
            exit;
          } elseif ($_SESSION['passwd'] == $passwd_mng) {
            $_SESSION['home_url'] = $csctm_url_mng;
            header('Location: ' . $csctm_url_mng); //
            exit;
          }
        }
      }
    }
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>roominr | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="./bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="./bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="./plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">ログインで氣質診断画面へ移行します。</p>

      <form action="index.php" method="post">
        <div class="form-group has-feedback">
          <input type="password" name="passwd" class="form-control" placeholder="パスワード">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <input type="hidden" name="action" value="login">
        <div class="row">
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">ログイン</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->


    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery 3 -->
  <script src="./bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="./bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="./plugins/iCheck/icheck.min.js"></script>
  <script>
    $(function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
      });
    });
  </script>
</body>

</html>
