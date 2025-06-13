function getJSP(url, div, before, after, popup, formData = null) {
    if (before) before();
    const contentDiv = document.getElementById(div);

    if (!contentDiv) {
        console.error(`Element with ID "${div}" not found.`);
        return;
    }

    contentDiv.innerHTML = "<i class=\"fa fa-spinner fa-spin\"></i>";

    let options = {
        method: formData ? 'POST' : 'GET',  // Ако има податоци, користи POST
        headers: formData ? {} : {
            'Content-Type': 'application/json'
        },
        body: formData ? formData : null
    };

    fetch(url, options)
        .then(response => {
            console.log("Response Status:", response.status);
            if (!response.ok) throw new Error(`Error: ${response.status}`);
            return response.text();
        })
        .then(data => {
            if (popup === 1) {
                contentDiv.style.display = "block";
            }

            $(contentDiv).html(data); // Вметни го враќаниот HTML во `div`
            if (after) after();
        })
        .catch(error => {
            console.error("Fetch Error:", error);
            contentDiv.innerHTML = error.message;
        });
}
