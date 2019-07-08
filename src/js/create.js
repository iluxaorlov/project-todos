export default function() {
    let text = document.getElementById('form__text').value.trim();
    let xhr = new XMLHttpRequest();
    let json = JSON.stringify({
        "text": text
    });

    xhr.onreadystatechange = function() {
        if (this.readyState !== 4) return;

        if (this.status === 201) {
            if (this.responseText) {
                document.getElementById('form__text').value = '';
                document.getElementById('form__text').blur();
                insert(this.responseText);
            }
        }
    };

    xhr.open('POST', '/api');
    xhr.setRequestHeader('Content-type', 'application/json');
    xhr.send(json);
}

function insert(json) {
    let object = JSON.parse(json);
    let task = document.createElement('div');
    task.id = object.id;
    task.className = 'task';
    document.getElementById('tasks').insertAdjacentElement('beforeend', task);

    insertCheck(task);
    insertText(task, object);
    insertDestroy(task);
}

function insertCheck(task) {
    let check = document.createElement('div');
    check.className = 'task__uncheck';
    check.innerHTML = '<i class="far fa-circle"></i>';
    task.insertAdjacentElement('beforeend', check);
}

function insertText(task, object) {
    let text = document.createElement('textarea');
    text.className = 'task__text';
    text.rows = 1;
    text.value = object.text;
    task.insertAdjacentElement('beforeend', text);
}

function insertDestroy(task) {
    let destroy = document.createElement('div');
    destroy.className = 'task__destroy';
    destroy.innerHTML = '<i class="fas fa-times"></i>';
    task.insertAdjacentElement('beforeend', destroy);
}