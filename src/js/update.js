let inProgress = false;

export default function(item) {
    item.style.cursor = 'text';
    item.focus();

    item.addEventListener('blur', function() {
        if (inProgress === false) {
            inProgress = true;
            request(item);
        }
    });

    item.addEventListener('keydown', function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            item.blur();
        }
    });
}

function request(item) {
    let id = item.parentElement.id;
    let text = item.value.trim();
    let xhr = new XMLHttpRequest();
    let json = JSON.stringify({
        "text": text
    });

    xhr.onreadystatechange = function() {
        if (this.readyState !== 4) return;

        if (this.status === 200) {
            inProgress = false;
            item.value = text;
            item.style.cursor = 'default';
        }
    };

    xhr.open('PUT', '/api/' + id);
    xhr.setRequestHeader('Content-type', 'application/json');
    xhr.send(json);
}