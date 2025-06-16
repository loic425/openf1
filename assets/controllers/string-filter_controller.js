import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
    static values = {
        formName: String
    }

    updateUrl(event) {
        const value = event.target.value;
        const url = new URL(window.location.href);

        const name = this.formNameValue || '';

        if (!name) {
            return;
        }

        url.searchParams.set(name, value);

        history.pushState({}, '', url);
    }
}
