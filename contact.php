<?php
require_once 'includes/functions.php';
require_once 'config/database.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $subject = sanitize($_POST['subject'] ?? '');
    $message = sanitize($_POST['message'] ?? '');
    
    if ($name && $email && $subject && $message) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                // Create contact_messages table if it doesn't exist
                $pdo->exec("CREATE TABLE IF NOT EXISTS contact_messages (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL,
                    subject VARCHAR(500) NOT NULL,
                    message TEXT NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    status ENUM('new', 'read', 'replied') DEFAULT 'new'
                )");
                
                // Insert message
                $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $email, $subject, $message]);
                $success = true;
            } catch (PDOException $e) {
                $error = "An error occurred. Please try again.";
            }
        } else {
            $error = "Please enter a valid email address.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Art & Stationery</title>
    <meta name="description" content="Get in touch with ArtStationery. We're here to help with any questions about products, orders, or partnerships.">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        .contact-method {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s;
            border: 1px solid var(--border);
        }
        .contact-method:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }
        .contact-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--gradient-primary);
            color: white;
            font-size: 1.5rem;
            transition: all 0.3s;
            margin: 0 0.5rem;
        }
        .social-link:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: var(--shadow-lg);
        }
    </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<header style="background: var(--surface); padding: 3rem 0; border-bottom: 1px solid var(--border);">
    <div class="container">
        <h1 style="margin-bottom: 1rem;">📧 Get in Touch</h1>
        <p style="color: var(--text-light); font-size: 1.1rem;">Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
    </div>
</header>

<main class="container" style="margin-top: 3rem; margin-bottom: 4rem;">
    
    <?php if ($success): ?>
        <div class="card" style="max-width: 700px; margin: 0 auto 3rem auto; text-align: center; background: linear-gradient(to bottom right, #c6f6d5, #9ae6b4); border: 2px solid #48bb78;">
            <h2 style="color: #22543d; margin-bottom: 1rem;">✅ Message Sent!</h2>
            <p style="color: #22543d; font-size: 1.1rem;">Thank you for contacting us! We'll get back to you within 24 hours.</p>
        </div>
    <?php elseif ($error): ?>
        <div class="card" style="max-width: 700px; margin: 0 auto 3rem auto; text-align: center; background: #fed7d7; border: 2px solid #f56565;">
            <p style="color: #822727; font-weight: 600;"><?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-2 gap-lg" style="margin-bottom: 4rem;">
        
        <!-- Contact Form -->
        <div class="card">
            <h2 style="margin-bottom: 1.5rem;">Send Us a Message</h2>
            <form method="POST" action="contact.php">
                <div class="form-group">
                    <label for="name" class="form-label">Your Name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" id="subject" name="subject" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="message" class="form-label">Message</label>
                    <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Send Message</button>
            </form>
        </div>

        <!-- Contact Methods -->
        <div>
            <h2 style="margin-bottom: 1.5rem;">Other Ways to Reach Us</h2>
            
            <div class="grid grid-cols-1 gap-md">
                <div class="contact-method">
                    <div class="contact-icon">📧</div>
                    <h3 style="margin-bottom: 0.5rem;">Email</h3>
                    <a href="mailto:support@artstationery.com" style="color: var(--primary); font-weight: 600;">support@artstationery.com</a>
                    <p style="color: var(--text-light); font-size: 0.875rem; margin-top: 0.5rem;">We'll respond within 24 hours</p>
                </div>

                <div class="contact-method">
                    <div class="contact-icon">📞</div>
                    <h3 style="margin-bottom: 0.5rem;">Phone</h3>
                    <a href="tel:+15551234567" style="color: var(--primary); font-weight: 600;">+1 (555) 123-4567</a>
                    <p style="color: var(--text-light); font-size: 0.875rem; margin-top: 0.5rem;">Mon-Fri, 9AM-6PM EST</p>
                </div>

                <div class="contact-method">
                    <div class="contact-icon">💬</div>
                    <h3 style="margin-bottom: 0.5rem;">Live Chat</h3>
                    <p style="color: var(--text-light);">Available on our website</p>
                    <button class="btn btn-primary btn-sm" style="margin-top: 0.5rem;">Start Chat</button>
                </div>
            </div>

            <!-- Social Media -->
            <div style="margin-top: 2rem; text-align: center;">
                <h3 style="margin-bottom: 1rem;">Follow Us</h3>
                <div>
                    <a href="#" class="social-link" title="Facebook">📘</a>
                    <a href="#" class="social-link" title="Instagram">📷</a>
                    <a href="#" class="social-link" title="Twitter">🐦</a>
                    <a href="#" class="social-link" title="Pinterest">📌</a>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Link -->
    <div class="card" style="text-align: center; background: linear-gradient(to bottom right, var(--primary-light), var(--surface));">
        <h2 style="margin-bottom: 1rem;">Looking for Quick Answers?</h2>
        <p style="color: var(--text-light); font-size: 1.1rem; margin-bottom: 1.5rem;">
            Check out our FAQ page for instant answers to common questions.
        </p>
        <a href="faq.php" class="btn btn-primary">Visit FAQ</a>
    </div>

</main>

<?php include 'includes/page-footer.php'; ?>

</body>
</html>
