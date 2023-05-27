<?php
include 'templates/base.php';

if (isset($_SESSION['phone']))
{
    if (isset($_SESSION['position'])) header("Location: login.php");
    $mysql = mysqli_connect("localhost", "root", "") or die("Неможливо під'єднатись до сервера");
    $db = mysqli_select_db($mysql, "dentist") or die("Даної бази даних не існує");
}
else header("Location: login.php");
?>

<?php startblock('title') ?>dentist-account<?php endblock();

startblock('content');
if (!isset($_POST['submit'])) {
    $sql = "SELECT * FROM users where phone=" . $_SESSION['phone'];
    $rows = mysqli_query($mysql, $sql);
    $line = mysqli_fetch_array($rows);
?>
<h1 class="title">Profile</h1>
<div class="profile-clock">
<form method="post" action="signup.php">
    <table>
        <tr><td>
            First name
            <input
            type="text"
            required
            name="first_name"
            autofocus
            size="15"
            value="<?php echo  $line['first_name']; ?>">
        </td></tr>
        <tr><td>
            Last name
            <input
            type="text"
            required
            name="last_name"
            size="15"
            value="<?php echo  $line['last_name']; ?>">
        </td></tr>
        <tr><td>
            Birthday
            <input
            type="date"
            name="date"
            value="<?php if (isset($line['birthday'])) echo  $line['birthday']; ?>">
        </td></tr>
        <tr><td>
            Email
            <input
            type="email"
            name="email"
            placeholder="name@gmail.com"
            size="15"
            value="<?php if (isset($line['email'])) echo  $line['email']; ?>">
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
            size="10"
            value="<?php echo  $line['phone']; ?>">
        </td></tr>
        <tr><td>
            Password
            <input
            required
            type="password"
            name="pass"
            maxlength="15"
            size="15"
            value="<?php echo  $line['password']; ?>">
        </td></tr>
        <tr><td colspan="2" align="center">
            <input type="submit" name="submit" value="Edit">
        </td></tr>
        <tr><td colspan="2" align="center">
            <input type="reset" name="reset" value="Reset">
        </td></tr>
    </table>
</form>
</div>
<h1 class="title">Appointments & Calls</h1>
<?php
if (isset($_SESSION['status'])) { echo '<div class="allert" style="color:red;"><h3>' . $_SESSION['status'] . '</h3></div>';
    unset($_SESSION['status']); }
?>
<div class="profile-clock">
<table width="100%" border="1" cellspacing="1">
<?php
                    $request = "SELECT * FROM messages where phone=" . $_SESSION['phone'];
                    $rows_msg = mysqli_query($mysql, $request);
                    $count = 1;
                    while ($line = mysqli_fetch_array($rows_msg)) {
                        if ($count == 1){
                        ?>
                        <tr>
                            <td>service</td>
                            <td>first name</td>
                            <td>last name</td>
                            <td>delete</td>
                        </tr>
                        <?php
                        }
                        $count++;
                        $sql = "SELECT * FROM users WHERE phone='" . $line['phone'] . "'";
                        $rows_items = mysqli_query($mysql, $sql);
                        $row = mysqli_fetch_array($rows_items);
                        if ($row > 0)
                        {
                            if (isset($line['id_service']))
                            {
                                $sql = "SELECT * FROM `prices-items` WHERE id=" . $line['id_service'];
                                $item_res = mysqli_query($mysql, $sql);
                                $item = mysqli_fetch_array($item_res);    
                                echo "<td>" . $item['item'] . "</td>";
                            } else echo "<td>-</td>";
                            echo "<td>" . $row['first_name'] . "</td>";
                            echo "<td>" . $row['last_name'] . "</td>";
                            echo "<td><a href='delete.php?value=msg&id=" . $line['id'] . "'>Delete</a></td>";
                            echo "</tr>";
                        }
                    }
                    if (mysqli_num_rows($rows_msg) == 0) echo "<h2 style='color:yellow;'>You don't have any assigned calls (</h2>";
                    ?>
</table>
</div>

<?php
} /*elseif (isset($_POST['submit']))*/
endblock();
?>
