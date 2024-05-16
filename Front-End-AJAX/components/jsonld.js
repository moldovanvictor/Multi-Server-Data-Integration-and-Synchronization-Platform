br = document.createElement('br');
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

function procesareRaspuns(date) {
    createFirstTable(date);
    createFirstForm(date);
    console.log( 'Datele JSON-LD au fost scrapate cu succes.' );
}
function cerere() {
    axios.get( "http://127.0.0.1:8000/jsonLdScraping" )
        .then((response) => {
            procesareRaspuns( response['data'] );
        })
        .catch((error) => console.log( error ));
}