<html>
    <head>

    </head>
    <body>
        <table>
            <?php
             $conn = new mysqli("localhost", "root", "" ,"dbdelivery");
             $result=$conn->query("SELECT from tblcategory order by fldcategory");
             while ($row=$result->fetch_assoc()){
                $category-strtoupper($row["fldcategory"]);
                echo <tr><td><input type="button" value='$category' class=mycat onclick=display($row[id])></td></tr>
             }
             echo <tr><td><input type="button" value='' class=mycat onclick=display(0)></td></tr>;
        </table>
    </body>
</html>