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
            // Use prepared statements and proper table name
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
        </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr align=center>
            <td><a href=account.php?txtdelname=$row[fldname]> <button> X </button> </a>
            <a href=ledger.php?txtname=$row[fldname]> <button> Ledger </button</td>
            <td> $row[fldname] </td>
            <td> $row[fldtype] </td>
            </tr>";
        }
        
        echo "</table>";
        ?>
        </div>
    </body>
</html>