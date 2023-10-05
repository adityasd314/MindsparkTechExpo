<?php
if (!empty($_FILES['pdf_file']['name'])) {
    //a $_FILES 'error' value of zero means success. Anything else and something wrong with attached file.
    if ($_FILES['pdf_file']['error'] != 0) {
        echo 'Something wrong with the file.';
    } else { //pdf file uploaded okay.
        //project_name supplied from the form field
        $project_name = $_FILES['pdf_file']['name'];
        //attached pdf file information

        $file_name = $_FILES['pdf_file']['name'];
        $file_tmp = $_FILES['pdf_file']['tmp_name'];
        $file_size = $_FILES['pdf_file']['size'];
        $contact = $_POST['contact'];
        $name = $_POST['name'];
        if ($pdf_blob = fopen($file_tmp, "rb")) {
            try {
                require "mycon.php";
                require "data.php";
                $table_name = pdf_table;
                $pdo = myConn::connect("a@7");

                $insert_sql = "INSERT INTO `$table_name` (`project_name`, `pdf_doc`, `phoneNumber`, `name`) VALUES(:project_name, :pdf_doc, :phoneNumber, :candidate);";

                $stmt = $pdo->prepare($insert_sql);
                $stmt->bindParam(':project_name', $project_name);
                $stmt->bindParam(':pdf_doc', $pdf_blob, PDO::PARAM_LOB);
                $stmt->bindParam(':phoneNumber', $contact);
                $stmt->bindParam(':candidate', $name);
                if ($stmt->execute() === FALSE) {
                    echo 'Could not save information to the database';
                    // $errorInfo = $stmt->errorInfo();
                    // echo 'Could not save information to the database. Error: ' . $errorInfo[2];

                } else {
                    echo 'Information saved';
                }

            } catch (PDOException $e) {
                // echo 'Database Error ' . $e->getMessage() . ' in ' . $e->getFile() .
                // ': ' . $e->getLine();
            }
        } else {
            //fopen() was not successful in opening the .pdf file for reading.
            echo 'Could not open the attached pdf file';
        }
    }
} else {
    //submit button was not clicked. No direct script navigation.
    header('Location: choose_file.php');
}