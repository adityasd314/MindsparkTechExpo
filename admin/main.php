<?php
require "../mycon.php";
require "../data.php";
$columns = ["id", "name", "phoneNumber", "project_name"];
$table_data = myConn::getDataByColumns("a@7", pdf_table, $columns);
print_r(json_encode($table_data));