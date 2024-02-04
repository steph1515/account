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
        <?php
        // Capture the account type from the GET parameter
        $accountType = isset($_GET["txttype"]) ? $_GET["txttype"] : '';
        ?>

        <form action="ledger.php" method="get">
            Account No:
            <input type="text" name="txtacc" id="" readonly value='<?php echo isset($_GET["txtacc"]) ? $_GET["txtacc"] : ''; ?>'> <br><br>
            Name:
            <input type="text" name="txtname" id="" readonly value='<?php echo isset($_GET["txtname"]) ? $_GET["txtname"] : ''; ?>'> <br><br>
            <input type="hidden" name="txttype" value='<?php echo isset($_GET["txttype"]) ? $_GET["txttype"] : ''; ?>'>
            Description:
            <select name="txtdesc" id="">
                <option value="insurance">insurance</option>
                <option value="loan">loan</option>
                <option value="payment">payment</option>
            </select> <br><br>
            Amount:
            <input type="number" name="txtamount" id="" required> <br><br>
            <input type="submit" value="Add"><br><br>
        </form>

        <a href="account.php"><input type="button" value="Account"></a>

        <?php
        $conn = new mysqli('localhost', 'root', '', 'dbprint');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if(isset($_GET["txtdesc"]) && isset($_GET["txtamount"]) && $_GET["txtamount"] > 0) {
            $balance = 0;
            $amount = $_GET["txtamount"];
            $description = $_GET["txtdesc"];
            $account = $_GET["txtacc"];
            
            // Fetch the last balance
            $result = $conn->query("SELECT fldbal FROM tblledger WHERE fldacc='$account' ORDER BY id DESC LIMIT 1");
            if($row = $result->fetch_assoc()) {
                $balance = $row["fldbal"];
            }

            // Decide on debit or credit based on the account type
            if($accountType == "asset" || $accountType == "ownersEquity") {
                $balance += $amount;
                $stmt = $conn->prepare("INSERT INTO tblledger (fldacc, flddesc, flddebit, fldbal) VALUES (?, ?, ?, ?)");
            } else {
                $balance -= $amount;
                $stmt = $conn->prepare("INSERT INTO tblledger (fldacc, flddesc, fldcredit, fldbal) VALUES (?, ?, ?, ?)");
            }

            $stmt->bind_param("ssdd", $account, $description, $amount, $balance);
            $stmt->execute();
            $stmt->close();
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
            $result = $conn->query("SELECT * FROM tblledger WHERE fldacc='" . $_GET["txtacc"] . "'");
            while ($row = $result->fetch_assoc()) {
                echo "<tr align=center>
                <td>{$row['flddesc']}</td>
                <td>{$row['flddebit']}</td>
                <td>{$row['fldcredit']}</td>
                <td>{$row['fldbal']}</td>
                </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
