const requestURL = "main.php";
const passkey = "a@7";
const requestMethod = "POST";
const loadData = function () {
    $.ajax({
        url: requestURL,
        method: requestMethod,
        data: { pass: passkey }
        , processData: false,
        contentType: false,
        success: (response) => {
            const data = JSON.parse(response);
            displayData(data);
        }
    });

}