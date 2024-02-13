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

if ( $_SESSION['passwd'] != '' ) {
    $_SESSION['sidemenu'] = 'rstudent_list';
  } else {
        header('Location: ../../index.php');
        exit;
  }


// db connect
$link1 = db_connect1();

//********************************************************************
if ( isset($_GET['action']) ) {
  if ( $_GET['action'] == 'rstudentdel' ) {

	$sql = "delete from rstudent where rstudent_id = '" . $_GET['rstudent_id'] . "'";
	$result = mysqli_query( $link1, $sql );

  }
}

//********************************************************************
if ( isset($_GET['action']) ) {
  if ( $_GET['action'] == 'rstclassdel' ) {

  $sql = "delete from rstclass where rstclass_id = '" . $_GET['rstclass_id'] . "'";
  $result = mysqli_query( $link1, $sql );

  }
}




?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>氣質診断管理システム | 受講生一覧</title><!-- 20171002 -->
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
function navi_win2( Masterid ) {
        self.window.name="main"
        w = window.open('', 'Remocon', 'width=800,height=900,status=yes,scrollbars=yes,directories=no,menubar=no,resizable=yes,toolbar=no');
        if (w != null) {
                if (w.opener == null) {w.opener = self;}
                w.location.href = './rstudent_edit.php?mstact=mstedit&masterid=' + Masterid;
        }
}
</script>
<script language="JavaScript" type="text/javascript">
function navi_win1() {
        self.window.name="main"
        w = window.open('', 'Remocon', 'width=800,height=900,status=yes,scrollbars=yes,directories=no,menubar=no,resizable=yes,toolbar=no');
        if (w != null) {
                if (w.opener == null) {w.opener = self;}
                w.location.href = './rstudent_edit.php?mstact=mstnew';
        }
}
</script>
<script language="JavaScript" type="text/javascript">
function navi_win3( Masterid ) {
        self.window.name="main"
        w = window.open('', 'Remocon', 'width=800,height=700,status=yes,scrollbars=yes,directories=no,menubar=no,resizable=yes,toolbar=no');
        if (w != null) {
                if (w.opener == null) {w.opener = self;}
                w.location.href = './rstclass_edit.php?mstact=mstnew&masterid=' + Masterid;
        }
}
</script>
<script language="JavaScript" type="text/javascript">
function navi_win4( Masterid ) {
        self.window.name="main"
        w = window.open('', 'Remocon', 'width=800,height=700,status=yes,scrollbars=yes,directories=no,menubar=no,resizable=yes,toolbar=no');
        if (w != null) {
                if (w.opener == null) {w.opener = self;}
                w.location.href = './rstclass_edit.php?mstact=mstedit&masterid=' + Masterid;
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
    <?php require("main_header.php") ?>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
    <?php require("side_menu.php") ?>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        受講生一覧
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
            <div class="box-footer">
              <a href="javascript:navi_win1()"><button class="btn btn-primary">受講生追加</button></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th class="huntsys1">名前</th>
                  <th class="huntsys1">生年月日</th>
                  <th class="huntsys1">メール</th>
                  <th class="huntsys1">連絡先</th>
                  <th class="huntsys1">取得資格</th>
                  <th class="huntsys1">入会日</th>
                  <th class="huntsys1" colspan="3">選択</th>
                </tr>
                </thead>
                <thead>
                <tr>
                  <th class="huntsys1">&nbsp;</th>
                  <th class="huntsys1">受講名</th>
                  <th class="huntsys1">受講期間</th>
                  <th class="huntsys1">受講料</th>
                  <th class="huntsys1">支払方法</th>
                  <th class="huntsys1">支払状況</th>
                  <th class="huntsys1" colspan="2">選択</th>
                </tr>
                </thead>

        			  <?php
        				$where101 = '';
        				$sql101 = '';
        				$result101 = '';
        				$where101 .= "rstudent_id > '" . '0' . "' and ";
        				$where101 .= '1 = 1';
        				$sql101 = "select * from rstudent where $where101 order by rstudent_id";
        				$result101 = mysqli_query( $link1, $sql101 ) or die('query error201' . mysqli_error($link1));

        			  ?>
        			  <?php $m = 0; while ( $rstudent = mysqli_fetch_array( $result101 ) ) { ?>
                  <tbody>
            				<tr>
            				  <td class="huntsys1"><?php echo $rstudent['rst_kanji'] ?></td>
            				  <td class="huntsys1"><?php echo $rstudent['rst_birthday'] ?></td>
                      <td class="huntsys1"><?php echo $rstudent['rst_mail'] ?></td>
                      <td class="huntsys1"><?php echo $rstudent['rst_phone'] ?></td>
            				  <td class="huntsys1"><?php echo $rstudent['rst_qualifi'] ?></td>
            				  <td class="huntsys1"><?php echo $rstudent['rst_clsreg'] ?></td>
            				  <td class="huntsys1"><a href="javascript:navi_win2( '<?php echo $rstudent['rstudent_id'] ?>' )">編集</a></td>
            				  <td class="huntsys1"><a href="rstudent_list.php?rstudent_id=<?php echo $rstudent['rstudent_id'] ?>&action=rstudentdel" alt="削除" title="データを削除します。" onClick="return confirm( 'データを削除します。よろしいですか？' )">削除</a></td>
                      <td class="huntsys1"><a href="javascript:navi_win3( '<?php echo $rstudent['rstudent_id'] ?>' )">受講追加</a></td>
            				</tr>
                  </tbody>
                  <?php
                  $where111 = '';
                  $sql111 = '';
                  $result111 = '';
                  $where111 .= "rsc_rstudentid = '" . $rstudent['rstudent_id'] . "' and ";
                  $where111 .= '1 = 1';
                  $sql111 = "select * from rstclass where $where111 order by rsc_clsfrom DESC";
                  $result111 = mysqli_query( $link1, $sql111 ) or die('query error213' . mysqli_error($link1));
                  ?>
                  <?php $k = 0; while ( $rstclass = mysqli_fetch_array( $result111 ) ) { ?>
                    <tbody>
                      <tr>
                        <td class="huntsys1">&nbsp;</td>
                        <td class="huntsys1"><?php echo $rstclass['rsc_name'] ?></td>
                        <td class="huntsys1"><?php echo $rstclass['rsc_clsfrom'] ?>〜<?php echo $rstclass['rsc_clsto'] ?></td>
                        <td class="huntsys1"><?php echo $rstclass['rsc_pay'] ?>円</td>
                        <td class="huntsys1"><?php echo $paymth_tbl[$rstclass['rsc_paymth']] ?></td>
                        <td class="huntsys1"><?php echo $rstclass['rsc_payst'] ?></td>
                        <td class="huntsys1"><a href="javascript:navi_win4( '<?php echo $rstclass['rstclass_id'] ?>' )">編集</a></td>
                        <td class="huntsys1"><a href="rstudent_list.php?rstclass_id=<?php echo $rstclass['rstclass_id'] ?>&action=rstclassdel" alt="削除" title="データを削除します。" onClick="return confirm( 'データを削除します。よろしいですか？' )">削除</a></td>
                      </tr>
                    </tbody>
                  <?php $k ++; } ?>
                <?php $m ++; } ?>

              </table>
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
