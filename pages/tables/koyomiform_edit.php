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

if ( isset($_GET['mstact']) ) {
  if ( $_GET['mstact'] != '' ) {
    $_SESSION['mstact'] = $_GET['mstact'];
	
	if (  $_SESSION['mstact'] == 'mstedit' ) {
  	  if ( $_GET['masterid'] != '' ) {
        $_SESSION['masterid'] = $_GET['masterid'];
		

		$where1 = '';
		$sql1 = '';
		$result1 = '';
		$sql1 = "select * from koyomiform where koyomiform_id = '" . $_SESSION['masterid'] . "'";
		$result1 = mysqli_query( $link1, $sql1 );
		$koyomiform = mysqli_fetch_array( $result1 );		
		
      }
	}
	if (  $_SESSION['mstact'] == 'mstnew' ) {
		
  	  if ( $_GET['masterid'] != '' ) {
        $_SESSION['masterid'] = '0';

		$where1 = '';
		$sql1 = '';
		$result1 = '';
		$sql1 = "select * from koyomiform where koyomiform_id = '" . '0' . "'";
		$result1 = mysqli_query( $link1, $sql1 );
		$koyomiform = mysqli_fetch_array( $result1 );
	  }
	}
	
  }
}

//********************************************************************
if ( isset($_POST['syori']) ) {
  if ( $_POST['syori'] == '登録' ) {
	  
	$kfm_chgyear = $_POST['kfm_year'] . '-' . $_POST['chgyear_month'] . '-' . $_POST['chgyear_day'];
	  
	$kfm_chgjan = $_POST['kfm_year'] . '-01-' . $_POST['chgjan_day'];
	$kfm_convjan = $_POST['kfm_year'] . '-01-' . $_POST['convjan_day'];
	$kfm_chgfeb = $_POST['kfm_year'] . '-02-' . $_POST['chgfeb_day'];
	$kfm_convfeb = $_POST['kfm_year'] . '-02-' . $_POST['convfeb_day'];
	$kfm_chgmar = $_POST['kfm_year'] . '-03-' . $_POST['chgmar_day'];
	$kfm_convmar = $_POST['kfm_year'] . '-03-' . $_POST['convmar_day'];
	$kfm_chgapr = $_POST['kfm_year'] . '-04-' . $_POST['chgapr_day'];
	$kfm_convapr = $_POST['kfm_year'] . '-04-' . $_POST['convapr_day'];
	$kfm_chgmay = $_POST['kfm_year'] . '-05-' . $_POST['chgmay_day'];
	$kfm_convmay = $_POST['kfm_year'] . '-05-' . $_POST['convmay_day'];
	$kfm_chgjun = $_POST['kfm_year'] . '-06-' . $_POST['chgjun_day'];
	$kfm_convjun = $_POST['kfm_year'] . '-06-' . $_POST['convjun_day'];
	$kfm_chgjul = $_POST['kfm_year'] . '-07-' . $_POST['chgjul_day'];
	$kfm_convjul = $_POST['kfm_year'] . '-07-' . $_POST['convjul_day'];
	$kfm_chgaug = $_POST['kfm_year'] . '-08-' . $_POST['chgaug_day'];
	$kfm_convaug = $_POST['kfm_year'] . '-08-' . $_POST['convaug_day'];
	$kfm_chgsep = $_POST['kfm_year'] . '-09-' . $_POST['chgsep_day'];
	$kfm_convsep = $_POST['kfm_year'] . '-09-' . $_POST['convsep_day'];
	$kfm_chgoct = $_POST['kfm_year'] . '-10-' . $_POST['chgoct_day'];
	$kfm_convoct = $_POST['kfm_year'] . '-10-' . $_POST['convoct_day'];
	$kfm_chgnov = $_POST['kfm_year'] . '-11-' . $_POST['chgnov_day'];
	$kfm_convnov = $_POST['kfm_year'] . '-11-' . $_POST['convnov_day'];
	$kfm_chgdec = $_POST['kfm_year'] . '-12-' . $_POST['chgdec_day'];
	$kfm_convdec = $_POST['kfm_year'] . '-12-' . $_POST['convdec_day'];
	  
	if (  $_SESSION['mstact'] == 'mstnew' ) {
		
		
		$sql = "insert into koyomiform (
			kfm_year,
			kfm_chgyear,
			kfm_chgjan,
			kfm_convjan,
			kfm_chgfeb,
			kfm_convfeb,
			kfm_chgmar,
			kfm_convmar,
			kfm_chgapr,
			kfm_convapr,
			kfm_chgmay,
			kfm_convmay,
			kfm_chgjun,
			kfm_convjun,
			kfm_chgjul,
			kfm_convjul,
			kfm_chgaug,
			kfm_convaug,
			kfm_chgsep,
			kfm_convsep,
			kfm_chgoct,
			kfm_convoct,
			kfm_chgnov,
			kfm_convnov,
			kfm_chgdec,
			kfm_convdec,
			kfm_notes,
			kfm_status
		) values (
			'" . mysqli_real_escape_string( $link1, $_POST['kfm_year']  ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_chgyear ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_chgjan ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_convjan ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_chgfeb ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_convfeb ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_chgmar ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_convmar ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_chgapr ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_convapr ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_chgmay ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_convmay ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_chgjun ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_convjun ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_chgjul ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_convjul ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_chgaug ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_convaug ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_chgsep ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_convsep ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_chgoct ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_convoct ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_chgnov ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_convnov ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_chgdec ) . "',
			'" . mysqli_real_escape_string( $link1, $kfm_convdec ) . "',
			'" . '' . "',
			'" . '0' . "'
		)";
		$result = mysqli_query( $link1, $sql ) or die('query error164' . mysql_error());
		$_SESSION['masterid'] = mysqli_insert_id( $link1 );
		$_SESSION['mstact'] = 'mstedit';
	
		$where = '';
		$sql1 = '';
		$result1 = '';
		$sql1 = "select * from koyomiform where koyomiform_id = '" . $_SESSION['masterid'] . "'";
		$result1 = mysqli_query( $link1, $sql1 );
		$koyomiform = mysqli_fetch_array( $result1 );
		
		
	
	} else {

		$sql = "update koyomiform set
					kfm_year = '" . mysqli_real_escape_string( $link1, $_POST['kfm_yaer'] ) . "',
					kfm_chgyear = '" . mysqli_real_escape_string( $link1, $kfm_chgyear ) . "',
					kfm_chgjan = '" . mysqli_real_escape_string( $link1, $kfm_chgjan ) . "',
					kfm_convjan = '" . mysqli_real_escape_string( $link1, $kfm_convjan ) . "',
					kfm_chgfeb = '" . mysqli_real_escape_string( $link1, $kfm_chgfeb ) . "',
					kfm_convfeb = '" . mysqli_real_escape_string( $link1, $kfm_convfeb ) . "',
					kfm_chgmar = '" . mysqli_real_escape_string( $link1, $kfm_chgmar ) . "',
					kfm_convmar = '" . mysqli_real_escape_string( $link1, $kfm_convmar ) . "',
					kfm_chgapr = '" . mysqli_real_escape_string( $link1, $kfm_chgapr ) . "',
					kfm_convapr = '" . mysqli_real_escape_string( $link1, $kfm_convapr ) . "',
					kfm_chgmay = '" . mysqli_real_escape_string( $link1, $kfm_chgmay ) . "',
					kfm_convmay = '" . mysqli_real_escape_string( $link1, $kfm_convmay ) . "',
					kfm_chgjun = '" . mysqli_real_escape_string( $link1, $kfm_chgjun ) . "',
					kfm_convjun = '" . mysqli_real_escape_string( $link1, $kfm_convjun ) . "',
					kfm_chgjul = '" . mysqli_real_escape_string( $link1, $kfm_chgjul ) . "',
					kfm_convjul = '" . mysqli_real_escape_string( $link1, $kfm_convjul ) . "',
					kfm_chgaug = '" . mysqli_real_escape_string( $link1, $kfm_chgaug ) . "',
					kfm_convaug = '" . mysqli_real_escape_string( $link1, $kfm_convaug ) . "',
					kfm_chgsep = '" . mysqli_real_escape_string( $link1, $kfm_chgsep ) . "',
					kfm_convsep = '" . mysqli_real_escape_string( $link1, $kfm_convsep ) . "',
					kfm_chgoct = '" . mysqli_real_escape_string( $link1, $kfm_chgoct ) . "',
					kfm_convoct = '" . mysqli_real_escape_string( $link1, $kfm_convoct ) . "',
					kfm_chgnov = '" . mysqli_real_escape_string( $link1, $kfm_chgnov ) . "',
					kfm_convnov = '" . mysqli_real_escape_string( $link1, $kfm_convnov ) . "',
					kfm_chgdec = '" . mysqli_real_escape_string( $link1, $kfm_chgdec ) . "',
					kfm_convdec = '" . mysqli_real_escape_string( $link1, $kfm_convdec ) . "'
			where koyomiform_id = '" . $_SESSION['masterid'] . "'";
		$result = mysqli_query( $link1, $sql ) or die('query error206' . mysql_error());
		
		$where1 = '';
		$sql1 = '';
		$result1 = '';
		$sql1 = "select * from koyomiform where koyomiform_id = '" . $_SESSION['masterid'] . "'";
		$result1 = mysqli_query( $link1, $sql1 );
		$koyomiform = mysqli_fetch_array( $result1 );
		
		
		
	}

	$mstmsg = '登録しました。';
		
  }
}




?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>鑑定暦生成設定</title>
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
              <h3 class="box-title">鑑定暦生成設定</h3>
				<a href="javascript:ctrl_wind('koyomiform_list.php')"><button class="btn btn-info pull-right">閉じる</button></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
	　　　　　　<form name="frm1" action="koyomiform_edit.php" method="post" class="search_form general_form">
                <!-- text input -->
                <div class="form-group">
                  <label>年（西暦）</label>
                  <input type="text" name="kfm_year" value="<?php echo $koyomiform['kfm_year']; ?>" placeholder="1900,2000, ...">年
                </div>
                <div class="form-group">
                  <label>月、日は２桁入力してください。</label>
                </div>
                <div class="form-group">
                  <label>年切替</label>
                  <input type="text" name="chgyear_month" value="<?php echo substr($koyomiform['kfm_chgyear'],5,2); ?>" placeholder="01,02, ..." size=4>月
                  <input type="text" name="chgyear_day" value="<?php echo substr($koyomiform['kfm_chgyear'],8,2); ?>" placeholder="01,02, ..." size=4>日
                </div>
                <div class="form-group">
                  <label>１月</label>
                  <input type="text" name="chgjan_day" value="<?php echo substr($koyomiform['kfm_chgjan'],8,2); ?>" placeholder="01,02, ..." size=4>（切替）日／
                  <input type="text" name="convjan_day" value="<?php echo substr($koyomiform['kfm_convjan'],8,2); ?>" placeholder="01,02, ..." size=4>（変換）日
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <label>２月</label>
                  <input type="text" name="chgfeb_day" value="<?php echo substr($koyomiform['kfm_chgfeb'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（切替）日／
                  <input type="text" name="convfeb_day" value="<?php echo substr($koyomiform['kfm_convfeb'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（変換）日
                </div>
                <div class="form-group">
                  <label>３月</label>
                  <input type="text" name="chgmar_day" value="<?php echo substr($koyomiform['kfm_chgmar'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（切替）日／
                  <input type="text" name="convmar_day" value="<?php echo substr($koyomiform['kfm_convmar'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（変換）日
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <label>４月</label>
                  <input type="text" name="chgapr_day" value="<?php echo substr($koyomiform['kfm_chgapr'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（切替）日／
                  <input type="text" name="convapr_day" value="<?php echo substr($koyomiform['kfm_convapr'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（変換）日
                </div>
                <div class="form-group">
                  <label>５月</label>
                  <input type="text" name="chgmay_day" value="<?php echo substr($koyomiform['kfm_chgmay'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（切替）日／
                  <input type="text" name="convmay_day" value="<?php echo substr($koyomiform['kfm_convmay'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（変換）日
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <label>６月</label>
                  <input type="text" name="chgjun_day" value="<?php echo substr($koyomiform['kfm_chgjun'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（切替）日／
                  <input type="text" name="convjun_day" value="<?php echo substr($koyomiform['kfm_convjun'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（変換）日
                </div>
                <div class="form-group">
                  <label>７月</label>
                  <input type="text" name="chgjul_day" value="<?php echo substr($koyomiform['kfm_chgjul'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（切替）日／
                  <input type="text" name="convjul_day" value="<?php echo substr($koyomiform['kfm_convjul'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（変換）日
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <label>８月</label>
                  <input type="text" name="chgaug_day" value="<?php echo substr($koyomiform['kfm_chgaug'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（切替）日／
                  <input type="text" name="convaug_day" value="<?php echo substr($koyomiform['kfm_convaug'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（変換）日
                </div>
                <div class="form-group">
                  <label>９月</label>
                  <input type="text" name="chgsep_day" value="<?php echo substr($koyomiform['kfm_chgsep'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（切替）日／
                  <input type="text" name="convsep_day" value="<?php echo substr($koyomiform['kfm_convsep'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（変換）日
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <label>１０月</label>
                  <input type="text" name="chgoct_day" value="<?php echo substr($koyomiform['kfm_chgoct'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（切替）日／
                  <input type="text" name="convoct_day" value="<?php echo substr($koyomiform['kfm_convoct'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（変換）日
                </div>
                <div class="form-group">
                  <label>１１月</label>
                  <input type="text" name="chgnov_day" value="<?php echo substr($koyomiform['kfm_chgnov'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（切替）日／
                  <input type="text" name="convnov_day" value="<?php echo substr($koyomiform['kfm_convnov'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（変換）日
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <label>１２月</label>
                  <input type="text" name="chgdec_day" value="<?php echo substr($koyomiform['kfm_chgdec'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（切替）日／
                  <input type="text" name="convdec_day" value="<?php echo substr($koyomiform['kfm_convdec'],8,2); ?>" placeholder="01,02, ..." size=4 maxlength=2>（変換）日
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
