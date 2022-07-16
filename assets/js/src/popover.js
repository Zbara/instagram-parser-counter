import { Popover } from 'bootstrap';


/*
Core popovers
 */
let popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
popoverTriggerList.map(function (popoverTriggerEl) {
	let options = {
		delay: {show: 5, hide: 5},
		html: popoverTriggerEl.getAttribute('data-bs-html') === "true" ?? false,
		placement: popoverTriggerEl.getAttribute('data-bs-placement') ?? 'auto'
	};
	return new Popover(popoverTriggerEl, options);
});