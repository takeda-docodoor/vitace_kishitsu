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
	  	  if ( $_GET['masterid'] > '0' ) {
	        $_SESSION['masterid'] = $_GET['masterid'];

					$where1 = '';
					$sql1 = '';
					$result1 = '';
					$sql1 = "select * from rstclass where rstclass_id = '" . $_SESSION['masterid'] . "'";
					$result1 = mysqli_query( $link1, $sql1 );
					$rstclass = mysqli_fetch_array( $result1 );		
			  
			
	      }
		}
		if (  $_SESSION['mstact'] == 'mstnew' ) {
			
	  	  if ( $_GET['masterid'] > '0' ) {
	        $_SESSION['rstudentid'] = $_GET['masterid'];

					$where1 = '';
					$sql1 = '';
					$result1 = '';
					$sql1 = "select * from rstclass where rstclass_id = '" . '0' . "'";
					$result1 = mysqli_query( $link1, $sql1 );
					$rstclass = mysqli_fetch_array( $result1 );
				}
		}
	
  }
}

//********************************************************************
if ( isset($_POST['syori']) ) {
  if ( $_POST['syori'] == '登録' ) {
	  
	  
	  if (  $_SESSION['mstact'] == 'mstnew' ) {
			
		
		$sql = "insert into rstclass (
			rsc_rstudentid,
			rsc_name,
			rsc_clsfrom,
			rsc_clsto,
			rsc_paymth,
			rsc_pay,
			rsc_payst,
			rsc_notes
		) values (
			'" . mysqli_real_escape_string( $link1, $_SESSION['rstudentid'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['rsc_name'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['rsc_clsfrom'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['rsc_clsto'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['rsc_paymth'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['rsc_pay'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['rsc_payst'] ) . "',
			'" . '' . "'
		)";
		$result = mysqli_query( $link1, $sql ) or die('query error104' . mysql_error());
		$_SESSION['masterid'] = mysqli_insert_id( $link1 );
		$_SESSION['mstact'] = 'mstedit';
	
		$where = '';
		$sql1 = '';
		$result1 = '';
		$sql1 = "select * from rstclass where rstclass_id = '" . $_SESSION['masterid'] . "'";
		$result1 = mysqli_query( $link1, $sql1 );
		$rstclass = mysqli_fetch_array( $result1 );
		
		
        $mstmsg = '登録しました。';
	
	  } else {

		$sql = "update rstclass set
					rsc_name = '" . mysqli_real_escape_string( $link1, $_POST['rsc_name'] ) . "',
					rsc_clsfrom = '" . mysqli_real_escape_string( $link1, $_POST['rsc_clsfrom'] ) . "',
					rsc_clsto = '" . mysqli_real_escape_string( $link1, $_POST['rsc_clsto'] ) . "',
					rsc_paymth = '" . mysqli_real_escape_string( $link1, $_POST['rsc_paymth'] ) . "',
					rsc_pay = '" . mysqli_real_escape_string( $link1, $_POST['rsc_pay'] ) . "',
					rsc_payst = '" . mysqli_real_escape_string( $link1, $_POST['rsc_payst'] ) . "'
			where rstclass_id = '" . $_SESSION['masterid'] . "'";
		$result = mysqli_query( $link1, $sql ) or die('query error128' . mysql_error());
		
		$where1 = '';
		$sql1 = '';
		$result1 = '';
		$sql1 = "select * from rstclass where rstclass_id = '" . $_SESSION['masterid'] . "'";
		$result1 = mysqli_query( $link1, $sql1 );
		$rstclass = mysqli_fetch_array( $result1 );
		
		
        $mstmsg = '登録しました。';
		
	  }

		
  }
}




?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>受講情報編集</title>
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
              <h3 class="box-title">受講情報編集</h3>
				<a href="javascript:ctrl_wind('rstudent_list.php')"><button class="btn btn-info pull-right">閉じる</button></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
	　　　　　　<form name="frm1" action="rstclass_edit.php" method="post" class="search_form general_form">
                <!-- text input -->
    		    <?php if ( $error != '' ) { ?>
                <div class="form-group">
					<label><font color="#FF0000"><?php echo $error; ?></font></label>
                </div>
    		    <?php } ?>
                <div class="form-group">
                  <label>受講名</label>
                  <input type="text" name="rsc_name" value="<?php echo $rstclass['rsc_name']; ?>" class="form-control" placeholder="受講名 ...">
                </div>
                <div class="form-group">
                  <label>受講期間</label>
                  <input type="text" name="rsc_clsfrom" value="<?php echo $rstclass['rsc_clsfrom']; ?>" class="form-control" placeholder="2000-01-01 ...">
                  〜
                  <input type="text" name="rsc_clsto" value="<?php echo $rstclass['rsc_clsto']; ?>" class="form-control" placeholder="2000-01-01 ...">
                </div>
                <div class="form-group">
                  <label>支払方法</label>
                  <select class="form-control" name="rsc_paymth"><?php foreach ( $paymth_tbl as $key => $value ) if ( $key == $rstclass['rsc_paymth'] ) echo "<option value=$key selected>$value\n"; else echo "<option value=$key>$value\n" ?></select>
                </div>
                <div class="form-group">
                  <label>支払料金</label>
                  <input type="text" name="rsc_pay" value="<?php echo $rstclass['rsc_pay']; ?>" class="form-control" placeholder="1234 ...">
                </div>
                <div class="form-group">
                  <label>支払状況</label>
                  <input type="text" name="rsc_payst" value="<?php echo $rstclass['rsc_payst']; ?>" class="form-control" placeholder="一括済み...">
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
