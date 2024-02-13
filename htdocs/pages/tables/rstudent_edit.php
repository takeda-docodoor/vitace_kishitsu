<?php
//
session_set_cookie_params( 365 * 24 * 3600 );
session_start();
////
//
require( '../../config.php' );
require( '../../lib.php' );
require( '../../system_tbl.php' );

$nyear = date( 'Y' );
$nmonth = date( 'm' );
$nday = date( 'd' );
$nhour = date( 'H' );
$nmin = date( 'i' );
$nsec = date( 's' );

$now_date = $nyear . '-' . $nmonth . '-' . $nday . ' ' . $nhour . ':' . $nmin . ':' . $nsec;

$now_ymd = $nyear . '-' . $nmonth . '-' . $nday;

//
$login_st = 0;    // ログイン初期化

$error = '';



// db connect
$link1 = db_connect1();
//$link2 = db_connect2();
//
////
////if ( auth () ) $login_st = 1 ;
//
//$_SESSION['sdate'] = $now_date;

$mstmsg = '';


//********************************************************************
if ( isset($_GET['mstact']) ) {
  if ( $_GET['mstact'] != '' ) {
    $_SESSION['mstact'] = $_GET['mstact'];

		if (  $_SESSION['mstact'] == 'mstedit' ) {
	  	  if ( $_GET['masterid'] != '' ) {
	        $_SESSION['masterid'] = $_GET['masterid'];

					$where1 = '';
					$sql1 = '';
					$result1 = '';
					$sql1 = "select * from rstudent where rstudent_id = '" . $_SESSION['masterid'] . "'";
					$result1 = mysqli_query( $link1, $sql1 );
					$rstudent = mysqli_fetch_array( $result1 );


	      }
		}
		if (  $_SESSION['mstact'] == 'mstnew' ) {

	        $_SESSION['masterid'] = '0';

					$where1 = '';
					$sql1 = '';
					$result1 = '';
					$sql1 = "select * from rstudent where rstudent_id = '" . '0' . "'";
					$result1 = mysqli_query( $link1, $sql1 );
					$rstudent = mysqli_fetch_array( $result1 );
		}

  }
}

//********************************************************************
if ( isset($_POST['syori']) ) {
  if ( $_POST['syori'] == '登録' ) {

	$where5 = '';
	$sql5 = '';
	$result5 = '';
	$sql5 = "select * from rstudent where rst_mail = '" . $_POST['rst_mail'] . "'";
	$result5 = mysqli_query( $link1, $sql5 );
	$rstudent5 = mysqli_fetch_array( $result5 );

	if (  $rstudent5['rstudent_id'] > '0' ) {
		$error = 'このメールアドレスで既に登録されています。';


		$where1 = '';
		$sql1 = '';
		$result1 = '';
		$sql1 = "select * from rstudent where rstudent_id = '" . $_SESSION['masterid'] . "'";
		$result1 = mysqli_query( $link1, $sql1 );
		$rstudent = mysqli_fetch_array( $result1 );

	} else {

	  if (  $_SESSION['mstact'] == 'mstnew' ) {


		$sql = "insert into rstudent (
			rst_kanji,
			rst_kana,
			rst_sex,
			rst_mail,
			rst_birthday,
			rst_post,
			rst_add,
			rst_phone,
			rst_qualifi,
			rst_clsreg,
			rst_notes
		) values (
			'" . mysqli_real_escape_string( $link1, $_POST['rst_kanji'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['rst_kana'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['rst_sex'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['rst_mail'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['rst_birthday'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['rst_post'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['rst_add'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['rst_phone'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['rst_qualifi'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['rst_clsreg'] ) . "',
			'" . '' . "'
		)";
		$result = mysqli_query( $link1, $sql ) or die('query error126' . mysqli_error($link1));
		$_SESSION['masterid'] = mysqli_insert_id( $link1 );
		$_SESSION['mstact'] = 'mstedit';

		$where = '';
		$sql1 = '';
		$result1 = '';
		$sql1 = "select * from rstudent where rstudent_id = '" . $_SESSION['masterid'] . "'";
		$result1 = mysqli_query( $link1, $sql1 );
		$rstudent = mysqli_fetch_array( $result1 );


        $mstmsg = '登録しました。';

	  } else {

		$sql = "update rstudent set
					rst_kanji = '" . mysqli_real_escape_string( $link1, $_POST['rst_kanji'] ) . "',
					rst_kana = '" . mysqli_real_escape_string( $link1, $_POST['rst_kana'] ) . "',
					rst_sex = '" . mysqli_real_escape_string( $link1, $_POST['rst_sex'] ) . "',
					rst_mail = '" . mysqli_real_escape_string( $link1, $_POST['rst_mail'] ) . "',
					rst_birthday = '" . mysqli_real_escape_string( $link1, $_POST['rst_birthday'] ) . "',
					rst_post = '" . mysqli_real_escape_string( $link1, $_POST['rst_post'] ) . "',
					rst_add = '" . mysqli_real_escape_string( $link1, $_POST['rst_add'] ) . "',
					rst_phone = '" . mysqli_real_escape_string( $link1, $_POST['rst_phone'] ) . "',
					rst_qualifi = '" . mysqli_real_escape_string( $link1, $_POST['rst_qualifi'] ) . "'
					rst_clsreg = '" . mysqli_real_escape_string( $link1, $_POST['rst_clsreg'] ) . "'
			where rstudent_id = '" . $_SESSION['masterid'] . "'";
		$result = mysqli_query( $link1, $sql ) or die('query error153' . mysqli_error($link1));

		$where1 = '';
		$sql1 = '';
		$result1 = '';
		$sql1 = "select * from rstudent where rstudent_id = '" . $_SESSION['masterid'] . "'";
		$result1 = mysqli_query( $link1, $sql1 );
		$rstudent = mysqli_fetch_array( $result1 );


        $mstmsg = '登録しました。';

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
  <title>受講生情報編集</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<script langugae="javascript">
<!--
function ctrl_wind(url) {
  opener.location.href = url;
  window.close();
}
//-->
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->

  <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-xs-12">
          <!-- Horizontal Form -->
          <!-- /.box -->
          <!-- general form elements disabled -->
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">受講生情報編集</h3>
				<a href="javascript:ctrl_wind('rstudent_list.php')"><button class="btn btn-info pull-right">閉じる</button></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
	　　　　　　<form name="frm1" action="rstudent_edit.php" method="post" class="search_form general_form">
                <!-- text input -->
    		    <?php if ( $error != '' ) { ?>
                <div class="form-group">
					<label><font color="#FF0000"><?php echo $error; ?></font></label>
                </div>
    		    <?php } ?>
                <div class="form-group">
                  <label>名前</label>
                  <input type="text" name="rst_kanji" value="<?php echo $rstudent['rst_kanji']; ?>" class="form-control" placeholder="名前 ...">
                </div>
                <div class="form-group">
                  <label>フリガナ</label>
                  <input type="text" name="rst_kana" value="<?php echo $rstudent['rst_kana']; ?>" class="form-control" placeholder="フリガナ ...">
                </div>
                <div class="form-group">
                  <label>性別</label>
                  <select class="form-control" name="rst_sex"><?php foreach ( $sex_tbl as $key => $value ) if ( $key == $rstudent['rst_sex'] ) echo "<option value=$key selected>$value\n"; else echo "<option value=$key>$value\n" ?></select>
                </div>
                <div class="form-group">
                  <label>生年月日</label>
                  <input type="text" name="rst_birthday" value="<?php echo $rstudent['rst_birthday']; ?>" class="form-control" placeholder="2000-01-01 ...">
                </div>
                <div class="form-group">
                  <label>メール</label>
                  <input type="text" name="rst_mail" value="<?php echo $rstudent['rst_mail']; ?>" class="form-control" placeholder="abcde@fghij...">
                </div>
                <div class="form-group">
                  <label>郵便番号</label>
                  <input type="text" name="rst_post" value="<?php echo $rstudent['rst_post']; ?>" class="form-control" placeholder="123-4567 ...">
                </div>
                <div class="form-group">
                  <label>住所</label>
                  <input type="text" name="rst_add" value="<?php echo $rstudent['rst_add']; ?>" class="form-control" placeholder="都道府県　市　町 番地　...">
                </div>
                <div class="form-group">
                  <label>電話</label>
                  <input type="text" align=""name="rst_phone" value="<?php echo $rstudent['rst_phone']; ?>" class="form-control" placeholder="123-4567-...">
                </div>
                <div class="form-group">
                  <label>習得資格</label>
                  <input type="text" name="rst_qualifi" value="<?php echo $rstudent['rst_qualifi']; ?>" class="form-control" placeholder="　気質診断１級...">
                </div>
                <div class="form-group">
                  <label>入会日</label>
                  <input type="text" name="rst_clsreg" value="<?php echo $rstudent['rst_clsreg']; ?>" class="form-control" placeholder="2000-01-01 ...">
                </div>


              <div class="box-footer">
                <button type="submit" class="btn btn-primary"  name="syori" value="登録">登録</button>
    				  <?php if ( $mstmsg <> '' ) { ?>
					    <?php echo $mstmsg; ?>
    				  <?php } ?>
              </div>


              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
</html>
