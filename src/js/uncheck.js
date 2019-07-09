export default function(item) {
    let id = item.parentElement.id;
    let xhr = new XMLHttpRequest();
    let json = JSON.stringify({
        "status": 0
    });

    xhr.onreadystatechange = function() {
        if (this.readyState !== 4) return;

        if (this.status === 200) {
            item.className = 'task__uncheck';
            item.innerHTML = '<i class="fas fa-check-circle"></i>';
            item.nextElementSibling.style.textDecoration = 'none';
            item.nextElementSibling.style.color = '#000000';
        }
    };

    xhr.open('PUT', '/api/' + id);
    xhr.setRequestHeader('Content-type', 'application/json');
    xhr.send(json);
}