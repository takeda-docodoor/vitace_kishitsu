<?php

// lib.php

// mailsender(smtp)
//Qdmailをロード
require_once('qdmail.php');
//Qdsmtpをロード
//（ドキュメントには、記述不要とかいてあるが、書かないとうまくいかないことがあった）
require_once('qdsmtp.php');

//メール送信関数
// $to：送信先メールアドレス
// $subject：件名（日本語OK）
// $body：本文（日本語OK）
// $fromname：送信元名（日本語OK）
// $fromaddress：送信元メールアドレス
function mailsender( $to,$subject,$body,$fromname,$fromaddress ){
    //SMTP送信
    $mail = new Qdmail();
    $mail -> smtp(true);
    $param = array(
        'host'=>'smtp.kagoya.net',
        'port'=> 587 ,
        'from'=>'sectest@sec-hyogo.net',
        'protocol'=>'SMTP_AUTH',
        'user'=>'tcn.information',
        'pass' => 'r8dW#7DCX8CM9aM9',
    );
    $mail ->smtpServer($param);
    $mail ->to($to);
    $mail ->subject($subject);
    $mail ->from($fromaddress,$fromname);
    $mail ->text($body);
    $return_flag = $mail ->send();
    return $return_flag;
}

// auth
function auth() {
	global $magic_code;

	if ( md5( $magic_code . $_SESSION['login_id'] ) == $_SESSION['auth_code'] ) {
		return TRUE;
	} else {
//		setcookie( session_name(), '', 0 );
//		session_destroy();
		return FALSE;
	}
}

//
function calc_handling( $sub_total, $payment_option ) {
	switch ( $payment_option ) {
	case 0: // クレジットカード
		if ( $sub_total >= 1500 )
			return 0;
		else 
			return 525;
	case 1: // 銀行振り込み
		if ( $sub_total >= 1500 )
			return 0;
		else 
			return 525;
	case 2: // 代引き
		if ( $sub_total >= 1500 )
			return 0 + ceil( $sub_total * 0.05 );
		else 
			return 525 + ceil( $sub_total * 0.05 );
	}
}

// db connect
function db_connect1() {
	global $db_host1, $db_name1, $db_user1, $db_password1;

	$link1 = mysqli_connect( $db_host1, $db_user1, $db_password1 ) or die("接続１エラー１");
	mysqli_select_db( $link1, $db_name1 ) or die("接続１エラー２");
	//mysqli_query( 'set character set utf8' );

	return $link1;
}

function db_connect2() {
	global $db_host2, $db_name2, $db_user2, $db_password2;

	$link2 = mysql_connect( $db_host2, $db_user2, $db_password2 ) or die("接続２エラー１");
	mysql_select_db( $db_name2,$link2 ) or die("接続２エラー２");
	mysql_query( 'set character set utf8' );

	return $link2;
}

function get_age( $birthday ) {
	$age = date( 'Y' ) - date( 'Y', strtotime( $birthday ) );
	if ( date( 'md' ) < date( 'md', strtotime( $birthday ) ) ) $age --;
	return $age;
}

function get_jyear( $wyear ) {
	if ( $wyear > '1988' ) {
		$nengo = '4';
		$jyear = $wyear - 1988;
	} else {
		$nengo = '3';
		$jyear = $wyear - 1925;
	}
	
	if ( $wyear < '1925' ) {
		$nengo = '0';
		$jyear = '0';
	}
	return $jyear;
}
function get_nengo( $wyear ) {
	if ( $wyear > '1988' ) {
		$nengo = '4';
		$jyear = $wyear - 1988;
	} else {
		$nengo = '3';
		$jyear = $wyear - 1925;
	}
	if ( $wyear < '1925' ) {
		$nengo = '0';
		$jyear = '0';
	}
	return $nengo;
}


function get_wyear( $nengo, $jyear ) {
	if ( $nengo == '3' ) {
		$wyear = $jyear + 1925;
	}
	if ( $nengo == '4' ) {
		$wyear = $jyear + 1988;
	}
	if ( $jyear == '0' ) {
		$wyear = '0000';
	}
	return $wyear;
}

function get_author_name( $link, $author_id ) {
	$sql = "select author_name from author where author_id = '$author_id'";
	$result = mysql_query( $sql ) ;
	$author = mysql_fetch_array( $result );
	return $author['author_name'];
}

function get_category_name( $link, $category_id ) {
	$sql = "select category_name from category where category_id = '$category_id'";
	$result = mysql_query( $sql ) ;
	$category = mysql_fetch_array( $result );
	return $category['category_name'];
}

function get_publisher_name( $link, $publisher_id ) {
	$sql = "select publisher_name from publisher where publisher_id = '$publisher_id'";
	$result = mysql_query( $sql ) ;
	$publisher = mysql_fetch_array( $result );
	return $publisher['publisher_name'];
}

//
function make_category( $parent_id, $order, $sort, $value, $indent ) {
	$sql = "select * from category where parent_id = '$parent_id' and category_id >= 0 order by '$order' $sort";
	$result = mysql_query( $sql );

	while ( $category = mysql_fetch_array( $result ) ) {
		if ( $category['category_id'] == $value )
			echo "<option value=${category['category_id']} selected>$indent${category['category_name']}\n";
		else 
			echo "<option value=${category['category_id']}>$indent${category['category_name']}\n";

		make_category( $category['category_id'], $order, $sort, $value, $indent . '&nbsp;' );
	}
}

//

function fgetcsv_reg (&$handle, $length = null, $d = ',', $e = '"') {
	$d = preg_quote($d);
	$e = preg_quote($e);
	$_line = "";

	while ($eof != true) {
		$_line .= (empty($length) ? fgets($handle) : fgets($handle, $length));
		$itemcnt = preg_match_all('/'.$e.'/', $_line, $dummy);
		if ($itemcnt % 2 == 0) $eof = true;
	}
	
	$_csv_line = preg_replace('/(?:\\r\\n|[\\r\\n])?$/', $d, trim($_line));
	$_csv_pattern = '/('.$e.'[^'.$e.']*(?:'.$e.$e.'[^'.$e.']*)*'.$e.'|[^'.$d.']*)'.$d.'/';
	preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
	$_csv_data = $_csv_matches[1];
	
	for($_csv_i=0;$_csv_i<count($_csv_data);$_csv_i++){
		$_csv_data[$_csv_i]=preg_replace('/^'.$e.'(.*)'.$e.'$/s','$1',$_csv_data[$_csv_i]);
		$_csv_data[$_csv_i]=str_replace($e.$e, $e, $_csv_data[$_csv_i]);
	}
	
	return empty($_line) ? false : $_csv_data;
}

//カレンダー日の作成
function make_calend( $m1_ymd ) {
  $m1w  = date("w",strtotime($m1_ymd));
  $mend  = date('t', strtotime($m1_ymd));
  
  $m1y  = date("Y",strtotime($m1_ymd));
  $m1m  = date("m",strtotime($m1_ymd));
  
  $bm1_ymd = date('Y-m-d', strtotime($m1_ymd . ' -1 month'));
  $bmend  = date('t', strtotime($bm1_ymd));
  
  $bm1y  = date("Y",strtotime($bm1_ymd));
  $bm1m  = date("m",strtotime($bm1_ymd));
  
  $nm1_ymd = date('Y-m-d', strtotime($m1_ymd . ' +1 month'));
  $nm1y  = date("Y",strtotime($nm1_ymd));
  $nm1m  = date("m",strtotime($nm1_ymd));
  
  if ( $m1w == '1' ) {
    $w11 = '1'; $w11d =  $m1y . '-' . $m1m . '-01';
    $w12 = '2'; $w12d =  $m1y . '-' . $m1m . '-02';
    $w13 = '3'; $w13d =  $m1y . '-' . $m1m . '-03';
    $w14 = '4'; $w14d =  $m1y . '-' . $m1m . '-04';
    $w15 = '5'; $w15d =  $m1y . '-' . $m1m . '-05';
    $w16 = '6'; $w16d =  $m1y . '-' . $m1m . '-06';
    $w17 = '7'; $w17d =  $m1y . '-' . $m1m . '-07';
    $w21 = '8'; $w21d =  $m1y . '-' . $m1m . '-08';
    $w22 = '9'; $w22d =  $m1y . '-' . $m1m . '-09';
    $w23 = '10'; $w23d =  $m1y . '-' . $m1m . '-10';
    $w24 = '11'; $w24d =  $m1y . '-' . $m1m . '-11';
    $w25 = '12'; $w25d =  $m1y . '-' . $m1m . '-12';
    $w26 = '13'; $w26d =  $m1y . '-' . $m1m . '-13';
    $w27 = '14'; $w27d =  $m1y . '-' . $m1m . '-14';
    $w31 = '15'; $w31d =  $m1y . '-' . $m1m . '-15';
    $w32 = '16'; $w32d =  $m1y . '-' . $m1m . '-16';
    $w33 = '17'; $w33d =  $m1y . '-' . $m1m . '-17';
    $w34 = '18'; $w34d =  $m1y . '-' . $m1m . '-18';
    $w35 = '19'; $w35d =  $m1y . '-' . $m1m . '-19';
    $w36 = '20'; $w36d =  $m1y . '-' . $m1m . '-20';
    $w37 = '21'; $w37d =  $m1y . '-' . $m1m . '-21';
    $w41 = '22'; $w41d =  $m1y . '-' . $m1m . '-22';
    $w42 = '23'; $w42d =  $m1y . '-' . $m1m . '-23';
    $w43 = '24'; $w43d =  $m1y . '-' . $m1m . '-24';
    $w44 = '25'; $w44d =  $m1y . '-' . $m1m . '-25';
    $w45 = '26'; $w45d =  $m1y . '-' . $m1m . '-26';
    $w46 = '27'; $w46d =  $m1y . '-' . $m1m . '-27';
    $w47 = '28'; $w47d =  $m1y . '-' . $m1m . '-28';
    if ( $mend == '28' ) {
	  $w51 = '1'; $w51d =  $nm1y . '-' . $nm1m . '-01';
	  $w52 = '2'; $w52d =  $nm1y . '-' . $nm1m . '-02';
	  $w53 = '3'; $w53d =  $nm1y . '-' . $nm1m . '-03';
	  $w54 = '4'; $w54d =  $nm1y . '-' . $nm1m . '-04';
	  $w55 = '5'; $w55d =  $nm1y . '-' . $nm1m . '-05';
	  $w56 = '6'; $w56d =  $nm1y . '-' . $nm1m . '-06';
	  $w57 = '7'; $w57d =  $nm1y . '-' . $nm1m . '-07';
	}
    if ( $mend == '29' ) {
	  $w51 = '29'; $w51d =  $m1y . '-' . $m1m . '-29';
	  $w52 = '1'; $w52d =  $nm1y . '-' . $nm1m . '-01';
	  $w53 = '2'; $w53d =  $nm1y . '-' . $nm1m . '-02';
	  $w54 = '3'; $w54d =  $nm1y . '-' . $nm1m . '-03';
	  $w55 = '4'; $w55d =  $nm1y . '-' . $nm1m . '-04';
	  $w56 = '5'; $w56d =  $nm1y . '-' . $nm1m . '-05';
	  $w57 = '6'; $w57d =  $nm1y . '-' . $nm1m . '-06';
	}
    if ( $mend == '30' ) {
	  $w51 = '29'; $w51d =  $m1y . '-' . $m1m . '-29';
	  $w52 = '30'; $w52d =  $m1y . '-' . $m1m . '-30';
	  $w53 = '1'; $w53d =  $nm1y . '-' . $nm1m . '-01';
	  $w54 = '2'; $w54d =  $nm1y . '-' . $nm1m . '-02';
	  $w55 = '3'; $w55d =  $nm1y . '-' . $nm1m . '-03';
	  $w56 = '4'; $w56d =  $nm1y . '-' . $nm1m . '-04';
	  $w57 = '5'; $w57d =  $nm1y . '-' . $nm1m . '-05';
	}
    if ( $mend == '31' ) {
	  $w51 = '29'; $w51d =  $m1y . '-' . $m1m . '-29';
	  $w52 = '30'; $w52d =  $m1y . '-' . $m1m . '-30';
	  $w53 = '31'; $w53d =  $m1y . '-' . $m1m . '-31';
	  $w54 = '1'; $w54d =  $nm1y . '-' . $nm1m . '-01';
	  $w55 = '2'; $w55d =  $nm1y . '-' . $nm1m . '-02';
	  $w56 = '3'; $w56d =  $nm1y . '-' . $nm1m . '-03';
	  $w57 = '4'; $w57d =  $nm1y . '-' . $nm1m . '-04';
	}
	$w61 = '0'; $w61d = '0';
	$w62 = '0'; $w62d = '0';
	$w63 = '0'; $w63d = '0';
	$w64 = '0'; $w64d = '0';
	$w65 = '0'; $w65d = '0';
	$w66 = '0'; $w66d = '0';
	$w67 = '0'; $w67d = '0';
  }
  
  if ( $m1w == '2' ) {
    $w11 = $bmend; $w11d =  $bm1y . '-' . $bm1m . '-' . $w11;
    $w12 = '1'; $w12d =  $m1y . '-' . $m1m . '-01';
    $w13 = '2'; $w13d =  $m1y . '-' . $m1m . '-02';
    $w14 = '3'; $w14d =  $m1y . '-' . $m1m . '-03';
    $w15 = '4'; $w15d =  $m1y . '-' . $m1m . '-04';
    $w16 = '5'; $w16d =  $m1y . '-' . $m1m . '-05';
    $w17 = '6'; $w17d =  $m1y . '-' . $m1m . '-06';
    $w21 = '7'; $w21d =  $m1y . '-' . $m1m . '-07';
    $w22 = '8'; $w22d =  $m1y . '-' . $m1m . '-08';
    $w23 = '9'; $w23d =  $m1y . '-' . $m1m . '-09';
    $w24 = '10'; $w24d =  $m1y . '-' . $m1m . '-10';
    $w25 = '11'; $w25d =  $m1y . '-' . $m1m . '-11';
    $w26 = '12'; $w26d =  $m1y . '-' . $m1m . '-12';
    $w27 = '13'; $w27d =  $m1y . '-' . $m1m . '-13';
    $w31 = '14'; $w31d =  $m1y . '-' . $m1m . '-14';
    $w32 = '15'; $w32d =  $m1y . '-' . $m1m . '-15';
    $w33 = '16'; $w33d =  $m1y . '-' . $m1m . '-16';
    $w34 = '17'; $w34d =  $m1y . '-' . $m1m . '-17';
    $w35 = '18'; $w35d =  $m1y . '-' . $m1m . '-18';
    $w36 = '19'; $w36d =  $m1y . '-' . $m1m . '-19';
    $w37 = '20'; $w37d =  $m1y . '-' . $m1m . '-20';
    $w41 = '21'; $w41d =  $m1y . '-' . $m1m . '-21';
    $w42 = '22'; $w42d =  $m1y . '-' . $m1m . '-22';
    $w43 = '23'; $w43d =  $m1y . '-' . $m1m . '-23';
    $w44 = '24'; $w44d =  $m1y . '-' . $m1m . '-24';
    $w45 = '25'; $w45d =  $m1y . '-' . $m1m . '-25';
    $w46 = '26'; $w46d =  $m1y . '-' . $m1m . '-26';
    $w47 = '27'; $w47d =  $m1y . '-' . $m1m . '-27';
    $w51 = '28'; $w51d =  $m1y . '-' . $m1m . '-28';
    if ( $mend == '28' ) {
	  $w52 = '1'; $w52d =  $nm1y . '-' . $nm1m . '-01';
	  $w53 = '2'; $w53d =  $nm1y . '-' . $nm1m . '-02';
	  $w54 = '3'; $w54d =  $nm1y . '-' . $nm1m . '-03';
	  $w55 = '5'; $w55d =  $nm1y . '-' . $nm1m . '-04';
	  $w56 = '5'; $w56d =  $nm1y . '-' . $nm1m . '-05';
	  $w57 = '6'; $w57d =  $nm1y . '-' . $nm1m . '-06';
	}
    if ( $mend == '29' ) {
	  $w52 = '29'; $w52d =  $m1y . '-' . $m1m . '-29';
	  $w53 = '1'; $w53d =  $nm1y . '-' . $nm1m . '-01';
	  $w54 = '2'; $w54d =  $nm1y . '-' . $nm1m . '-02';
	  $w55 = '3'; $w55d =  $nm1y . '-' . $nm1m . '-03';
	  $w56 = '4'; $w56d =  $nm1y . '-' . $nm1m . '-04';
	  $w57 = '5'; $w57d =  $nm1y . '-' . $nm1m . '-05';
	}
    if ( $mend == '30' ) {
	  $w52 = '29'; $w52d =  $m1y . '-' . $m1m . '-29';
	  $w53 = '30'; $w53d =  $m1y . '-' . $m1m . '-30';
	  $w54 = '1'; $w54d =  $nm1y . '-' . $nm1m . '-01';
	  $w55 = '2'; $w55d =  $nm1y . '-' . $nm1m . '-02';
	  $w56 = '3'; $w56d =  $nm1y . '-' . $nm1m . '-03';
	  $w57 = '4'; $w57d =  $nm1y . '-' . $nm1m . '-04';
	}
    if ( $mend == '31' ) {
	  $w52 = '29'; $w52d =  $m1y . '-' . $m1m . '-29';
	  $w53 = '30'; $w53d =  $m1y . '-' . $m1m . '-30';
	  $w54 = '31'; $w54d =  $m1y . '-' . $m1m . '-31';
	  $w55 = '1'; $w55d =  $nm1y . '-' . $nm1m . '-01';
	  $w56 = '2'; $w56d =  $nm1y . '-' . $nm1m . '-02';
	  $w57 = '3'; $w57d =  $nm1y . '-' . $nm1m . '-03';
	}
	$w61 = '0'; $w61d = '0';
	$w62 = '0'; $w62d = '0';
	$w63 = '0'; $w63d = '0';
	$w64 = '0'; $w64d = '0';
	$w65 = '0'; $w65d = '0';
	$w66 = '0'; $w66d = '0';
	$w67 = '0'; $w67d = '0';
  }
  
  if ( $m1w == '3' ) {
    $w11 = $bmend - 1; $w11d =  $bm1y . '-' . $bm1m . '-' . $w11;
    $w12 = $bmend; $w12d =  $bm1y . '-' . $bm1m . '-' . $w12;
    $w13 = '1'; $w13d =  $m1y . '-' . $m1m . '-01';
    $w14 = '2'; $w14d =  $m1y . '-' . $m1m . '-02';
    $w15 = '3'; $w15d =  $m1y . '-' . $m1m . '-03';
    $w16 = '4'; $w16d =  $m1y . '-' . $m1m . '-04';
    $w17 = '5'; $w17d =  $m1y . '-' . $m1m . '-05';
    $w21 = '6'; $w21d =  $m1y . '-' . $m1m . '-06';
    $w22 = '7'; $w22d =  $m1y . '-' . $m1m . '-07';
    $w23 = '8'; $w23d =  $m1y . '-' . $m1m . '-08';
    $w24 = '9'; $w24d =  $m1y . '-' . $m1m . '-09';
    $w25 = '10'; $w25d =  $m1y . '-' . $m1m . '-10';
    $w26 = '11'; $w26d =  $m1y . '-' . $m1m . '-11';
    $w27 = '12'; $w27d =  $m1y . '-' . $m1m . '-12';
    $w31 = '13'; $w31d =  $m1y . '-' . $m1m . '-13';
    $w32 = '14'; $w32d =  $m1y . '-' . $m1m . '-14';
    $w33 = '15'; $w33d =  $m1y . '-' . $m1m . '-15';
    $w34 = '16'; $w34d =  $m1y . '-' . $m1m . '-16';
    $w35 = '17'; $w35d =  $m1y . '-' . $m1m . '-17';
    $w36 = '18'; $w36d =  $m1y . '-' . $m1m . '-18';
    $w37 = '19'; $w37d =  $m1y . '-' . $m1m . '-19';
    $w41 = '20'; $w41d =  $m1y . '-' . $m1m . '-20';
    $w42 = '21'; $w42d =  $m1y . '-' . $m1m . '-21';
    $w43 = '22'; $w43d =  $m1y . '-' . $m1m . '-22';
    $w44 = '23'; $w44d =  $m1y . '-' . $m1m . '-23';
    $w45 = '24'; $w45d =  $m1y . '-' . $m1m . '-24';
    $w46 = '25'; $w46d =  $m1y . '-' . $m1m . '-25';
    $w47 = '26'; $w47d =  $m1y . '-' . $m1m . '-26';
    $w51 = '27'; $w51d =  $m1y . '-' . $m1m . '-27';
    $w52 = '28'; $w52d =  $m1y . '-' . $m1m . '-28';
    if ( $mend == '28' ) {
	  $w53 = '1'; $w53d =  $nm1y . '-' . $nm1m . '-01';
	  $w54 = '2'; $w54d =  $nm1y . '-' . $nm1m . '-02';
	  $w55 = '3'; $w55d =  $nm1y . '-' . $nm1m . '-03';
	  $w56 = '4'; $w56d =  $nm1y . '-' . $nm1m . '-04';
	  $w57 = '5'; $w57d =  $nm1y . '-' . $nm1m . '-05';
	}
    if ( $mend == '29' ) {
	  $w53 = '29'; $w53d =  $m1y . '-' . $m1m . '-29';
	  $w54 = '1'; $w54d =  $nm1y . '-' . $nm1m . '-01';
	  $w55 = '2'; $w55d =  $nm1y . '-' . $nm1m . '-02';
	  $w56 = '3'; $w56d =  $nm1y . '-' . $nm1m . '-03';
	  $w57 = '4'; $w57d =  $nm1y . '-' . $nm1m . '-04';
	}
    if ( $mend == '30' ) {
	  $w53 = '29'; $w53d =  $m1y . '-' . $m1m . '-29';
	  $w54 = '30'; $w54d =  $m1y . '-' . $m1m . '-30';
	  $w55 = '1'; $w55d =  $nm1y . '-' . $nm1m . '-01';
	  $w56 = '2'; $w56d =  $nm1y . '-' . $nm1m . '-02';
	  $w57 = '3'; $w57d =  $nm1y . '-' . $nm1m . '-03';
	}
    if ( $mend == '31' ) {
	  $w53 = '29'; $w53d =  $m1y . '-' . $m1m . '-29';
	  $w54 = '30'; $w54d =  $m1y . '-' . $m1m . '-30';
	  $w55 = '31'; $w55d =  $m1y . '-' . $m1m . '-31';
	  $w56 = '1'; $w56d =  $nm1y . '-' . $nm1m . '-01';
	  $w57 = '2'; $w57d =  $nm1y . '-' . $nm1m . '-02';
	}
	$w61 = '0'; $w61d = '0';
	$w62 = '0'; $w62d = '0';
	$w63 = '0'; $w63d = '0';
	$w64 = '0'; $w64d = '0';
	$w65 = '0'; $w65d = '0';
	$w66 = '0'; $w66d = '0';
	$w67 = '0'; $w67d = '0';
  }
  
  if ( $m1w == '4' ) {
    $w11 = $bmend - 2; $w11d =  $bm1y . '-' . $bm1m . '-' . $w11;
    $w12 = $bmend - 1; $w12d =  $bm1y . '-' . $bm1m . '-' . $w12;
    $w13 = $bmend; $w13d =  $bm1y . '-' . $bm1m . '-' . $w13;
    $w14 = '1'; $w14d =  $m1y . '-' . $m1m . '-01';
    $w15 = '2'; $w15d =  $m1y . '-' . $m1m . '-02';
    $w16 = '3'; $w16d =  $m1y . '-' . $m1m . '-03';
    $w17 = '4'; $w17d =  $m1y . '-' . $m1m . '-04';
    $w21 = '5'; $w21d =  $m1y . '-' . $m1m . '-05';
    $w22 = '6'; $w22d =  $m1y . '-' . $m1m . '-06';
    $w23 = '7'; $w23d =  $m1y . '-' . $m1m . '-07';
    $w24 = '8'; $w24d =  $m1y . '-' . $m1m . '-08';
    $w25 = '9'; $w25d =  $m1y . '-' . $m1m . '-09';
    $w26 = '10'; $w26d =  $m1y . '-' . $m1m . '-10';
    $w27 = '11'; $w27d =  $m1y . '-' . $m1m . '-11';
    $w31 = '12'; $w31d =  $m1y . '-' . $m1m . '-12';
    $w32 = '13'; $w32d =  $m1y . '-' . $m1m . '-13';
    $w33 = '14'; $w33d =  $m1y . '-' . $m1m . '-14';
    $w34 = '15'; $w34d =  $m1y . '-' . $m1m . '-15';
    $w35 = '16'; $w35d =  $m1y . '-' . $m1m . '-16';
    $w36 = '17'; $w36d =  $m1y . '-' . $m1m . '-17';
    $w37 = '18'; $w37d =  $m1y . '-' . $m1m . '-18';
    $w41 = '19'; $w41d =  $m1y . '-' . $m1m . '-19';
    $w42 = '20'; $w42d =  $m1y . '-' . $m1m . '-20';
    $w43 = '21'; $w43d =  $m1y . '-' . $m1m . '-21';
    $w44 = '22'; $w44d =  $m1y . '-' . $m1m . '-22';
    $w45 = '23'; $w45d =  $m1y . '-' . $m1m . '-23';
    $w46 = '24'; $w46d =  $m1y . '-' . $m1m . '-24';
    $w47 = '25'; $w47d =  $m1y . '-' . $m1m . '-25';
    $w51 = '26'; $w51d =  $m1y . '-' . $m1m . '-26';
    $w52 = '27'; $w52d =  $m1y . '-' . $m1m . '-27';
    $w53 = '28'; $w53d =  $m1y . '-' . $m1m . '-28';
    if ( $mend == '28' ) {
	  $w54 = '1'; $w54d =  $nm1y . '-' . $nm1m . '-01';
	  $w55 = '2'; $w55d =  $nm1y . '-' . $nm1m . '-02';
	  $w56 = '3'; $w56d =  $nm1y . '-' . $nm1m . '-03';
	  $w57 = '4'; $w57d =  $nm1y . '-' . $nm1m . '-04';
	}
    if ( $mend == '29' ) {
	  $w54 = '29'; $w54d =  $m1y . '-' . $m1m . '-29';
	  $w55 = '1'; $w55d =  $nm1y . '-' . $nm1m . '-01';
	  $w56 = '2'; $w56d =  $nm1y . '-' . $nm1m . '-02';
	  $w57 = '3'; $w57d =  $nm1y . '-' . $nm1m . '-03';
	}
    if ( $mend == '30' ) {
	  $w54 = '29'; $w54d =  $m1y . '-' . $m1m . '-29';
	  $w55 = '30'; $w55d =  $m1y . '-' . $m1m . '-30';
	  $w56 = '1'; $w56d =  $nm1y . '-' . $nm1m . '-01';
	  $w57 = '2'; $w57d =  $nm1y . '-' . $nm1m . '-02';
	}
    if ( $mend == '31' ) {
	  $w54 = '29'; $w54d =  $m1y . '-' . $m1m . '-29';
	  $w55 = '30'; $w55d =  $m1y . '-' . $m1m . '-30';
	  $w56 = '31'; $w56d =  $m1y . '-' . $m1m . '-31';
	  $w57 = '1'; $w57d =  $nm1y . '-' . $nm1m . '-01';
	}
	$w61 = '0'; $w61d = '0';
	$w62 = '0'; $w62d = '0';
	$w63 = '0'; $w63d = '0';
	$w64 = '0'; $w64d = '0';
	$w65 = '0'; $w65d = '0';
	$w66 = '0'; $w66d = '0';
	$w67 = '0'; $w67d = '0';
  }
  
  if ( $m1w == '5' ) {
    $w11 = $bmend - 3; $w11d =  $bm1y . '-' . $bm1m . '-' . $w11;
    $w12 = $bmend - 2; $w12d =  $bm1y . '-' . $bm1m . '-' . $w12;
    $w13 = $bmend - 1; $w13d =  $bm1y . '-' . $bm1m . '-' . $w13;
    $w14 = $bmend; $w14d =  $bm1y . '-' . $bm1m . '-' . $w14;
    $w15 = '1'; $w15d =  $m1y . '-' . $m1m . '-01';
    $w16 = '2'; $w16d =  $m1y . '-' . $m1m . '-02';
    $w17 = '3'; $w17d =  $m1y . '-' . $m1m . '-03';
    $w21 = '4'; $w21d =  $m1y . '-' . $m1m . '-04';
    $w22 = '5'; $w22d =  $m1y . '-' . $m1m . '-05';
    $w23 = '6'; $w23d =  $m1y . '-' . $m1m . '-06';
    $w24 = '7'; $w24d =  $m1y . '-' . $m1m . '-07';
    $w25 = '8'; $w25d =  $m1y . '-' . $m1m . '-08';
    $w26 = '9'; $w26d =  $m1y . '-' . $m1m . '-09';
    $w27 = '10'; $w27d =  $m1y . '-' . $m1m . '-10';
    $w31 = '11'; $w31d =  $m1y . '-' . $m1m . '-11';
    $w32 = '12'; $w32d =  $m1y . '-' . $m1m . '-12';
    $w33 = '13'; $w33d =  $m1y . '-' . $m1m . '-13';
    $w34 = '14'; $w34d =  $m1y . '-' . $m1m . '-14';
    $w35 = '15'; $w35d =  $m1y . '-' . $m1m . '-15';
    $w36 = '16'; $w36d =  $m1y . '-' . $m1m . '-16';
    $w37 = '17'; $w36d =  $m1y . '-' . $m1m . '-17';
    $w41 = '18'; $w41d =  $m1y . '-' . $m1m . '-18';
    $w42 = '19'; $w42d =  $m1y . '-' . $m1m . '-19';
    $w43 = '20'; $w43d =  $m1y . '-' . $m1m . '-20';
    $w44 = '21'; $w44d =  $m1y . '-' . $m1m . '-21';
    $w45 = '22'; $w45d =  $m1y . '-' . $m1m . '-22';
    $w46 = '23'; $w46d =  $m1y . '-' . $m1m . '-23';
    $w47 = '24'; $w47d =  $m1y . '-' . $m1m . '-24';
    $w51 = '25'; $w51d =  $m1y . '-' . $m1m . '-25';
    $w52 = '26'; $w52d =  $m1y . '-' . $m1m . '-26';
    $w53 = '27'; $w53d =  $m1y . '-' . $m1m . '-27';
    $w54 = '28'; $w54d =  $m1y . '-' . $m1m . '-28';
    if ( $mend == '28' ) {
	  $w55 = '1'; $w55d =  $nm1y . '-' . $nm1m . '-01';
	  $w56 = '2'; $w56d =  $nm1y . '-' . $nm1m . '-02';
	  $w57 = '3'; $w57d =  $nm1y . '-' . $nm1m . '-03';
	}
    if ( $mend == '29' ) {
	  $w55 = '29'; $w55d =  $m1y . '-' . $m1m . '-29';
	  $w56 = '1'; $w56d =  $nm1y . '-' . $nm1m . '-01';
	  $w57 = '2'; $w57d =  $nm1y . '-' . $nm1m . '-02';
	}
    if ( $mend == '30' ) {
	  $w55 = '29'; $w55d =  $m1y . '-' . $m1m . '-29';
	  $w56 = '30'; $w56d =  $m1y . '-' . $m1m . '-30';
	  $w57 = '1'; $w57d =  $nm1y . '-' . $nm1m . '-01';
	}
    if ( $mend == '31' ) {
	  $w55 = '29'; $w55d =  $m1y . '-' . $m1m . '-29';
	  $w56 = '30'; $w56d =  $m1y . '-' . $m1m . '-30';
	  $w57 = '31'; $w57d =  $m1y . '-' . $m1m . '-31';
	}
	$w61 = '0'; $w61d = '0';
	$w62 = '0'; $w62d = '0';
	$w63 = '0'; $w63d = '0';
	$w64 = '0'; $w64d = '0';
	$w65 = '0'; $w65d = '0';
	$w66 = '0'; $w66d = '0';
	$w67 = '0'; $w67d = '0';
  }
  
  if ( $m1w == '6' ) {
    $w11 = $bmend - 4; $w11d =  $bm1y . '-' . $bm1m . '-' . $w11;
    $w12 = $bmend - 3; $w12d =  $bm1y . '-' . $bm1m . '-' . $w12;
    $w13 = $bmend - 2; $w13d =  $bm1y . '-' . $bm1m . '-' . $w13;
    $w14 = $bmend - 1; $w14d =  $bm1y . '-' . $bm1m . '-' . $w14;
    $w15 = $bmend; $w15d =  $bm1y . '-' . $bm1m . '-' . $w15;
    $w16 = '1'; $w16d =  $m1y . '-' . $m1m . '-01';
    $w17 = '2'; $w17d =  $m1y . '-' . $m1m . '-02';
    $w21 = '3'; $w21d =  $m1y . '-' . $m1m . '-03';
    $w22 = '4'; $w22d =  $m1y . '-' . $m1m . '-04';
    $w23 = '5'; $w23d =  $m1y . '-' . $m1m . '-05';
    $w24 = '6'; $w24d =  $m1y . '-' . $m1m . '-06';
    $w25 = '7'; $w25d =  $m1y . '-' . $m1m . '-07';
    $w26 = '8'; $w26d =  $m1y . '-' . $m1m . '-08';
    $w27 = '9'; $w27d =  $m1y . '-' . $m1m . '-09';
    $w31 = '10'; $w31d =  $m1y . '-' . $m1m . '-10';
    $w32 = '11'; $w32d =  $m1y . '-' . $m1m . '-11';
    $w33 = '12'; $w33d =  $m1y . '-' . $m1m . '-12';
    $w34 = '13'; $w34d =  $m1y . '-' . $m1m . '-13';
    $w35 = '14'; $w35d =  $m1y . '-' . $m1m . '-14';
    $w36 = '15'; $w36d =  $m1y . '-' . $m1m . '-15';
    $w37 = '16'; $w37d =  $m1y . '-' . $m1m . '-16';
    $w41 = '17'; $w41d =  $m1y . '-' . $m1m . '-17';
    $w42 = '18'; $w42d =  $m1y . '-' . $m1m . '-18';
    $w43 = '19'; $w43d =  $m1y . '-' . $m1m . '-19';
    $w44 = '20'; $w44d =  $m1y . '-' . $m1m . '-20';
    $w45 = '21'; $w45d =  $m1y . '-' . $m1m . '-21';
    $w46 = '22'; $w46d =  $m1y . '-' . $m1m . '-22';
    $w47 = '23'; $w47d =  $m1y . '-' . $m1m . '-23';
    $w51 = '24'; $w51d =  $m1y . '-' . $m1m . '-24';
    $w52 = '25'; $w52d =  $m1y . '-' . $m1m . '-25';
    $w53 = '26'; $w53d =  $m1y . '-' . $m1m . '-26';
    $w54 = '27'; $w54d =  $m1y . '-' . $m1m . '-27';
    $w55 = '28'; $w55d =  $m1y . '-' . $m1m . '-28';
    if ( $mend == '28' ) {
	  $w56 = '1'; $w56d =  $nm1y . '-' . $nm1m . '-01';
	  $w57 = '2'; $w57d =  $nm1y . '-' . $nm1m . '-02';
	  $w61 = '0'; $w61d = '0';
	  $w62 = '0'; $w62d = '0';
	  $w63 = '0'; $w63d = '0';
	  $w64 = '0'; $w64d = '0';
	  $w65 = '0'; $w65d = '0';
	  $w66 = '0'; $w66d = '0';
	  $w67 = '0'; $w67d = '0';
	}
    if ( $mend == '29' ) {
	  $w56 = '29'; $w56d =  $m1y . '-' . $m1m . '-29';
	  $w57 = '1'; $w57d =  $nm1y . '-' . $nm1m . '-01';
	  $w61 = '0'; $w61d = '0';
	  $w62 = '0'; $w62d = '0';
	  $w63 = '0'; $w63d = '0';
	  $w64 = '0'; $w64d = '0';
	  $w65 = '0'; $w65d = '0';
	  $w66 = '0'; $w66d = '0';
	  $w67 = '0'; $w67d = '0';
	}
    if ( $mend == '30' ) {
	  $w56 = '29'; $w56d =  $m1y . '-' . $m1m . '-29';
	  $w57 = '30'; $w57d =  $m1y . '-' . $m1m . '-30';
	  $w61 = '0'; $w61d = '0';
	  $w62 = '0'; $w62d = '0';
	  $w63 = '0'; $w63d = '0';
	  $w64 = '0'; $w64d = '0';
	  $w65 = '0'; $w65d = '0';
	  $w66 = '0'; $w66d = '0';
	  $w67 = '0'; $w67d = '0';
	}
    if ( $mend == '31' ) {
	  $w56 = '29'; $w56d =  $m1y . '-' . $m1m . '-29';
	  $w57 = '30'; $w57d =  $m1y . '-' . $m1m . '-30';
	  $w61 = '31'; $w61d =  $m1y . '-' . $m1m . '-31';
	  $w62 = '1'; $w62d =  $nm1y . '-' . $nm1m . '-01';
	  $w63 = '2'; $w63d =  $nm1y . '-' . $nm1m . '-02';
	  $w64 = '3'; $w64d =  $nm1y . '-' . $nm1m . '-03';
	  $w65 = '4'; $w65d =  $nm1y . '-' . $nm1m . '-04';
	  $w66 = '5'; $w66d =  $nm1y . '-' . $nm1m . '-05';
	  $w67 = '6'; $w67d =  $nm1y . '-' . $nm1m . '-06';
	}
  }
  
  if ( $m1w == '0' ) {
    $w11 = $bmend - 5; $w11d =  $bm1y . '-' . $bm1m . '-' . $w11;
    $w12 = $bmend - 4; $w12d =  $bm1y . '-' . $bm1m . '-' . $w12;
    $w13 = $bmend - 3; $w13d =  $bm1y . '-' . $bm1m . '-' . $w13;
    $w14 = $bmend - 2; $w14d =  $bm1y . '-' . $bm1m . '-' . $w14;
    $w15 = $bmend - 1; $w15d =  $bm1y . '-' . $bm1m . '-' . $w15;
    $w16 = $bmend; $w16d =  $bm1y . '-' . $bm1m . '-' . $w16;
    $w17 = '1'; $w17d =  $m1y . '-' . $m1m . '-01';
    $w21 = '2'; $w21d =  $m1y . '-' . $m1m . '-02';
    $w22 = '3'; $w22d =  $m1y . '-' . $m1m . '-03';
    $w23 = '4'; $w23d =  $m1y . '-' . $m1m . '-04';
    $w24 = '5'; $w24d =  $m1y . '-' . $m1m . '-05';
    $w25 = '6'; $w25d =  $m1y . '-' . $m1m . '-06';
    $w26 = '7'; $w26d =  $m1y . '-' . $m1m . '-07';
    $w27 = '8'; $w27d =  $m1y . '-' . $m1m . '-08';
    $w31 = '9'; $w31d =  $m1y . '-' . $m1m . '-09';
    $w32 = '10'; $w32d =  $m1y . '-' . $m1m . '-10';
    $w33 = '11'; $w33d =  $m1y . '-' . $m1m . '-11';
    $w34 = '12'; $w34d =  $m1y . '-' . $m1m . '-12';
    $w35 = '13'; $w35d =  $m1y . '-' . $m1m . '-13';
    $w36 = '14'; $w36d =  $m1y . '-' . $m1m . '-14';
    $w37 = '15'; $w37d =  $m1y . '-' . $m1m . '-15';
    $w41 = '16'; $w41d =  $m1y . '-' . $m1m . '-16';
    $w42 = '17'; $w42d =  $m1y . '-' . $m1m . '-17';
    $w43 = '18'; $w43d =  $m1y . '-' . $m1m . '-18';
    $w44 = '19'; $w44d =  $m1y . '-' . $m1m . '-19';
    $w45 = '20'; $w45d =  $m1y . '-' . $m1m . '-20';
    $w46 = '21'; $w46d =  $m1y . '-' . $m1m . '-21';
    $w47 = '22'; $w47d =  $m1y . '-' . $m1m . '-22';
    $w51 = '23'; $w51d =  $m1y . '-' . $m1m . '-23';
    $w52 = '24'; $w52d =  $m1y . '-' . $m1m . '-24';
    $w53 = '25'; $w53d =  $m1y . '-' . $m1m . '-25';
    $w54 = '26'; $w54d =  $m1y . '-' . $m1m . '-26';
    $w55 = '27'; $w55d =  $m1y . '-' . $m1m . '-27';
    $w56 = '28'; $w56d =  $m1y . '-' . $m1m . '-28';
    if ( $mend == '28' ) {
	  $w57 = '1'; $w57d =  $nm1y . '-' . $nm1m . '-01';
	  $w61 = '0'; $w61d = '0';
	  $w62 = '0'; $w62d = '0';
	  $w63 = '0'; $w63d = '0';
	  $w64 = '0'; $w64d = '0';
	  $w65 = '0'; $w65d = '0';
	  $w66 = '0'; $w66d = '0';
	  $w67 = '0'; $w67d = '0';
	}
    if ( $mend == '29' ) {
	  $w57 = '29'; $w57d =  $m1y . '-' . $m1m . '-29';
	  $w61 = '0'; $w61d = '0';
	  $w62 = '0'; $w62d = '0';
	  $w63 = '0'; $w63d = '0';
	  $w64 = '0'; $w64d = '0';
	  $w65 = '0'; $w65d = '0';
	  $w66 = '0'; $w66d = '0';
	  $w67 = '0'; $w67d = '0';
	}
    if ( $mend == '30' ) {
	  $w57 = '29'; $w57d =  $m1y . '-' . $m1m . '-29';
	  $w61 = '30'; $w61d =  $m1y . '-' . $m1m . '-30';
	  $w62 = '1'; $w62d =  $nm1y . '-' . $nm1m . '-01';
	  $w63 = '2'; $w63d =  $nm1y . '-' . $nm1m . '-02';
	  $w64 = '3'; $w64d =  $nm1y . '-' . $nm1m . '-03';
	  $w65 = '4'; $w65d =  $nm1y . '-' . $nm1m . '-04';
	  $w66 = '5'; $w66d =  $nm1y . '-' . $nm1m . '-05';
	  $w67 = '6'; $w67d =  $nm1y . '-' . $nm1m . '-06';
	}
    if ( $mend == '31' ) {
	  $w57 = '29'; $w57d =  $m1y . '-' . $m1m . '-29';
	  $w61 = '30'; $w61d =  $m1y . '-' . $m1m . '-30';
	  $w62 = '31'; $w62d =  $m1y . '-' . $m1m . '-31';
	  $w63 = '1'; $w63d =  $nm1y . '-' . $nm1m . '-01';
	  $w64 = '2'; $w64d =  $nm1y . '-' . $nm1m . '-02';
	  $w65 = '3'; $w65d =  $nm1y . '-' . $nm1m . '-03';
	  $w66 = '4'; $w66d =  $nm1y . '-' . $nm1m . '-04';
	  $w67 = '5'; $w67d =  $nm1y . '-' . $nm1m . '-05';
	}
  }
  
  $_SESSION['mwdate']  = array($w11,$w12,$w13,$w14,$w15,$w16,$w17,$w21,$w22,$w23,$w24,$w25,$w26,$w27,$w31,$w32,$w33,$w34,$w35,$w36,$w37,$w41,$w42,$w43,$w44,$w45,$w46,$w47,$w51,$w52,$w53,$w54,$w55,$w56,$w57,$w61,$w62,$w63,$w64,$w65,$w66,$w67);
  
  $_SESSION['mwymd']  = array($w11d,$w12d,$w13d,$w14d,$w15d,$w16d,$w17d,$w21d,$w22d,$w23d,$w24d,$w25d,$w26d,$w27d,$w31d,$w32d,$w33d,$w34d,$w35d,$w36d,$w37d,$w41d,$w42d,$w43d,$w44d,$w45d,$w46d,$w47d,$w51d,$w52d,$w53d,$w54d,$w55d,$w56d,$w57d,$w61d,$w62d,$w63d,$w64d,$w65d,$w66d,$w67d);
}

?>