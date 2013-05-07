<?php
	header('Access-Control-Allow-Origin: *');
	include('../libs/mpdf/mpdf.php');

   	$resumeHTML = $_GET['resumeHTML'];
    $mpdf = new mPDF('utf-8', 'A4');
    $mpdf->WriteHTML($resumeHTML);
    $mpdf->Output();
    echo $resumeHTML;
    exit;
?>