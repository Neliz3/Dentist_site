<?php
    require_once 'settings/ti.php';
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php startblock('title') ?><?php endblock() ?></title>
    <link rel="stylesheet" href="/static/css/main.css">
    <link rel="stylesheet" href="/static/css/header.css">
    <link rel="stylesheet" href="/static/css/contents.css">
    <link rel="stylesheet" href="/static/css/footer.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>

<body>

    <header>
        <nav class="nav"  id="scroll-top">
            <ul>
                <li><a href="/templates/home-page.php">HOME</a></li>
                <li><a href="/templates/prices-page.php" target="_blank">PRICES</a></li>
                <li><a href="/templates/about-page.php" target="_blank">ABOUT</a></li>
                <?php if (isset($_SESSION['position']))
                {
                    echo "<li><a href='/admin.php' target='_blank'>DASHBOARD</a></li>"; 
                    echo "<li><a href='/logout.php' target='_blank'>LOG OUT</a></li>";
                }
                elseif (isset($_SESSION['phone']))
                {
                    echo "<li><a href='/logout.php' target='_blank'>LOG OUT</a></li>";
                    echo "<li><a href='/account.php' target='_blank'>" . $_SESSION['first_name'] . "</a></li>";
                }
                else echo "<li><a href='/login.php' target='_blank'>SIGN IN/UP</a></li>";
                ?>
            </ul>
        </nav>
        <img src="/static/images/Logo-green.png" class="logo-img">
    </header>

    <div class="content-section">
        <?php startblock('content') ?>
        <?php endblock() ?>
    </div>

    <div class="button">
        <a href="#scroll-top">
            <img src="/static/images/fast-forward.png" class="up-button">
        </a>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col">
                    <h4>contact us</h4>
                    <ul>
                        <li>+38 095 457 79 97</li>
                        <li>+98 096 789 15 94</li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>address</h4>
                    <ul>
                        <li>вул.Січових Стрільців,10Б<br>Київ</li>
                    </ul>
                </div>
                <div class="map">
                    <ul>
                        <li>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1972.953115164547!2d30.504271961837443!
        3d50.456068310222435!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40d4ce670ab303cf%3A0x6c9b
        e16452874aae!2sSichovykh%20Striltsiv%20St%2C%2010%D0%91%2C%20Kyiv%2C%2002000!5e0!3m2!1sen!2sua!4v1
        665658781375!5m2!1sen!2sua" width="200px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>follow us</h4>
                    <div class="social-links">
                        <a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="https://t.me/stomatolohiaypoprostomu32" target="_blank"><i class="fab fa-telegram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>