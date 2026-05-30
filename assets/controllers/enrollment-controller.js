import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["collectionHolder", "section", "prompt"];
    static values = {
        index: Number,
        prototype: String
    }

    connect() {
        this.index = this.collectionHolderTarget.children.length > 0
            ? parseInt(this.collectionHolderTarget.dataset.index)
            : 0;

        if (this.collectionHolderTarget.children.length > 0) {
            this.showSection();
        }
    }

    add(event) {
        if (event) event.preventDefault();

        this.showSection();

        const content = this.prototypeValue.replace(/__name__/g, this.index);

        const item = document.createElement('li');
        item.classList.add('border', 'rounded', 'p-3', 'mb-3', 'bg-light', 'position-relative');
        item.innerHTML = content;

        // Bouton de suppression
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.classList.add('btn-close', 'position-absolute', 'top-0', 'end-0', 'm-2', 'remove-child');
        removeBtn.setAttribute('aria-label', 'Close');
        removeBtn.addEventListener('click', (e) => this.remove(e));

        item.appendChild(removeBtn);

        this.collectionHolderTarget.appendChild(item);
        this.index++;
    }

    showNewChildForm(event) {
        if (event) event.preventDefault();
        this.add();
    }

    remove(event) {
        if (event) event.preventDefault();
        event.target.closest('li').remove();

        if (this.collectionHolderTarget.children.length === 0) {
            this.hideSection();
        }
    }

    showSection() {
        this.sectionTarget.style.display = 'block';
        if (this.hasPromptTarget) {
            this.promptTarget.style.display = 'none';
        }
    }

    hideSection() {
        this.sectionTarget.style.display = 'none';
        if (this.hasPromptTarget) {
            this.promptTarget.style.display = 'block';
        }
    }
}
