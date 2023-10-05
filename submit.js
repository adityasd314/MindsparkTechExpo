
const submitBtn = document.querySelector("#submit_btn");
const requestURL = "submit.php";
const requestMethod = "POST";

// validateData();
const sendData = () => {
    const data = validatedData();
    if (data == -1) {
        return null;
    }
    const formData = new FormData(form1);
    const { name, contact, pdfFile } = data;
    formData.append("pdf_file", pdfFile);
    formData.append("name", name);
    formData.append("contact", contact);

    $.ajax({
        url: requestURL,
        method: requestMethod,
        data: formData
        , processData: false,
        contentType: false,
        success: (response) => {
            alert(response);
            form1.reset();
        }
    });
}
submitBtn.addEventListener("click", function (e) {
    hiddenSubmit.click();
    const validated = [...form1.elements].every((x) => x.validity.valid)
    if (!validated) return;
    sendData();
});


hiddenSubmit.onsubmit = ((e) => {
    e.preventDefault();
    console.log(' :>> ',);

});