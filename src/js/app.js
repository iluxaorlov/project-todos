import '../scss/app.scss';
import create from './create';
import check from './check';
import uncheck from './uncheck';
import destroy from './destroy';
import update from './update';
import autosize from './autosize';

document.getElementById('form__text').addEventListener('input', function() {
    autosize(this);
});

document.getElementById('form__text').addEventListener('keydown', function(event) {
    if (event.keyCode === 13) {
        event.preventDefault();
        create();
    }
});

document.getElementById('tasks').addEventListener('click', function(event) {
    let item = event.target;

    while (item !== this) {
        if (item.className === 'task__check') {
            uncheck(item);
        }

        if (item.className === 'task__uncheck') {
            check(item);
        }

        if (item.className === 'task__text') {
            update(item);
        }

        if (item.className === 'task__destroy') {
            destroy(item);
        }

        item = item.parentElement;
    }
});

document.getElementById('tasks').addEventListener('input', function(event) {
    let item = event.target;

    while (item !== this) {
        if (item.className === 'task__text') {
            autosize(item);
        }

        item = item.parentElement;
    }
});

for (let item of document.getElementsByClassName('task__text')) {
    autosize(item);
}