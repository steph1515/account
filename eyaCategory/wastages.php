<html>
    <body>
        
        <a href="product.php"><input type="button" value="Product"></a>
        <a href="delivery.php"><input type="button" value="Delivery"></a>
        <a href="transfer.php"><input type="button" value="Transfer"></a>
        <a href="wastages.php"><input type="button" value="Wastages"></a>
        <a href="pullout.php"><input type="button" value="Pull Out"></a><br>

        <h1>WASTAGES</h1>
        <form action="wastages.php" method="get">
            Date:
             <input type="date" name="txtdate" value="<?PHP echo date('Y-m-d') ?>"><br><br>
            Waste no.
             <input type="number" name="txtwaste"><br><br>
            Reason:
             <input type="text" name="txtreason"><br><br>
            Product: 
            <select name="txtproduct" required>
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
            <input type="submit" value="Add"><br><br>
        </form>
        <table border=1>
            <tr>
                <th>X</th>
                <th>Date</th>
                <th>Waste No.</th>
                <th>Reason</th>
                <th>Product</th>
                <th>Quantity</th>
            </tr>
            <?PHP
            $conn = new mysqli("localhost", "root", "" ,"dbdelivery");
            if (isset($_GET['txtproduct'])) {
                
                $balance=0;
                // Fetch current balance for the product
                $result = $conn->query("SELECT fldbalance FROM tblledger WHERE fldname = '$_GET[txtproduct]'");
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $balance = $row['fldbalance'];
                }
                $balance=$balance-$_GET["txtquantity"];

                $conn->query("insert into tblwastages (flddate,fldproduct,fldquantity,fldwasteno,fldreason) values ('$_GET[txtdate]','$_GET[txtproduct]','$_GET[txtquantity]','$_GET[txtwaste]','$_GET[txtreason]')");
                $conn->query("insert into tblledger (fldname,fldcode,fldtype,fldout,fldbalance) values ('$_GET[txtproduct]','$_GET[txtdate]','Wastages','$_GET[txtquantity]',$balance)");                
            } elseif (isset($_GET['txtdelid'])) {
                $conn->query("delete from tblwastages where id = '$_GET[txtdelid]'");
            }

            $result=$conn->query("select * from tblwastages");
            while ($row=$result->fetch_assoc()) {
                echo "<tr>
                <td><a href=wastages.php?txtdelid=$row[id]>X</a></td>
                <td>$row[flddate]</td>
                <td>$row[fldwasteno]</td>
                <td>$row[fldreason]</td>
                <td>$row[fldproduct]</td>
                <td>$row[fldquantity]</td>
                </tr>";
            }
            ?>
    </body>
</html>