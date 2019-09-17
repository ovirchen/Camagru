
<!DOCTYPE html>
<html>
<head>
    <title>Picture</title>
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
    <link href="/css/main.css" type="text/css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" sizes="16x16" href="/images/icon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<body>
<!--<div class="body">-->
    <header class="header">
        <div class="header-logo">
            <a href="http://localhost:8080">
                take<span style="color: #9ae5e5;">a</span>picture
            </a>
        </div>
        <div class="header-navigation" id="headerNav">
            <a href="#" id="menu" class="icon">&#9776;</a>
            <div class="header-items">
                <a href="http://localhost:8080/camera">CAMERA</a>
                <a href="http://localhost:8080/photoes">PHOTOES</a>
                <a href="http://localhost:8080/profile">PROFILE</a>
                <?php

                if (isset($_SESSION['user']))
                    echo "<a href=\"http://localhost:8080/main/logout\">LOGOUT</a>";
                else
                    echo "<a href=\"http://localhost:8080/login\">LOGIN</a>";

                ?>
            </div>
        </div>
    </header>

    <?php include 'application/views/' . $content_view; ?>
    <footer class="footer">
        <div>
            <p class="footer-logo">Copyright <?php echo date('Y');?></p>
        </div>
    </footer>
    <script src="/js/js.js" type="text/javascript"></script>
    <script src="/js/main.js" type="text/javascript"></script>
<!--</div>-->
</body>

</html>