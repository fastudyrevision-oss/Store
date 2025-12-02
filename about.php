<?php
require_once 'includes/functions.php';
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Art & Stationery</title>
    <meta name="description" content="Learn about ArtStationery - your trusted marketplace for premium art supplies and stationery from verified sellers worldwide.">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        .about-hero {
            background: var(--gradient-primary);
            color: white;
            padding: 4rem 0;
            text-align: center;
            border-radius: 0 0 2rem 2rem;
            margin-bottom: 4rem;
        }
        .about-hero h1 {
            color: white;
            -webkit-text-fill-color: white;
            background: none;
            margin-bottom: 1rem;
        }
        .value-card {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            transition: transform 0.3s;
            border: 1px solid var(--border);
        }
        .value-card:hover {
            transform: translateY(-5px);
        }
        .value-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .stat-box {
            text-align: center;
            padding: 2rem;
        }
        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            color: var(--text-light);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.05em;
        }
    </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<header class="about-hero">
    <div class="container">
        <h1>About ArtStationery</h1>
        <p style="font-size: 1.25rem; opacity: 0.95; max-width: 700px; margin: 0 auto;">
            We're building a global marketplace that connects creative minds with premium art supplies and stationery from trusted sellers worldwide.
        </p>
    </div>
</header>

<main class="container" style="margin-bottom: 4rem;">
    
    <!-- Our Story -->
    <section style="max-width: 800px; margin: 0 auto 4rem auto; text-align: center;">
        <h2 style="margin-bottom: 1.5rem;">Our Story</h2>
        <p style="font-size: 1.1rem; color: var(--text-light); line-height: 1.8;">
            Founded by artists and stationery enthusiasts, ArtStationery was born from a simple idea: everyone deserves access to quality creative tools. We've built a platform that empowers independent sellers while providing customers with an unparalleled selection of authentic, premium products. From professional artists to hobbyists, students to collectors, we serve a diverse community united by their passion for creativity.
        </p>
    </section>

    <!-- Stats -->
    <section style="margin-bottom: 4rem;">
        <div class="grid grid-cols-4 gap-lg">
            <div class="stat-box">
                <div class="stat-number">10K+</div>
                <div class="stat-label">Products</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">500+</div>
                <div class="stat-label">Trusted Sellers</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">50K+</div>
                <div class="stat-label">Happy Customers</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">100+</div>
                <div class="stat-label">Countries</div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section style="margin-bottom: 4rem;">
        <div class="grid grid-cols-2 gap-lg">
            <div class="card" style="background: linear-gradient(to bottom right, var(--primary-light), var(--surface));">
                <h3 style="margin-bottom: 1rem;">🎯 Our Mission</h3>
                <p style="line-height: 1.8;">To empower creativity by making high-quality art materials accessible to everyone, while supporting independent sellers and small businesses in building sustainable livelihoods.</p>
            </div>
            <div class="card" style="background: linear-gradient(to bottom right, var(--surface), #fef5e7);">
                <h3 style="margin-bottom: 1rem;">🚀 Our Vision</h3>
                <p style="line-height: 1.8;">To become the world's leading platform for creative tools, fostering a global community of makers, dreamers, and doers who inspire each other every day.</p>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section style="margin-bottom: 4rem;">
        <h2 style="text-align: center; margin-bottom: 2rem;">Our Core Values</h2>
        <div class="grid grid-cols-3 gap-lg">
            <div class="value-card">
                <div class="value-icon">✨</div>
                <h3>Quality First</h3>
                <p style="color: var(--text-light);">We only work with verified sellers offering authentic, premium products.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🤝</div>
                <h3>Community Driven</h3>
                <p style="color: var(--text-light);">Supporting artists, sellers, and creators is at the heart of everything we do.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🌍</div>
                <h3>Global Reach</h3>
                <p style="color: var(--text-light);">Connecting creative minds across borders and cultures worldwide.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">💡</div>
                <h3>Innovation</h3>
                <p style="color: var(--text-light);">Constantly improving our platform to serve you better.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🔒</div>
                <h3>Trust & Safety</h3>
                <p style="color: var(--text-light);">Your security and satisfaction are our top priorities.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🎨</div>
                <h3>Creativity</h3>
                <p style="color: var(--text-light);">Inspiring and enabling creative expression in all its forms.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section style="text-align: center;">
        <div class="card" style="max-width: 700px; margin: 0 auto; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <h2 style="color: white; margin-bottom: 1rem;">Join Our Community</h2>
            <p style="font-size: 1.1rem; margin-bottom: 1.5rem; opacity: 0.95;">
                Whether you're a buyer looking for premium supplies or a seller wanting to reach a global audience, we'd love to have you!
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="products.php" class="btn btn-secondary" style="background: white; color: var(--primary);">Start Shopping</a>
                <a href="register.php" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 2px solid white;">Become a Seller</a>
            </div>
        </div>
    </section>

</main>

<?php include 'includes/page-footer.php'; ?>

</body>
</html>
