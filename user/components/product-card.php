<?php
// expects $product array
$imagePath = $product['image_url'] 
    ? '/art_stationery/' . $product['image_url'] 
    : '/art_stationery/assets/no-image.png';
?>
<div class="col-md-6 col-lg-4">
    <div class="card shadow-sm border-0 h-100 product-card position-relative overflow-hidden">
        
        <!-- Optional Badge -->
        <?php if (!empty($product['badge'])): ?>
            <span class="badge bg-success position-absolute top-0 start-0 m-2 px-3 py-1" style="font-size:0.8rem;">
                <?= htmlspecialchars($product['badge']) ?>
            </span>
        <?php endif; ?>

        <!-- Product Image with overlay -->
        <div class="product-img-wrapper position-relative">
            <img src="<?= htmlspecialchars($imagePath) ?>" 
                 class="card-img-top product-img" 
                 alt="<?= htmlspecialchars($product['name']) ?>">
            
            <!-- Quick View overlay -->
            <div class="quick-view-overlay d-flex align-items-center justify-content-center">
                <button class="btn btn-light btn-sm fw-bold quick-view-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#quickViewModal"
                    data-name="<?= htmlspecialchars($product['name']) ?>"
                    data-category="<?= htmlspecialchars($product['category']) ?>"
                    data-price="₨ <?= number_format($product['price'], 2) ?>"
                    data-image="<?= htmlspecialchars($imagePath) ?>"
                    data-addtocart="?add_to_cart=<?= $product['product_id'] ?>">
                    Quick View
                </button>

            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body d-flex flex-column justify-content-between">
            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
            <p class="text-muted mb-2"><?= htmlspecialchars($product['category']) ?></p>
            <p class="fw-bold text-success mb-3">₨ <?= number_format($product['price'], 2) ?></p>
            <a href="?add_to_cart=<?= $product['product_id'] ?>" class="btn btn-primary w-100">
                <i class="fas fa-cart-plus me-1"></i> Add to Cart
            </a>
        </div>
    </div>
</div>
