<?php
require_once 'includes/functions.php';
require_once 'config/database.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = sanitize($_POST['email']);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            // Create newsletter_subscribers table if it doesn't exist
            $pdo->exec("CREATE TABLE IF NOT EXISTS newsletter_subscribers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) UNIQUE NOT NULL,
                subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                is_active BOOLEAN DEFAULT TRUE
            )");
            
            // Insert subscriber
            $stmt = $pdo->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?) ON DUPLICATE KEY UPDATE is_active = TRUE");
            $stmt->execute([$email]);
            $success = true;
        } catch (PDOException $e) {
            $error = "An error occurred. Please try again.";
        }
    } else {
        $error = "Please enter a valid email address.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter - Art & Stationery</title>
    <meta name="description" content="Subscribe to our newsletter for exclusive offers, new product launches, and creative inspiration.">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        .newsletter-hero {
            background: var(--gradient-primary);
            color: white;
            padding: 4rem 0;
            text-align: center;
            border-radius: 0 0 2rem 2rem;
            margin-bottom: 3rem;
        }
        .newsletter-hero h1 {
            color: white;
            -webkit-text-fill-color: white;
            background: none;
            margin-bottom: 1rem;
        }
        .benefit-card {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 1rem;
            box-shadow: var(--shadow-md);
            transition: transform 0.3s;
        }
        .benefit-card:hover {
            transform: translateY(-5px);
        }
        .benefit-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<header class="newsletter-hero">
    <div class="container">
        <h1>Join Our Creative Community</h1>
        <p style="font-size: 1.25rem; opacity: 0.95; max-width: 600px; margin: 0 auto;">Get exclusive offers, early access to new products, and creative inspiration delivered to your inbox.</p>
    </div>
</header>

<main class="container" style="margin-bottom: 4rem;">
    
    <?php if ($success): ?>
        <div class="card" style="max-width: 600px; margin: 0 auto 3rem auto; text-align: center; background: linear-gradient(to bottom right, #c6f6d5, #9ae6b4); border: 2px solid #48bb78;">
            <h2 style="color: #22543d; margin-bottom: 1rem;">🎉 Welcome Aboard!</h2>
            <p style="color: #22543d; font-size: 1.1rem;">Thank you for subscribing! Check your inbox for a special welcome offer.</p>
        </div>
    <?php elseif ($error): ?>
        <div class="card" style="max-width: 600px; margin: 0 auto 3rem auto; text-align: center; background: #fed7d7; border: 2px solid #f56565;">
            <p style="color: #822727; font-weight: 600;"><?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <!-- Subscription Form -->
    <section style="max-width: 600px; margin: 0 auto 4rem auto;">
        <div class="card" style="text-align: center;">
            <h2 style="margin-bottom: 1rem;">Subscribe to Our Newsletter</h2>
            <p style="color: var(--text-light); margin-bottom: 2rem;">Stay updated with the latest products, exclusive deals, and creative tips.</p>
            <form method="POST" action="newsletter.php">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Enter your email address" required style="text-align: center; font-size: 1.1rem;">
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.1rem;">Subscribe Now</button>
            </form>
            <p style="color: var(--text-light); font-size: 0.875rem; margin-top: 1rem;">We respect your privacy. Unsubscribe anytime.</p>
        </div>
    </section>

    <!-- Benefits -->
    <section>
        <h2 style="text-align: center; margin-bottom: 2rem;">What You'll Get</h2>
        <div class="grid grid-cols-3 gap-lg">
            <div class="benefit-card">
                <div class="benefit-icon">🎁</div>
                <h3>Exclusive Offers</h3>
                <p style="color: var(--text-light);">Get access to subscriber-only discounts and special promotions.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">🚀</div>
                <h3>Early Access</h3>
                <p style="color: var(--text-light);">Be the first to know about new product launches and collections.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">💡</div>
                <h3>Creative Tips</h3>
                <p style="color: var(--text-light);">Receive tutorials, inspiration, and tips from professional artists.</p>
            </div>
        </div>
    </section>

</main>

<?php include 'includes/page-footer.php'; ?>

</body>
</html>
