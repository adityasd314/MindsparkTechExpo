<?php
require "mycon.php";
require "data.php";
$file_name = "myPDFFIleFromBlob.pdf";
$dir = "./temp/";
$file_path = $dir . $file_name;
$table_data = myConn::getDataByColumns("a@7", pdf_table, ["id"]);
$blob_index = 2;

$primary_key = $_REQUEST['k'];
$p = 0;
// print_r($table_data);
foreach ($table_data as $i) {
    // print_r($i);
    if ($i[0] == $primary_key) {
        $row_index = $p;
        break;
    }
    $p++;
}
$table_data = myConn::getData("a@7", pdf_table);

$pdf_blob = $table_data[$row_index][$blob_index];


header("Content-type: application/pdf");
header('Content-disposition: inline; filename=".pdf"');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');
header('Content-Length: ' . strlen($pdf_blob));

echo $pdf_blob;