export default function(item) {
    let id = item.parentElement.id;
    let xhr = new XMLHttpRequest();
    let json = JSON.stringify({
        "complete": 1
    });

    xhr.onreadystatechange = function() {
        if (this.readyState !== 4) return;

        if (this.status === 200) {
            item.className = 'task__check';
            item.innerHTML = '<i class="far fa-check-circle"></i>';
            item.nextElementSibling.style.textDecoration = 'line-through';
            item.nextElementSibling.style.color = '#cfe5d9';
        }
    };

    xhr.open('PUT', '/api/' + id);
    xhr.setRequestHeader('Content-type', 'application/json');
    xhr.send(json);
}