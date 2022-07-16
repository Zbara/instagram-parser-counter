import {Ajax} from "./Ajax";
import {toast} from "./src/toast"
import {alert} from "./src/alert";
import {FormValidate} from "./formValidate";
import {butloading, generateTableRow} from "./src/libs";

export class FormEdit extends Ajax {
    static edit(el) {
        this.post(el.dataset.editPath, this.formData({}), {
            onDone: function (result) {
                document.querySelector('.edit-model').innerHTML = result.edit;

                new bootstrap.Modal(document.getElementById('exampleModalToggle')).show();
                const model = document.querySelector('#modelEdit');


                if (model) {
                    model.addEventListener('submit', (event) => {
                        event.preventDefault();

                        FormEdit.save(event, model.getAttribute('action'));
                    });
                    FormValidate.isError(model);
                }
            },
            onFail: function (error) {
                toast('Ошибка', error.messages);
            }
        });
    }

    static save(event, action) {
        let formData = new FormData(event.target);
        formData.append('save', 1);

        this.post(action, formData, {
            onDone: function (result) {
                alert(result.messages, 'success', 'editAlert')
            },
            onFail: function (error) {
                FormValidate.getErrorForm(error.messages, event.target);
            },
            showProgress: function () {
                butloading(event.submitter, true)
            },
            hideProgress: function () {
                butloading(event.submitter, false, 'Изменить')
            }
        });
    }
}

new FormEdit();
