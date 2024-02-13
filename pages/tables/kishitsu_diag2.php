
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
        <div class="col-md-6">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">『協会』</a></li>
<!--
              <li><a href="#timeline" data-toggle="tab">Timeline</a></li>
              <li><a href="#settings" data-toggle="tab">Settings</a></li>
-->
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <!-- Post -->
                <div class="post">
                  <div class="user-block">
                    <img class="img-circle img-bordered-sm" src="../../dist/img/kishitu_logo.jpg" alt="user image">
                        <span class="username">
                          VITACEグループ<br>一般社団法人氣質診断士協会/風水ライフデザインスクール
                        </span>
                  </div>
                  <!-- /.user-block -->
                  <p>
                    氣質診断とは生年月日から導くあなたの取扱説明書。生年月日で人生は決まりませんが、生まれてきた日に意味はあります。そこから導く思考パターンや言動特性、これが氣質診断です。氣質診断でわかることの基本はこのページでお伝えしている「基本氣質」と「６つの星のバランス」<br><br>
                    基本氣質もとても大事ですし、ここから魂の使命を導きますが６つの星のバランスが与える影響も大きいものです。氣質診断で重要な６つの星のバランスは氣質診断士から診断を受けることでわかります。ぜひ氣質診断士から診断を受けましょう。<br><br>
                    一般社団法人氣質診断士協会では氣質組織論を核に組織における人間関係構築に役立つ氣質診断をお届けしています。<br>
                    一般社団法人氣質診断士協会の公式LINEはこちら（<a href="https://lin.ee/lFQuC2p" target="_blank">リンク</a>）<br>一般社団法人氣質診断士協会ホームページはこちら（<a href="https://www.vtckishitsu.com/" target="_blank">リンク</a>）<br><br>
                    風水ライフデザインスクールでは氣質診断をベースに心と体、魂そして人間関係の健康をより具体的にサポートしています。またプロとして活躍できる氣質診断士育成にも力を入れています。<br>
                    風水ライフデザインスクールの公式LINEはこちら（<a href="https://lin.ee/ZqW60JH" target="_blank">リンク</a>）<br>
                    風水ライフデザインスクールホームページはこちら（<a href="https://fengshuilifedesignschool.online/" target="_blank">リンク</a>）<br><br>
                    氣質診断を考案した松岡紫鳳は財運コンサルタントとして活動しています。また風水ライフデザインスクールの校長として自ら氣質診断の指導も行っています。<br>
                    松岡紫鳳の公式LINEはこちらはこちら（<a href="https://lin.ee/kQG9Xk8" target="_blank">リンク</a>）<br>
                    財運コンサルタント松岡紫鳳ホームページはこちら（<a href="http://matsuokashiho.com/" target="_blank">リンク</a>）

                  </p>

                </div>
                <!-- /.post -->


              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <!-- The timeline -->
                <ul class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-red">
                          10 Feb. 2014
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-envelope bg-blue"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                      <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                      <div class="timeline-body">
                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                        quora plaxo ideeli hulu weebly balihoo...
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs">Read more</a>
                        <a class="btn btn-danger btn-xs">Delete</a>
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-user bg-aqua"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                      <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                      </h3>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-comments bg-yellow"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                      <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                      <div class="timeline-body">
                        Take me to your leader!
                        Switzerland is small and neutral!
                        We are more like Germany, ambitious and misunderstood!
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-green">
                          3 Jan. 2014
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-camera bg-purple"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                      <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                      <div class="timeline-body">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="settings">
                <form class="form-horizontal">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputName" placeholder="Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputName" placeholder="Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
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
