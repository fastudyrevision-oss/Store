<?php
require_once 'includes/functions.php';
require_once 'config/database.php';

$faqs = [
    [
        'category' => 'Orders & Shipping',
        'questions' => [
            [
                'q' => 'How long does shipping take?',
                'a' => 'Standard shipping typically takes 3-5 business days. Express shipping is available for 1-2 day delivery. International orders may take 7-14 business days depending on your location.'
            ],
            [
                'q' => 'Do you offer free shipping?',
                'a' => 'Yes! We offer free standard shipping on all orders over $50 within the continental United States. International shipping rates vary by location.'
            ],
            [
                'q' => 'Can I track my order?',
                'a' => 'Absolutely! Once your order ships, you\'ll receive a tracking number via email. You can also track your order status by logging into your account and visiting the "My Orders" page.'
            ],
            [
                'q' => 'What if my order arrives damaged?',
                'a' => 'We take great care in packaging, but if your order arrives damaged, please contact us within 48 hours with photos. We\'ll send a replacement or issue a full refund immediately.'
            ]
        ]
    ],
    [
        'category' => 'Products & Sellers',
        'questions' => [
            [
                'q' => 'Are all products authentic?',
                'a' => 'Yes! We carefully vet all our sellers and only work with authorized distributors and verified independent sellers. All products are guaranteed authentic.'
            ],
            [
                'q' => 'How do I become a seller?',
                'a' => 'Click "Sign Up" and select "Seller Account" during registration. You\'ll need to provide business verification documents and complete our seller onboarding process.'
            ],
            [
                'q' => 'Can I request custom products?',
                'a' => 'Many of our sellers offer custom orders! Look for the "Custom Orders Available" badge on seller profiles, or contact them directly through their shop page.'
            ]
        ]
    ],
    [
        'category' => 'Returns & Refunds',
        'questions' => [
            [
                'q' => 'What is your return policy?',
                'a' => 'We offer a 30-day return policy on most items. Products must be unused and in original packaging. Some items like custom orders or opened art supplies may not be eligible for return.'
            ],
            [
                'q' => 'How do I initiate a return?',
                'a' => 'Log into your account, go to "My Orders," select the order you want to return, and click "Request Return." Follow the prompts to print your prepaid return label.'
            ],
            [
                'q' => 'When will I receive my refund?',
                'a' => 'Refunds are processed within 5-7 business days after we receive your return. The refund will be credited to your original payment method.'
            ]
        ]
    ],
    [
        'category' => 'Account & Payment',
        'questions' => [
            [
                'q' => 'What payment methods do you accept?',
                'a' => 'We accept all major credit cards (Visa, MasterCard, American Express, Discover), PayPal, Apple Pay, and Google Pay.'
            ],
            [
                'q' => 'Is my payment information secure?',
                'a' => 'Absolutely! We use industry-standard SSL encryption and never store your complete credit card information. All payments are processed through secure, PCI-compliant payment gateways.'
            ],
            [
                'q' => 'Can I save multiple shipping addresses?',
                'a' => 'Yes! You can save multiple shipping addresses in your account settings for faster checkout.'
            ]
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Art & Stationery</title>
    <meta name="description" content="Find answers to frequently asked questions about ordering, shipping, returns, and more.">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        .faq-category {
            margin-bottom: 3rem;
        }
        .faq-item {
            background: white;
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }
        .faq-item:hover {
            box-shadow: var(--shadow-md);
        }
        .faq-question {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }
        .faq-question::before {
            content: 'Q:';
            color: var(--primary);
            font-weight: 800;
            flex-shrink: 0;
        }
        .faq-answer {
            color: var(--text-light);
            line-height: 1.8;
            padding-left: 2rem;
        }
        .category-header {
            display: inline-block;
            background: var(--gradient-primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius-full);
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<header style="background: var(--surface); padding: 3rem 0; border-bottom: 1px solid var(--border);">
    <div class="container">
        <h1 style="margin-bottom: 1rem;">❓ Frequently Asked Questions</h1>
        <p style="color: var(--text-light); font-size: 1.1rem;">Find answers to common questions about our products, orders, and services.</p>
    </div>
</header>

<main class="container" style="margin-top: 3rem; margin-bottom: 4rem;">
    
    <div style="max-width: 900px; margin: 0 auto;">
        <?php foreach ($faqs as $category): ?>
        <div class="faq-category">
            <h2 class="category-header"><?php echo htmlspecialchars($category['category']); ?></h2>
            
            <?php foreach ($category['questions'] as $faq): ?>
            <div class="faq-item">
                <div class="faq-question"><?php echo htmlspecialchars($faq['q']); ?></div>
                <div class="faq-answer"><?php echo htmlspecialchars($faq['a']); ?></div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
        
        <!-- Still Have Questions? -->
        <div class="card" style="text-align: center; background: linear-gradient(to bottom right, var(--primary-light), var(--surface)); margin-top: 3rem;">
            <h2 style="margin-bottom: 1rem;">Still Have Questions?</h2>
            <p style="color: var(--text-light); font-size: 1.1rem; margin-bottom: 1.5rem;">
                Can't find what you're looking for? Our support team is here to help!
            </p>
            <a href="contact.php" class="btn btn-primary" style="font-size: 1.1rem; padding: 1rem 2rem;">Contact Support</a>
        </div>
    </div>

</main>

<?php include 'includes/page-footer.php'; ?>

</body>
</html>
