<html>
    <body>
        
        <a href="product.php"><input type="button" value="Product"></a>
        <a href="delivery.php"><input type="button" value="Delivery"></a>
        <a href="transfer.php"><input type="button" value="Transfer"></a>
        <a href="wastages.php"><input type="button" value="Wastages"></a>
        <a href="pullout.php"><input type="button" value="Pull Out"></a><br><br>

        <h1>History</h1>
    <table border=1>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>In</th>
                <th>Out</th>
                <th>Balance</th>
            </tr>
            <?PHP
            $conn = new mysqli("localhost", "root", "" ,"dbdelivery");
    
            $result=$conn->query("select * from tblledger where fldname='$_GET[txtname]'");
            while ($row=$result->fetch_assoc()) {
                echo "<tr>
                <td>$row[fldcode]</td>
                <td>$row[fldtype]</td>
                <td>$row[fldin]</td>
                <td>$row[fldout]</td>
                <td>$row[fldbalance]</td> 
                </tr>";
            }
            ?>
        </table>
    </body>
</html>