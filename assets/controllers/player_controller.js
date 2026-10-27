import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['audio', 'button', 'status', 'title', 'host'];
    static values = {
        nowPlayingUrl: String,
    };

    connect() {
        this.playing = false;
        this.refreshNowPlaying();
        this.timer = setInterval(() => this.refreshNowPlaying(), 60000);
    }

    disconnect() {
        clearInterval(this.timer);
    }

    toggle() {
        if (!this.hasAudioTarget || !this.audioTarget.src) {
            this.setStatus('Stream is offline');
            return;
        }

        if (this.playing) {
            this.audioTarget.pause();
            this.playing = false;
            this.setButton('Listen live');
            this.setStatus('Paused');
            return;
        }

        this.audioTarget.play()
            .then(() => {
                this.playing = true;
                this.setButton('On air — pause');
                this.setStatus('Streaming');
            })
            .catch(() => {
                this.playing = false;
                this.setButton('Listen live');
                this.setStatus('Could not start the stream');
            });
    }

    ended() {
        this.playing = false;
        this.setButton('Listen live');
        this.setStatus('Stream ended');
    }

    error() {
        this.playing = false;
        this.setButton('Listen live');
        this.setStatus('Stream unavailable');
    }

    async refreshNowPlaying() {
        if (!this.nowPlayingUrlValue) {
            return;
        }

        try {
            const response = await fetch(this.nowPlayingUrlValue, {
                headers: { Accept: 'application/json' },
            });
            if (!response.ok) {
                return;
            }

            const data = await response.json();
            if (this.hasTitleTarget) {
                this.titleTarget.textContent = data.title;
            }
            if (this.hasHostTarget) {
                this.hostTarget.textContent = `${data.host} · ${data.window}`;
            }
        } catch {
            // Keep the server-rendered fallback if the poll fails.
        }
    }

    setButton(text) {
        if (this.hasButtonTarget) {
            this.buttonTarget.textContent = text;
        }
    }

    setStatus(text) {
        if (this.hasStatusTarget) {
            this.statusTarget.textContent = text;
        }
    }
}
