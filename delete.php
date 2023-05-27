<?php session_start();
if (!isset($_SESSION['phone']))
{
    header("Location: login.php");
    die;
}
else {
        $mysql = mysqli_connect("localhost", "root", "") or die ("Неможливо під'єднатись до сервера");
        $db = mysqli_select_db($mysql, "dentist") or die ("Даної бази даних не існує");
        $value = $_GET['value'];
        $id = $_GET['id'];
        if ($value == 'msg') $sql = "DELETE FROM messages WHERE id=" . $id;
        elseif (($value == 'category') && isset($_SESSION['position']))
        {
            $items = mysqli_query($mysql, "SELECT * FROM `prices-items` WHERE id_category=" . $id);
            while ($row = mysqli_fetch_array($items))
            {
                $sql = "DELETE FROM `prices-items` WHERE id=" . $row['id'];
                mysqli_query($mysql, $sql);
            }
            $sql = "DELETE FROM `prices-category` WHERE id=" . $id;
        }
        elseif ($value == 'item' && isset($_SESSION['position'])) $sql = "DELETE FROM `prices-items` WHERE id=" . $id;

        mysqli_query($mysql, $sql);

        $_SESSION['status'] = "Was delete successfully!";
        if (isset($_SESSION['position'])) header('Location: admin.php');
        else header('Location: account.php');
    }
?>
