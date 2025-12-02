<?php
require_once 'database.php';

// Ensure we are in the config directory or adjust path
// This script assumes it's run from the root or config/ directory.
// Let's assume root for simplicity of require.

try {
    // Check if categories exist, if not add them
    $categories = [
        'Paints' => 'Watercolors, Acrylics, Oils, Gouache',
        'Brushes' => 'Synthetic, Hog Bristle, Sable, Palette Knives',
        'Canvas' => 'Cotton, Linen, Panels, Rolls',
        'Sketching' => 'Graphite, Charcoal, Pastels, Ink',
        'Paper' => 'Watercolor Paper, Sketchbooks, Mixed Media',
        'Digital Art' => 'Tablets, Stylus, Software',
        'Sculpting' => 'Clay, Tools, Wire Armature',
        'Easels' => 'Studio, Field, Tabletop'
    ];

    foreach ($categories as $name => $desc) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO categories (name, description) VALUES (?, ?)");
        $stmt->execute([$name, $desc]);
    }

    // Get Category IDs
    $cat_ids = [];
    $stmt = $pdo->query("SELECT id, name FROM categories");
    while ($row = $stmt->fetch()) {
        $cat_ids[$row['name']] = $row['id'];
    }

    // Get a Seller ID (Use the first seller found or create a dummy one)
    $stmt = $pdo->query("SELECT id FROM users WHERE user_type = 'seller' LIMIT 1");
    $seller_id = $stmt->fetchColumn();

    if (!$seller_id) {
        // Create a dummy seller
        $pass = password_hash('seller123', PASSWORD_DEFAULT);
        $pdo->exec("INSERT INTO users (full_name, email, password, user_type) VALUES ('Art Supply Co.', 'seller@example.com', '$pass', 'seller')");
        $seller_id = $pdo->lastInsertId();
        $pdo->exec("INSERT INTO seller_details (user_id, business_name) VALUES ($seller_id, 'Art Supply Co.')");
    }

    // Products Data
    $products = [
        ['Paints', 'Professional Watercolor Set', '24 half pans of high-quality pigments.', 89.99, 50, 'assets/images/watercolor.jpg'],
        ['Paints', 'Acrylic Paint Tube Set', '12 vibrant colors, heavy body acrylics.', 34.50, 100, 'assets/images/acrylics.jpg'],
        ['Brushes', 'Sable Hair Brush Set', 'Premium kolinsky sable brushes for detail work.', 120.00, 20, 'assets/images/brushes.jpg'],
        ['Canvas', 'Stretched Cotton Canvas 16x20', 'Triple primed, ready to paint.', 12.99, 200, 'assets/images/canvas.jpg'],
        ['Sketching', 'Graphite Pencil Set 12pk', 'Range from 6H to 8B.', 15.00, 150, 'assets/images/pencils.jpg'],
        ['Paper', 'Cold Press Watercolor Block', '140lb, 100% cotton paper.', 25.00, 80, 'assets/images/paper.jpg'],
        ['Easels', 'H-Frame Studio Easel', 'Solid beechwood construction, adjustable angle.', 150.00, 10, 'assets/images/easel.jpg'],
        ['Sculpting', 'Polymer Clay Starter Kit', '30 colors with sculpting tools.', 29.99, 60, 'assets/images/clay.jpg'],
        ['Digital Art', 'Digital Drawing Glove', 'Reduces friction and prevents smudges.', 8.99, 300, 'assets/images/glove.jpg'],
        ['Paints', 'Oil Paint Set 10 Tubes', 'Traditional oil colors, rich buttery consistency.', 45.00, 40, 'assets/images/oils.jpg'],
        ['Brushes', 'Fan Brush Size 6', 'Perfect for blending and textures.', 5.99, 120, 'assets/images/fanbrush.jpg'],
        ['Sketching', 'Charcoal Stick Box', 'Natural willow charcoal for expressive marks.', 6.50, 90, 'assets/images/charcoal.jpg'],
        ['Paper', 'Mixed Media Sketchbook', 'Heavyweight paper for wet and dry media.', 18.50, 75, 'assets/images/sketchbook.jpg'],
        ['Canvas', 'Canvas Panel 8x10 5-Pack', 'Rigid support for plein air painting.', 10.99, 180, 'assets/images/panels.jpg'],
        ['Paints', 'Gouache Paint Set', 'Opaque watercolors for design and illustration.', 22.00, 65, 'assets/images/gouache.jpg']
    ];

    $stmt = $pdo->prepare("INSERT INTO products (seller_id, category_id, name, description, price, stock_quantity, image_url) VALUES (?, ?, ?, ?, ?, ?, ?)");

    foreach ($products as $prod) {
        $cat_name = $prod[0];
        $cat_id = $cat_ids[$cat_name] ?? null;
        
        if ($cat_id) {
            // Check if product already exists to avoid duplicates on re-run
            $check = $pdo->prepare("SELECT id FROM products WHERE name = ?");
            $check->execute([$prod[1]]);
            if (!$check->fetch()) {
                $stmt->execute([$seller_id, $cat_id, $prod[1], $prod[2], $prod[3], $prod[4], $prod[5]]);
                echo "Added: " . $prod[1] . "<br>";
            }
        }
    }

    echo "Database seeded successfully!";

} catch (PDOException $e) {
    echo "Error seeding database: " . $e->getMessage();
}
?>
