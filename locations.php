<?php
require_once 'includes/functions.php';
require_once 'config/database.php';

// Store locations data
$locations = [
    [
        'name' => 'Downtown Art Hub',
        'address' => '123 Creative Street, Art District',
        'city' => 'New York, NY 10001',
        'phone' => '+1 (555) 123-4567',
        'hours' => 'Mon-Sat: 9:00 AM - 8:00 PM<br>Sunday: 10:00 AM - 6:00 PM',
        'services' => ['In-store Pickup', 'Art Workshops', 'Custom Orders'],
        'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.2412648750455!2d-73.98823492346652!3d40.75889713540147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25855c6480299%3A0x55194ec5a1ae072e!2sTimes%20Square!5e0!3m2!1sen!2sus!4v1700000000000!5m2!1sen!2sus'
    ],
    [
        'name' => 'Westside Stationery',
        'address' => '456 Paper Lane, Shopping Center',
        'city' => 'Los Angeles, CA 90001',
        'phone' => '+1 (555) 234-5678',
        'hours' => 'Mon-Fri: 10:00 AM - 7:00 PM<br>Sat-Sun: 11:00 AM - 5:00 PM',
        'services' => ['In-store Pickup', 'Gift Wrapping', 'Bulk Orders'],
        'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3305.4537183449!2d-118.24368492349658!3d34.05223597315655!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2c75ddc27da13%3A0xe22fdf6f254608f4!2sLos%20Angeles%2C%20CA!5e0!3m2!1sen!2sus!4v1700000000000!5m2!1sen!2sus'
    ],
    [
        'name' => 'Creative Corner',
        'address' => '789 Artist Avenue, Cultural Quarter',
        'city' => 'Chicago, IL 60601',
        'phone' => '+1 (555) 345-6789',
        'hours' => 'Mon-Sat: 9:00 AM - 9:00 PM<br>Sunday: Closed',
        'services' => ['In-store Pickup', 'Art Classes', 'Professional Supplies'],
        'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2970.3154876086755!2d-87.62979492342563!3d41.87811636468068!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x880e2c3cd0f4cbed%3A0xafe0a6ad09c0c000!2sChicago%2C%20IL!5e0!3m2!1sen!2sus!4v1700000000000!5m2!1sen!2sus'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Locations - Art & Stationery</title>
    <meta name="description" content="Visit our physical stores for in-person shopping, workshops, and expert advice.">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        .location-card {
            background: white;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            border: 1px solid var(--border);
        }
        .location-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
        }
        .location-map {
            width: 100%;
            height: 250px;
            border: none;
            background: var(--background);
        }
        .location-info {
            padding: 2rem;
        }
        .info-row {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1rem;
            gap: 1rem;
        }
        .info-icon {
            font-size: 1.25rem;
            color: var(--primary);
            min-width: 24px;
        }
        .service-tag {
            display: inline-block;
            background: var(--primary-light);
            color: var(--primary-dark);
            padding: 0.35rem 0.75rem;
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<header style="background: var(--surface); padding: 3rem 0; border-bottom: 1px solid var(--border);">
    <div class="container">
        <h1 style="margin-bottom: 1rem;">📍 Our Locations</h1>
        <p style="color: var(--text-light); font-size: 1.1rem;">Visit us in person for expert advice, workshops, and hands-on product experience.</p>
    </div>
</header>

<main class="container" style="margin-top: 3rem; margin-bottom: 4rem;">
    
    <div class="grid grid-cols-1 gap-lg" style="max-width: 900px; margin: 0 auto;">
        <?php foreach ($locations as $location): ?>
        <div class="location-card">
            <iframe 
                src="<?php echo $location['map']; ?>" 
                class="location-map"
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
            
            <div class="location-info">
                <h2 style="margin-bottom: 1.5rem; color: var(--text-main);"><?php echo htmlspecialchars($location['name']); ?></h2>
                
                <div class="info-row">
                    <span class="info-icon">📍</span>
                    <div>
                        <strong>Address:</strong><br>
                        <?php echo htmlspecialchars($location['address']); ?><br>
                        <?php echo htmlspecialchars($location['city']); ?>
                    </div>
                </div>
                
                <div class="info-row">
                    <span class="info-icon">📞</span>
                    <div>
                        <strong>Phone:</strong><br>
                        <a href="tel:<?php echo str_replace([' ', '(', ')', '-'], '', $location['phone']); ?>" style="color: var(--primary);">
                            <?php echo htmlspecialchars($location['phone']); ?>
                        </a>
                    </div>
                </div>
                
                <div class="info-row">
                    <span class="info-icon">🕒</span>
                    <div>
                        <strong>Hours:</strong><br>
                        <?php echo $location['hours']; ?>
                    </div>
                </div>
                
                <div class="info-row">
                    <span class="info-icon">✨</span>
                    <div>
                        <strong>Services:</strong><br>
                        <?php foreach ($location['services'] as $service): ?>
                            <span class="service-tag"><?php echo htmlspecialchars($service); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                    <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo urlencode($location['address'] . ', ' . $location['city']); ?>" target="_blank" class="btn btn-primary" style="flex: 1;">Get Directions</a>
                    <a href="tel:<?php echo str_replace([' ', '(', ')', '-'], '', $location['phone']); ?>" class="btn btn-secondary" style="flex: 1;">Call Now</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Additional Info Section -->
    <section style="margin-top: 4rem; text-align: center;">
        <div class="card" style="max-width: 700px; margin: 0 auto; background: linear-gradient(to bottom right, var(--primary-light), var(--surface));">
            <h2 style="margin-bottom: 1rem;">Can't Visit Us?</h2>
            <p style="color: var(--text-light); font-size: 1.1rem; margin-bottom: 1.5rem;">
                Shop online and enjoy free shipping on orders over $50, or choose in-store pickup at any location!
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="products.php" class="btn btn-primary">Shop Online</a>
                <a href="contact.php" class="btn btn-secondary">Contact Us</a>
            </div>
        </div>
    </section>

</main>

<?php include 'includes/page-footer.php'; ?>

</body>
</html>
