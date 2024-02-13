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
$_SESSION['upname1'] = '';



// db connect
$link1 = db_connect1();
//$link2 = db_connect2();
//
////
////if ( auth () ) $login_st = 1 ;
//
//$_SESSION['sdate'] = $now_date;

$mstmsg = '';

if ( isset($_GET['mstact']) ) {
  if ( $_GET['mstact'] != '' ) {
    $_SESSION['mstact'] = $_GET['mstact'];

	if (  $_SESSION['mstact'] == 'mstedit' ) {
  	  if ( $_GET['masterid'] != '' ) {
        $_SESSION['masterid'] = $_GET['masterid'];


		$where1 = '';
		$sql1 = '';
		$result1 = '';
		$sql1 = "select * from kishitsucert where kishitsucert_id = '" . $_SESSION['masterid'] . "'";
		$result1 = mysqli_query( $link1, $sql1 );
		$kishitsucert = mysqli_fetch_array( $result1 );


      }
	}
	if (  $_SESSION['mstact'] == 'mstnew' ) {

  	  if ( $_GET['masterid'] != '' ) {
        $_SESSION['masterid'] = '0';

		$where1 = '';
		$sql1 = '';
		$result1 = '';
		$sql1 = "select * from kishitsucert where kishitsucert_id = '" . '0' . "'";
		$result1 = mysqli_query( $link1, $sql1 );
		$kishitsucert = mysqli_fetch_array( $result1 );
	  }
	}

  }
}

//********************************************************************
if ( isset($_POST['syori']) ) {
  if ( $_POST['syori'] == '登録' ) {

	$upload_dir = "../../certimg/";

	if (isset($_FILES['file']) && $_FILES['file']['tmp_name']!="") { //添付ファイルをアップロードしていたら


		  $file_path = $upload_dir.$_FILES['file']['name'];
		  $_SESSION['upname1'] = $_FILES['file']['name'];

		echo $file_path;

		if (move_uploaded_file($_FILES['file']['tmp_name'],$file_path)) {
                  chmod($file_path,0644);
				  $errmsg .= '「' . $_FILES['file']['name'] . '」をアップロードしました。';
              } else {
                 $errmsg .= 'ファイルのアップロードに失敗しました。<br />';
			      $_SESSION['upname1'] = '';
              }
	}

	  if (  $_SESSION['mstact'] == 'mstnew' ) {


		$sql = "insert into kishitsucert (
			ksc_memberid,
			ksc_country,
			ksc_getyear,
			ksc_certno,
			ksc_stepclass,
			ksc_certificate,
			ksc_certsend,
			ksc_notes
		) values (
			'" . mysqli_real_escape_string( $link1, $_POST['ksc_memberid'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['ksc_country'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['ksc_getyear'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['ksc_certno'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['ksc_stepclass'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_SESSION['upname1'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['ksc_certsend'] ) . "',
			'" . '' . "'
		)";
		$result = mysqli_query( $link1, $sql ) or die('query error120' . mysqli_error($link1));
		$_SESSION['masterid'] = mysqli_insert_id( $link1 );
		$_SESSION['mstact'] = 'mstedit';

		$where = '';
		$sql1 = '';
		$result1 = '';
		$sql1 = "select * from kishitsucert where kishitsucert_id = '" . $_SESSION['masterid'] . "'";
		$result1 = mysqli_query( $link1, $sql1 );
		$kishitsucert = mysqli_fetch_array( $result1 );


        $mstmsg = '登録しました。';

	  } else {

        if ( $_SESSION['upname1'] == '' ) { $_SESSION['upname1'] = $_POST['ksc_certificate']; }

		$sql = "update kishitsucert set
					ksc_memberid = '" . mysqli_real_escape_string( $link1, $_POST['ksc_memberid'] ) . "',
					ksc_country = '" . mysqli_real_escape_string( $link1, $_POST['ksc_country'] ) . "',
					ksc_getyear = '" . mysqli_real_escape_string( $link1, $_POST['ksc_getyear'] ) . "',
					ksc_certno = '" . mysqli_real_escape_string( $link1, $_POST['ksc_certno'] ) . "',
					ksc_stepclass = '" . mysqli_real_escape_string( $link1, $_POST['ksc_stepclass'] ) . "',
					ksc_certificate = '" . mysqli_real_escape_string( $link1, $_SESSION['upname1'] ) . "',
					ksc_certsend = '" . mysqli_real_escape_string( $link1, $_POST['ksc_certsend'] ) . "'
			where kishitsucert_id = '" . $_SESSION['masterid'] . "'";
		$result = mysqli_query( $link1, $sql ) or die('query error147' . mysqli_error($link1));

		$where1 = '';
		$sql1 = '';
		$result1 = '';
		$sql1 = "select * from kishitsucert where kishitsucert_id = '" . $_SESSION['masterid'] . "'";
		$result1 = mysqli_query( $link1, $sql1 );
		$kishitsucert = mysqli_fetch_array( $result1 );


        $mstmsg = '登録しました。';

	  }


  }
}

//-------------------------------------------------------------------------------

$where51 = '';
$sql51 = '';
$result51 = '';
$member_tbl[] = '';

$where51 .= "member_id > '" . '0' . "' and ";
$where51 .= '1 = 1';
$sql51 = "select * from member where $where51 order by member_id";
$result51 = mysqli_query( $link1, $sql51 ) or die('query error175' . mysqli_error($link1));


$n = 0; while ( $member51 = mysqli_fetch_array( $result51 ) ) {
  $tbl_no = $member51['member_id'];
  $member_tbl[$tbl_no] = $member51['mbr_kanji'];
$n ++; }




?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>気質認定証明情報編集</title>
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
              <h3 class="box-title">気質認定証明情報編集</h3>
				<a href="javascript:ctrl_wind('kishitsucert_list.php')"><button class="btn btn-info pull-right">閉じる</button></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
	　　　　　　<form name="frm1" action="kishitsucert_edit.php" method="post" enctype="multipart/form-data" class="search_form general_form">
                <!-- text input -->
    		    <?php if ( $error <> '' ) { ?>
                <div class="form-group">
					<label><font color="#FF0000"><?php echo $error; ?></font></label>
                </div>
    		    <?php } ?>
                <div class="form-group">
                  <label>取得者</label>
                  <select class="form-control" name="ksc_memberid"><?php foreach ( $member_tbl as $key => $value ) if ( $key == $kishitsucert['ksc_memberid'] ) echo "<option value=$key selected>$value\n"; else echo "<option value=$key>$value\n" ?></select>
                </div>
                <div class="form-group">
                  <label>国</label>
                  <select class="form-control" name="ksc_country"><?php foreach ( $country_tbl as $key => $value ) if ( $key == $kishitsucert['ksc_country'] ) echo "<option value=$key selected>$value\n"; else echo "<option value=$key>$value\n" ?></select>
                </div>
                <div class="form-group">
                  <label>取得年</label>
                  <input type="text" name="ksc_getyear" value="<?php echo $kishitsucert['ksc_getyear']; ?>" class="form-control" placeholder="2001 ...">
                </div>
                <div class="form-group">
                  <label>認定番号</label>
                  <input type="text" name="ksc_certno" value="<?php echo $kishitsucert['ksc_certno']; ?>" class="form-control" placeholder="123A456 ...">
                </div>
                <div class="form-group">
                  <label>取得級</label>
                  <select class="form-control" name="ksc_stepclass"><?php foreach ( $stepclass_tbl as $key => $value ) if ( $key == $kishitsucert['ksc_stepclass'] ) echo "<option value=$key selected>$value\n"; else echo "<option value=$key>$value\n" ?></select>
                </div>
                <div class="form-group">
                  <label>認定証：<?php echo $kishitsucert['ksc_certificate']; ?></label>
                  <input type="hidden" name="ksc_certificate" value="<?php echo $kishitsucert['ksc_certificate']; ?>" />
                  <input type="file" name="file" size="25" value="" />
                </div>
                <div class="form-group">
                  <label>認定証送信</label>
                  <select class="form-control" name="ksc_certsend"><?php foreach ( $certsend_tbl as $key => $value ) if ( $key == $kishitsucert['ksc_certsend'] ) echo "<option value=$key selected>$value\n"; else echo "<option value=$key>$value\n" ?></select>
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
