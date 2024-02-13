<?php

// logout.php

require( '../../config.php' );

//
session_start(); // ---
setcookie( session_name(), '', time() - 3600 ); // ---
session_destroy(); // ---

//
if ( $_GET['redirect'] == '' ) $_GET['redirect'] = $login_mng; // ---


?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
	<meta http-equiv="refresh" content="0; url=<?php echo $_GET['redirect']; ?>"> 
	<title>Sample EC - ログアウト</title>
</head>
<body>
logging out..<br>
If you are not automatically redirected to top page.
Please click <a href="<?php echo $_GET['redirect']; ?>">here</a>.
</body>
</html>