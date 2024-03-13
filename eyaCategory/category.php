<html>
    <head>
        <style>
            .category-button {
            display: inline-block;
            padding: 13px 13px;
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
        <a href="category.php"><input type="button" value="Category" class="category-button"></a>
        <a href="product.php"><input type="button" value="Product" class="category-button"></a><br><Br>
        <form action="category.php" method="get">
            Category Name: <br>
            <input type="text" name="txtcategory" required>
            <input type="submit" value="Add">
        </form><br>

        <table border=1 cellspacing=0 width=200px>
            <tr align=center>
                <th></th>
                <th>Category</th>
            </tr>
            <?PHP
            $conn = new mysqli("localhost", "root", "" ,"dbdelivery");

            if (isset($_GET['txtcategory'])) {
                $conn->query("insert into tblcategory (fldcategory) values ('$_GET[txtcategory]')");
            } elseif (isset($_GET['txtdelid'])) {
                $conn->query("delete from tblcategory where id = '$_GET[txtdelid]'");
            }

            $result=$conn->query("select * from tblcategory");
            while ($row=$result->fetch_assoc()) {
                echo "<tr align=center>
                <td><a href=category.php?txtdelid=$row[id]>X</a></td>
                <td>$row[fldcategory]</td>
                </tr>";
            }
            ?>
        </table>
    </body>
</html>
