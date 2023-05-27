<?php session_start();

if (!isset($_POST['submit'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="/static/css/main.css">
    <link rel="stylesheet" href="/static/css/signin.css">
</head>
<body>
    <div class="login-form">
        <form method="post" action="signup.php">
            <table>
                <tr><td>
                    First name
                    <input
                    type="text"
                    required
                    name="first_name"
                    autofocus
                    size="15">
                </td></tr>
                <tr><td>
                    Last name
                    <input
                    type="text"
                    required
                    name="last_name"
                    size="15">
                </td></tr>
                <tr><td>
                    Birthday
                    <input
                    type="date"
                    name="date">
                </td></tr>
                <tr><td>
                    Email
                    <input
                    type="email"
                    name="email"
                    placeholder="name@gmail.com"
                    size="15">
                </td></tr>
                <tr><td>
                    Phone
                    <input
                    pattern="[0-9]{10}"
                    required
                    maxlength="10"
                    title="Number must contain +38 plus 10 characters."
                    type="tel"
                    name="phone"
                    size="15">
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
                    <input type="submit" name="submit" value="Sign up">
                </td></tr>
                <tr><td colspan="2" align="center">
                    <input type="reset" name="reset" value="Reset">
                </td></tr>
            </table>
        </form>
    </div>
</body>
</html>

<?php
} else {
    $mysql = mysqli_connect("localhost", "root", "") or die ("Неможливо під'єднатись до сервера");
    $db = mysqli_select_db($mysql, "dentist") or die ("Даної бази даних не існує");
    
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $pass = $_POST['pass'];

    $insert = "first_name='{$first_name}', last_name='{$last_name}', phone='{$phone}', password ='{$pass}'";
    
    if (!empty($_POST['email'])) $insert .= ", email='" . $_POST['email'] . "'";
    if (!empty($_POST['date']))
    {
        $date = date('Y-m-d', strtotime($_POST['date']));
        $insert .= ", birthday='" . $date . "'";
    }
    
    if ($_POST['submit'] == 'Sign up') $sql = "INSERT INTO users SET {$insert}";
    else $sql = "UPDATE users SET {$insert}";

    mysqli_query($mysql, $sql);

    if (mysqli_affected_rows($mysql) > 0)
    {
        $_SESSION['phone'] = $phone;
        $_SESSION['password'] = $pass;
        $_SESSION['first_name'] = $first_name;
        header("Location: /templates/home-page.php");
    }
    mysqli_close($mysql);
}
?>
