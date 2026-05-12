<?php
require_once 'functions.php';

// Handle Reservation Submission
$success_msg = '';
$error_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reserve_event'])) {
    $res_data = [
        'event_id' => $_POST['event_id'],
        'full_name' => $_POST['full_name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'seats' => $_POST['seats'] ?? 1
    ];
    if (create_reservation($res_data)) {
        $success_msg = "Success! Your spot has been reserved. We'll contact you soon.";
    } else {
        $error_msg = "Sorry, something went wrong. Please try again.";
    }
}

$page_title = 'Upcoming Events | FTLuma-Light';
include 'includes/header.php';

$all_events = get_all_events();
$upcoming_events = array_filter($all_events, function($e) { return $e['status'] === 'upcoming'; });
?>

<section class="hero" style="padding: 6rem 0; background: var(--primary-900); color: white;">
    <div class="container" style="text-align: center;">
        <span class="badge" style="background: var(--primary-500); border: none; margin-bottom: 1rem;">LUMA COMMUNITY</span>
        <h1 style="font-size: 4rem; margin-bottom: 1rem;">Upcoming <span class="text-gradient">Events</span></h1>
        <p style="color: var(--primary-200); max-width: 600px; margin: 0 auto;">Connect, learn, and grow with the FTLuma-Light community through our curated workshops and summits.</p>
    </div>
</section>

<main class="container" style="padding: 5rem 0;">
    <?php if ($success_msg): ?>
        <div class="alert alert-success" style="margin-bottom: 3rem;"><?php echo $success_msg; ?></div>
    <?php endif; ?>
    <?php if ($error_msg): ?>
        <div class="alert alert-error" style="margin-bottom: 3rem;"><?php echo $error_msg; ?></div>
    <?php endif; ?>

    <?php if (!empty($upcoming_events)): ?>
        <?php $featured = array_shift($upcoming_events); ?>
        <!-- Featured Event -->
        <div class="featured-event">
            <div class="fe-image">
                <img src="<?php echo get_image_url($featured['image']) ?: 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?auto=format&fit=crop&q=80&w=800'; ?>" alt="<?php echo e($featured['title']); ?>">
                <div class="fe-badge">NEXT EVENT</div>
            </div>
            <div class="fe-content">
                <div class="fe-meta">
                    <span>📅 <?php echo date('M d, Y', strtotime($featured['event_date'])); ?></span>
                    <span>⏰ <?php echo date('h:i A', strtotime($featured['event_time'])); ?></span>
                </div>
                <h2><?php echo e($featured['title']); ?></h2>
                <p><?php echo nl2br(e($featured['description'])); ?></p>
                <div class="fe-footer">
                    <div class="location">📍 <?php echo e($featured['location']); ?></div>
                    <button class="btn-primary" onclick="openReserveModal(<?php echo $featured['id']; ?>, '<?php echo addslashes($featured['title']); ?>')">Reserve Your Spot →</button>
                </div>
            </div>
        </div>

        <?php if (!empty($upcoming_events)): ?>
            <!-- Events Grid -->
            <div class="section-header" style="margin-top: 6rem;">
                <h2>More <span class="text-gradient">Upcoming</span> Sessions</h2>
            </div>
            
            <div class="events-grid">
                <?php foreach ($upcoming_events as $event): ?>
                    <div class="event-card">
                        <div class="ec-date">
                            <span class="day"><?php echo date('d', strtotime($event['event_date'])); ?></span>
                            <span class="month"><?php echo date('M', strtotime($event['event_date'])); ?></span>
                        </div>
                        <div class="ec-content">
                            <span class="ec-category"><?php echo e($event['category']); ?></span>
                            <h3><?php echo e($event['title']); ?></h3>
                            <div class="ec-info">
                                <span>⏰ <?php echo date('h:i A', strtotime($event['event_time'])); ?></span>
                                <span>📍 <?php echo e($event['location']); ?></span>
                            </div>
                            <p><?php echo e(substr($event['description'], 0, 150)); ?>...</p>
                            <button class="btn-text" onclick="openReserveModal(<?php echo $event['id']; ?>, '<?php echo addslashes($event['title']); ?>')">Reserve Spot →</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div style="text-align: center; padding: 5rem 0;">
            <div style="font-size: 4rem; margin-bottom: 2rem;">📅</div>
            <h3>No events scheduled right now.</h3>
            <p>Check back soon or follow our social media for updates!</p>
        </div>
    <?php endif; ?>

    <!-- Calendar CTA -->
    <div class="calendar-cta">
        <div class="cta-content">
            <h3>Never miss a moment</h3>
            <p>Subscribe to our global calendar to stay updated on all upcoming sessions.</p>
        </div>
        <button class="btn-outline">Add to Google Calendar</button>
    </div>
</main>

<!-- Reservation Modal -->
<div id="reserveModal" class="modal">
    <div class="modal-content" style="max-width: 500px;">
        <span class="close" onclick="closeReserveModal()">&times;</span>
        <h2 id="modalEventTitle">Reserve Your Spot</h2>
        <p style="margin-bottom: 2rem; color: var(--text-muted);">Fill in your details to secure your attendance.</p>
        
        <form action="events.php" method="POST">
            <input type="hidden" name="event_id" id="modalEventId">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" class="form-control" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="your@email.com" required>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" class="form-control" placeholder="+254...">
            </div>
            <button type="submit" name="reserve_event" class="btn-primary" style="width: 100%; margin-top: 1rem;">Confirm Reservation</button>
        </form>
    </div>
</div>

<script>
function openReserveModal(id, title) {
    document.getElementById('modalEventId').value = id;
    document.getElementById('modalEventTitle').innerText = 'Reserve for: ' + title;
    document.getElementById('reserveModal').style.display = "block";
}

function closeReserveModal() {
    document.getElementById('reserveModal').style.display = "none";
}

window.onclick = function(event) {
    if (event.target == document.getElementById('reserveModal')) {
        closeReserveModal();
    }
}
</script>

<style>
.featured-event {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    background: var(--bg-white);
    border-radius: 2rem;
    overflow: hidden;
    border: 1px solid var(--border);
    box-shadow: var(--shadow-lg);
}

.fe-image {
    position: relative;
    min-height: 400px;
}

.fe-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.fe-badge {
    position: absolute;
    top: 2rem;
    left: 2rem;
    background: var(--primary-500);
    color: white;
    padding: 0.5rem 1.5rem;
    border-radius: 2rem;
    font-weight: 800;
    font-size: 0.875rem;
}

.fe-content {
    padding: 4rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.fe-meta {
    display: flex;
    gap: 2rem;
    color: var(--primary-600);
    font-weight: 700;
    margin-bottom: 1.5rem;
    font-size: 0.875rem;
}

.fe-content h2 {
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.fe-content p {
    color: var(--text-muted);
    margin-bottom: 2.5rem;
    font-size: 1.125rem;
}

.fe-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid var(--border);
    padding-top: 2rem;
}

.fe-footer .location {
    font-weight: 600;
    color: var(--text-dark);
}

/* Events Grid */
.events-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
}

.event-card {
    display: flex;
    gap: 3rem;
    padding: 3rem;
    background: var(--bg-white);
    border-radius: 1.5rem;
    border: 1px solid var(--border);
    transition: var(--transition);
}

.event-card:hover {
    transform: translateX(10px);
    border-color: var(--primary-300);
    box-shadow: var(--shadow-md);
}

.ec-date {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-width: 100px;
    height: 100px;
    background: var(--primary-50);
    color: var(--primary-800);
    border-radius: 1rem;
}

.ec-date .day {
    font-size: 2rem;
    font-weight: 800;
    line-height: 1;
}

.ec-date .month {
    font-size: 0.875rem;
    font-weight: 700;
    text-transform: uppercase;
}

.ec-content {
    flex: 1;
}

.ec-category {
    display: inline-block;
    color: var(--primary-600);
    font-weight: 800;
    font-size: 0.75rem;
    text-transform: uppercase;
    margin-bottom: 0.5rem;
}

.ec-content h3 {
    font-size: 1.75rem;
    margin-bottom: 1rem;
}

.ec-info {
    display: flex;
    gap: 2rem;
    margin-bottom: 1.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-dark);
}

.ec-content p {
    color: var(--text-muted);
    margin-bottom: 1.5rem;
    max-width: 700px;
}

.ec-link {
    font-weight: 700;
    color: var(--primary-700);
    text-decoration: none;
}

/* Calendar CTA */
.calendar-cta {
    margin-top: 6rem;
    background: var(--primary-900);
    color: white;
    padding: 4rem;
    border-radius: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-image: radial-gradient(circle at top right, var(--primary-800), transparent);
}

.cta-content h3 {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.cta-content p {
    color: var(--primary-200);
}

.btn-outline {
    background: transparent;
    border: 2px solid white;
    color: white;
    padding: 1rem 2.5rem;
    border-radius: 1rem;
    font-weight: 700;
    cursor: pointer;
    transition: var(--transition);
}

.btn-outline:hover {
    background: white;
    color: var(--primary-900);
}

@media (max-width: 1024px) {
    .featured-event {
        grid-template-columns: 1fr;
    }
    .fe-image {
        min-height: 300px;
    }
}

@media (max-width: 768px) {
    .event-card {
        flex-direction: column;
        gap: 1.5rem;
        padding: 2rem;
    }
    .ec-date {
        flex-direction: row;
        width: 100%;
        height: auto;
        padding: 1rem;
        gap: 1rem;
    }
    .calendar-cta {
        flex-direction: column;
        text-align: center;
        gap: 2rem;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
