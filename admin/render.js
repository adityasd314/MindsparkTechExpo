
const comp = (elementName, options) => {
    const element = document.createElement(elementName);
    for (const option in options) {
        if (Object.hasOwnProperty.call(options, option)) {
            const value = options[option];
            element[option] = value;
        }
    }
    return element
}

const displayData = (data) => {
    const tbody = document.getElementById("dataTable");
    for (const row of data) {
        const tr = comp("tr");
        row.forEach((cell) => {
            const td = comp("td", { innerText: cell });
            tr.append(td);
        })
        tbody.append(tr);
    }
    [...tbody.rows].forEach((x) => {
        const ID = x.firstElementChild.innerText;
        const td = comp("td");
        const output = "pdf_writer.php";
        const a = comp("a", { href: `../${output}?k=${ID}`, innerText: "File" })
        td.append(a);
        x.append(td);
    })
}