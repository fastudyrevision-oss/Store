<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Product.php';

$productModel = new Product($conn);
$products = $productModel->getAll();

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle Add to Cart
if (isset($_GET['add_to_cart'])) {
    $productId = (int)$_GET['add_to_cart'];
    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 1;
    } else {
        $_SESSION['cart'][$productId]++;
    }
    header("Location: cart.php?added=$productId");
    exit;
}
?>

<?php include __DIR__ . '/includes/header.php'; ?>

<div class="container py-5">
    <h1 class="mb-4 fw-bold text-primary">WhimsiWrite Wonderland</h1>
    <div class="row g-4">
        <?php foreach ($products as $product): ?>
            <?php include __DIR__ . '/components/product-card.php'; ?>
        <?php endforeach; ?>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
<!-- Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="quickViewLabel">Product Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Content will be filled dynamically with JS -->
        <div class="row">
          <div class="col-md-6">
            <img src="" id="quickViewImage" class="img-fluid" alt="">
          </div>
          <div class="col-md-6">
            <h5 id="quickViewName"></h5>
            <p class="text-muted" id="quickViewCategory"></p>
            <p class="fw-bold text-success" id="quickViewPrice"></p>
            <p id="quickViewDescription"></p>
            <a href="#" id="quickViewAddToCart" class="btn btn-primary w-100">
              <i class="fas fa-cart-plus me-1"></i> Add to Cart
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Optional: JS to populate modal dynamically -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quickViewButtons = document.querySelectorAll('.quick-view-btn');
    
    quickViewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('quickViewName').textContent = this.dataset.name;
            document.getElementById('quickViewCategory').textContent = this.dataset.category;
            document.getElementById('quickViewPrice').textContent = this.dataset.price;
            document.getElementById('quickViewImage').src = this.dataset.image;
            document.getElementById('quickViewAddToCart').href = this.dataset.addtocart;
        });
    });
});
</script>