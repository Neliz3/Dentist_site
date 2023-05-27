<?php session_start();

if (!isset($_POST['submit']))
{
    if (isset($_SESSION['position'])) session_unset();
    elseif (isset($_SESSION['phone'])) $phone = $_SESSION['phone'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="/static/css/signin.css">
    <link rel="stylesheet" href="/static/css/main.css">
</head>
<body>
    <div class="login-form">
        <form method="post" action="login.php">
            <table>
                <tr><td>
                    Phone
                    <input
                    pattern="[0-9]{10}"
                    required
                    autofocus
                    maxlength="10"
                    title="Number must contain +38 plus 10 characters."
                    type="tel"
                    name="phone"
                    size="10"
                    value="<?php if (isset($phone)) echo $phone; ?>">
                </td></tr>
                <tr><td>
                    Password
                    <input
                    required
                    type="password"
                    name="pass"
                    maxlength="15"
                    size="15">
                </td></tr>
                <tr><td colspan="2" align="center">
                    <input type="submit" name="submit" value="Sign in"> or
                    <a href="signup.php" class="signup">Sign up</a>
                </td></tr>
            </table>
            <?php if (isset($_SESSION['status'])) { echo '<div class="allert">' . $_SESSION['status'] . '</div>';
                unset($_SESSION['status']); } ?>
        </form>
    </div>
    <div class="link-under"><a href="/templates/home-page.php">⇠ Continue without login ⇢</a></div>
</body>
</html>

<?php
} else {
    $mysql = mysqli_connect("localhost", "root", "") or die ("Неможливо під'єднатись до сервера");
    $db = mysqli_select_db($mysql, "dentist") or die ("Даної бази даних не існує");
    
    $phone = $_POST['phone'];
    $pass = $_POST['pass'];

    $sql = "SELECT * FROM users WHERE phone='{$phone}' AND password='{$pass}'";
    $sql_admin = "SELECT * FROM admins WHERE phone='{$phone}' AND password='{$pass}'";
    $res = mysqli_query($mysql, $sql);
    $res_admin = mysqli_query($mysql, $sql_admin);

    if (mysqli_num_rows($res) != 1 && mysqli_num_rows($res_admin) != 1)
    {
        $_SESSION['status'] = "Wrong login or password!";
        header("Location: login.php");
    }
    else
    {
        $_SESSION['phone'] = $phone;
        $_SESSION['password'] = $pass;
        $first_name = mysqli_fetch_array($res)['first_name'];

        if (mysqli_num_rows($res_admin) == 1)
            $_SESSION['position'] = mysqli_fetch_array($res_admin)['position'];
        else $_SESSION['first_name'] = $first_name;
        
        header("Location: index.php");
    }
    mysqli_close($mysql);
}
?>
