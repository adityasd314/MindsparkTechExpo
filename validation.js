const isValidContact = /[0-9]{10}/;
const allowedFiles = ["pdf"];
const MAX_FILE_SIZE_MB = 16;
const MAX_FILE_SIZE = MAX_FILE_SIZE_MB * 1024 * 1024;
const isValidData = (name, contact) => {
    if (!isValidContact.test(contact)) {
        alert("Enter a valid contact");
    }
    return name.length > 0 && isValidContact.test(contact);
}
const isAllowedFile = (fileType) => {


    return allowedFiles.some((x) => fileType.includes(x));
}
const isAllowedSize = (fileSize) => {
    return fileSize < MAX_FILE_SIZE;
}
const isValidFile = () => {
    return file_input.files.length > 0 && [...file_input.files].every(file => {
        const a = isAllowedFile(file.type);
        const b = isAllowedSize(file.size);
        if (!a)
            alert("file type should be one of the allowed type\nAllowed types: " + allowedFiles.join(", "));
        if (!b)
            alert("file size should be less than " + MAX_FILE_SIZE_MB + " MBs");

        return isAllowedFile(file.type) && isAllowedSize(file.size)
    })
}
const validatedData = () => {
    const data = collectData();

    const { name, contact, file } = data;
    if (!isValidFile())
        return -1;
    const pdfFile = file.files[0];
    let isValid = isValidData(name, contact);

    if (isValid && isValidFile()) {
        return { name, contact, pdfFile };
    } else {
        return -1;
    }
}
const collectData = () => {
    const [name, college, contact, productName, productDesc] = [candidate_name, college_name, phone_number, product_name, product_desc].map((x) => x.value.trim());
    console.log('name :>> ', name);
    const file = file_input;
    return { name, college, contact, productName, productDesc, file };
};
[...form1.elements].forEach((x) => {
    if (x.type != "file")
        x.onblur = function () { x.value = x.value.trim() }
})