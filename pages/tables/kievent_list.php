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
session_set_cookie_params( 365 * 24 * 3600 );

session_start();

//if ( $_SESSION['companyid'] > '0' ) {
//  } else {
//        header('Location: ../../index.php');
//        exit;
//  }


// db connect
$link1 = db_connect1();






//********************************************************************
if ( isset($_POST['syori']) ) {
  if ( $_POST['syori'] == '検索' ) {
	  
  	  if ( $_POST['mbr_companyid'] > '0' ) {
        $_SESSION['mbr_companyid'] = $_POST['mbr_companyid'];
	  }
	  
  }
}




//********************************************************************
if ( isset($_GET['action']) ) {
  if ( $_GET['action'] == 'memberdel' ) {
	  
	$sql = "delete from member where member_id = '" . $_GET['member_id'] . "'";
	$result = mysqli_query( $link1, $sql );
	  
  }
}




?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>氣質診断管理システム | イベント情報</title><!-- 20171002 -->
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
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
                w.location.href = './member_edit.php?mstact=mstedit&masterid=' + Masterid;
        }
}
</script>
<script language="JavaScript" type="text/javascript">
function navi_win1( Masterid ) {
        self.window.name="main"
        w = window.open('', 'Remocon', 'width=800,height=900,status=yes,scrollbars=yes,directories=no,menubar=no,resizable=yes,toolbar=no');
        if (w != null) {
                if (w.opener == null) {w.opener = self;}
                w.location.href = './member_edit.php?mstact=mstnew&masterid=' + Masterid;
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
        <span class="logo-lg"><b>管理者</b></span><!-- 20171002 -->
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
		  <font size="+1"><b>　<?php echo $_SESSION['mbr_kanji'] ?></b></font>
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
        <li class="treeview">
          <a href="#">
            <i class="fa fa-institution"></i> <span>メンバー情報</span>
            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="member_list.php"><i class="fa fa-circle-o"></i>メンバー情報一覧</a></li>
            <li class="active"><a href="kishitsucert_list.php"><i class="fa fa-circle-o"></i>認定証情報一覧</a></li>
            <li class="active"><a href="kicourse_list.php"><i class="fa fa-circle-o"></i>受講歴情報一覧</a></li>
            <li class="active"><a href="kistepup_list.php"><i class="fa fa-circle-o"></i>昇段受講情報一覧</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span>顧客情報</span>
            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>顧客一覧</a></li>
          </ul>
        </li>
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-user"></i> <span>イベント情報</span>
            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="kievent_list.php"><i class="fa fa-circle-o"></i>イベント一覧</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-inbox"></i> <span>鑑定暦データ生成</span>
            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="koyomiform_list.php"><i class="fa fa-circle-o"></i>鑑定暦データ生成</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-inbox"></i> <span>氣質診断</span>
            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="kishitsu_diag.html"><i class="fa fa-circle-o"></i>氣質診断結果</a></li>
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
        イベント一覧
      </h1>
      <ol class="breadcrumb">
        <li><a href="logout.php"><i class="fa fa-dashboard"></i> ログアウト</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th class="huntsys1">イベント名</th>
                  <th class="huntsys1">開催日</th>
                  <th class="huntsys1">開催場所</th>
                  <th class="huntsys1">内容</th>
                  <th class="huntsys1">担当</th>
                  <th class="huntsys1" colspan="2">選択</th>
                </tr>
                </thead>
                <tbody>
                
			  <?php
				$where101 = '';
				$sql101 = '';
				$result101 = '';
				$where101 .= "kievent_id > '" . '0' . "' and ";
				$where101 .= '1 = 1';
				$sql101 = "select * from kievent where $where101 order by kievent_id";
				$result101 = mysqli_query( $link1, $sql101 ) or die('query error284' . mysql_error());
		        
			  ?>
			  <?php $m = 0; while ( $kievent = mysqli_fetch_array( $result101 ) ) { ?>
				  <?php
					$where103 = '';
					$sql103 = '';
					$result103 = '';
					$sql103 = "select * from member where member_id = '" . $kievent['kev_person'] . "'";
					$result103 = mysqli_query( $link1, $sql103 );
					$member = mysqli_fetch_array( $result103 );
				  ?>
				<tr>
				  <td class="huntsys1"><?php echo $kievent['kev_name'] ?></td>
				  <td class="huntsys1"><?php echo $kievent['kev_holddate'] ?></td>
				  <td class="huntsys1"><?php echo $kievent['kev_holdwhere'] ?></td>
				  <td class="huntsys1"><?php echo $kievent['kev_contents'] ?></td>
				  <td class="huntsys1"><?php echo $member['mbr_kanji'] ?></td>
				  <td class="huntsys1"><a href="javascript:navi_win( '<?php echo $member['member_id'] ?>' )">編集</a></td>
				  <td class="huntsys1"><a href="member_list.php?member_id=<?php echo $member['member_id'] ?>&action=memberdel" alt="削除" title="データを削除します。" onClick="return confirm( 'データを削除します。よろしいですか？' )">削除</a></td>
				</tr>
              <?php $m ++; } ?>
               
                </tbody>
              </table>
              <div class="box-footer">
				  <a href="javascript:navi_win1( '<?php echo $_SESSION['mbr_companyid']  ?>' )"><button class="btn btn-primary">新規追加</button></a>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

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
    <strong>Copyright &copy; 2018 Office-N .</strong> All rights
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
