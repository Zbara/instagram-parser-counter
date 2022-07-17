import {Ajax} from "./Ajax";
import {toast} from "./src/toast"
import {alert} from "./src/alert";
import {FormValidate} from "./formValidate";
import {butloading, generateTableRow} from "./src/libs";

class Instagram extends Ajax {
    constructor() {
        const parseForm = document.querySelector('#parseForm')

        if (parseForm) {
            parseForm.addEventListener('submit', (event) => {
                event.preventDefault();

                Instagram.parse(event);
            });
            FormValidate.isError(parseForm);
        }
        super();
    }
    static parse(event) {
        let formData = new FormData(event.target);
        let table = document.querySelector('#parseInstagram');

        if (FormValidate.isValid(formData)) {
            this.post('/parse', formData, {
                onDone: function (result) {
                    event.target.reset();

                    table.insertAdjacentHTML(
                        "afterbegin", result.html);

                    alert(result.messages, 'success')
                },
                onFail: function (error) {
                    FormValidate.getErrorForm(error.messages, event.target);
                },
                showProgress: function () {
                    butloading(event.submitter, true)
                },
                hideProgress: function () {
                    butloading(event.submitter, false, 'Добавить')
                }
            });
        }
    }
}

new Instagram();
