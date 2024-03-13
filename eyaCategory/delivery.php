<html>
    <body>
                
        <a href="product.php"><input type="button" value="Product"></a>
        <a href="delivery.php"><input type="button" value="Delivery"></a>
        <a href="transfer.php"><input type="button" value="Transfer"></a>
        <a href="wastages.php"><input type="button" value="Wastages"></a>
        <a href="pullout.php"><input type="button" value="Pull Out"></a><br><br>

        <h1>Delivery</h1>
        <form action="delivery.php" method="get">
            Delivery Code:
            <input type="text" name="txtcode" required><br><br>
            Supplier:
            <input type="text" name="txtsupplier"><br><br>
            Date:
            <input type="date" name="txtdate"  value="<?PHP echo date('Y-m-d')?>"><br><br>
            Product: 
            <select name="txtproduct">
                <?PHP
                $conn = new mysqli("localhost", "root", "" ,"dbdelivery");

                $result = $conn->query("SELECT * from tblproduct");
                while($row=$result->fetch_assoc()){
                    echo "<option value=$row[fldname]>$row[fldname]</option>";
                }
                ?>
            </select><br><br>
            Quantity:
            <input type="number" name="txtquantity"><br><br>
            <input type="submit" value="Add" name="txtdelivery"><br><br>
        </form>

        <table border=1>
            <tr>
                <th>X</th>
                <th>Date</th>
                <th>Delivery Code</th>
                <th>Supplier</th>
                <th>Product</th>
                <th>Qty</th>
            </tr>
            <?PHP
            $conn = new mysqli("localhost", "root", "" ,"dbdelivery");

//here            
            // In delivery.php
            if (isset($_GET['txtcode'])) {
                $balance = 0;
                // Fetch current balance for the product
                $result = $conn->query("SELECT fldbalance FROM tblledger WHERE fldname = '$_GET[txtproduct]'");
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $balance = $row['fldbalance'];
                }
                // Add delivered quantity to the current balance
                $balance += $_GET["txtquantity"];

                // Update tblledger with new balance
                $conn->query("INSERT INTO tbldelivery (fldcode,fldsupplier,flddate,fldproduct,fldquantity) VALUES ('$_GET[txtcode]','$_GET[txtsupplier]','$_GET[txtdate]','$_GET[txtproduct]','$_GET[txtquantity]')");
                $conn->query("INSERT INTO tblledger (fldname,fldcode,fldtype,fldin,fldbalance) VALUES ('$_GET[txtproduct]','$_GET[txtdate]','Delivery','$_GET[txtquantity]',$balance)");
            }
//here

            $result=$conn->query("select * from tbldelivery");
            while ($row=$result->fetch_assoc()) {
                echo "<tr>
                <td><a href=delivery.php?txtdelid=$row[fldcode]>X</a></td>
                <td>$row[flddate]</td>
                <td>$row[fldcode]</td>
                <td>$row[fldsupplier]</td>
                <td>$row[fldproduct]</td>
                <td>$row[fldquantity]</td>
                </tr>";
            }
            ?>
        </table>
    </body>
</html>