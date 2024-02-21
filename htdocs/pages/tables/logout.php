<?php

// logout.php

require( '../../config.php' );

$login_mng = $site_domain;

//
session_start(); // ---
setcookie( session_name(), '', time() - 3600 ); // ---
session_destroy(); // ---

//リダイレクト先のURLを設定
$redirect_url = isset($_GET['redirect']) ? $_GET['redirect'] : $site_domain;

// リダイレクト処理
header("Location: $redirect_url");
exit;

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
	<meta http-equiv="refresh" content="0; url=<?php echo $_GET['redirect']; ?>">
	<title>Sample EC - ���O�A�E�g</title>
</head>
<body>
logging out..<br>
If you are not automatically redirected to top page.
Please click <a href="<?php echo $_GET['redirect']; ?>">here</a>.
</body>
</html>
