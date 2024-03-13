<!DOCTYPE html>
<html>
<head>
    <style>
        .nav {
            margin-bottom: 20px;
        }
        .container {
            display: flex;
            flex-direction: row;
        }
        .categories {
            margin-right: 20px;
        }
        .detail {
            margin-top: 25px;
        }
        .details {
            border: 1px solid black;
            padding: 20px;
            padding-bottom: 0;
        }
        .table {
            margin-left: 30px;
            margin-top: 25px;
            text-align:center;
        }
        .category-button {
            display: inline-block;
            padding: 10px 10px;
            background-color: gray;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .category-button:hover {
            background-color: darkgray;
        }
    </style>
</head>
<body>
    <div class="nav">
    <a href="category.php" class="category-button">Category</a>
    <a href="product.php" class="category-button">Product</a>
</div>

<div class="container">
    <div class="categories">
    <h2>Category</h2>
        <?php
        $conn = new mysqli("localhost", "root", "", "dbdelivery");
        $result = $conn->query("SELECT DISTINCT fldcategory FROM tblcategory");

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<a href='product.php?txtcategory=$row[fldcategory]' class='category-button'>$row[fldcategory]</a><br><br>";
            }
        }
        ?>
    </div>

    <?php
    $selectedCategory = isset($_GET['txtcategory']) ? htmlspecialchars($_GET['txtcategory']) : '';

    if (!empty($selectedCategory)) {
        ?>
       <div class="detail">
            <form action="product.php" method="get">
                <input type="text" name="txtcategory" readonly value="<?php echo $selectedCategory; ?>" style="width:255px; border:3px black solid;text-align:center;">

                <div class="details">
                Code:
                <input type="text" name="txtcode" value="<?php echo isset($_GET['txtcode']) ? htmlspecialchars($_GET['txtcode']) : ''; ?>" required><br><br>
                Name:
                <input type="text" name="txtname" value="<?php echo isset($_GET['txtname']) ? htmlspecialchars($_GET['txtname']) : ''; ?>" required><br><br>
                Price:
                <input type="number" name="txtprice" value="<?php echo isset($_GET['txtprice']) ? htmlspecialchars($_GET['txtprice']) : ''; ?>" required><br><br>
                Stocks:
                <input type="number" name="txtstocks" value="<?php echo isset($_GET['txtstocks']) ? htmlspecialchars($_GET['txtstocks']) : ''; ?>" required><br><br>
                <input type="submit" value="Add">
            </form><br><br>
        </div>
    </div>
        <div class="table">
            <table border=1 cellspacing=0 width=300px>
                <tr>
                    <th></th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stocks</th>
                </tr>
                <?php
                $conn = new mysqli("localhost", "root", "", "dbdelivery");

                if (isset($_GET['txtcategory'], $_GET['txtcode'])) {
                    $conn->query("insert into tblproduct (fldcode,fldname,fldprice,fldstocks,fldcategory) values ('$_GET[txtcode]','$_GET[txtname]','$_GET[txtprice]','$_GET[txtstocks]','$_GET[txtcategory]')");
                } elseif (isset($_GET['txtdelid'])) {
                    $conn->query("DELETE from tblproduct where id = '$_GET[txtdelid]'");
                }

                $result = $conn->query("SELECT * FROM tblproduct WHERE fldcategory = '$selectedCategory'");
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                        <td><a href=product.php?txtdelid=$row[id]&txtcategory=$row[fldcategory]>X</a></td>
                        <td>$row[fldcode]</td>
                        <td>$row[fldname]</a></td>
                        <td>$row[fldprice]</td>
                        <td>$row[fldstocks]</td>
                        </tr>";
                    }
                }
                ?>
            </table>
        </div>
        <?php
    }
    ?>
</div>

</body>
</html>
