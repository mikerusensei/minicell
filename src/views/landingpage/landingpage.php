<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Minicell Apparel</title>

        <link rel="icon" href="https://res.cloudinary.com/dzmhkee5i/image/upload/v1726044546/minicell/cvbz1wok7xzzwydkpklj.png" type="image/icon_type" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Stylesheet -->
        <link rel="stylesheet" href="src/views/landingpage/styles/style.css" />
        <link rel="stylesheet" href="src/views/landingpage/styles/header_style.css" />
        <link rel="stylesheet" href="src/views/landingpage/styles/landing.css" />
        <link rel="stylesheet" href="src/views/landingpage/styles/product_style.css" />

        <!-- Fonts -->
        <link href="https://fonts.cdnfonts.com/css/kulim-park" rel="stylesheet">
        <link href="https://fonts.cdnfonts.com/css/aclonica" rel="stylesheet">
        <link href="https://fonts.cdnfonts.com/css/spinnaker" rel="stylesheet">
        <link href="https://fonts.cdnfonts.com/css/br-cobane" rel="stylesheet">
        <link href="https://fonts.cdnfonts.com/css/chivo-mono" rel="stylesheet">

        <!-- <script src="script.js" defer></script> -->
    </head>
    <body>
        <div class="responsive-container">
            <header>
                <a href="/minicell/">
                    <img src="https://res.cloudinary.com/dzmhkee5i/image/upload/v1726044546/minicell/cvbz1wok7xzzwydkpklj.png">
                </a>
                <nav>
                    <div class="search-bar">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <p id="search">Search</p>
                    </div>
                    <div class="buttons">
                        <a href="/minicell/index.php/signUp">
                            <i class="fa-solid fa-user" id="btn"></i>
                        </a>
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                </nav>
            </header>
            <main>
                <section class="landing-page">
                    <div class="image-buttons">
                        <div class="kids-image">
                            <p>#KIDS</p>
                            <p>LINE</p>
                        </div>
                        <div class="mens-image">
                            <p>#MEN</p>
                            <p>LINE</p>
                        </div>
                    </div>
                    <div class="welcome-text">
                        <div class="upper">
                            <div class="welcome-header">
                                <h1># STYLISH</h1>
                                <h1>WHITE-TEES</h1>
                            </div>
                            <div class="description">
                                <p>Level up your white-tees with us!</p>
                                <p>Wear your usual with a style!</p>
                            </div>
                            <div class="explore-buttons">
                                <button id="add-cart">
                                    <p>Add to my Cart</p>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                                <button id="explore-now">
                                    <p>Explore Now</p>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                        <div class="lower">
                            <div class="lower-header">
                                <div class="arrow-header">
                                    <i class="fa-solid fa-arrow-left-long"></i>
                                    <h1>For <span>EVERYONE</span></h1>
                                </div>
                                <h1>But <span>NOTANYONE</span></h1>
                                <div class="description2">
                                    <p>Shop With Us!</p>
                                    <p>Shop just like Extraordinary</p>
                                </div>
                            </div>
                            <div class="login-buttons">
                                <a href="/minicell/index.php/login">
                                    <button id="login">
                                        <p>Log In Account</p>
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </button>
                                </a>
                                <a href="/minicell/index.php/signUp">
                                    <button id="sign-up">
                                        <p>Sign Up for Free</p>
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="product-page">
                    <?php
                    // Check if there are products to display
                    if (!empty($products)) {
                        foreach ($products as $product) {
                            ?>
                            <div class="product">
                                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                                <p><?php echo htmlspecialchars($product['description']); ?></p>
                                <p>Price: $<?php echo htmlspecialchars($product['price']); ?></p>
                                <p>Status: <?php echo htmlspecialchars($product['status']); ?></p>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p>No products available</p>";
                    }
                    ?>
                </section>
            </main>
            <footer>

            </footer>
        </div>
    </body>
</html>