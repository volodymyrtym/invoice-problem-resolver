import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    //todo

    goBack() {
        const params = new URLSearchParams(window.location.search);
        const returnUrl = params.get('returnUrl');

        if (returnUrl) {
            window.location.href = returnUrl;
        } else {
            alert('No return URL specified.');
        }
    }
}
