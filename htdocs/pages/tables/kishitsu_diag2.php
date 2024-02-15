
<?php

//


require( '../../config.php' );
require( '../../lib.php' );
require( '../../system_tbl.php' );

$nyear = date( 'Y' );
$njyear = $nyear - 1988;
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

//
// session_set_cookie_params( 365 * 24 * 3600 );

// session_start();

//if ( $_SESSION['passwd'] != '' ) {
//  } else {
//        header('Location: ../../index.php');
//        exit;
//  }


// db connect
$link1 = db_connect1();



//********************************************************************
if ( isset($_POST['syori']) ) {
  if ( $_POST['syori'] == '診断' ) {

  	  if ( $_POST['aky_year'] > '0' ) {
        $_SESSION['aky_year'] = $_POST['aky_year'];
	  }
  	  if ( $_POST['aky_month'] != '' ) {
        $_SESSION['aky_month'] = $_POST['aky_month'];
	  }
  	  if ( $_POST['aky_day'] != '' ) {
        $_SESSION['aky_day'] = $_POST['aky_day'];
	  }

  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>氣質診断 | 氣質診断10種</title><!-- 20171002 -->
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
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
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">



<script language="JavaScript" type="text/javascript">
function navi_win( Masterid ) {
        self.window.name="main"
        w = window.open('', 'Remocon', 'width=800,height=900,status=yes,scrollbars=yes,directories=no,menubar=no,resizable=yes,toolbar=no');
        if (w != null) {
                if (w.opener == null) {w.opener = self;}
                w.location.href = './attendance_edit.php?mstact=mstedit&masterid=' + Masterid;
        }
}
</script>
<script language="JavaScript" type="text/javascript">
function navi_win1( Masterid ) {
        self.window.name="main"
        w = window.open('', 'Remocon', 'width=800,height=900,status=yes,scrollbars=yes,directories=no,menubar=no,resizable=yes,toolbar=no');
        if (w != null) {
                if (w.opener == null) {w.opener = self;}
                w.location.href = './attendance_edit.php?mstact=mstnew&masterid=' + Masterid;
        }
}
</script>

<style type="text/css">

th.huntsys1 { text-align: center; }
td.huntsys1 { text-align: center; }

</style>

</head>
<body class="hold-transition skin-black-light sidebar-mini"><!-- 20171002 -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo $_SESSION['home_url'] ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><i class="fa fa-home"></i></span>
      <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>氣質診断</b></span><!-- 20171002 -->
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
    <section class="content-header">
      <h>
		  <font size="+1"><b></b></font>
      </h>
    </section>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel --><!-- 20171002 -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-inbox"></i> <span>氣質診断</span>
            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i>氣質診断結果</a></li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        氣質診断１０種
      </h1>
<!--
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">氣質</a></li>
        <li class="active">氣質診断１０種</li>
      </ol>
-->
    </section>

    <!-- Main content -->
    <section class="content">

            <div class="box-header">
              <h3 class="box-title">
　　　　　　　    <form name="frm1" action="kishitsu_diag2.php" enctype="multipart/form-data" method="post">
                  <input type="text" name="aky_year" value="<?php echo $_SESSION['aky_year']; ?>" placeholder="2018 ...">年
                  <input type="text" name="aky_month" value="<?php echo $_SESSION['aky_month']; ?>" placeholder="01 ...">月
                  <input type="text" name="aky_day" value="<?php echo $_SESSION['aky_day']; ?>" placeholder="01 ...">日
                  <button type="submit" class="btn btn-primary"  name="syori" value="診断">診断</button>
			    </form>
              </h3>
            </div>
      <div class="row">
        <div class="col-md-3">


		  <?php
			$aky_date = $_SESSION['aky_year'] . '-' . $_SESSION['aky_month'] . '-' . $_SESSION['aky_day'];
			$where101 = '';
			$sql101 = '';
			$result101 = '';
			$where101 .= "aky_date = '" . $aky_date . "' and ";
			$where101 .= '1 = 1';
			$sql101 = "select * from aurakoyomi where $where101";
			$result101 = mysqli_query( $link1, $sql101 ) or die('query error274' . mysqli_error($link1));
			$num_rows101 = mysqli_num_rows( $result101 );

		  ?>
          <!-- Profile Image -->
          <div class="box box-primary">

          <?php if ( $num_rows101 > '0' ) { ?>
            <?php $aurakoyomi = mysqli_fetch_array( $result101 ); ?>
            <div class="box-body box-profile">
              <h3 class="profile-username text-center">あなたの氣質は<br>「<?php echo $ki10w5_tbl[$aurakoyomi['aky_day10']]; ?>」の「<?php echo $ki10s2_tbl[$aurakoyomi['aky_day10']]; ?>」です。</h3>
              <img class="profile-user-img img-responsive img-circle" src="../../dist/img/<?php echo $ki10img10_tbl[$aurakoyomi['aky_day10']]; ?>" alt="User profile picture">


              <p class="text-muted text-center"><?php echo $ki10p10_tbl[$aurakoyomi['aky_day10']]; ?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>あなたの生まれ</b> <a class="pull-right"><?php echo $_SESSION['aky_year']; ?>年<?php echo $_SESSION['aky_month']; ?>月<?php echo $_SESSION['aky_day']; ?>日</a>
                </li>
                <li class="list-group-item">
                  <b>氣質</b> <a class="pull-right"><?php echo $ki10t10_tbl[$aurakoyomi['aky_day10']]; ?></a>
                </li>
              </ul>

            </div>
          <?php } else { ?>
            <div class="box-body box-profile">
              <h3 class="profile-username text-center">生年月日を入れてください。</h3>

            </div>
          <?php } ?>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">

            <?php $aurakoyomi = mysqli_fetch_array( $result101 ); ?>
            <div class="box-body box-profile">
              <img class="img-responsive" src="../../dist/img/vitace_group.png">

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2018 roominr .</strong> All rights
    reserved.
  </footer>

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
<!-- DataTables -->
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
