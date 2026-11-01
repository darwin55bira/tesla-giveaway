<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';

$settings = loadSettings();
$testimonials = generateTestimonials();
$comments = generateCommentTestimonials();
$liveFeed = generateLiveDeliveries($settings);

$pageTitle = $settings['site_title'];
require __DIR__ . '/includes/header.php';
?>

<div class="trust-bar">
    <div class="container">
        <span>✅ "Verified Official Event" <span class="fake-tag">FAKE</span></span>
        <span>🔒 "256-bit SSL Secured" <span class="fake-tag">MEANINGLESS</span></span>
        <span>💰 "10,000+ Paid Out" <span class="fake-tag">FAKE</span></span>
    </div>
</div>

<section class="hero" id="giveaway">
    <div class="container hero-grid">
        <div class="hero-content">
            <div class="hero-badges">
                <span class="hero-badge hero-badge-live"><span class="pulse-dot"></span> Demo Event</span>
                <span class="hero-badge hero-badge-joined">LIVE — <?= number_format($settings['participant_count']) ?> joined</span>
            </div>
            <h1>Win a <span class="text-red">Brand New</span> VoltDrive Electric Car</h1>
            <p>This is how a fake car giveaway looks. Click through it to learn the warning signs; nothing here costs money or saves your details.</p>
            <div class="hero-actions">
                <a href="participate.php" class="btn btn-lg">🚗 Try the Scam Flow →</a>
                <a href="payment.php" class="btn btn-lg btn-outline">Skip to the Red Flags</a>
            </div>
        </div>
        <div class="hero-visual">
            <div class="hero-card">
                <?= carImageHtml('model3', 'Electric car') ?>
                <div class="hero-card-overlay">
                    <span class="hero-card-title">VoltDrive Electric Car</span>
                    <span class="hero-card-sub">"100% Free — Just Pay Delivery" ← the trick</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-alt" id="info">
    <div class="container">
        <div class="section-header">
            <h2>Available Cars</h2>
            <p>Brand-new cars "delivered straight to your door". Scams use expensive prizes so a few hundred dollars feels small.</p>
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
                    <span class="free-badge">"FREE" 🎉</span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>Comments from "Winners"</h2>
        </div>
        <p class="demo-note">⚠️ <strong>Red flag:</strong> scam sites copy the look of video comments, often under a stolen or AI-faked video of a famous CEO. These names, flags and like counts are invented.</p>
        <div class="comments" id="commentFeed" style="max-width:760px;margin:0 auto">
            <?php foreach ($comments as $c): ?>
            <div class="comment">
                <div class="comment-avatar"><?= e($c['initials']) ?></div>
                <div class="comment-body">
                    <div class="comment-author"><?= e($c['name']) ?> <?= e($c['country']) ?> · <?= e((string)$c['days_ago']) ?> day<?= $c['days_ago'] > 1 ? 's' : '' ?> ago <span class="fake-tag">FAKE</span></div>
                    <div class="comment-text"><?= e($c['text']) ?></div>
                    <div class="comment-likes">👍 <?= number_format($c['likes']) ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section-alt" id="testimonials">
    <div class="container">
        <div class="section-header">
            <h2>What "Winners" Are Saying</h2>
        </div>
        <p class="demo-note">⚠️ <strong>Red flag:</strong> every testimonial mentions paying the delivery fee. That's deliberate: it makes the fee feel normal.</p>
        <div class="testimonials-grid" id="testimonialsGrid">
            <?php foreach ($testimonials as $t): ?>
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <div class="testimonial-avatar"><?= e($t['name'][0]) ?></div>
                    <div>
                        <div style="font-weight:600"><?= e($t['name']) ?> <span class="fake-tag">FAKE</span></div>
                        <div style="font-size:13px;color:var(--gray)"><?= e($t['country']) ?></div>
                    </div>
                </div>
                <p class="testimonial-quote">"<?= e($t['text']) ?>"</p>
                <div class="testimonial-received">"Received": <?= e($t['model']) ?> 🚗</div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" id="instruction">
    <div class="container">
        <div class="section-header">
            <h2>How the Scam Works</h2>
            <p>These are the steps a fake giveaway walks you through.</p>
        </div>
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-num">01</div>
                <h3>"Register Your Details"</h3>
                <p>They collect your name, address and phone, which can be sold or used for follow-up scams.</p>
            </div>
            <div class="step-card">
                <div class="step-num">02</div>
                <h3>"Choose Your Car"</h3>
                <p>Picking a model makes the prize feel real and already yours.</p>
            </div>
            <div class="step-card">
                <div class="step-num">03</div>
                <h3>"Pay the Delivery Fee"</h3>
                <p>The whole point. Paid in crypto, gift cards or friends-and-family transfers that can't be reversed.</p>
            </div>
            <div class="step-card">
                <div class="step-num">04</div>
                <h3>Nothing Arrives</h3>
                <p>Or a new "customs" or "insurance" fee appears. Then another. The car never existed.</p>
            </div>
        </div>
        <div style="text-align:center;margin-top:40px">
            <a href="participate.php" class="btn">🚗 Walk Through the Demo →</a>
        </div>
    </div>
</section>

<section class="section section-alt" id="cars">
    <div class="container">
        <div class="event-header">
            <h2>Choose Your Electric Car</h2>
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
            <p class="demo-note" style="margin-top:16px">⚠️ <strong>Red flag:</strong> this countdown quietly restarts when it hits zero. It exists only to rush you.</p>
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
                        <div class="fee-label">"One-Time Delivery Fee"</div>
                        <div class="fee-amount">$<?= (int)$car['fee'] ?></div>
                        <div class="fee-note">The scam: real prizes never cost you money</div>
                    </div>
                    <a href="participate.php?car=<?= e(urlencode($car['id'])) ?>" class="btn btn-block">🚗 See What Happens Next →</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>"Live" Deliveries</h2>
        </div>
        <p class="demo-note">⚠️ <strong>Red flag:</strong> this feed is random names picked by code and refreshed every 30 seconds. Nobody is receiving a car.</p>
        <div class="live-feed">
            <div class="live-feed-header">
                <span class="live-dot"></span>
                <strong>Live Delivery Feed</strong>
                <span class="fake-tag">FAKE</span>
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
