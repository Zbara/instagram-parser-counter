import {sprintf} from "sprintf-js";
import TomSelect from 'tom-select';

function empty(e) {
    switch (e) {
        case "":
        case 0:
        case 0:
        case "0":
        case null:
        case false:
        case typeof (e) == "undefined":
            return true;
        default:
            return false;
    }
}

function butloading(e, d, text) {
    if (d) {
        e.innerHTML = '<div style="width:87px;text-align:center;">' +
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' +
            '<span class="sr-only">Отправка...</span>' +
            '</div>';
        e.disabled = true;
    } else {
        e.innerHTML = text;
        e.disabled = false;
    }
}


function dump(el){
    console.log(el);
}

function generateTableRow(object, el, name) {
    let tr = document.createElement('tr');

    tr.setAttribute(name, object.id)

    object.option = '';

    for (let z in object) {
        let td = document.createElement('td');
        td.innerHTML = object[z];

        tr.appendChild(td);
    }
    el.insertBefore(tr, el.children[0])
}


function declOfNum(number, words) {
    number = (number) ? number : 0;

    return sprintf(words[(number % 100 > 4 && number % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][(number % 10 < 5) ? Math.abs(number) % 10 : 5]], number);
}

function redirect(url) {
    document.location.href = url;
}

function TomSelectInit() {
    const el = document.querySelectorAll('select');

    el.forEach(function (value, key, parent) {
        new TomSelect("#" + value.id, {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    });
}

//TomSelectInit();

export {empty, butloading, generateTableRow, declOfNum, redirect, TomSelectInit, dump}
