function procesareDateRdf4j(dateRdf4j) {
    tinta = document.getElementById("tinta");
    table = document.createElement('table');
    thead = document.createElement('thead');
    headerRow = document.createElement('tr');
    headers = ['Nume Pozitie', 'Descriere Pozitie', 'Data Postarii', 'Data Expirarii', 'Tip Contract', 'Nume Firma', 'Adresa'];
    headers.forEach(function (header) {
        th = document.createElement('th');
        th.textContent = header;
        headerRow.appendChild(th);
    });
    thead.appendChild(headerRow);
    table.appendChild(thead);
    tbody = document.createElement('tbody');
    dateRdf4j.forEach(function (o) {
        if (o['@type'] && o['@type'] == 'https://schema.org/JobPosting') {
            for (let i = 0; i < o['https://schema.org/hiringOrganization'].length; i++) {
                row = document.createElement('tr');
                tdNumePozitie = document.createElement('td');
                tdNumePozitie.textContent = o['https://schema.org/title'][0]['@value'];
                tdDescriere = document.createElement('td');
                tdDescriere.textContent = o['https://schema.org/description'][0]['@value'];
                tdDataPostarii = document.createElement('td');
                tdDataPostarii.textContent = o['https://schema.org/datePosted'][0]['@value'];
                tdDataExpirarii = document.createElement('td');
                tdDataExpirarii.textContent = o['https://schema.org/validThrough'][0]['@value'];
                tdTipContract = document.createElement('td');
                tdTipContract.textContent = o['https://schema.org/employmentType'][0]['@value'];
                firmaObj = dateRdf4j.find(x => x['@id'] === o['https://schema.org/hiringOrganization'][i]['@id']);
                tdNumeFirma = document.createElement('td');
                tdNumeFirma.textContent = firmaObj['https://schema.org/name'][0]['@value'];
                tdAdresa = document.createElement('td');
                tdAdresa.textContent = firmaObj['https://schema.org/address'][0]['@value']
                row.appendChild(tdNumePozitie);
                row.appendChild(tdDescriere);
                row.appendChild(tdDataPostarii);
                row.appendChild(tdDataExpirarii);
                row.appendChild(tdTipContract);
                row.appendChild(tdNumeFirma);
                row.appendChild(tdAdresa);
                tbody.appendChild(row);
            }
        }
    });
    table.appendChild(tbody);
    tinta.appendChild(table);
    butonToGraphql = document.createElement('input');
    butonToGraphql.setAttribute('type', 'button');
    butonToGraphql.setAttribute('onclick', 'trimiteDateGraphql(' + JSON.stringify(dateRdf4j) + ')');
    butonToGraphql.setAttribute('value', 'Trimite date la GraphQL');
    document.getElementById('tinta').appendChild(br);
    document.getElementById('tinta').appendChild(butonToGraphql);
}
function preiaDateRdf4j() {
    axios.get("http://127.0.0.1:8000/getRdf4j")
        .then((response) => {
            procesareDateRdf4j(response.data);
            console.log( 'Datele de pe serverul RDF4J au fost preluate cu succes.' );
        })
        .catch((error) => console.log(error));
}
function trimiteCatreRdf4j(date) {
    firmeValue = document.getElementById('firme').value;
    adresaValue = document.getElementById('adresa').value;
    pozitieValue = document.getElementById('title').value;
    if ( !firmeValue ) {
        alert( 'Te rog introdu o firma!' );
    }
    if ( !adresaValue ) {
        alert( 'Te rog introdu o adresa!' );
    }
    if ( firmeValue && adresaValue ) {
        pozitieToAppend = date['@graph'].find(job => job['title'] === pozitieValue);
        jsonToAppend = {
            "@type": "Organization",
            "@id": "x:" + firmeValue.toLowerCase(),
            "name": firmeValue,
            "address": adresaValue
        };
        pozitieToAppend.hiringOrganization.push(jsonToAppend);
        axios.post("http://127.0.0.1:8000/sendToRdf4j", date)
            .then((response) => {
                butonGetRdf4j = document.createElement('input');
                butonGetRdf4j.setAttribute('type', 'button');
                butonGetRdf4j.setAttribute('onclick', 'preiaDateRdf4j()');
                butonGetRdf4j.setAttribute('value', 'Preia date de la RDF4J');
                document.getElementById('tinta').appendChild(br);
                document.getElementById('tinta').appendChild(butonGetRdf4j);
                console.log( 'Datele catre serverul RDF4J au fost trimise cu succes.' );
            })
            .catch((error) => console.log(error));
    }
}