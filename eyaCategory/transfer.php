<html>
        <body>
                    
            <a href="product.php"><input type="button" value="Product"></a>
            <a href="delivery.php"><input type="button" value="Delivery"></a>
            <a href="transfer.php"><input type="button" value="Transfer"></a>
            <a href="wastages.php"><input type="button" value="Wastages"></a>
            <a href="pullout.php"><input type="button" value="Pull Out"></a><br><br>

            <h1>Wastages</h1>
            <form action="wastages.php" method="get">
                Date:
                 <input type="date" name="txtdate" value="<?PHP echo date('Y-m-d')?>"><br><br>
                 Wastage No:
                 <input type="text" name="txtwasteno" value=""><br><br>
                 Reason:
                 <input type="text" name="txtreason" value=""><br><br>
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
                <input type="submit" value="Add" name="txtdelivery"><br><br>
            </form>
            <table border=1>
                <tr>
                    <th>X</th>
                    <th>Date</th>
                    <th>Wastage No.</th>
                    <th>Reason</th>
                    <th>Product</th>
                    <th>Quantity</th>
                </tr>
                <?PHP
                $conn = new mysqli("localhost", "root", "" ,"dbdelivery");
                
    //here            
                // In wastage.php
                if (isset($_GET['txtproduct'])) {
                    $balance = 0;
                    // Fetch the most recent balance for the product, ensure you have a column that can order the entries by recency
                    $result = $conn->query("SELECT fldbalance FROM tblledger WHERE fldname = '$_GET[txtproduct]' ORDER BY id DESC LIMIT 1");
                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $balance = $row['fldbalance'];
                    }
                    // Subtract wastage quantity from the current balance
                    $newBalance = $balance - $_GET["txtquantity"];
                
                    // Insert into tblwastages with wastage details
                    $conn->query("INSERT INTO tblwastages (flddate,fldwasteno,fldreason,fldproduct,fldquantity) VALUES ('$_GET[txtdate]','$_GET[txtwasteno]','$_GET[txtreason]','$_GET[txtproduct]','$_GET[txtquantity]')");
                
                    // Insert a new ledger entry to reflect the wastage (assuming this is the desired approach)
                    $conn->query("INSERT INTO tblledger (fldname,fldcode,fldtype,fldout,fldbalance) VALUES ('$_GET[txtproduct]','$_GET[txtdate]','Wastage','$_GET[txtquantity]',$newBalance)");
                }
                else if (isset($_GET['txtdelid'])) {
                    $conn->query("DELETE from tblwastages where id = '$_GET[txtdelid]'");
                }
    //here

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
            </table>
        </body>
    </html>