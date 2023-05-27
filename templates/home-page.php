<?php
    include 'base.php';
    $mysql = mysqli_connect("localhost", "root", "") or die("Неможливо під'єднатись до сервера");
    $db = mysqli_select_db($mysql, "dentist") or die("Даної бази даних не існує");
?>

<?php startblock('title') ?>dentist<?php endblock() ?>

<?php
startblock('content');
if (!isset($_POST['submit'])) {
    if (isset($_SESSION['status'])) { echo '<div class="allert" style="color:red;"><h3>' . $_SESSION['status'] . '</h3></div>';
                unset($_SESSION['status']); } ?>
<form class="form start" method="post" action="home-page.php">
    <label>+38</label>
    <input
        name="phone"
        type="tel"
        pattern="[0-9]{10}"
        required
        autofocus
        size="10"
        maxlength="10"
        title="Number must contain +38 plus 10 characters."
        <?php if (isset($_SESSION['phone'])) echo "value='" . $_SESSION['phone'] . "'"; ?>>
    <input type="submit" name="submit" value="Call me!">
</form>
<h1 class="title ad">
    GET THE BEST TRANSFORMATION OF YOUR TEETH RIGHT NOW!
</h1>
<a href="#enter" class="arrows">
    <img src="/static/images/Arrow-yellow.png" class="arrow">
</a>
<h3 class="ad-green">
    Simply enter your phone number and we'll phone you!
</h3>
<a href="#enter" class="arrows">
    <img src="/static/images/Arrow-yellow.png" class="arrow">
</a>
<div class="first-part">
    Teeth cleaning | Consultation | Making an appointment
</div>
<a href="#enter" class="arrows">
    <img src="/static/images/Arrow-yellow.png" class="arrow">
</a>
<form class="form" id="enter" method="post" action="home-page.php">
    <label>+38</label>
    <input
        name="phone"
        type="tel"
        pattern="[0-9]{10}"
        required
        size="10"
        maxlength="10"
        title="Number must contain +38 plus 10 characters."
        <?php if (isset($_SESSION['phone'])) echo "value='" . $_SESSION['phone'] . "'"; ?>>
    <input type="submit" name="submit" value="Call me!">
</form>
<?php
} elseif ($_POST['submit'] ==  'Call me!')
{
    $phone =  $_POST['phone'];
    $insert = "phone='{$phone}'";

    $sql = "INSERT INTO messages SET {$insert}";
    mysqli_query($mysql, $sql);
    mysqli_close($mysql);
    $_SESSION['status'] = 'We will call you soon!';
    header("Location: /templates/home-page.php");
}
endblock();
?>
