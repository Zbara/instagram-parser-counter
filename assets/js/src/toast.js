import { Toast } from 'bootstrap';


let toastsTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="toast"]'));
toastsTriggerList.map(function (toastTriggerEl) {
	return new Toast(toastTriggerEl);
});

export function toast(title, messages){
	const toast = document.querySelector('.toast');


	toast.querySelector('.me-auto').innerHTML = title;
	toast.querySelector('.toast-body').innerHTML = messages;

	new Toast(document.querySelector('.toast')).show();
}
