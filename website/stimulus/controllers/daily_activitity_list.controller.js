import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['project', 'type', 'description', 'time'];

    /**
     * @type {HTMLElement}
     */
    get projectTarget() {
        return this.targets.find('project');
    }

    /**
     * @type {HTMLElement}
     */
    get typeTarget() {
        return this.targets.find('type');
    }

    /**
     * @type {HTMLElement}
     */
    get descriptionTarget() {
        return this.targets.find('description');
    }

    /**
     * @type {HTMLElement}
     */
    get timeTarget() {
        return this.targets.find('time');
    }

    edit() {
        this.makeEditable(this.projectTarget, 'project');
        this.makeEditable(this.typeTarget, 'type');
        this.makeEditable(this.descriptionTarget, 'description');
        this.makeEditable(this.timeTarget, 'time');

        this.toggleActionButtons(true);
    }

    save() {
        const updatedData = {
            id: this.element.dataset.activityId,
            project: this.getInputValue(this.projectTarget),
            type: this.getInputValue(this.typeTarget),
            description: this.getInputValue(this.descriptionTarget),
            time: this.getInputValue(this.timeTarget),
        };

        fetch('/api/update-activity', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(updatedData),
        })
            .then((response) => {
                if (!response.ok) throw new Error('Failed to update activity');
                return response.json();
            })
            .then((data) => {
                this.updateField(this.projectTarget, data.project);
                this.updateField(this.typeTarget, data.type);
                this.updateField(this.descriptionTarget, data.description);
                this.updateField(this.timeTarget, data.time);

                this.makeReadonly(this.projectTarget);
                this.makeReadonly(this.typeTarget);
                this.makeReadonly(this.descriptionTarget);
                this.makeReadonly(this.timeTarget);

                this.toggleActionButtons(false);
            })
            .catch((error) => {
                console.error(error);
                alert('Failed to save changes.');
            });
    }

    /**
     * Видаляє активність.
     */
    delete() {
        if (confirm('Are you sure you want to delete this item?')) {
            const id = this.element.dataset.activityId;

            fetch(`/api/delete-activity/${id}`, { method: 'DELETE' })
                .then((response) => {
                    if (!response.ok) throw new Error('Failed to delete activity');
                    this.element.remove();
                })
                .catch((error) => {
                    console.error(error);
                    alert('Failed to delete item.');
                });
        }
    }

    add(event) {
        event.preventDefault();

        const currentUrl = window.location.href;

        const targetUrl = new URL('/add-activity', window.location.origin);
        targetUrl.searchParams.append('returnUrl', currentUrl); // Додаємо параметр returnUrl

        window.location.href = targetUrl.toString();
    }

    /**
     *
     * @param {HTMLElement} target - Елемент, який потрібно зробити редагованим.
     * @param {string} name - Ім'я для input.
     */
    makeEditable(target, name) {
        const value = target.textContent || '';
        target.innerHTML = `<input type="text" name="${name}" value="${value}" />`;
    }

    /**
     *
     * @param {HTMLElement} target
     */
    makeReadonly(target) {
        const input = target.querySelector('input');
        if (input) target.textContent = input.value;
    }

    /**
     *
     * @param {HTMLElement} target - Елемент із input.
     * @returns {string} Значення input або текст елемента.
     */
    getInputValue(target) {
        const input = target.querySelector('input');
        return input ? input.value : target.textContent || '';
    }

    /**
     *
     * @param {HTMLElement} target
     * @param {string} value
     */
    updateField(target, value) {
        target.textContent = value;
    }

    /**
     * @param {boolean} editing
     */
    toggleActionButtons(editing) {
        const editButton = this.element.querySelector('[data-action="activity#edit"]');
        const saveButton = this.element.querySelector('[data-action="activity#save"]');

        if (editing) {
            editButton.style.display = 'none';
            saveButton.style.display = '';
        } else {
            editButton.style.display = '';
            saveButton.style.display = 'none';
        }
    }
}
