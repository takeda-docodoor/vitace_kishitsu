<?php

//


require('../../config.php');
require('../../lib.php');
require('../../system_tbl.php');

$nyear = date('Y');
$njyear = $nyear - 1988;
$nmonth = date('m');
$nday = date('d');
$nhour = date('H');
$nmin = date('i');
$nsec = date('s');

$now_date = $nyear . '-' . $nmonth . '-' . $nday . ' ' . $nhour . ':' . $nmin . ':' . $nsec;

$now_ymd = $nyear . '-' . $nmonth . '-' . $nday;


//
$login_st = 0;    // ログイン初期化

$error = '';

//
session_set_cookie_params(365 * 24 * 3600);

session_start();

//if ( $_SESSION['companyid'] > '0' ) {
//  } else {
//        header('Location: ../../index.php');
//        exit;
//  }


// db connect
$link1 = db_connect1();


////
//if ( auth () ) $login_st = 1 ;
//if ( $login_st != '1' ) {
//  header( 'Location: ' . $login_url ); //
//  exit;
//}





//********************************************************************
if (isset($_GET['action'])) {
  if ($_GET['action'] == 'attendancedel') {

    $sql = "delete from attendance where attendance_id = '" . $_GET['attendance_id'] . "'";
    $result = mysqli_query($link1, $sql);
  }

  if ($_GET['action'] == 'koyomiformdel') {

    $where1 = '';
    $sql1 = '';
    $result1 = '';
    $sql1 = "select * from koyomiform where koyomiform_id = '" . $_GET['koyomiform_id'] . "'";
    $result1 = mysqli_query($link1, $sql1);
    $koyomiform = mysqli_fetch_array($result1);

    $aura_ymdfrom = $koyomiform['kfm_year'] . '-01-01';
    $aura_ymdto = $koyomiform['kfm_year'] . '-12-31';
    $where10 = '';
    $sql10 = '';
    $result10 = '';
    $where10 .= "aky_date >= '" . $aura_ymdfrom . "' and ";
    $where10 .= "aky_date <= '" . $aura_ymdto . "' and ";
    $where10 .= '1 = 1';
    $sql10 = "select * from aurakoyomi where $where10 order by aky_date";
    $result10 = mysqli_query($link1, $sql10) or die('query error88' . mysqli_error($link1));
    while ($aurakoyomi10 = mysqli_fetch_array($result10)) {
      $sql = "delete from aurakoyomi where aurakoyomi_id = '" . $aurakoyomi10['aurakoyomi_id'] . "'";
      $result = mysqli_query($link1, $sql);
    }

    $sql = "delete from koyomiform where koyomiform_id = '" . $_GET['koyomiform_id'] . "'";
    $result = mysqli_query($link1, $sql);
  }
}


?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>氣質診断管理システム | 鑑定暦生成</title><!-- 20171002 -->
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
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">



  <script language="JavaScript" type="text/javascript">
    function navi_win(Masterid) {
      self.window.name = "main"
      w = window.open('', 'Remocon', 'width=800,height=900,status=yes,scrollbars=yes,directories=no,menubar=no,resizable=yes,toolbar=no');
      if (w != null) {
        if (w.opener == null) {
          w.opener = self;
        }
        w.location.href = './koyomiform_edit.php?mstact=mstedit&masterid=' + Masterid;
      }
    }
  </script>
  <script language="JavaScript" type="text/javascript">
    function navi_win1(Masterid) {
      self.window.name = "main"
      w = window.open('', 'Remocon', 'width=800,height=900,status=yes,scrollbars=yes,directories=no,menubar=no,resizable=yes,toolbar=no');
      if (w != null) {
        if (w.opener == null) {
          w.opener = self;
        }
        w.location.href = './koyomiform_edit.php?mstact=mstnew&masterid=' + Masterid;
      }
    }
  </script>

  <style type="text/css">
    th.huntsys1 {
      text-align: center;
    }

    td.huntsys1 {
      text-align: center;
    }

    .box_sample {
      width: 50%;
      background-color: #FFFFFF;

      @media screen and (max-width:960px) {
        width: 100%;
      }
    }

    .box-body {
      @media screen and (max-width:960px) {
        overflow: scroll;
      }

    }
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
          <li class="treeview active">
            <a href="#">
              <i class="fa fa-inbox"></i> <span>鑑定暦データ生成</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="koyomiform_list.php"><i class="fa fa-circle-o"></i>鑑定暦データ生成</a></li>
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
          鑑定暦生成
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
                月切替日は干支切替日と変換切替日の両方を設定します。
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th class="huntsys1">年</th>
                      <th class="huntsys1">年切替</th>
                      <th class="huntsys1">１月</th>
                      <th class="huntsys1">２月</th>
                      <th class="huntsys1">３月</th>
                      <th class="huntsys1">４月</th>
                      <th class="huntsys1">５月</th>
                      <th class="huntsys1">６月</th>
                      <th class="huntsys1">７月</th>
                      <th class="huntsys1">８月</th>
                      <th class="huntsys1">９月</th>
                      <th class="huntsys1">１０月</th>
                      <th class="huntsys1">１１月</th>
                      <th class="huntsys1">１２月</th>
                      <th class="huntsys1" colspan="4">選択</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    $where101 = '';
                    $sql101 = '';
                    $result101 = '';
                    $where101 .= "kfm_year > '" . '0' . "' and ";
                    $where101 .= '1 = 1';
                    $sql101 = "select * from koyomiform where $where101 order by kfm_year";
                    $result101 = mysqli_query($link1, $sql101) or die('query error635' . mysqli_error($link1));

                    ?>
                    <?php $m = 0;
                    while ($koyomiform = mysqli_fetch_array($result101)) { ?>
                      <tr>
                        <td class="huntsys1"><?php echo $koyomiform['kfm_year']; ?></td>
                        <td class="huntsys1"><?php echo substr($koyomiform['kfm_chgyear'], 5, 2); ?>月<?php echo substr($koyomiform['kfm_chgyear'], 8, 2); ?>日</td>
                        <td class="huntsys1"><?php echo substr($koyomiform['kfm_chgjan'], 8, 2); ?>日／<?php echo substr($koyomiform['kfm_convjan'], 8, 2); ?>日</td>
                        <td class="huntsys1"><?php echo substr($koyomiform['kfm_chgfeb'], 8, 2); ?>日／<?php echo substr($koyomiform['kfm_convfeb'], 8, 2); ?>日</td>
                        <td class="huntsys1"><?php echo substr($koyomiform['kfm_chgmar'], 8, 2); ?>日／<?php echo substr($koyomiform['kfm_convmar'], 8, 2); ?>日</td>
                        <td class="huntsys1"><?php echo substr($koyomiform['kfm_chgapr'], 8, 2); ?>日／<?php echo substr($koyomiform['kfm_convapr'], 8, 2); ?>日</td>
                        <td class="huntsys1"><?php echo substr($koyomiform['kfm_chgmay'], 8, 2); ?>日／<?php echo substr($koyomiform['kfm_convmay'], 8, 2); ?>日</td>
                        <td class="huntsys1"><?php echo substr($koyomiform['kfm_chgjun'], 8, 2); ?>日／<?php echo substr($koyomiform['kfm_convjun'], 8, 2); ?>日</td>
                        <td class="huntsys1"><?php echo substr($koyomiform['kfm_chgjul'], 8, 2); ?>日／<?php echo substr($koyomiform['kfm_convjul'], 8, 2); ?>日</td>
                        <td class="huntsys1"><?php echo substr($koyomiform['kfm_chgaug'], 8, 2); ?>日／<?php echo substr($koyomiform['kfm_convaug'], 8, 2); ?>日</td>
                        <td class="huntsys1"><?php echo substr($koyomiform['kfm_chgsep'], 8, 2); ?>日／<?php echo substr($koyomiform['kfm_convsep'], 8, 2); ?>日</td>
                        <td class="huntsys1"><?php echo substr($koyomiform['kfm_chgoct'], 8, 2); ?>日／<?php echo substr($koyomiform['kfm_convoct'], 8, 2); ?>日</td>
                        <td class="huntsys1"><?php echo substr($koyomiform['kfm_chgnov'], 8, 2); ?>日／<?php echo substr($koyomiform['kfm_convnov'], 8, 2); ?>日</td>
                        <td class="huntsys1"><?php echo substr($koyomiform['kfm_chgdec'], 8, 2); ?>日／<?php echo substr($koyomiform['kfm_convdec'], 8, 2); ?>日</td>
                        <td class="huntsys1"><a href="aurakoyomi_list.php?koyomiform_id=<?php echo $koyomiform['koyomiform_id'] ?>&action=seisei" alt="生成" title="データを生成します。" onClick="return confirm( 'データを生成します。よろしいですか？' )">生成</a></td>
                        <td class="huntsys1"><a href="aurakoyomi_list.php?koyomiform_id=<?php echo $koyomiform['koyomiform_id'] ?>&action=disp" alt="表示">表示</a></td>
                        <td class="huntsys1"><a href="javascript:navi_win( '<?php echo $koyomiform['koyomiform_id'] ?>' )">編集</a></td>
                        <td class="huntsys1"><a href="koyomiform_list.php?koyomiform_id=<?php echo $koyomiform['koyomiform_id'] ?>&action=koyomiformdel" alt="削除" title="データを削除します。" onClick="return confirm( 'データを削除します。よろしいですか？' )">削除</a></td>
                      </tr>
                    <?php $m++;
                    } ?>
                  </tbody>
                </table>
                <div class="box-footer">
                  <a href="javascript:navi_win1()"><button class="btn btn-primary">新規追加</button></a>
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
      <strong>Copyright &copy; 2018 ROOMINR .</strong> All rights
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
  <script src="../../dist/js/jquery-3.7.1.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="../../dist/js/bootstrap.min.js"></script>
  <!-- DataTables -->
  <script src="../../dist/js/jquery.dataTables.min.js"></script>
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
    $(function() {
      $(document).ready(function() {
        $('#example1').DataTable()
        $('#example2').DataTable({
          'paging': true,
          'lengthChange': false,
          'searching': false,
          'ordering': true,
          'info': true,
          'autoWidth': false
        });
      });
    })
  </script>
</body>

</html>
