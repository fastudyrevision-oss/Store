<footer style="background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%); color: white; padding: 4rem 0 2rem 0; margin-top: 4rem;">
    <div class="container">
        <div class="grid grid-cols-4 gap-lg" style="margin-bottom: 3rem;">
            <div>
                <h3 style="color: white; margin-bottom: 1rem; font-size: 1.5rem;">ArtStationery</h3>
                <p style="color: #a0aec0; line-height: 1.8;">Your one-stop marketplace for premium art supplies and stationery from trusted sellers worldwide.</p>
            </div>
            <div>
                <h4 style="color: white; margin-bottom: 1rem;">Shop</h4>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 0.5rem;"><a href="products.php" style="color: #a0aec0;">All Products</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="top-products.php" style="color: #a0aec0;">Top Products</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="top-sellers.php" style="color: #a0aec0;">Top Sellers</a></li>
                </ul>
            </div>
            <div>
                <h4 style="color: white; margin-bottom: 1rem;">Company</h4>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 0.5rem;"><a href="about.php" style="color: #a0aec0;">About Us</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="contact.php" style="color: #a0aec0;">Contact</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="locations.php" style="color: #a0aec0;">Locations</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="faq.php" style="color: #a0aec0;">FAQ</a></li>
                </ul>
            </div>
            <div>
                <h4 style="color: white; margin-bottom: 1rem;">Newsletter</h4>
                <p style="color: #a0aec0; margin-bottom: 1rem;">Subscribe for updates and exclusive offers.</p>
                <form action="newsletter.php" method="POST" style="display: flex; gap: 0.5rem;">
                    <input type="email" name="email" placeholder="Your email" required style="flex: 1; padding: 0.75rem; border-radius: 0.5rem; border: none; font-size: 0.9rem;">
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 1.5rem;">Subscribe</button>
                </form>
            </div>
        </div>
        <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2rem; text-align: center;">
            <p style="color: #a0aec0; margin: 0;">&copy; <?php echo date('Y'); ?> ArtStationery. All rights reserved.</p>
        </div>
    </div>
</footer>
