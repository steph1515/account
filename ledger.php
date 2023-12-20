<html>
    <body>
        <a href=account.php><input type="button" value="Account"></a>
        <form action=ledger.php method="get">
            Account No:
            <input type="text" name="txtacc" id="" readonly value='<?php echo $_GET["txtacc"]; ?>'> <br><br>
            Name:
            <input type="text" name="txtname" id="" readonly value='<?php echo $_GET["txtname"]; ?>'> <br><br>
            Date:
            <input type="date" name="txtdate" id=""> <br><br>
            Type:
            <select name="txttype" id="">
                <option value="debit">debit</option>
                <option value="credit">credit</option>
            </select> <br><br>
            Description:
            <input type="text" name="txtdesc" id=""> <br><br>
            Amount:
            <input type="text" name="txtamount" id="" required><br><br>
            <input type="submit" value="Add"><br><br>
        </form>

        <?php
        $conn=new mysqli('localhost','root','','dbaccount');
        if(isset($_GET["txttype"])) {
            $balance=0;
            $result=$conn->query("SELECT * from tblledger where fldacc='$_GET[txtacc]' order by id desc limit 1");

            while($row=$result->fetch_assoc()) {
                $balance=$row["fldbal"];
            }

            if($_GET["txttype"]=="debit") {
                $balance=$balance+$_GET["txtamount"];
                $conn->query("INSERT into tblledger (fldacc,flddate,flddesc,flddebit,fldbal) values ('$_GET[txtacc]','$_GET[txtdate]','$_GET[txtdesc]','$_GET[txtamount]','$balance')");
            }else {
                $balance=$balance-$_GET["txtamount"];
                $conn->query("INSERT into tblledger (fldacc,flddate,flddesc,fldcredit,fldbal) values ('$_GET[txtacc]','$_GET[txtdate]','$_GET[txtdesc]','$_GET[txtamount]','$balance')");
            }
        }
        ?>

        <?php
        echo "<a href=/finals/fpdf186/pdf.php?txtacc=$_GET[txtacc]><input type=button value=Print></a>";
        ?>

        <table border=1 cellspacing=0 cellpadding=0 width="500px">
            <tr align=center>
                <td>Date</td>
                <td>Description</td>
                <td>Debit</td>
                <td>Credit</td>
                <td>Balance</td>
            </tr>

            <?php
            $result=$conn->query("SELECT * from tblledger where fldacc='$_GET[txtacc]'");
            while($row=$result->fetch_assoc()) {
                echo "<tr align=center>
                <td>$row[flddate]</td>
                <td>$row[flddesc]</td>
                <td>$row[flddebit]</td>
                <td>$row[fldcredit]</td>
                <td>$row[fldbal]</td>
                </tr>";
            }
            ?>
        </table>
    </body>
</html>