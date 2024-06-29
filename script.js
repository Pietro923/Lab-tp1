document.getElementById('calculadoraForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var method = document.getElementById('method').value;
    var url = 'http://localhost/tp1/calculadora.php';
    var params = {};

    if (method === 'GET') {
        url += '?num1=' + encodeURIComponent(document.getElementById('num1').value) + '&num2=' + encodeURIComponent(document.getElementById('num2').value);
    } else {
        params.method = method;
        params.headers = { 'Content-Type': 'application/json' };
        params.body = JSON.stringify({ num1: document.getElementById('num1').value, num2: document.getElementById('num2').value });
    }

    fetch(url, params)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('resultado').innerText = JSON.stringify(data);
            document.getElementById('resultado').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
        });
});