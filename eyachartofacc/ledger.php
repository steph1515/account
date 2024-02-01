<html>
    <head>
        <style>
            div {
                border: 1px solid black;
                padding: 30px;
                width: 50%;
                margin-left: 300px;
            }
        </style>
    </head>
    <body>
        <div>
        <form action=ledger.php method="get">
            Account No:
            <input type="text" name="txtacc" id="" readonly value='<?php echo $_GET["txtacc"]; ?>'> <br><br>
            Name:
            <input type="text" name="txtname" id="" readonly value='<?php echo $_GET["txtname"]; ?>'> <br><br>
            Description:
            <select name="txtdesc" id="" required>
                <option value="insurance">insurance</option>
                <option value="bills">bills</option>
                <option value="loan">loan</option>
            </select> <br><br>
            Amount:
            <input type="number" name="txtamount" id="" required>
            <input type="submit" value="Add"><br><br>
        </form>

        <a href=account.php><input type="button" value="Account"></a>

        <?php
        $conn=new mysqli('localhost','root','','dbprint');
        if(isset($_GET["txtdesc"])) {
            $balance=0;
            $result=$conn->query("SELECT * from tblledger where fldname='$_GET[txtname]'");

            while($row=$result->fetch_assoc()) {
                $balance=$row["fldbal"];
            }

            if ($_GET["txttype"] == "asset" || $_GET["txttype"] == "ownersEquity") {
                $balance = $balance + $_GET["txtamount"];
                $conn->query("INSERT INTO tblledger (fldname, fldacc, flddate, flddesc, flddebit, fldbal) VALUES ('$_GET[txtname]','','', '$_GET[txtdesc]', '$_GET[txtamount]', '$balance')");
            } else {
                $balance = $balance - $_GET["txtamount"];
                $conn->query("INSERT INTO tblledger (fldname, fldacc, flddate, flddesc, fldcredit, fldbal) VALUES ('$_GET[txtname]','','', '$_GET[txtdesc]', '$_GET[txtamount]', '$balance')");
            }

        }
        ?>

        <table align=center border=1 cellspacing=0 cellpadding=0 width="500px">
            <tr align=center>
                <td>Description</td>
                <td>Debit</td>
                <td>Credit</td>
                <td>Balance</td>
            </tr>

            <?php
           $result = $conn->query("SELECT * FROM tblledger WHERE fldname='$_GET[txtname]'");
           while ($row = $result->fetch_assoc()) {
                echo "<tr align=center>
                <td>$row[flddesc]</td>
                <td>$row[flddebit]</td>
                <td>$row[fldcredit]</td>
                <td>$row[fldbal]</td>
                </tr>";
            }
            ?>
        </table>
        </div>
    </body>
</html>