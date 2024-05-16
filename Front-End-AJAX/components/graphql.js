function preiaDateGraphQl() {
    obiectInterogare = {
        query: "{ allJobPostings { title description datePosted validThrough employmentType hiringOrganization } }"
    }
    textInterogare = JSON.stringify(obiectInterogare);
    axios.post("http://127.0.0.1:8000/getGraphQl", textInterogare)
        .then((response) => {
            createLastTable(response['data']['data']);
            console.log( 'Datele de pe serverul GraphQl au fost preluate cu succes.' );
        })
        .catch((error) => console.log(error));
}
function trimiteDateGraphql(dateGraphQl) {
    axios.post("http://127.0.0.1:8000/sendToGraphQl", dateGraphQl)
        .then((response) => {
            butonGetGraphql = document.createElement('input');
            butonGetGraphql.setAttribute('type', 'button');
            butonGetGraphql.setAttribute('onclick', 'preiaDateGraphQl()');
            butonGetGraphql.setAttribute('value', 'Preia date de la GraphQL');
            document.getElementById('tinta').appendChild(br);
            document.getElementById('tinta').appendChild(butonGetGraphql);
            console.log( 'Datele catre serverul GraphQl au fost trimise  cu succes.' );
        })
        .catch((error) => console.log(error));
}