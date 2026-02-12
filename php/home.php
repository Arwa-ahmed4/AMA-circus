<?php
session_start(); 
//التأكد من تسجيل الدخول 
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
   
    header("Location: login.php");
    exit; 
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>The Circus</title>
        <link rel="stylesheet" href="Common.css">

        <style>

            h1, h2, h3 {
                color:#555555;
            }

            .navbar {

                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 50px;
                background-color: rgba(148, 6, 45, 0.87);
                border-radius: 5px;
                flex-direction: row-reverse;
            }


            .hero-section {

                background-image: url("images/Capture%20Home3.PNG");
                background-size: cover;
                background-position: center;
                color: #ffffff;
                padding: 20px;
                height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                text-align: center;
            }


            .hero-content h1 {
                font-size:4em;
                color: rgb(248, 227, 200);
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.43);
            }


            .hero-content p {
                font-size: 1.5em;
                margin-top: -20px;
                color: rgb(248, 227, 200);
            }

            .buy-tickets-btn {
                text-decoration: none;
                margin-top: 230px;
                display: inline-block;
                background-color: rgba(255, 255, 255, 0);
                color: rgb(33, 28, 28);
                border: none;
                padding: 15px 30px;
                font-size: 1.5em;
                font-weight: bold;
                border-radius: 50px;
                cursor: pointer;
                transition: background-color 0.3s;
                margin-left: -30px;
            }

            .welcome-section {
                text-align: center;
                padding: 50px 20px;
                background-color: #ffffff;
            }

            .welcome-section h2 {
                font-size: 2.5em;
                color: rgb(137, 35, 60);
                margin-bottom: 20px;
            }

            /* Upcoming Offers */
            .news-events-section {
                background-color: #295029;
                padding: 50px 20px;
            }

            .news-events-section h2 {

                text-align: center;
                font-size: 2.5em;
                color: #ffffff;
                margin-bottom: 40px;
            }

            .cards-container {
                display: flex;
                justify-content: center;
                gap: 30px;
                flex-wrap: wrap;
                align-items: stretch;
            }

            .card {
                background-color: beige;
                border-radius: 10px;
                overflow: hidden;
                flex: 1 1 300px;
                text-align: center;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            }

            .card img {
                width: 100%;
                height: 200px;
                object-fit: cover;
                display: block;
            }

            .card h3 {
                background-color: #f3f3da;
                color: #635555;
                padding: 10px 0;
                margin: 0;
            }

            .card-btn {
                border: none;
                padding: 10px 20px;
                margin-bottom: 15px;
                border-radius: 5px;
                cursor: pointer;
            }

            .card:nth-child(1) .card-btn {
                background-color: rgb(165, 117, 57);
                color: #ffffff;
            }
            .card:nth-child(2) .card-btn {
                background-color: rgb(165, 117, 57);
                color: white;
            }
            .card:nth-child(3) .card-btn {
                background-color: rgb(165, 117, 57);
                color: white;
            }

            /* All Offers */
            .all-offers-section {
                padding: 50px 20px;
                text-align: center;
                background-color: #f8f8f8;
            }

            .all-offers-box {
                display: inline-block;
                background-color: rgb(140, 100, 49);
                color: white;
                font-size: 1.5em;
                font-weight: bold;
                text-decoration: none;
                padding: 20px 40px;
                border-radius: 50px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                transition: background-color 0.3s ease, transform 0.3s ease;
            }

            .all-offers-box:hover {
                background-color: rgb(117, 69, 10);
                transform: translateY(-5px);
            }

        </style>

    </head>

    <body>

        <header class="hero-section">
            <nav class="navbar">
                <div class="logo">
                    AMA
                    <a href="logout.php" class="logout-link">Logout</a>
                    <a href="update.php" class="avatar-link">⚙️</a>
                </div>
                <ul class="nav-links">
                    <li><a href="Project(Home).php" class="active"> Home </a></li>
                    <li><a href="show%20bage.html"> Shows </a></li>
                    <li><a href="project_ticket.html"> Tickets </a></li>
                    <li><a href="Project(Contact).html"> Contact </a></li>
                </ul>
            </nav>

            <section class="hero-content"> 
                <h1>BUY TICKETS<br> ONLINE</h1>
            </section>

            <section class="hero-content"> 
                <a href="show%20bage.html" class="buy-tickets-btn"> Book Your Tickets Now</a>
            </section>

        </header>

        <section class="welcome-section">
            <h2>WELCOME TO OUR WEBSITE</h2>
            <h3>! Hello Ladies and gentlemen, welcome to the place where laughter meets excitement, here the story begins</h3>
        </section>

        <section class="news-events-section">
            <h2>Upcoming Offers</h2>
            <div class="cards-container">

                <article class="card"> 
                    <img src="images/Capture PR1.PNG" alt="The Enchanted Illusions">
                    <h3>The Enchanted Illusions<br><br> 12 Sept </h3>
                    <button class="card-btn" onclick="window.location.href='project_ticket.html'">Show more</button>
                </article>

                <article class="card"> 
                    <img src="images/Capture PR3.PNG" alt="The Juggling Masters">
                    <h3>The Juggling Masters<br><br> 15 Sept </h3>
                    <button class="card-btn" onclick="window.location.href='project_ticket.html'">Show more</button>
                </article>

                <article class="card"> 
                    <img src="images/Capture PR2.PNG" alt="Wild Wonders Show">
                    <h3>Wild Wonders Show<br><br> 18 Sept </h3>
                    <button class="card-btn" onclick="window.location.href='project_ticket.html'">Show more</button>
                </article>

            </div>
        </section>

        <section class="all-offers-section">
            <a href="show%20bage.html" class="all-offers-box"> Go to viewers of all shows </a>
        </section>




    </body>
</html>
