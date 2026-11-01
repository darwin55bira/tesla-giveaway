</main>
<footer class="site-footer">
    <div class="container">
        <div class="footer-brand">
            <span class="text-logo">⚡ <?= e($settings['brand']) ?></span>
        </div>
        <div class="footer-nav">
            <a href="<?= e(baseUrl('#giveaway')) ?>">Giveaway</a>
            <a href="<?= e(baseUrl('#info')) ?>">Info</a>
            <a href="<?= e(baseUrl('#instruction')) ?>">Instruction</a>
            <a href="<?= e(baseUrl('participate.php')) ?>">Participate</a>
        </div>
                <p class="footer-text">This site is a scam-awareness demonstration. VoltDrive is a fictional brand, every testimonial, "live" delivery and notification on it is fake, and no payment is ever requested or accepted. It is not affiliated with any car maker. Real giveaways never ask winners to pay a fee.</p>
        <p class="footer-copy">Scam-awareness demo · not a real giveaway</p>
    </div>
</footer>
<script>window.LIVE_TOASTS = <?= json_encode(liveToastData(), JSON_UNESCAPED_UNICODE) ?>;</script>
<script src="<?= e(baseUrl('assets/js/app.js')) ?>"></script>
</body>
</html>
