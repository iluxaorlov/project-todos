document.getElementById('form').addEventListener('submit', function(e) {
    e.preventDefault();

    let xhr = new XMLHttpRequest();
    let text = document.getElementById('text').value;
    let json = JSON.stringify({
        "text": text
    });

    xhr.onreadystatechange = function() {
        if (this.readyState !== 4) return;

        if (this.status === 201) {
            if (this.responseText) {
                insert(this.responseText);
            }
        }
    };

    xhr.open('POST', '/api');
    xhr.setRequestHeader('Content-type', 'application/json');
    xhr.send(json);
});

function insert(response) {
    let object = JSON.parse(response);
    let item = document.createElement('p');
    item.id = object.id;
    item.innerText = object.text;
    document.getElementById('tasks').insertAdjacentElement('beforeend', item);
}

document.getElementById('tasks').addEventListener('click', function(e) {
    let element = e.target;

    if (element.className === 'task__complete') {
        complete(element);
    }

    function complete(element) {
        let id = element.parentElement.id;
        let xhr = new XMLHttpRequest();
        let json = JSON.stringify({
            "complete": 1
        });

        xhr.onreadystatechange = function() {
            if (this.readyState !== 4) return;

            if (this.status === 200) {
                element.innerText = 'v';
            }
        };

        xhr.open('PUT', '/api/' + id);
        xhr.setRequestHeader('Content-type', 'application/json');
        xhr.send(json);
    }
});

document.getElementById('tasks').addEventListener('click', function(e) {
    let element = e.target;

    if (element.className === 'task__delete') {
        complete(element);
    }

    function complete(element) {
        let id = element.parentElement.id;
        let xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (this.readyState !== 4) return;

            if (this.status === 204) {
                element.parentElement.remove();
            }
        };

        xhr.open('DELETE', '/api/' + id);
        xhr.setRequestHeader('Content-type', 'application/json');
        xhr.send();
    }
});