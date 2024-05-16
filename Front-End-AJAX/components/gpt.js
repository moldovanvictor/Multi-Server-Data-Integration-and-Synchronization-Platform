function trimiteDateAi(dateCatreAi) {
    document.getElementById('loading-icon').style.display = 'block';
    axios.post("http://127.0.0.1:8000/sendToAi", dateCatreAi)
        .then((response) => {
            var textBox = document.createElement('div');
            textBox.innerText = response['data'];
            var tinta = document.getElementById('tinta');
            tinta.appendChild(textBox);
            console.log( 'Datele catre OpenAI au fost trimise cu succes.' );
        })
        .catch((error) => console.log(error))
        .finally(() => {
            document.getElementById('loading-icon').style.display = 'none';
        });
}