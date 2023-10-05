<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    print_r($_POST);
    print_r($_FILES);
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    print("$name, $contact");
    // Accessing the uploaded file (if any)
    if (isset($_FILES['formData']) && $_FILES['formData']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['formData']['tmp_name'];
        $file_name = $_FILES['formData']['name'];

        // Move the uploaded file to a desired directory
        move_uploaded_file($tmp_name, 'uploads/' . $file_name);
    }

    // Process the data as needed
    // ...

    // Send a response back to the AJAX request
    echo 'Data received successfully';
} else {
    echo 'Invalid request method';
}
?>