<!DOCTYPE html>
    <html lang="en">
        <head>
            <title>
                Thanks
            </title>
        </head>
        <meta charset='utf-8'>
        <link rel="stylesheet" href="main.css">
        <link rel="shortcut icon" href="camera.ico">
        <link rel="stylesheet" media="print" href="print.css">
        <meta name="viewport" content="width=device-with, initial-scale=1.0">
        <body>
            <img src="background.jpg" alt="background" id="background">
            <div id="left-column">
                <nav id="navfixed">
                    <ul>
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>
                            <a href="iso.html">ISO</a>
                        </li>
                        <li>
                            <a href="aperture.html">Aperture</a>
                        </li>
                        <li>
                            <a href="shutter.html">Shutter</a>
                        </li>
                        <li>
                            <a href="equip.html">Other Equipments</a>
                        </li>
                        <li>
                            <a href="comp.html">Camera Comparison</a>
                        </li>
                        <li>
                            <a href="form.html">Sign Up Form</a><span id="quote"> (sign up for more information)</span>
                        </li>
                    </ul>
                    <h3>
                        Other Links:
                    </h3>
                    <ul>
                        <li>
                            <a href="http://www.fotobeginner.com/">FOTO BEGINNER</a>
                        </li>
                        <li>
                            <a href="http://www.techradar.com/news/photography-video-capture/cameras/buying-guide-best-slrs-for-beginners-1251700">Techradar</a>
                        </li>
                        <li>
                            <a href="https://en.wikipedia.org/wiki/Camera">Wikipedia - Camera</a>
                        </li>
                        <li>
                            <footer>
                                &copy; 2017 STANLEY HUNG
                            </footer>
                        </li>
                        <li></li>
                        <li></li>
                    </ul>
                </nav>
            </div>
            <div id="main-column">
                <h1>
                    Thank You! Request has been received. Thanks for your participation!
                </h1>
                <?php
                    $message = "Name: ".$_POST['name']."\n";
                    $message .= "Gender: ".$_POST['gender']."\n";
                    $message .= "Email: ".$_POST['email']."\n";
                    $message .= "Comment: ".$_POST['comments']."\n"; 
                    mail("stanleyhung0908@gmail.com","New Registration",$message);
                ?>
            </div>    
        </body>
        <header id="headfixed">
            <h1>
                <img src="camera.png" alt="cartoon">
                PHOTOGRAPHING BEGINNER
                <img src="camera.png" alt="cartoon">
            </h1>
            <h4>
                THANK YOU
            </h4>
        </header>
    </html>