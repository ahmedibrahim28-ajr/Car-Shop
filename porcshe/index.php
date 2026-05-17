<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porsche</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Header Start -->
    <header>
        <div id="navbar">
            <img src="./img/Porsche-logo.png" alt="porsche Logo">
            <nav role="navigation">
                <ul>
                <li><a href="profile.php">profile</a></li>
                    <li><a href="Category.php?user_id=<?php echo $_SESSION['user_id']; ?>">Category</a></li>
                    <li><a href="favorites.php?user_id=<?php echo $_SESSION['user_id']; ?> ">favorite</a></li>
                    <li><a href="news.php?user_id=<?php echo $_SESSION['user_id']; ?>">News</a></li>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                    
                </ul>
            </nav>
        </div>

        <video autoplay muted loop class="video-background">
            <source src="./img/Porsche 911 Turbo S Edit 4K - Caredits4ever (720p60, h264, youtube).mp4" type="video/mp4">
           
        </video>

        <div class="content">
            <h1>Welcome To <span class="primary-text"> Porsche </span> </h1>
            <p></p>
            <a href="category.php" class="btn btn-primary">Buy Your Car Now!</a>
        </div>
    </header>
    <!-- Header End -->
    <main>
        <!-- About Section Start -->
        <section id="about">
            <div class="container">
                <div class="title">
                    <h2>Our Best Seller</h2>
                    <p>More than 25+ years of experience</p>
                </div>
                <div class="about-content">
                    <div>
                        <p>The Porsche 911 GTS is a high-performance sports car that sits between the standard Carrera models and the track-focused GT3 in Porsche's iconic 911 lineup. It blends daily usability with thrilling performance, making it a popular choice for enthusiasts who desire a car capable of both exhilarating drives and everyday comfort.</p>
                    </div>
                    <img src="./img/Porsche-911-GT3-RS-Configurator-1.jpg" alt="Porsche">
                </div>
            </div>
        </section>
        <!-- About Section End -->
        <!-- Offers Section Start -->
        <section id="offers">
            <div class="container">
                <div class="title">
                    <h2>Our Special Offers</h2>
                    <p>More than 25+ years of experience</p>
                </div>
                <div class="offers-items">
                    <div>
                        <img src="./img/Porche taycaan.jpg" alt="Porsche Taycan">
                        <div>
                            <h3>Porsche Taycan</h3>
                            <p>The Porsche Taycan is Porsche's groundbreaking fully-electric sports sedan, combining cutting-edge electric vehicle (EV) technology with the brand's iconic performance and luxury.</p>
                            <p><del>$30000000</del> <span class="primary-text">$2500000</span></p>
                        </div>
                    </div>
                    <div>
                        <img src="./img/newcayenne.jpg" alt="Porsche Cayenne">
                        <div>
                            <h3>Porsche Cayenne</h3>
                            <p>The Porsche Cayenne is a luxury SUV that combines sports car performance with practicality and elegance.</p>
                            <p><del>$30000000 </del> <span class="primary-text">$2500000</span></p>
                        </div>
                    </div>
                    <div>
                        <img src="./img/porsche panemera.jpg" alt="Porsche Panamera">
                        <div>
                            <h3>Porsche Panamera</h3>
                            <p>The Porsche Panamera is a luxury sports sedan that masterfully blends Porsche's signature performance with the comfort and practicality of a four-door design.</p>
                            <p><del>$30000000</del> <span class="primary-text">$25000000</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Offers Section End -->
        <!-- Menu Section Start -->



        <!-- Slider Section -->
        <section id="slider">
            <div class="slideshow-container">
                <!-- Slide 1 -->
                <div class="mySlides fade">
                    <img src="./img/boxter.jpg" style="width:100%">
                    <div class="text">Porsche Boxster</div>
                </div>
                <!-- Slide 2 -->
                <div class="mySlides fade">
                    <img src="./img/porsche-cayenne.jpg" style="width:100%">
                    <div class="text">Porsche 911 Turbo</div>
                </div>
                <!-- Slide 3 -->
                <div class="mySlides fade">
                    <img src="./img/porsche_panamera_e-hybrid_0011.jpg" style="width:100%">
                    <div class="text">Porsche Cayenne</div>
                </div>
                <!-- Navigation Buttons -->
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>
            <!-- Dots/Indicators -->
            <div style="text-align:center">
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
            </div>
        </section>




        
            </div>
        </section>
        <!-- Menu Section End -->

        <!-- Gallery Section Start -->
        <section id="gallery">
            <div class="container">
                <h2>Our Store Gallery</h2>
                <div class="img-gallery">
                    <img src="./img/porsche race.jpg" alt="green porsche">
                    <img src="./img/green porcshe2.jpg" alt="green porcshe2">
                    <img src="./img/porsche dakar.jpeg" alt="porsche dakar">
                    <img src="./img/porsches.jpg" alt="porsches">
                </div>
            </div>
        </section>
        <!-- Gallary Section End -->

        <!-- Contact Section Start -->
        <section id="contact">
            <div class="container">
                <div class="contact-content">
                    <div class="contact-info">
                        <div>
                            <h3>ADDRESS</h3>
                            <p><i class="fa-solid fa-location-dot"></i> Dr. Ing. h.c. F. Porsche AG, Porscheplatz 1</p>
                            <p><i class="fa-solid fa-phone"></i> Phone: (0711) 911 - 0</p>
                            <p><i class="fa-regular fa-envelope"></i> porsche@official.com</p>
                        </div>
                        <div>
                            <h3>WORKING HOURS</h3>
                            <p>8:00 am to 11:00 pm on Weekdays</p>
                            <p>11:00 am to 1:00 Am on Weekends</p>
                        </div>
                        <div>
                            <h3>FOLLOW US</h3>
                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                    <form>
                        <input type="text" name="Name" id="name" placeholder="Full Name">
                        <input type="email" name="email" id="email" placeholder="Email Address">
                        <input type="text" name="subject" id="subject" placeholder="Subject">
                        <textarea name="message" id="message" cols="30" rows="5" placeholder="Message"></textarea>
                        <button type="submit" class="btn btn-third">SEND US!</button>
                    </form>
                </div>
            </div>
        </section>
        <!-- Contact Section End -->

        

    </main>
    <footer id="footer">
        <p>&copy; 2024 Porsche Official. All Rights Reserved.</p>
    </footer>
    <script src="script.js"></script>
</body>

</html>
