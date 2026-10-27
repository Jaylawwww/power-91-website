import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        timezone: { type: String, default: 'Asia/Manila' },
        withZone: { type: Boolean, default: false },
    };

    connect() {
        this.tick();
        this.timer = setInterval(() => this.tick(), 1000);
    }

    disconnect() {
        clearInterval(this.timer);
    }

    tick() {
        const options = {
            timeZone: this.timezoneValue,
            hour: 'numeric',
            minute: '2-digit',
            second: '2-digit',
            hour12: true,
        };

        if (this.withZoneValue) {
            options.timeZoneName = 'short';
        }

        this.element.textContent = new Intl.DateTimeFormat('en-US', options).format(new Date());
    }
}
