<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';

$settings = loadSettings();
$testimonials = generateTestimonials();
$comments = generateCommentTestimonials();
$liveFeed = generateLiveDeliveries($settings);

$pageTitle = $settings['site_title'] . ' — Official Giveaway';
require __DIR__ . '/includes/header.php';
?>

<div class="trust-bar">
    <div class="container">
        <span>✅ Verified Official Event</span>
        <span>🔒 256-bit SSL Secured</span>
        <span>📜 Smart Contract Powered</span>
        <span>💰 10,000+ Paid Out</span>
    </div>
</div>

<section class="hero" id="giveaway">
    <div class="container hero-grid">
        <div class="hero-content">
            <div class="hero-badges">
                <span class="hero-badge hero-badge-live"><span class="pulse-dot"></span> Official Event</span>
                <span class="hero-badge hero-badge-joined">LIVE — <?= number_format($settings['participant_count']) ?> joined</span>
            </div>
            <h1>Win a <span class="text-red">Brand New</span> Tesla Electric Car</h1>
            <p>Tesla, the world's leading electric vehicle manufacturer, is giving away brand new electric cars to participants worldwide. Claim your car today!</p>
            <div class="hero-actions">
                <a href="participate.php" class="btn btn-lg">🚗 Claim Your Free Car →</a>
                <a href="#cars" class="btn btn-lg btn-outline">View All Models</a>
            </div>
            <div class="hero-tags">
                <span>🔒 SSL Secured</span>
                <span>✅ Verified</span>
                <span>🌍 Global</span>
            </div>
        </div>
        <div class="hero-visual">
            <div class="hero-card">
                <?= carImageHtml('model3', 'Tesla Electric Car') ?>
                <div class="hero-card-overlay">
                    <span class="hero-card-title">Tesla Electric Car</span>
                    <span class="hero-card-sub">100% Free — Just Pay Delivery</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-alt" id="info">
    <div class="container">
        <div class="section-header">
            <h2>Available Tesla Cars</h2>
            <p>Choose your preferred Tesla electric car. All models are brand new <strong>2024–2025</strong> editions delivered straight to your door.</p>
        </div>
        <div class="car-grid-sm">
            <?php foreach (array_slice($settings['cars'], 0, 4) as $car): ?>
            <div class="car-card-sm">
                <div class="car-card-sm-img">
                    <?= carImageHtml($car['image'], $car['name']) ?>
                    <span class="car-card-sm-tag"><?= e($car['sm_badge'] ?? $car['badge']) ?></span>
                </div>
                <div class="car-card-sm-body">
                    <h3><?= e($car['name']) ?> <?= e($car['year']) ?></h3>
                    <div class="type"><?= e($car['category'] ?? $car['type']) ?></div>
                    <div class="specs"><?= e(carSpecLine($car)) ?></div>
                    <span class="free-badge">FREE 🎉</span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Official Announcement</span>
            <h2>Tesla's Global Car Giveaway</h2>
            <p>Watch Tesla's official announcement of their biggest car giveaway for all countries worldwide.</p>
        </div>
        <div class="video-section">
            <div class="video-card">
                <?= youtubeEmbedHtml('official') ?>
                <div class="video-meta">
                    <div class="video-channel">
                        <?= channelAvatarHtml() ?>
                        <div>
                            <div class="channel-name">Tesla Official</div>
                            <div class="channel-subs">28.4M subscribers</div>
                        </div>
                    </div>
                    <div class="video-actions">
                        <button>Subscribe</button>
                        <button>👍 1.2M</button>
                        <button>Share</button>
                        <button>Download</button>
                    </div>
                </div>
                <div class="comments"><p style="padding:0 0 12px;font-size:13px;color:var(--gray)">Comments · 70,842</p></div>
            </div>
            <div class="video-card">
                <h3 class="video-card-title">More Proof from Winners</h3>
                <p class="video-card-sub">Watch real testimonials from Tesla car recipients around the world.</p>
                <?= youtubeEmbedHtml('testimonials') ?>
                <div class="video-meta">
                    <div class="video-channel">
                        <?= channelAvatarHtml() ?>
                        <div>
                            <div class="channel-name">Tesla Global</div>
                            <div class="channel-subs">12.8M subscribers</div>
                        </div>
                    </div>
                    <p class="video-comments-label">Comments · 75,600</p>
                </div>
                <div class="comments" id="commentFeed">
                    <?php foreach ($comments as $c): ?>
                    <div class="comment">
                        <div class="comment-avatar"><?= e($c['initials']) ?></div>
                        <div class="comment-body">
                            <div class="comment-author"><?= e($c['name']) ?> <?= e($c['country']) ?> · <?= e((string)$c['days_ago']) ?> day<?= $c['days_ago'] > 1 ? 's' : '' ?> ago</div>
                            <div class="comment-text"><?= e($c['text']) ?></div>
                            <div class="comment-likes">👍 <?= number_format($c['likes']) ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <h2>Straight from the CEO</h2>
            <p>Official announcements from Tesla's leadership</p>
        </div>
        <div class="ceo-section">
            <div class="ceo-card">
                <div class="ceo-profile">
                    <div class="ceo-avatar">EM</div>
                    <div>
                        <div style="font-weight:600">Elon Musk</div>
                        <div style="font-size:13px;color:var(--gray)">CEO, Tesla, Inc.</div>
                    </div>
                </div>
                <p class="ceo-text">Tesla is committed to accelerating the world's transition to sustainable energy. As part of our mission, we're launching a worldwide giveaway of our electric vehicles — completely free. Just cover the delivery cost and a brand-new Tesla will be shipped directly to your door. 🚗⚡</p>
                <div class="tweet-stats"><span>❤️ 128K</span><span>🔁 47K</span><span>💬 8.2K</span></div>
            </div>
            <div class="tweet-card">
                <div class="ceo-profile">
                    <?= channelAvatarHtml() ?>
                    <div>
                        <div style="font-weight:600">Tesla Official</div>
                        <div style="font-size:13px;color:var(--gray)">@Tesla · Official Account</div>
                    </div>
                </div>
                <p class="ceo-text">📢 OFFICIAL ANNOUNCEMENT: Our global Tesla car giveaway is NOW LIVE! 🌍 Open to ALL countries. No purchase necessary — just cover the one-time delivery fee. Model 3, Model Y, Model S, Model X and more available. Don't miss out! 🎁🚗</p>
                <div class="tweet-stats"><span>❤️ 215K</span><span>🔁 89K</span><span>💬 14K</span></div>
            </div>
        </div>
    </div>
</section>

<section class="section" id="testimonials">
    <div class="container">
        <div class="section-header">
            <h2>What Winners Are Saying</h2>
            <p>Real testimonials from verified Tesla car recipients</p>
        </div>
        <div class="testimonials-grid" id="testimonialsGrid">
            <?php foreach ($testimonials as $t): ?>
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <div class="testimonial-avatar"><?= e($t['name'][0]) ?></div>
                    <div>
                        <div style="font-weight:600"><?= e($t['name']) ?></div>
                        <div style="font-size:13px;color:var(--gray)"><?= e($t['country']) ?></div>
                    </div>
                </div>
                <p class="testimonial-quote">"<?= e($t['text']) ?>"</p>
                <div class="testimonial-received">✅ Received: <?= e($t['model']) ?> 🚗</div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <h2>Follow Tesla Official</h2>
            <p>Verified official social media accounts of Tesla worldwide.</p>
        </div>
        <div class="social-grid">
            <div class="social-card">
                <div class="social-icon">𝕏</div>
                <h3>Tesla Official</h3>
                <p>@TeslaOfficial</p>
                <p style="font-size:13px;color:var(--gray);margin-top:8px">28.4M followers</p>
            </div>
            <div class="social-card">
                <div class="social-icon">📘</div>
                <h3>Tesla</h3>
                <p>TeslaOfficial</p>
                <p style="font-size:13px;color:var(--gray);margin-top:8px">14.2M likes</p>
            </div>
            <div class="social-card">
                <div class="social-icon">📸</div>
                <h3>Tesla</h3>
                <p>@teslamotors</p>
                <p style="font-size:13px;color:var(--gray);margin-top:8px">12.8M followers</p>
            </div>
        </div>
    </div>
</section>

<section class="section" id="instruction">
    <div class="container">
        <div class="section-header">
            <h2>How to Claim Your Tesla Car</h2>
            <p>Follow these simple steps to receive your brand new Tesla electric car giveaway</p>
        </div>
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-num">01</div>
                <h3>Register Your Details</h3>
                <p>Enter your name, delivery address, and contact information so Tesla can ship your car directly to you.</p>
            </div>
            <div class="step-card">
                <div class="step-num">02</div>
                <h3>Choose Your Tesla Car</h3>
                <p>Select your preferred Tesla model: Model 3, Model Y, Model S, or Model X — all brand new!</p>
            </div>
            <div class="step-card">
                <div class="step-num">03</div>
                <h3>Pay Delivery Fee</h3>
                <p>Pay the small one-time delivery fee to cover shipping and logistics. This is the only fee required.</p>
            </div>
            <div class="step-card">
                <div class="step-num">04</div>
                <h3>Receive Your Tesla Car</h3>
                <p>Your brand new Tesla electric car will be delivered to your door within 7–14 business days. Enjoy!</p>
            </div>
        </div>
        <div style="text-align:center;margin-top:40px">
            <a href="participate.php" class="btn">🚗 Start Claiming Your Tesla Now →</a>
        </div>
    </div>
</section>

<section class="section section-alt" id="cars">
    <div class="container">
        <div class="event-header">
            <span class="section-label">Official Tesla Global Giveaway</span>
            <h2>Choose Your Tesla Electric Car</h2>
            <p>Tesla is gifting brand new electric vehicles to participants worldwide.</p>
            <div class="countdown" id="countdown"
                 data-hours="<?= (int)$settings['event_hours'] ?>"
                 data-minutes="<?= (int)$settings['event_minutes'] ?>"
                 data-seconds="<?= (int)$settings['event_seconds'] ?>">
                <span class="countdown-label">Event ends in:</span>
                <div class="countdown-blocks">
                    <div class="countdown-item"><span class="num" id="cd-hours">11</span><span class="label">HRS</span></div>
                    <span class="countdown-sep">:</span>
                    <div class="countdown-item"><span class="num" id="cd-minutes">42</span><span class="label">MIN</span></div>
                    <span class="countdown-sep">:</span>
                    <div class="countdown-item"><span class="num" id="cd-seconds">33</span><span class="label">SEC</span></div>
                </div>
            </div>
            <p class="participant-count"><?= number_format($settings['participant_count']) ?> participants</p>
        </div>
        <div class="car-grid-lg">
            <?php foreach ($settings['cars'] as $car): ?>
            <div class="car-card-lg">
                <div class="car-card-top <?= e(carHeaderTheme($car['image'])) ?>">
                    <span class="car-badge"><?= e($car['badge']) ?></span>
                    <div class="type"><?= e($car['type']) ?></div>
                    <h3><?= e($car['name']) ?></h3>
                    <div class="year"><?= e($car['year']) ?> Model</div>
                </div>
                <div class="car-card-img">
                    <?= carImageHtml($car['image'], $car['name']) ?>
                </div>
                <div class="car-card-body">
                    <div class="car-specs">
                        <div class="spec-item"><div class="label">⚡ Power</div><div class="value"><?= e($car['power']) ?></div></div>
                        <div class="spec-item"><div class="label">⭐ Range</div><div class="value"><?= e($car['range']) ?></div></div>
                        <div class="spec-item"><div class="label">🌍 Ships To</div><div class="value">All Countries</div></div>
                        <div class="spec-item"><div class="label">🕐 Delivery</div><div class="value"><?= e($car['delivery_days']) ?></div></div>
                    </div>
                    <div class="fee-box">
                        <div class="fee-label">One-Time Delivery Fee</div>
                        <div class="fee-amount">$<?= (int)$car['fee'] ?></div>
                        <div class="fee-note">Covers shipping, customs & logistics</div>
                    </div>
                    <a href="participate.php?car=<?= e(urlencode($car['id'])) ?>" class="btn btn-block">🚗 Claim This Tesla Now →</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>Live Deliveries</h2>
            <p>Real-time updates of Tesla car deliveries happening right now across the world.</p>
        </div>
        <div class="live-feed">
            <div class="live-feed-header">
                <span class="live-dot"></span>
                <strong>Live Delivery Feed</strong>
                <span style="color:var(--red);font-size:12px;font-weight:600">LIVE</span>
            </div>
            <div id="liveFeed">
                <?php foreach ($liveFeed as $item): ?>
                <div class="feed-item">
                    <div class="feed-item-left">
                        <div class="feed-name"><?= e($item['name']) ?> <?= e($item['country']) ?></div>
                        <div class="feed-status"><?= e($item['car']) ?> · <?= e($item['status']) ?></div>
                    </div>
                    <div style="text-align:right">
                        <div class="feed-fee">$<?= (int)$item['fee'] ?></div>
                        <div class="feed-time"><?= (int)$item['minutes_ago'] ?> min ago</div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
