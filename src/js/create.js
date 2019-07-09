import autosize from './autosize';

export default function() {
    let text = document.getElementById('form__text').value.trim();
    let xhr = new XMLHttpRequest();
    let json = JSON.stringify({
        "text": text
    });

    xhr.onreadystatechange = function() {
        if (this.readyState !== 4) return;

        if (this.status === 200) {
            if (this.responseText) {
                let formText = document.getElementById('form__text');
                formText.value = '';
                formText.style.height = '19px';
                formText.blur();
                formText.focus();
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
    let text = insertText(task, object);
    insertDestroy(task);
    autosize(text);
}

function insertCheck(task) {
    let check = document.createElement('div');
    check.className = 'task__uncheck';
    check.innerHTML = '<i class="fas fa-check-circle"></i>';
    task.insertAdjacentElement('beforeend', check);
}

function insertText(task, object) {
    let text = document.createElement('textarea');
    text.className = 'task__text';
    text.rows = 1;
    text.value = object.text;
    task.insertAdjacentElement('beforeend', text);

    return text;
}

function insertDestroy(task) {
    let destroy = document.createElement('div');
    destroy.className = 'task__destroy';
    destroy.innerHTML = '<i class="fas fa-times-circle"></i>';
    task.insertAdjacentElement('beforeend', destroy);
}