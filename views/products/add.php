<?php
// add.php - Form for adding a new product

include_once '../../includes/header.php';
include_once '../../includes/navbar.php';
?>

<div class="container">
    <h2>Add New Product</h2>
    <form action="../../controllers/productController.php?action=add" method="POST">
        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
</div>

<?php
include_once '../../includes/footer.php';
?>