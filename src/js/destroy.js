export default function(item) {
    let id = item.parentElement.id;
    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (this.readyState !== 4) return;

        if (this.status === 200) {
            item.parentElement.remove();
        }
    };

    xhr.open('DELETE', '/api/' + id);
    xhr.setRequestHeader('Content-type', 'application/json');
    xhr.send();
}