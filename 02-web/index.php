<?php
/*
 *
 * FRONT CONTROLER
 *
 */

include("user_config.php");


if ( $g_USER_debug == true ) {
    echo "<pre>";
    print_r($_GET);
    echo "</pre>";
}


echo <<<EOT
<!DOCTYPE html>
<html>
    <head>
        <title>PhpFusion Official Homepage</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="pf_util.js" type="text/javascript"></script>
        
        <link href="pf_style.css" rel="stylesheet" type="text/css" />
        
        <link rel="shortcut icon" href="favicon.ico" />
    </head>

   <body>
EOT;

include($g_USER_headerfile);

echo <<<EOT
<div id="mainpaper">
EOT;

include($g_USER_menufile);

if ( isset($_GET['contact']) ) {
    include($g_USER_contactfile);

} else if ( isset($_GET['search']) ) {
    include("cat_searchresult.php");
    
} else {
    include("index_txt.html");
}

include($g_USER_footerfile);

echo <<<EOT
</div><!-- mainpaper -->
</div><!-- mainbody -->
</body>
</html>
EOT;
