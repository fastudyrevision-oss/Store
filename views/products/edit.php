<?php
// This file provides a form for editing an existing product.

include_once '../../includes/header.php';
include_once '../../includes/navbar.php';
include_once '../../models/Product.php';

// Assuming we have a method to get the product by ID
$productId = $_GET['id'] ?? null;
$product = Product::getById($productId);

if (!$product) {
    echo "Product not found.";
    exit;
}
?>

<div class="container">
    <h2>Edit Product</h2>
    <form action="../../controllers/productController.php?action=edit&id=<?php echo $product->id; ?>" method="POST">
        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product->name); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($product->description); ?></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product->price); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>

<?php
include_once '../../includes/footer.php';
?>