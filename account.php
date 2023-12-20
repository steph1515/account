<html>
    <body>
        <form action=account.php method="get">
            Account No.
            <input type="text" name="txtacc" id=""> <br><br>
            Name:
            <input type="text" name="txtname" id=""> <br><br>
            <input type="submit" value="Save"><br><br>
        </form>

        <?php
        $conn=new mysqli('localhost','root','','dbaccount');

        if(isset($_GET["txtacc"])) {
            $conn->query("INSERT into tblaccount (fldacc,fldname) values ('$_GET[txtacc]','$_GET[txtname]')");
        }elseif(isset($_GET["txtdelid"])) {
            $conn->query("DELETE from tblaccount where id=$_GET[txtdelid]");
        }

        $result=$conn->query("SELECT * from tblaccount");
        echo "<table border=1 cellpadding=0 cellspacing=0>
        <tr>
        <td></td>
        <td>Account No.</td>
        <td>Name</td>
        </tr>";

        while($row=$result->fetch_assoc()) {
            echo"<tr>
            <td><a href=account.php?txtdelid=$row[id]> X </a></td>
            <td><a href=ledger.php?txtacc=$row[fldacc]&txtname=$row[fldname]> $row[fldacc] </a></td>
            <td> $row[fldname] </td>
            </tr>";
        }
        echo "</table>"
        ?>
    </body>
</html>