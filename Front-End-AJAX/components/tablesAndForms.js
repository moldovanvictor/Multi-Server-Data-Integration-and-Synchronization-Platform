function createFirstTable(date) {
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
    date['@graph'].forEach(function (job) {
        row = document.createElement('tr');
        tdNumePozitie = document.createElement('td');
        tdNumePozitie.textContent = job.title;
        tdDescriere = document.createElement('td');
        tdDescriere.textContent = job.description;
        tdDataPostarii = document.createElement('td');
        tdDataPostarii.textContent = job.datePosted;
        tdDataExpirarii = document.createElement('td');
        tdDataExpirarii.textContent = job.validThrough;
        tdTipContract = document.createElement('td');
        tdTipContract.textContent = job.employmentType;
        row.appendChild(tdNumePozitie);
        row.appendChild(tdDescriere);
        row.appendChild(tdDataPostarii);
        row.appendChild(tdDataExpirarii);
        row.appendChild(tdTipContract);
        tbody.appendChild(row);
        job.hiringOrganization.forEach(function (firma) {
            tdNumeFirma = document.createElement('td');
            tdNumeFirma.textContent = firma.name;
            tdAdresa = document.createElement('td');
            tdAdresa.textContent = firma.address;
            row.appendChild(tdNumeFirma);
            row.appendChild(tdAdresa);
        });
    });
    table.appendChild(tbody);
    tinta.appendChild(table);
}
function createFirstForm(date) {
    form = document.createElement('form');
    form.setAttribute('id', 'toRdf4j');
    form.setAttribute('method', 'POST');
    labelName = document.createElement('label');
    labelName.setAttribute('for', 'firme');
    labelName.textContent = 'Nume Firma:   ';
    form.appendChild(labelName);
    inputFirme = document.createElement('input');
    inputFirme.setAttribute('type', 'text');
    inputFirme.setAttribute('name', 'firme');
    inputFirme.setAttribute('id', 'firme');
    form.appendChild(inputFirme);
    form.appendChild(document.createElement('br'));
    labelAddress = document.createElement('label');
    labelAddress.setAttribute('for', 'adresa');
    labelAddress.textContent = "Adresa Firma:   ";
    form.appendChild(labelAddress);
    inputAddress = document.createElement('input');
    inputAddress.setAttribute('type', 'text');
    inputAddress.setAttribute('name', 'adresa');
    inputAddress.setAttribute('id', 'adresa');
    form.appendChild(inputAddress);
    labelPozitie = document.createElement('label');
    labelPozitie.setAttribute('for', 'title');
    labelPozitie.textContent = 'Pozitie:   ';
    form.appendChild(document.createElement('br'));
    form.appendChild(labelPozitie);
    dropdownPozitie = document.createElement('select');
    dropdownPozitie.setAttribute('id', 'title');
    date['@graph'].forEach(function (pozitie) {
        option = document.createElement('option');
        option.text = pozitie.title;
        dropdownPozitie.add(option);
    });
    form.appendChild(dropdownPozitie);
    form.appendChild(document.createElement('br'));
    toRdfBUtton = document.createElement('input');
    toRdfBUtton.setAttribute('type', 'button');
    toRdfBUtton.setAttribute('onclick', 'trimiteCatreRdf4j(' + JSON.stringify(date) + ')');
    toRdfBUtton.setAttribute('value', 'Trimite Catre RDF4J');
    form.appendChild(toRdfBUtton);
    tinta.appendChild(form);
}

function createLastTable(dateGraphQl) {
    tinta = document.getElementById('tinta');
    tinta.appendChild(br);
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
    for (index in dateGraphQl['allJobPostings']) {
        for (let i = 0; i < dateGraphQl['allJobPostings'][index]['hiringOrganization'].length; i++) {
            row = document.createElement('tr');
            tdNumePozitie = document.createElement('td');
            tdNumePozitie.textContent = dateGraphQl['allJobPostings'][index]['title'];
            tdDescriere = document.createElement('td');
            tdDescriere.textContent = dateGraphQl['allJobPostings'][index]['description'];
            tdDataPostarii = document.createElement('td');
            tdDataPostarii.textContent = dateGraphQl['allJobPostings'][index]['datePosted'];
            tdDataExpirarii = document.createElement('td');
            tdDataExpirarii.textContent = dateGraphQl['allJobPostings'][index]['validThrough'];
            tdTipContract = document.createElement('td');
            tdTipContract.textContent = dateGraphQl['allJobPostings'][index]['employmentType'];
            tdNumeFirma = document.createElement('td');
            tdNumeFirma.textContent = dateGraphQl['allJobPostings'][index]['hiringOrganization'][i]['name'];
            tdAdresa = document.createElement('td');
            tdAdresa.textContent = dateGraphQl['allJobPostings'][index]['hiringOrganization'][i]['address'];
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
    table.appendChild(tbody);
    tinta.appendChild(table);
    butonToAi = document.createElement('input');
    butonToAi.setAttribute('type', 'button');
    butonToAi.setAttribute('onclick', 'trimiteDateAi(' + JSON.stringify(dateGraphQl) + ')');
    butonToAi.setAttribute('value', 'Trimite date la OpenAI');
    document.getElementById('tinta').appendChild(br);
    document.getElementById('tinta').appendChild(butonToAi);
}