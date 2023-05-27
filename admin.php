<?php
session_start();

if (!isset($_SESSION['position'])) {
    $_SESSION['status'] = "You are not an admin!";
    header("Location: login.php");
    die;
} else {
    $mysql = mysqli_connect("localhost", "root", "") or die("Неможливо під'єднатись до сервера");
    $db = mysqli_select_db($mysql, "dentist") or die("Даної бази даних не існує");

    if (isset($_GET['id'])) $id = $_GET['id'];
    if (isset($_GET['value'])) $value = $_GET['value'];
    if (isset($_GET['id_category'])) $id_category = $_GET['id_category'];
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <link rel="stylesheet" href="/static/css/main.css">
        <link rel="stylesheet" href="/static/css/header.css">
        <link rel="stylesheet" href="/static/css/admins.css">
    </head>

    <body>
        <header>
            <nav class="nav">
                <ul>
                    <li><a href="/templates/home-page.php">HOME</a></li>
                    <li><a href="logout.php" target="_blank">Log out</a></li>
                </ul>
            </nav>
        </header>



        <!-- if (!isset($_POST['submit'])) -->

        <?php
        if (!isset($_POST['submit'])) {

            if (isset($_SESSION['status'])) { echo '<div class="allert" style="color:red;"><h3>' . $_SESSION['status'] . '</h3></div>';
                unset($_SESSION['status']); }
            ?>

            <!-- <User's Choice Managing> -->
            <div class="content">
                <h1 style="color:red;">User's Messages</h1>
                <?php
                if (isset($_SESSION['status'])) { echo '<div class="allert" style="color:red;"><h3>' . $_SESSION['status'] . '</h3></div>';
                    unset($_SESSION['status']); }
                ?>

                <!-- Messages' table -->
                <table width="100%" border="1" cellspacing="1">
                        <tr>
                            <td>#ID</td>
                            <td>phone</td>
                            <td>service</td>
                            <td>first name</td>
                            <td>last name</td>
                            <td>is child</td>
                            <td>delete</td>
                        </tr>
                    <?php
                    $rows_msg = mysqli_query($mysql, "SELECT * FROM messages");
                    while ($line = mysqli_fetch_array($rows_msg)) {
                        echo "<tr>";
                        echo "<td>" . $line['id'] . "</td>";
                        echo "<td>" . $line['phone'] . "</td>";

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
                            if (isset($line['id_child'])) echo "<td>Yes</td>";
                            else echo "<td>-</td>";
                        }
                        else echo "<td>-</td><td>-</td><td>-</td><td>-</td>";
                        echo "<td><a href='delete.php?value=msg&id=" . $line['id'] . "'>Delete</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
                <?php



            ### <!-- <Staff section> -->
            if ($_SESSION['position'] == 'Chief Administrator') {

                $rows = mysqli_query($mysql, "SELECT * FROM admins");
        ?>
                <?php
                if (isset($_SESSION['status'])) { echo '<div class="allert" style="color:red;"><h3>' . $_SESSION['status'] . '</h3></div>';
                    unset($_SESSION['status']); }
                ?>

                <div class="content">
                    <h1>Staff</h1>
                    <table width="100%" border="1" cellspacing="1">
                        <tr>
                            <td>#ID</td>
                            <td>Email</td>
                            <td>Phone</td>
                            <td>Position</td>
                        </tr>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                            $mysql = mysqli_connect("localhost", "root", "") or die("Неможливо під'єднатись до сервера");
                            $db = mysqli_select_db($mysql, "dentist") or die("Даної бази даних не існує");
                            $rows = mysqli_query($mysql, "SELECT * FROM admins");
                            while ($line = mysqli_fetch_array($rows)) {
                                echo "<tr>";
                                echo "<td>" . $line['id'] . "</td>";
                                echo "<td>" . $line['email'] . "</td>";
                                echo "<td>" . $line['phone'] . "</td>";
                                echo "<td>" . $line['position'] . "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </table>
                </div>
            <?php
            } ?>
            <!-- </Staff section> -->



            <!-- <Adding a role section> -->
            <div class="content">
                <h1>Adding a role</h1>
                <?php
                if (isset($_SESSION['status'])) { echo '<div class="allert" style="color:red;"><h3>' . $_SESSION['status'] . '</h3></div>';
                    unset($_SESSION['status']); }
                ?>

                <div class="login">
                    <form method="post" action="admin.php">
                        <table>
                            <tr>
                                <td>
                                    Email
                                    <input required type="email" name="email" placeholder="name@gmail.com" size="15">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Position
                                    <select name="position">
                                        <option selected value="Administrator">Administrator</option>
                                        <?php if ($_SESSION['position'] == 'Chief Administrator')
                                            echo "<option value='Chief Administrator'>Chief Administrator</option>" ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Phone
                                    <input pattern="[0-9]{10}" required maxlength="10" title="Number must contain +38 plus 10 characters." type="tel" name="phone" size="15">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Password
                                    <input required type="password" name="pass" maxlength="15" size="15">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input type="submit" name="submit" value="Register">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input type="reset" name="reset" value="Reset">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            <!-- </Adding a role section> -->



            <!-- <Deleting a person section> -->
            <?php
            if ($_SESSION['position'] == 'Chief Administrator') {

                $rows = mysqli_query($mysql, "SELECT * FROM admins");
            ?>
                <div class="content">
                    <h1>Deleting a role</h1>
                    <?php
                    if (isset($_SESSION['status'])) { echo '<div class="allert" style="color:red;"><h3>' . $_SESSION['status'] . '</h3></div>';
                        unset($_SESSION['status']); }
                    ?>

                    Choose a person to delete:
                    <form method="post" action="admin.php" name="delete">
                        <select name="admins-email">
                            <?php
                            while ($line = mysqli_fetch_array($rows))
                                echo "<option value='" . $line['email'] . "'>" . $line['email'] . "(" . $line['position'] . ")" . "</option>"
                            ?>
                        </select>
                        <input type="submit" name="submit" value="Delete">
                    </form>
                </div>
            <?php } ?>
            <!-- </Deleting a person section> -->



            <!-- <Price Managing> -->
            <div class="content">
                <h1>Price Managing</h1>
                <?php
                if (isset($_SESSION['status'])) { echo '<div class="allert" style="color:red;"><h3>' . $_SESSION['status'] . '</h3></div>';
                    unset($_SESSION['status']); }
                ?>

                <h6>"Services" category is used for offering by users!</h6>
                <p><a href='admin.php?act=new&value=category'>New category</a></p>


                <!-- Price table -->
                <table width="100%" border="1" cellspacing="1">
                    <?php

                    $rows_cat = mysqli_query($mysql, "SELECT * FROM `prices-category`");
                    while ($line = mysqli_fetch_array($rows_cat)) {
                        $rows_items = mysqli_query($mysql, "SELECT * FROM `prices-items` WHERE id_category=" . $line['id']);
                        echo "<tr>";
                        echo "<th>" . $line['title'] . "</th>";
                        echo "<th><a href='admin.php?act=new&value=item&id=" . $line['id'] . "'>New item</a></th>";
                        echo "<td><a href='admin.php?act=edit&value=category&id=" . $line['id'] . "'>Edit</a></td>";
                        echo "<div class='underlines'><td><a href='delete.php?value=category&id=" . $line['id'] . "'>Delete</a></td></div>";
                        echo "</tr>";
                        while ($row = mysqli_fetch_array($rows_items)) {
                            echo "<tr>";
                            echo "<td>" . $row['item'] . "</td>";
                            echo "<td>&nbsp;" . $row['price'] . " UAN&nbsp;</td>";
                            echo "<td><a href='admin.php?act=edit&value=item&id=" . $row['id'] . "&id_category=" . $row['id_category'] . "'>Edit</a></td>";
                            echo "<td><a href='delete.php?value=item&id=" . $row['id'] . "'>Delete</a></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </table>
                <?php

            ### <!-- when a button was clicked -->
            if (isset($_GET['act'])) {

                ### if button is 'edit'
                if ($_GET['act'] == 'edit') {
                ?>
                    <div class="content plus">
                        <h2>Editing form</h2>
                        <form action="admin.php?value=<?php echo $value ?>&id=<?php echo $id; if (isset($id_category)) echo "&id_category=" . $id_category; ?>" method="post">
                            <?php
                            if ($value == 'category') {
                                $sql = "SELECT * FROM `prices-category` WHERE id=" . $id;
                                $res = mysqli_query($mysql, $sql);
                                $row = mysqli_fetch_array($res);
                                $title = $row['title'];
                            ?>Title <input autofocus required type="text" name="title" value="<?php echo $title; ?>" /><br> <?php
                            } elseif ($value == 'item') {
                                $sql = "SELECT * FROM `prices-items` WHERE id=" . $id;
                                $res = mysqli_query($mysql, $sql);
                                $row = mysqli_fetch_array($res);
                                $item = $row['item'];
                                $price = $row['price'];

                                ?>Item <input autofocus required type="text" name="item" value="<?php echo $item; ?>" /><br>
                                Price <input required type="text" name="price" value="<?php echo $price; ?>" /><br>
                                <select name="cats">
                                <?php
                                    $rows_cat = mysqli_query($mysql, "SELECT * FROM `prices-category`");
                                    while ($line = mysqli_fetch_array($rows_cat)) {
                                        $output = '<option value="' . $line['id'];
                                        if ($id_category == $line['id']) $output .= '" selected>';
                                        else $output .= '">';
                                        $output .= $line['title'] . '</option>';
                                        echo $output;
                                    }
                                    echo "</select>";
                                }
                                ?>
                                <input type="submit" name="submit" value="Edit">
                                <input type="reset" name="reset" value="Reset">
                        </form>
                    </div>

                <?php
                ### if button is 'new'
                } elseif ($_GET['act'] == 'new') {
                ?>
                    <div class="content plus">
                        <h2>Adding form</h2>
                        <form action="admin.php?value=<?php echo $value; if (isset($id)) echo "&id=" . $id; ?>" method="post">
                        <?php
                            if ($value == 'category') echo "Title <input autofocus required type='text' name='title' /><br>";      
                            elseif ($value == 'item')
                                echo "Item <input autofocus required type='text' name='item' /><br>Price <input required type='text' name='price' /><br>";
                        ?>
                        <input type="submit" name="submit" value="Add">
                        <input type="reset" name="reset" value="Reset">
                        </form>
                    </div>
            <!-- </Price Managing> -->


                                                                    <!-- if (isset($_POST['submit'])) -->


            <!-- <Chief Administrator's functionality> -->
                <!-- <Submit 'Register'> -->
                <?php
                }}} elseif ($_POST['submit'] == 'Register') {

                    $email = $_POST['email'];
                    $phone = $_POST['phone'];
                    $pass = $_POST['pass'];
                    $position = $_POST['position'];

                    $sql = "INSERT INTO admins SET email='{$email}', phone='{$phone}', password='{$pass}', position='{$position}'";

                    mysqli_query($mysql, $sql);

                    if (mysqli_affected_rows($mysql) > 0) $_SESSION['status'] = "$email was added!";
                    else $_SESSION['status'] = "Error has occurred!";
                    header("Location: admin.php");
                ### <!-- </Submit 'Register'> -->



                ### <!-- <Submit 'Delete'> -->
                } elseif ($_POST['submit'] == 'Delete') {

                    $email = $_POST['admins-email'];

                    $sql = "DELETE FROM admins WHERE email='{$email}'";
                    mysqli_query($mysql, $sql);

                    if (mysqli_query($mysql, $sql)) $_SESSION['status'] = "Administrator was deleted successfully!";
                    else $_SESSION['status'] = "Error has occurred!";
                    header("Location: admin.php");
                }
                ###<!-- </Submit 'Delete'> -->
            ###<!-- <Chief Administrator's functionality> -->



            ###<!-- <Price Managing> -->
                ###<!-- <Submit 'Edit'> -->
                elseif ($_POST['submit'] == 'Edit') {
                    if ($value == 'category') {
                        $title = $_POST['title'];
                        $sql = "UPDATE `prices-category` SET title='{$title}' WHERE id='{$id}'";
                    } elseif ($value == 'item') {
                        $item = $_POST['item'];
                        $price = $_POST['price'];
                        $cat_id = $_POST['cats'];
                        $sql = "UPDATE `prices-items` SET item='{$item}', price='{$price}', id_category='{$cat_id}' WHERE id='{$id}'";
                    }
                    mysqli_query($mysql, $sql);
                    $_SESSION['status'] = "Title/item was changed!";
                    header('Location: admin.php');
                }
                ###<!-- </Submit 'Edit'> -->



                ###<!-- <Submit 'Add'> -->
                elseif ($_POST['submit'] == 'Add') {
                    if ($value == 'category') {
                        $title = $_POST['title'];
                        $sql = "INSERT INTO `prices-category` SET title='{$title}'";
                    } elseif ($value == 'item') {
                        $item = $_POST['item'];
                        $price = $_POST['price'];
                        $sql = "INSERT INTO `prices-items` SET item='{$item}', price='{$price}', id_category='{$id}'";
                    }
                    mysqli_query($mysql, $sql);
                    $_SESSION['status'] = "Title/item was added!";
                    header('Location: admin.php');
                }
                ###<!-- </Submit 'Add'> -->
            ###<!-- </Price Managing> -->
            ?>
            </div>
        <?php

        mysqli_close($mysql);
    }
        ?>
    </body>

    </html>