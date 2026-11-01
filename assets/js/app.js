document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.getElementById('menuToggle');
    const mainNav = document.getElementById('mainNav');
    if (menuToggle && mainNav) {
        menuToggle.addEventListener('click', () => mainNav.classList.toggle('open'));
    }

    const countdown = document.getElementById('countdown');
    if (countdown) {
        let hours = parseInt(countdown.dataset.hours || '11', 10);
        let minutes = parseInt(countdown.dataset.minutes || '42', 10);
        let seconds = parseInt(countdown.dataset.seconds || '33', 10);

        const hEl = document.getElementById('cd-hours');
        const mEl = document.getElementById('cd-minutes');
        const sEl = document.getElementById('cd-seconds');

        const pad = (n) => String(n).padStart(2, '0');

        setInterval(() => {
            seconds--;
            if (seconds < 0) { seconds = 59; minutes--; }
            if (minutes < 0) { minutes = 59; hours--; }
            if (hours < 0) { hours = 11; minutes = 42; seconds = 33; }

            if (hEl) hEl.textContent = pad(hours);
            if (mEl) mEl.textContent = pad(minutes);
            if (sEl) sEl.textContent = pad(seconds);
        }, 1000);
    }

    const liveFeed = document.getElementById('liveFeed');
    if (liveFeed) {
        setInterval(async () => {
            try {
                const res = await fetch('api/live-feed.php');
                const data = await res.json();
                if (!data.deliveries) return;

                liveFeed.innerHTML = data.deliveries.map(item => `
                    <div class="feed-item">
                        <div class="feed-item-left">
                            <div class="feed-name">${item.name} ${item.country}</div>
                            <div class="feed-status">${item.car} · ${item.status}</div>
                        </div>
                        <div style="text-align:right">
                            <div class="feed-fee">$${item.fee}</div>
                            <div class="feed-time">${item.minutes_ago} min ago</div>
                        </div>
                    </div>
                `).join('');
            } catch (e) { /* silent */ }
        }, 30000);
    }

    initLiveToasts();
});

function initLiveToasts() {
    const container = document.getElementById('liveToastContainer');
    const toasts = window.LIVE_TOASTS || [];
    if (!container || !toasts.length) return;

    const shuffled = [...toasts].sort(() => Math.random() - 0.5);
    let index = 0;
    let hideTimer = null;
    let nextTimer = null;

    const escapeHtml = (str) => String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');

    const showToast = (item) => {
        container.innerHTML = `
            <div class="live-toast show">
                <div class="live-toast-inner">
                    <div class="live-toast-icon">✓</div>
                    <div class="live-toast-body">
                        <div class="live-toast-header">
                            <span class="live-toast-name">${escapeHtml(item.name)}</span>
                            <span class="live-toast-country">${escapeHtml(item.country)}</span>
                            <span class="fake-tag">FAKE</span>
                        </div>
                        <p class="live-toast-text">Just paid delivery fee for <span class="live-toast-car">${escapeHtml(item.car)}</span></p>
                        <p class="live-toast-status">Demo: scam sites invent pop-ups like this to pressure you.</p>
                    </div>
                </div>
                <div class="live-toast-progress"><div class="live-toast-progress-bar"></div></div>
            </div>
        `;
    };

    const hideToast = () => {
        const toast = container.querySelector('.live-toast');
        if (toast) {
            toast.classList.remove('show');
            toast.classList.add('hide');
            setTimeout(() => { container.innerHTML = ''; }, 300);
        }
    };

    const cycle = () => {
        showToast(shuffled[index % shuffled.length]);
        index++;
        hideTimer = setTimeout(hideToast, 4000);
        nextTimer = setTimeout(cycle, 6000 + Math.random() * 4000);
    };

    setTimeout(cycle, 2000);
}
