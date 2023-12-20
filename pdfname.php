<?PHP
require('fpdf.php');
$conn=new mysqli("localhost", "root", "", "dbaccount");
$pdf = new FPDF('L','mm', 'Letter');
$pdf->SetAutoPageBreak(true, 5);
$pdf->AddPage();

$pdf->setxy(120,60);
$pdf->SetFont('Arial', 'B',12);
$pdf->cell(0,0,'Transaction', 0,0,'');

$pdf->setxy(70,70);
$pdf->SetFont('Arial', 'B',9);
$pdf->Cell(20,5,"Date",1,0,'C');
$pdf->Cell(50,5,"Description",1,0, 'C');
$pdf->Cell(20,5,"Debit",1,0, 'C');
$pdf->Cell(20,5, "Credit",1,0, 'C');
$pdf->Cell(20,5,"Balance",1,0, 'C');

$result = $conn->query("SELECT * FROM tblledger WHERE fldacc='$_GET[txtacc]'");
$row = $result->fetch_assoc();
$accountNumber = $row["fldacc"];

$resultAccount = $conn->query("SELECT * FROM tblaccount WHERE fldacc='$accountNumber'");
$rowAccount = $resultAccount->fetch_assoc();
$accountName = $rowAccount["fldname"];

$pdf->setxy(70,50);
$pdf->SetFont('Arial', 'B', 12) ;
$pdf->Cell(0, 0, 'Account Number: ' . $accountNumber, 0, 0, "L");
$pdf->Ln();
$pdf->setxy(70,55);
$pdf->Cell(0, 0, 'Account Name: ' . $accountName, 0, 1, "L");


$pdf->sety(75);
$pdf->SetFont('Arial', '',9);
$result=$conn->query("SELECT * FROM tblledger WHERE fldacc='$_GET[txtacc]'");

while($row=$result->fetch_assoc()){
    $pdf->setx(70);
    $pdf->Cell(20,5,$row["flddate"],1,0,'C');
    $pdf->Cell(50,5,$row["flddesc"],1,0, 'C');
    $pdf->Cell(20,5,$row["flddebit"],1,0, 'C');
    $pdf->Cell(20,5, $row["fldcredit"],1,0, 'C');
    $pdf->Cell(20,5,$row["fldbal"],1,1, 'C');
}

$pdf->Output();
?>