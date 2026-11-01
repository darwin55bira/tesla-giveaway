</main>
<footer class="site-footer">
    <div class="container">
        <div class="footer-brand">
            <img src="<?= e(baseUrl('assets/images/tesla-logo.png')) ?>" alt="Tesla" class="footer-logo">
        </div>
        <div class="footer-nav">
            <a href="<?= e(baseUrl('#giveaway')) ?>">Giveaway</a>
            <a href="<?= e(baseUrl('#info')) ?>">Info</a>
            <a href="<?= e(baseUrl('#instruction')) ?>">Instruction</a>
            <a href="<?= e(baseUrl('participate.php')) ?>">Participate</a>
            <a href="<?= e(baseUrl('transactions.php')) ?>">Transactions</a>
        </div>
        <div class="footer-badges">
            <span>🔒 SSL Secured</span>
            <span>🚗 Tesla Certified</span>
            <span>⚡ Electric Vehicle</span>
            <span>✅ 10,000+ Delivered</span>
            <span>🌐 Official Event</span>
        </div>
        <p class="footer-text">This is an official Tesla Motors global car giveaway event. Tesla is the world's leading electric vehicle manufacturer gifting brand new electric vehicles to participants worldwide.</p>
        <p class="footer-copy">© <?= date('Y') ?> Tesla Motors Official Giveaway. All rights reserved.</p>
    </div>
</footer>
<script>window.LIVE_TOASTS = <?= json_encode(liveToastData(), JSON_UNESCAPED_UNICODE) ?>;</script>
<script src="<?= e(baseUrl('assets/js/app.js')) ?>"></script>
</body>
</html>
