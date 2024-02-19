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

if ($_SESSION['passwd'] != '') {
  $_SESSION['sidemenu'] = 'kishitsu_diag';
} else {
  header('Location: ../../index.php');
  exit;
}


// db connect
$link1 = db_connect1();

$_SESSION['aky_year'] = '';
$_SESSION['aky_month'] = '';
$_SESSION['aky_day'] = '';

//********************************************************************
if (isset($_POST['syori'])) {
  if ($_POST['syori'] == '表示') {

    if ($_POST['aky_year'] > '0') {
      $_SESSION['aky_year'] = $_POST['aky_year'];
    }
    if ($_POST['aky_month'] != '') {
      $_SESSION['aky_month'] = $_POST['aky_month'];
    }
    if ($_POST['aky_day'] != '') {
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
  <title>氣質診断 | 氣質診断結果</title><!-- 20171002 -->
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
        w.location.href = './attendance_edit.php?mstact=mstedit&masterid=' + Masterid;
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
        w.location.href = './attendance_edit.php?mstact=mstnew&masterid=' + Masterid;
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

    }

    .table-wrap {
      @media screen and (max-width:960px) {
        max-width: 100%;
        overflow: scroll;
      }
    }

    .eto-img-wrap {
      .img {
        @media screen and (max-width:960px) {
          width: 100%;
        }
      }
    }
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
          氣質情報
          <small></small>
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
              <div class="box-header">
                <h3 class="box-title">
                  <form name="frm1" action="kishitsu_diag.php" enctype="multipart/form-data" method="post">
                    <input type="text" class="input-numeric" inputmode="numeric" name="aky_year" value="<?php echo $_SESSION['aky_year']; ?>" placeholder="西暦" size="4" maxlength="4">年
                    <select name="aky_month"><?php foreach ($month_tbl as $key => $value) if ($key == $_SESSION['aky_month']) echo "<option value=$key selected>$value\n";
                                              else echo "<option value=$key>$value\n" ?></select>月
                    <select name="aky_day"><?php foreach ($day_tbl as $key => $value) if ($key == $_SESSION['aky_day']) echo "<option value=$key selected>$value\n";
                                            else echo "<option value=$key>$value\n" ?></select>日
                    <button type="submit" class="btn btn-primary" name="syori" value="表示">表示</button>
                  </form>
                  生年月日を入力ください。
                </h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <h1>氣質</h1>
                <div class="table-wrap">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th class="huntsys1" colspan="2">年干支(year)</th>
                        <th class="huntsys1" colspan="2">月干支(month)</th>
                        <th class="huntsys1" colspan="2">日干支(day)</th>
                      </tr>
                    </thead>

                    <?php
                    $aky_date = $_SESSION['aky_year'] . '-' . $_SESSION['aky_month'] . '-' . $_SESSION['aky_day'];
                    $where101 = '';
                    $sql101 = '';
                    $result101 = '';
                    $where101 .= "aky_date = '" . $aky_date . "' and ";
                    $where101 .= '1 = 1';
                    $sql101 = "select * from aurakoyomi where $where101";
                    $result101 = mysqli_query($link1, $sql101) or die('query error274' . mysqli_error($link1));
                    $num_rows101 = mysqli_num_rows($result101);

                    ?>
                    <?php if ($num_rows101 > '0') { ?>
                      <?php $aurakoyomi = mysqli_fetch_array($result101); ?>
                      <tbody>
                        <tr>
                          <td class="huntsys1"><?php echo $aura10_tbl[$aurakoyomi['aky_year10']]; ?></td>
                          <td class="huntsys1"><?php echo $aura12_tbl[$aurakoyomi['aky_year12']]; ?></td>
                          <td class="huntsys1"><?php echo $aura10_tbl[$aurakoyomi['aky_month10']]; ?></td>
                          <td class="huntsys1"><?php echo $aura12_tbl[$aurakoyomi['aky_month12']]; ?></td>
                          <td class="huntsys1"><?php echo $aura10_tbl[$aurakoyomi['aky_day10']]; ?></td>
                          <td class="huntsys1"><?php echo $aura12_tbl[$aurakoyomi['aky_day12']]; ?></td>
                        </tr>
                      </tbody>
                      <tbody>
                        <tr>
                          <td class="huntsys1" bgcolor="#<?php echo $bgcolor10_tbl[$aurakoyomi['aky_year10']]; ?>">
                            <font color="#<?php echo $fontcolor10_tbl[$aurakoyomi['aky_year10']]; ?>"><?php echo $kishitsu10_tbl[$aurakoyomi['aky_year10']]; ?></font>
                          </td>
                          <td class="huntsys1" bgcolor="#<?php echo $bgcolor10_tbl[$aurakoyomi['aky_yearconv']]; ?>">
                            <font color="#<?php echo $fontcolor10_tbl[$aurakoyomi['aky_yearconv']]; ?>"><?php echo $kishitsu10_tbl[$aurakoyomi['aky_yearconv']]; ?></font>
                          </td>
                          <td class="huntsys1" bgcolor="#<?php echo $bgcolor10_tbl[$aurakoyomi['aky_month10']]; ?>">
                            <font color="#<?php echo $fontcolor10_tbl[$aurakoyomi['aky_month10']]; ?>"><?php echo $kishitsu10_tbl[$aurakoyomi['aky_month10']]; ?></font>
                          </td>
                          <td class="huntsys1" bgcolor="#<?php echo $bgcolor10_tbl[$aurakoyomi['aky_monthconv']]; ?>">
                            <font color="#<?php echo $fontcolor10_tbl[$aurakoyomi['aky_monthconv']]; ?>"><?php echo $kishitsu10_tbl[$aurakoyomi['aky_monthconv']]; ?></font>
                          </td>
                          <td class="huntsys1" bgcolor="#<?php echo $bgcolor10_tbl[$aurakoyomi['aky_day10']]; ?>">
                            <font color="#<?php echo $fontcolor10_tbl[$aurakoyomi['aky_day10']]; ?>"><?php echo $kishitsu10_tbl[$aurakoyomi['aky_day10']]; ?></font>
                          </td>
                          <td class="huntsys1" bgcolor="#<?php echo $bgcolor10_tbl[$aurakoyomi['aky_dayconv']]; ?>">
                            <font color="#<?php echo $fontcolor10_tbl[$aurakoyomi['aky_dayconv']]; ?>"><?php echo $kishitsu10_tbl[$aurakoyomi['aky_dayconv']]; ?></font>
                          </td>
                        </tr>
                      </tbody>
                    <?php } else { ?>
                    <?php } ?>
                  </table>
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

        <div class="row">
          <div class="col-xs-12">
            <div class="box_sample">
              <!-- /.box-header -->
              <div class="box-body">
                <h3>色見本</h3>
                <div class="table-wrap">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th class="huntsys1">&nbsp;</th>
                        <th class="huntsys1">木</th>
                        <th class="huntsys1">火</th>
                        <th class="huntsys1">土</th>
                        <th class="huntsys1">金</th>
                        <th class="huntsys1">水</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th class="huntsys1">陽(＋)</th>
                        <td class="huntsys1" bgcolor="#1822C1">
                          <font color="#FFFFFF">木(＋)wood</font>
                        </td>
                        <td class="huntsys1" bgcolor="#FF0000">
                          <font color="#FFFFFF">火(＋)fire</font>
                        </td>
                        <td class="huntsys1" bgcolor="#8A4115">
                          <font color="#FFFFFF">土(＋)earth</font>
                        </td>
                        <td class="huntsys1" bgcolor="#A0955E">
                          <font color="#FFFFFF">金(＋)metal</font>
                        </td>
                        <td class="huntsys1" bgcolor="#000000">
                          <font color="#FFFFFF">水(＋)water</font>
                        </td>
                      </tr>
                      <tr>
                        <th class="huntsys1">陰(ー)</th>
                        <td class="huntsys1" bgcolor="#90A4F2">木(ー)wood</td>
                        <td class="huntsys1" bgcolor="#F64A71">火(ー)fire</td>
                        <td class="huntsys1" bgcolor="#E3EB0B">土(ー)earth</td>
                        <td class="huntsys1" bgcolor="#FFFFFF">金(ー)metal</td>
                        <td class="huntsys1" bgcolor="#949494">水(ー)water</td>
                      </tr>

                    </tbody>
                  </table>
                </div>
              </div>

              <!-- /.box-body -->
            </div>
            <?php if ($_SESSION['passwd'] == $passwd_img || $_SESSION['passwd'] == $passwd_mng) { ?>
              <div class="eto-img-wrap">
                <img srcset="../../dist/img/roominr_12table.png 590w" sizes="(max-width:960px) 87vw, 590px" src="../../dist/img/roominr_12table.png" alt="干支画像" class="img">
              </div>
            <?php } ?>
            <!-- /.box -->

            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>

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
    $(function() {
      $('#example1').DataTable()
      $('#example2').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': false,
        'ordering': true,
        'info': true,
        'autoWidth': false
      })
    })
  </script>
  <script>
    (function() {
      if (!Element.prototype.matches) Element.prototype.matches = Element.prototype.msMatchesSelector;
      const filter = function(e) {
        let v = e.target.value
          .replace(/[０-９]/g, function(x) {
            return String.fromCharCode(x.charCodeAt(0) - 0xFEE0)
          })
          .replace(/[^0-9]/g, '');
        e.target.value = v;
      };

      let isComposing = false; // IE11対応が不要の場合は InputEvent.isComposing が使用できます。
      document.addEventListener('input', function(e) {
        if (!isComposing && e.target.matches("input.input-numeric")) filter(e)
      });
      document.addEventListener('compositionstart', function(e) {
        if (e.target.matches("input.input-numeric")) {
          isComposing = true;
        }
      });
      document.addEventListener('compositionend', function(e) {
        if (e.target.matches("input.input-numeric")) {
          isComposing = false;
          setTimeout(function() {
            filter(e)
          }, 0);
        }
      });
    })();
  </script>
</body>

</html>
