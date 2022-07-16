export function alert(message, type, editAlert) {

    let el = document.getElementById((editAlert) ? editAlert : 'alert');

    if(removeAlert(el)) {
        let wrapper = document.createElement('div')
        wrapper.innerHTML = '<div class="alert alert-' + type + ' alert-dismissible" role="alert">' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
        el.append(wrapper)

        setTimeout(function () {
            removeAlert(el);
        }, 5000);
    }
}
function removeAlert(el){
    if(el.firstChild) {
        while (el.firstChild) {
            el.removeChild(el.firstChild);
        }
    }
    return true;
}
