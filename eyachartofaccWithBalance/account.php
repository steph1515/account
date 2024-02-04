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
        <div align=center>
        <form action="account.php" method="get">
            Account Name
            <input type="text" name="txtname" id="" required> <br><br>
            Type:
            <select name="txttype" id="" required>
                <option value="asset">asset</option>
                <option value="liability">liability</option>
                <option value="ownersEquity">owner's equity</option>
            </select> <br><br>
            <input type="submit" value="Add">
        </form>

        <?php
        $conn = new mysqli('localhost','root','','dbprint');
        if(isset($_GET["txtname"])) {
            $conn->query("INSERT into tblaccountchart(fldname, fldtype) values ('$_GET[txtname]','$_GET[txttype]')");
        }elseif(isset($_GET["txtdelname"])){
            $stmt = $conn->prepare("DELETE from tblaccountchart where fldname=?");
            $stmt->bind_param("s", $_GET['txtdelname']);
            $stmt->execute();
            $stmt->close();
        }
        

        $result=$conn->query("SELECT * from tblaccountchart");
        echo "<table align=center border=1 cellpadding=0 cellspacing=0 width=500px height=50px>
        <tr align=center>
        <th></th>
        <th>Account Name</th>
        <th>Type</th>
        <th>Balance</th>
        </tr>";
        while ($row = $result->fetch_assoc()) {
            $accountName = $row['fldname'];

            // Fetch the total balance for the account from ledger entries
            $balanceResult = $conn->query("SELECT fldbal FROM tblledger WHERE fldname='$accountName' ORDER BY id DESC LIMIT 1");
            $totalBalance = 0;
            if ($balanceRow = $balanceResult->fetch_assoc()) {
                $totalBalance = $balanceRow['fldbal'];
            }


        echo "<tr align=center>
        <td><a href=account.php?txtdelname=".$row['fldname']."> <button> X </button> </a>
        <a href=ledger.php?txtacc=".$row['id']."&txtname=".$row['fldname']."&txttype=".$row['fldtype']."> <button> Ledger </button></td>
        <td> ".$row['fldname']." </td>
        <td> ".$row['fldtype']." </td>
        <td> ".$totalBalance." </td>
        </tr>";
        }
        
        echo "</table>";
        ?>
        </div>
    </body>
</html>