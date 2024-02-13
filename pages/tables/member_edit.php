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
		$sql1 = "select * from member where member_id = '" . $_SESSION['masterid'] . "'";
		$result1 = mysqli_query( $link1, $sql1 );
		$member = mysqli_fetch_array( $result1 );		
		  
		
      }
	}
	if (  $_SESSION['mstact'] == 'mstnew' ) {
		
  	  if ( $_GET['masterid'] != '' ) {
        $_SESSION['masterid'] = '0';

		$where1 = '';
		$sql1 = '';
		$result1 = '';
		$sql1 = "select * from member where member_id = '" . '0' . "'";
		$result1 = mysqli_query( $link1, $sql1 );
		$member = mysqli_fetch_array( $result1 );
	  }
	}
	
  }
}

//********************************************************************
if ( isset($_POST['syori']) ) {
  if ( $_POST['syori'] == '登録' ) {
	  
	$where5 = '';
	$sql5 = '';
	$result5 = '';
	$sql5 = "select * from member where mbr_loginid = '" . $_POST['mbr_loginid'] . "'";
	$result5 = mysqli_query( $link1, $sql5 );
	$member5 = mysqli_fetch_array( $result5 );
	  
	if (  $member5['member_id'] > '0' ) {
		$error = 'IDが他の人と重複してます。';
		
		
		$where1 = '';
		$sql1 = '';
		$result1 = '';
		$sql1 = "select * from member where member_id = '" . $_SESSION['masterid'] . "'";
		$result1 = mysqli_query( $link1, $sql1 );
		$member = mysqli_fetch_array( $result1 );		
		
	} else {
	  
	  if (  $_SESSION['mstact'] == 'mstnew' ) {
			
		
		$sql = "insert into member (
			mbr_kanji,
			mbr_kana,
			mbr_mailadd,
			mbr_birthday,
			mbr_type,
			mbr_person,
			mbr_post,
			mbr_add,
			mbr_phone1,
			mbr_phone2,
			mbr_namecd,
			mbr_mailmg,
			mbr_kishitsu,
			mbr_kieventid,
			mbr_notes
		) values (
			'" . mysqli_real_escape_string( $link1, $_POST['mbr_kanji'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['mbr_kana'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['mbr_mailadd'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['mbr_birthday'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['mbr_type'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['mbr_person'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['mbr_post'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['mbr_add'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['mbr_phone1'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['mbr_phone2'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['mbr_namecd'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['mbr_mailmg'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['mbr_kishitsu'] ) . "',
			'" . mysqli_real_escape_string( $link1, $_POST['mbr_kieventid'] ) . "',
			'" . '' . "'
		)";
		$result = mysqli_query( $link1, $sql ) or die('query error135' . mysql_error());
		$_SESSION['masterid'] = mysqli_insert_id( $link1 );
		$_SESSION['mstact'] = 'mstedit';
	
		$where = '';
		$sql1 = '';
		$result1 = '';
		$sql1 = "select * from member where member_id = '" . $_SESSION['masterid'] . "'";
		$result1 = mysqli_query( $link1, $sql1 );
		$member = mysqli_fetch_array( $result1 );
		
		
        $mstmsg = '登録しました。';
	
	  } else {

		$sql = "update member set
					mbr_kanji = '" . mysqli_real_escape_string( $link1, $_POST['mbr_kanji'] ) . "',
					mbr_kana = '" . mysqli_real_escape_string( $link1, $_POST['mbr_kana'] ) . "',
					mbr_mailadd = '" . mysqli_real_escape_string( $link1, $_POST['mbr_mailadd'] ) . "',
					mbr_birthday = '" . mysqli_real_escape_string( $link1, $_POST['mbr_birthday'] ) . "',
					mbr_type = '" . mysqli_real_escape_string( $link1, $_POST['mbr_type'] ) . "',
					mbr_person = '" . mysqli_real_escape_string( $link1, $_POST['mbr_person'] ) . "',
					mbr_post = '" . mysqli_real_escape_string( $link1, $_POST['mbr_post'] ) . "',
					mbr_add = '" . mysqli_real_escape_string( $link1, $_POST['mbr_add'] ) . "',
					mbr_phone1 = '" . mysqli_real_escape_string( $link1, $_POST['mbr_phone1'] ) . "',
					mbr_phone2 = '" . mysqli_real_escape_string( $link1, $_POST['mbr_phone2'] ) . "',
					mbr_namecd = '" . mysqli_real_escape_string( $link1, $_POST['mbr_namecd'] ) . "',
					mbr_mailmg = '" . mysqli_real_escape_string( $link1, $_POST['mbr_mailmg'] ) . "',
					mbr_kishitsu = '" . mysqli_real_escape_string( $link1, $_POST['mbr_kishitsu'] ) . "',
					mbr_kieventid = '" . mysqli_real_escape_string( $link1, $_POST['mbr_kieventid'] ) . "'
			where member_id = '" . $_SESSION['masterid'] . "'";
		$result = mysqli_query( $link1, $sql ) or die('query error167' . mysql_error());
		
		$where1 = '';
		$sql1 = '';
		$result1 = '';
		$sql1 = "select * from member where member_id = '" . $_SESSION['masterid'] . "'";
		$result1 = mysqli_query( $link1, $sql1 );
		$member = mysqli_fetch_array( $result1 );
		
		
        $mstmsg = '登録しました。';
		
	  }
	  
    }

		
  }
}

//-------------------------------------------------------------------------------

$where51 = '';
$sql51 = '';
$result51 = '';
$person_tbl[] = '';

$where51 .= "member_id > '" . '0' . "' and ";
$where51 .= "mbr_type = '" . '1' . "' and ";
$where51 .= '1 = 1';
$sql51 = "select * from member where $where51 order by member_id";
$result51 = mysqli_query( $link1, $sql51 ) or die('query error200' . mysql_error());


$n = 0; while ( $member51 = mysqli_fetch_array( $result51 ) ) {
  $tbl_no = $member51['member_id'];
  $person_tbl[$tbl_no] = $member51['mbr_kanji'];
$n ++; }

//-------------------------------------------------------------------------------

$where61 = '';
$sql61 = '';
$result61 = '';
$kievent_tbl[] = '';


$where61 .= "kievent_id > '" . '0' . "' and ";
$where61 .= '1 = 1';
$sql61 = "select * from kievent where $where61 order by kievent_id";
$result61 = mysqli_query( $link1, $sql61 ) or die('query error208' . mysql_error());


$n = 0; while ( $kievent = mysqli_fetch_array( $result61 ) ) {
  $tbl_no = $kievent['kievent_id'];
  $kievent_tbl[$tbl_no] = $kievent['kev_name'];
$n ++; }



?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>メンバー情報編集</title>
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
              <h3 class="box-title">メンバー情報編集</h3>
				<a href="javascript:ctrl_wind('member_list.php')"><button class="btn btn-info pull-right">閉じる</button></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
	　　　　　　<form name="frm1" action="member_edit.php" method="post" class="search_form general_form">
                <!-- text input -->
    		    <?php if ( $error <> '' ) { ?>
                <div class="form-group">
					<label><font color="#FF0000"><?php echo $error; ?></font></label>
                </div>
    		    <?php } ?>
                <div class="form-group">
                  <label>名前</label>
                  <input type="text" name="mbr_kanji" value="<?php echo $member['mbr_kanji']; ?>" class="form-control" placeholder="名前 ...">
                </div>
                <div class="form-group">
                  <label>フリガナ</label>
                  <input type="text" name="mbr_kana" value="<?php echo $member['mbr_kana']; ?>" class="form-control" placeholder="フリガナ ...">
                </div>
                <div class="form-group">
                  <label>メール</label>
                  <input type="text" name="mbr_mailadd" value="<?php echo $member['mbr_mailadd']; ?>" class="form-control" placeholder="abcde@fghij...">
                </div>
                <div class="form-group">
                  <label>生年月日</label>
                  <input type="text" name="mbr_birthday" value="<?php echo $member['mbr_birthday']; ?>" class="form-control" placeholder="2000-01-01 ...">
                </div>
                <div class="form-group">
                  <label>区分</label>
                  <select class="form-control" name="mbr_type"><?php foreach ( $mbrtype_tbl as $key => $value ) if ( $key == $member['mbr_type'] ) echo "<option value=$key selected>$value\n"; else echo "<option value=$key>$value\n" ?></select>
                </div>
                <div class="form-group">
                  <label>担当</label>
                  <select class="form-control" name="mbr_person"><?php foreach ( $person_tbl as $key => $value ) if ( $key == $member['mbr_person'] ) echo "<option value=$key selected>$value\n"; else echo "<option value=$key>$value\n" ?></select>
                </div>
                <div class="form-group">
                  <label>郵便番号</label>
                  <input type="text" name="mbr_post" value="<?php echo $member['mbr_post']; ?>" class="form-control" placeholder="123-4567 ...">
                </div>
                <div class="form-group">
                  <label>住所</label>
                  <input type="text" name="mbr_add" value="<?php echo $member['mbr_add']; ?>" class="form-control" placeholder="都道府県　市　町 番地　...">
                </div>
                <div class="form-group">
                  <label>電話1</label>
                  <input type="text" align=""name="mbr_phone1" value="<?php echo $member['mbr_phone1']; ?>" class="form-control" placeholder="123-4567-...">
                </div>
                <div class="form-group">
                  <label>電話2</label>
                  <input type="text" align=""name="mbr_phone2" value="<?php echo $member['mbr_phone2']; ?>" class="form-control" placeholder="123-4567-...">
                </div>
                <div class="form-group">
                  <label>名刺</label>
                  <select class="form-control" name="mbr_namcd"><?php foreach ( $umu_tbl as $key => $value ) if ( $key == $member['mbr_namcd'] ) echo "<option value=$key selected>$value\n"; else echo "<option value=$key>$value\n" ?></select>
                </div>
                <div class="form-group">
                  <label>メルマガ</label>
                  <select class="form-control" name="mbr_mailmg"><?php foreach ( $umu_tbl as $key => $value ) if ( $key == $member['mbr_mailmg'] ) echo "<option value=$key selected>$value\n"; else echo "<option value=$key>$value\n" ?></select>
                </div>
                <div class="form-group">
                  <label>気質診断</label>
                  <select class="form-control" name="mbr_kishitsu"><?php foreach ( $umu_tbl as $key => $value ) if ( $key == $member['mbr_kishitsu'] ) echo "<option value=$key selected>$value\n"; else echo "<option value=$key>$value\n" ?></select>
                </div>
                <div class="form-group">
                  <label>参加イベント</label>
                  <select class="form-control" name="mbr_kieventid"><?php foreach ( $kievent_tbl as $key => $value ) if ( $key == $member['mbr_kieventid'] ) echo "<option value=$key selected>$value\n"; else echo "<option value=$key>$value\n" ?></select>
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
