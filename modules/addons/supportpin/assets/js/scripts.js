const supportPin = {
    init: function () {
        // Initialize support pin widgets.
        document.querySelectorAll('.supportpin-sidebar-widget').forEach(widget => {
            this.renderPin(widget);
        });
    },

    renderPin: function (widget) {
        const pin = widget.dataset.pin || '';
        const isVisible = widget.dataset.visible === 'true';
        const container = widget.querySelector('.supportpin-digits-container');

        container.innerHTML = '';

        for (let i = 0; i < pin.length; i++) {
            const digitBox = document.createElement('div');
            digitBox.className = 'supportpin-digit-box';

            const span = document.createElement('span');
            span.textContent = isVisible ? pin[i] : '•';

            digitBox.appendChild(span);
            container.appendChild(digitBox);
        }

        // Toggle visibility icon.
        const eyeIcon = widget.querySelector('.fa-eye, .fa-eye-slash');
        if (eyeIcon) {
            eyeIcon.className = isVisible ? 'fas fa-eye-slash' : 'fas fa-eye';
        }
    },

    toggleVisibility: function (event) {
        if (event) event.preventDefault();
        const widget = event.target.closest('.supportpin-sidebar-widget');

        const isVisible = widget.dataset.visible === 'true';
        widget.dataset.visible = !isVisible;

        this.renderPin(widget);
    },

    copyToClipboard: function (event) {
        if (event) event.preventDefault();
        const widget = event.target.closest('.supportpin-sidebar-widget');
        const pin = widget.dataset.pin;

        navigator.clipboard.writeText(pin).then(() => {
            const container = widget.querySelector('.supportpin-digits-container');
            const originalTitle = container.title;

            // Show copied feedback.
            container.classList.add('copied');

            setTimeout(() => {
                container.classList.remove('copied');
            }, 500);
        });
    },

    renew: function (event) {
        if (event) event.preventDefault();

        const widget = event.target.closest('.supportpin-sidebar-widget');
        if (!widget) return;

        const boxes = widget.querySelectorAll('.supportpin-digit-box');
        boxes.forEach(el => el.style.opacity = '0.5');

        fetch('index.php?m=supportpin&page=renew', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'PIN=true'
        })
            .then(response => response.json())
            .then(data => {
                widget.dataset.pin = data.PIN;
                this.renderPin(widget);
            })
            .catch(error => {
                console.error('Error renewing PIN:', error);
                boxes.forEach(el => el.style.opacity = '1');
                alert('Failed to renew PIN. Please try again.');
            });
    }
};

// Initialize on load.
document.addEventListener('DOMContentLoaded', () => {
    supportPin.init();
});
