<?php
include 'base.php';
$mysql = mysqli_connect("localhost", "root", "") or die ("Неможливо під'єднатись до сервера");
$db = mysqli_select_db($mysql, "dentist") or die ("Даної бази даних не існує");
?>

<?php startblock('title') ?>dentist-prices<?php endblock();

startblock('content');
if (!isset($_POST['submit'])) {
?>
<br>
<h1 class="title">PRICES</h1>
<br>
<?php
if (isset($_SESSION['status'])) { echo '<div class="allert" style="color:red;"><h3>' . $_SESSION['status'] . '</h3></div>';
    unset($_SESSION['status']); }
?>
<div class="table">
<table>
<?php
    if (isset($_SESSION['status'])) { echo '<div class="allert" style="color:red;"><h3>' . $_SESSION['status'] . '</h3></div>';
        unset($_SESSION['status']); }

    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $rows_cat = mysqli_query($mysql, "SELECT * FROM `prices-category` where title='Services'");
        while ($line = mysqli_fetch_array($rows_cat))
        {
            $rows_items = mysqli_query($mysql, "SELECT * FROM `prices-items` WHERE id_category=" . $line['id']);
            echo "<tr>";
            echo "<th colspan='3'>" . $line['title'] . "</th>";
            echo "</tr>";
            while ($row = mysqli_fetch_array($rows_items))
            {
                echo "<tr>";
                echo "<td>" . $row['item'] . "</td>";
                echo "<td class='price'>" . $row['price'] . " UAN&nbsp;</td>";
                if (isset($_SESSION['phone']))
                {
                        $id_service = $row['id'];
                        echo "<td width='max-content'>";
                        echo "<form action='/templates/prices-page.php?id_service=" . $id_service . "' method='post'>";
                        echo '<input type="submit" name="submit" value="Buy"></form></td>';
                }
                else echo '<td width="max-content"><a href="/signup.php" class="buy" style="color:red; font-weight:900;">Buy</a></td>';
                echo "</tr>";
            }
        }
    }
?>
</table>
</div>
<br><br>
<div class="table">
<table>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $rows_cat = mysqli_query($mysql, "SELECT * FROM `prices-category`");
        while ($line = mysqli_fetch_array($rows_cat))
        {
                if ($line['title'] == 'Services') continue;
                $rows_items = mysqli_query($mysql, "SELECT * FROM `prices-items` WHERE id_category=" . $line['id']);
                echo "<tr>";
                echo "<th colspan='2'>" . $line['title'] . "</th>";
                echo "</tr>";
                while ($row = mysqli_fetch_array($rows_items))
                {
                        echo "<tr>";
                        echo "<td>" . $row['item'] . "</td>";
                        echo "<td class='price'>" . $row['price'] . " UAN&nbsp;</td>";
                        echo "</tr>";    
                }
        }
    }
    ?>
</table>
</div>
<?php
} elseif ($_POST['submit'] ==  'Buy')
{
        $id_service = $_GET['id_service'];
        $phone =  $_SESSION['phone'];
        $insert = "id_service='{$id_service}', phone='{$phone}'";
                
        $sql = "INSERT INTO messages SET {$insert}";
        mysqli_query($mysql, $sql);
        mysqli_close($mysql);
        $_SESSION['status'] = "See your <a href='/account.php'>profile!</a>";
        header("Location: /templates/prices-page.php");
}
endblock();
?>
