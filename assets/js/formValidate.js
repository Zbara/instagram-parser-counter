import {empty} from "./src/libs";
import {alert} from "./src/alert";

class FormValidate {
    static advanceSetting(e, block) {
        const selector = document.querySelector(block);

        if (parseInt(e.target.value) === 2) {
            selector.classList.remove('d-none');
        } else selector.classList.add("d-none");
    }

    static isError(el) {
        el.addEventListener("input", function (e) {
            if (e.target.nextElementSibling.style.display === 'block') {
                e.target.nextElementSibling.style.display = 'none';
            }
        });
    }

    static setErrorInputMsg(i) {
        let el = typeof i == 'string' ? document.querySelector('[name="' + i + '"]') : document.querySelector(i);

        if (el) {
            el.style.background = '#ffefef';
            el.focus();

            setTimeout(function () {
                el.style.background = '#fff';
                el.focus();
            }, 700);
        }
    }

    static isValid(formData, ignore = []) {
        const error = [];

        formData.forEach(function (v, k, f) {
            if (empty(v) && !ignore[k]) {
                error.push(k)
                FormValidate.setErrorInputMsg(k)
            }
        });
        return error.length === 0;
    }

    static getErrorForm(error, event) {
        if (typeof error === 'object') {
            Object.keys(error).forEach(function (key) {
                event.querySelector('#' + key).style.display = 'block';
                event.querySelector('#' + key).textContent = error[key][0];

            });
        } else alert(error, 'danger')
    }
}

export {FormValidate}
