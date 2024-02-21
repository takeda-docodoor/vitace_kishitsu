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


////
//if ( auth () ) $login_st = 1 ;
//if ( $login_st != '1' ) {
//  header( 'Location: ' . $login_url ); //
//  exit;
//}




//********************************************************************
if ( isset($_POST['syori']) ) {
  if ( $_POST['syori'] == '検索' ) {

  	  if ( $_POST['aura_year'] > '0' ) {
        $_SESSION['aura_year'] = $_POST['aura_year'];
	  }
  	  if ( $_POST['aura_month'] != '' ) {
        $_SESSION['aura_month'] = $_POST['aura_month'];
	  }

  }
}

//********************************************************************
if ( isset($_GET['action']) ) {
  if ( $_GET['action'] == 'disp' ) {

	$where1 = '';
	$sql1 = '';
	$result1 = '';
	$sql1 = "select * from koyomiform where koyomiform_id = '" . $_GET['koyomiform_id'] . "'";
	$result1 = mysqli_query( $link1, $sql1 );
	$koyomiform = mysqli_fetch_array( $result1 );

    $_SESSION['aura_year'] = $koyomiform['kfm_year'];
    $_SESSION['aura_month'] = '01';
  }
}

//********************************************************************
if ( isset($_GET['action']) ) {
  if ( $_GET['action'] == 'seisei' ) {

	$where1 = '';
	$sql1 = '';
	$result1 = '';
	$sql1 = "select * from koyomiform where koyomiform_id = '" . $_GET['koyomiform_id'] . "'";
	$result1 = mysqli_query( $link1, $sql1 );
	$koyomiform = mysqli_fetch_array( $result1 );

	$aura_ymdfrom = $koyomiform['kfm_year'] . '-01-01';
	$aura_ymdto = $koyomiform['kfm_year'] . '-12-31';
	$where10 = '';
	$sql10 = '';
	$result10 = '';
	$where10 .= "aky_date >= '" . $aura_ymdfrom . "' and ";
	$where10 .= "aky_date <= '" . $aura_ymdto . "' and ";
	$where10 .= '1 = 1';
	$sql10 = "select * from aurakoyomi where $where10 order by aky_date";
	$result10 = mysqli_query( $link1, $sql10 ) or die('query error88' . mysqli_error($link1));
	while ( $aurakoyomi10 = mysqli_fetch_array( $result10 ) ) {
		$sql = "delete from aurakoyomi where aurakoyomi_id = '" . $aurakoyomi10['aurakoyomi_id'] . "'";
		$result = mysqli_query( $link1, $sql );
	}

	$koyomi_base = '1900-01-01';

	$koyomi_start = $koyomiform['kfm_year'] . '-01-01';
	$start_time = $koyomiform['kfm_year'] . '-01-01 00:00:00';
	$koyomi_end = $koyomiform['kfm_year'] . '-12-31';
	$cal_a = ($koyomiform['kfm_year'] - 1900) % 10;
	$year_aura10 = ($cal_a + 6) % 10;
	if ( $year_aura10 == 0 ) {$year_aura10 = 10;}

	$cal_b = ($koyomiform['kfm_year'] - 1900) % 12;
	$year_aura12 = ($cal_b + 12) % 12;
	if ( $year_aura12 == 0 ) {$year_aura12 = 12;}

	$cal_c = ($koyomiform['kfm_year'] - 1900) * 2;
	$month_aura10 = ($cal_c + 3) % 10;
	$month_aura12 = 1;

	$timestamp1 = strtotime($koyomi_base);
    $timestamp2 = strtotime($koyomi_start);
    $seconddiff = abs($timestamp2 - $timestamp1);
    $daydiff = $seconddiff / (60 * 60 * 24);
	$cal_d = $daydiff % 10;
	$day_aura10 = 1 + $cal_d;
	$cal_e = $daydiff % 12;
	$day_aura12 = ($cal_e + 11) % 12;
	if ( $day_aura12 == 0 ) {$day_aura12 = 12;}

	$aky_date = $koyomi_start;
	$aky_time = $start_time;
    $aky_year10 = $year_aura10;
    $aky_year12 = $year_aura12;
	$aky_yearconv = $aurachg_tbl[$aky_year12];
    $aky_month10 = $month_aura10;
    $aky_month12 = $month_aura12;
	$aky_monthconv = $aurachg_tbl[$month_aura12];
    $aky_day10 = $day_aura10;
    $aky_day12 = $day_aura12;
	$aky_dayconv = $aurachg_tbl[$day_aura12];

	$n = 0; while ( $aky_date <= $koyomi_end ) {
	//$n = 0; while ( $n <= 40 ) {

	  if ( $aky_date == $koyomiform['kfm_chgyear'] ) {
         $aky_year10 = $aky_year10 + 1;
		 if ( $aky_year10 > 10 ) {$aky_year10 = $aky_year10 - 10;}
         $aky_year12 = $aky_year12 + 1;
		 if ( $aky_year12 > 12 ) {$aky_year12 = $aky_year12 - 12;}
         $aky_yearconv = $aurachg_tbl[$aky_year12];
	  }
	  if ( $aky_date == $koyomiform['kfm_chgjan'] ) {
         $aky_month10 = $aky_month10 + 1;
		 if ( $aky_month10 > 10 ) {$aky_month10 = $aky_month10 - 10;}
         $aky_month12 = $aky_month12 + 1;
		 if ( $aky_month12 > 12 ) {$aky_month12 = $aky_month12 - 12;}
	  }
	  if ( $aky_date == $koyomiform['kfm_convjan'] ) {
	     $aky_monthconv = $aurachg_tbl[$aky_month12];
	  }
	  if ( $aky_date == $koyomiform['kfm_chgfeb'] ) {
         $aky_month10 = $aky_month10 + 1;
		 if ( $aky_month10 > 10 ) {$aky_month10 = $aky_month10 - 10;}
         $aky_month12 = $aky_month12 + 1;
		 if ( $aky_month12 > 12 ) {$aky_month12 = $aky_month12 - 12;}
	  }
	  if ( $aky_date == $koyomiform['kfm_convfeb'] ) {
	     $aky_monthconv = $aurachg_tbl[$aky_month12];
	  }
	  if ( $aky_date == $koyomiform['kfm_chgmar'] ) {
         $aky_month10 = $aky_month10 + 1;
		 if ( $aky_month10 > 10 ) {$aky_month10 = $aky_month10 - 10;}
         $aky_month12 = $aky_month12 + 1;
		 if ( $aky_month12 > 12 ) {$aky_month12 = $aky_month12 - 12;}
	  }
	  if ( $aky_date == $koyomiform['kfm_convmar'] ) {
	     $aky_monthconv = $aurachg_tbl[$aky_month12];
	  }
	  if ( $aky_date == $koyomiform['kfm_chgapr'] ) {
         $aky_month10 = $aky_month10 + 1;
		 if ( $aky_month10 > 10 ) {$aky_month10 = $aky_month10 - 10;}
         $aky_month12 = $aky_month12 + 1;
		 if ( $aky_month12 > 12 ) {$aky_month12 = $aky_month12 - 12;}
	  }
	  if ( $aky_date == $koyomiform['kfm_convapr'] ) {
	     $aky_monthconv = $aurachg_tbl[$aky_month12];
	  }
	  if ( $aky_date == $koyomiform['kfm_chgmay'] ) {
         $aky_month10 = $aky_month10 + 1;
		 if ( $aky_month10 > 10 ) {$aky_month10 = $aky_month10 - 10;}
         $aky_month12 = $aky_month12 + 1;
		 if ( $aky_month12 > 12 ) {$aky_month12 = $aky_month12 - 12;}
	  }
	  if ( $aky_date == $koyomiform['kfm_convmay'] ) {
	     $aky_monthconv = $aurachg_tbl[$aky_month12];
	  }
	  if ( $aky_date == $koyomiform['kfm_chgjun'] ) {
         $aky_month10 = $aky_month10 + 1;
		 if ( $aky_month10 > 10 ) {$aky_month10 = $aky_month10 - 10;}
         $aky_month12 = $aky_month12 + 1;
		 if ( $aky_month12 > 12 ) {$aky_month12 = $aky_month12 - 12;}
	  }
	  if ( $aky_date == $koyomiform['kfm_convjun'] ) {
	     $aky_monthconv = $aurachg_tbl[$aky_month12];
	  }
	  if ( $aky_date == $koyomiform['kfm_chgjul'] ) {
         $aky_month10 = $aky_month10 + 1;
		 if ( $aky_month10 > 10 ) {$aky_month10 = $aky_month10 - 10;}
         $aky_month12 = $aky_month12 + 1;
		 if ( $aky_month12 > 12 ) {$aky_month12 = $aky_month12 - 12;}
	  }
	  if ( $aky_date == $koyomiform['kfm_convjul'] ) {
	     $aky_monthconv = $aurachg_tbl[$aky_month12];
	  }
	  if ( $aky_date == $koyomiform['kfm_chgaug'] ) {
         $aky_month10 = $aky_month10 + 1;
		 if ( $aky_month10 > 10 ) {$aky_month10 = $aky_month10 - 10;}
         $aky_month12 = $aky_month12 + 1;
		 if ( $aky_month12 > 12 ) {$aky_month12 = $aky_month12 - 12;}
	  }
	  if ( $aky_date == $koyomiform['kfm_convaug'] ) {
	     $aky_monthconv = $aurachg_tbl[$aky_month12];
	  }
	  if ( $aky_date == $koyomiform['kfm_chgsep'] ) {
         $aky_month10 = $aky_month10 + 1;
		 if ( $aky_month10 > 10 ) {$aky_month10 = $aky_month10 - 10;}
         $aky_month12 = $aky_month12 + 1;
		 if ( $aky_month12 > 12 ) {$aky_month12 = $aky_month12 - 12;}
	  }
	  if ( $aky_date == $koyomiform['kfm_convsep'] ) {
	     $aky_monthconv = $aurachg_tbl[$aky_month12];
	  }
	  if ( $aky_date == $koyomiform['kfm_chgoct'] ) {
         $aky_month10 = $aky_month10 + 1;
		 if ( $aky_month10 > 10 ) {$aky_month10 = $aky_month10 - 10;}
         $aky_month12 = $aky_month12 + 1;
		 if ( $aky_month12 > 12 ) {$aky_month12 = $aky_month12 - 12;}
	  }
	  if ( $aky_date == $koyomiform['kfm_convoct'] ) {
	     $aky_monthconv = $aurachg_tbl[$aky_month12];
	  }
	  if ( $aky_date == $koyomiform['kfm_chgnov'] ) {
         $aky_month10 = $aky_month10 + 1;
		 if ( $aky_month10 > 10 ) {$aky_month10 = $aky_month10 - 10;}
         $aky_month12 = $aky_month12 + 1;
		 if ( $aky_month12 > 12 ) {$aky_month12 = $aky_month12 - 12;}
	  }
	  if ( $aky_date == $koyomiform['kfm_convnov'] ) {
	     $aky_monthconv = $aurachg_tbl[$aky_month12];
	  }
	  if ( $aky_date == $koyomiform['kfm_chgdec'] ) {
         $aky_month10 = $aky_month10 + 1;
		 if ( $aky_month10 > 10 ) {$aky_month10 = $aky_month10 - 10;}
         $aky_month12 = $aky_month12 + 1;
		 if ( $aky_month12 > 12 ) {$aky_month12 = $aky_month12 - 12;}
	  }
	  if ( $aky_date == $koyomiform['kfm_convdec'] ) {
	     $aky_monthconv = $aurachg_tbl[$aky_month12];
	  }

		$sql = "insert into aurakoyomi (
			aky_date,
			aky_year10,
			aky_year12,
			aky_yearconv,
			aky_month10,
			aky_month12,
			aky_monthconv,
			aky_day10,
			aky_day12,
			aky_dayconv,
			aky_notes,
			aky_status
		) values (
			'" . mysqli_real_escape_string( $link1, $aky_date  ) . "',
			'" . mysqli_real_escape_string( $link1, $aky_year10 ) . "',
			'" . mysqli_real_escape_string( $link1, $aky_year12 ) . "',
			'" . mysqli_real_escape_string( $link1, $aky_yearconv ) . "',
			'" . mysqli_real_escape_string( $link1, $aky_month10 ) . "',
			'" . mysqli_real_escape_string( $link1, $aky_month12 ) . "',
			'" . mysqli_real_escape_string( $link1, $aky_monthconv ) . "',
			'" . mysqli_real_escape_string( $link1, $aky_day10 ) . "',
			'" . mysqli_real_escape_string( $link1, $aky_day12 ) . "',
			'" . mysqli_real_escape_string( $link1, $aky_dayconv ) . "',
			'" . '' . "',
			'" . '0' . "'
		)";
		$result = mysqli_query( $link1, $sql ) or die('query error164' . mysqli_error($link1));

		$aky_date = date('Y-m-d', strtotime('+1 day', strtotime($aky_time)));
		$aky_time = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($aky_time)));

        $aky_day10 = $aky_day10 + 1;
		if ( $aky_day10 > 10 ) {$aky_day10 = $aky_day10 - 10;}
        $aky_day12 = $aky_day12 + 1;
		if ( $aky_day12 > 12 ) {$aky_day12 = $aky_day12 - 12;}
		$aky_dayconv = $aurachg_tbl[$aky_day12];

	$n ++; }

    $_SESSION['aura_year'] = $koyomiform['kfm_year'];
    $_SESSION['aura_month'] = '01';

  }
}


//********************************************************************
if ( isset($_GET['action']) ) {
  if ( $_GET['action'] == 'attendancedel' ) {

	$sql = "delete from attendance where attendance_id = '" . $_GET['attendance_id'] . "'";
	$result = mysqli_query( $link1, $sql );

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
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">



<script language="JavaScript" type="text/javascript">
function navi_win( Masterid ) {
        self.window.name="main"
        w = window.open('', 'Remocon', 'width=800,height=900,status=yes,scrollbars=yes,directories=no,menubar=no,resizable=yes,toolbar=no');
        if (w != null) {
                if (w.opener == null) {w.opener = self;}
                w.location.href = './koyomiform_edit.php?mstact=mstedit&masterid=' + Masterid;
        }
}
</script>
<script language="JavaScript" type="text/javascript">
function navi_win1( Masterid ) {
        self.window.name="main"
        w = window.open('', 'Remocon', 'width=800,height=900,status=yes,scrollbars=yes,directories=no,menubar=no,resizable=yes,toolbar=no');
        if (w != null) {
                if (w.opener == null) {w.opener = self;}
                w.location.href = './koyomiform_edit.php?mstact=mstnew&masterid=' + Masterid;
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
            <div class="box-header">
              <h3 class="box-title">
　　　　　　　    <form name="frm1" action="aurakoyomi_list.php" enctype="multipart/form-data" method="post">
                  <input type="text" name="aura_year" value="<?php echo $_SESSION['aura_year']; ?>" placeholder="2018 ...">年
                  <input type="text" name="aura_month" value="<?php echo $_SESSION['aura_month']; ?>" placeholder="01 ...">月
                  <button type="submit" class="btn btn-primary"  name="syori" value="検索">検索</button>
			    </form>
              </h3>
            </div>
            <div class="box-body">
              <table class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th class="huntsys1">日付</th>
                  <th class="huntsys1">年干</th>
                  <th class="huntsys1">年支</th>
                  <th class="huntsys1">年変換</th>
                  <th class="huntsys1">月干</th>
                  <th class="huntsys1">月支</th>
                  <th class="huntsys1">月変換</th>
                  <th class="huntsys1">日干</th>
                  <th class="huntsys1">日支</th>
                  <th class="huntsys1">日変換</th>
                </tr>
                </thead>
                <tbody>

			  <?php
				$aura_ymdfrom = $_SESSION['aura_year'] . '-' . $_SESSION['aura_month'] . '-01';
				$aura_ymdto = $_SESSION['aura_year'] . '-' . $_SESSION['aura_month'] . '-' . date('t', strtotime($aura_ymdfrom));
				$where101 = '';
				$sql101 = '';
				$result101 = '';
				$where101 .= "aky_date >= '" . $aura_ymdfrom . "' and ";
				$where101 .= "aky_date <= '" . $aura_ymdto . "' and ";
				$where101 .= '1 = 1';
				$sql101 = "select * from aurakoyomi where $where101 order by aky_date";
				$result101 = mysqli_query( $link1, $sql101 );

        if (!$result101) {
          $errorMessage = mysqli_error($link1);
          // die('query error274' . $errorMessage);
          die();
        }

			  ?>
			  <?php $m = 0; while ( $aurakoyomi = mysqli_fetch_array( $result101 ) ) { ?>
				<tr>
				  <td class="huntsys1"><?php echo $aurakoyomi['aky_date']; ?></td>
				  <td class="huntsys1"><?php echo $aura10_tbl[$aurakoyomi['aky_year10']]; ?></td>
				  <td class="huntsys1"><?php echo $aura12_tbl[$aurakoyomi['aky_year12']]; ?></td>
				  <td class="huntsys1"><?php echo $aura10_tbl[$aurakoyomi['aky_yearconv']]; ?></td>
				  <td class="huntsys1"><?php echo $aura10_tbl[$aurakoyomi['aky_month10']]; ?></td>
				  <td class="huntsys1"><?php echo $aura12_tbl[$aurakoyomi['aky_month12']]; ?></td>
				  <td class="huntsys1"><?php echo $aura10_tbl[$aurakoyomi['aky_monthconv']]; ?></td>
				  <td class="huntsys1"><?php echo $aura10_tbl[$aurakoyomi['aky_day10']]; ?></td>
				  <td class="huntsys1"><?php echo $aura12_tbl[$aurakoyomi['aky_day12']]; ?></td>
				  <td class="huntsys1"><?php echo $aura10_tbl[$aurakoyomi['aky_dayconv']]; ?></td>
				</tr>
              <?php $m ++; } ?>
                </tbody>
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
