<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Contact</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="Your page description here"/>
    <meta name="author" content=""/><!-- css -->
    <link href="https://fonts.googleapis.com/css?family=Handlee|Open+Sans:300,400,600,700,800" rel="stylesheet"/>
    <link href="css/bootstrap.css" rel="stylesheet"/>
    <link href="css/bootstrap-responsive.css" rel="stylesheet"/>
    <link href="css/flexslider.css" rel="stylesheet"/>
    <link href="css/prettyPhoto.css" rel="stylesheet"/>
    <link href="css/camera.css" rel="stylesheet"/>
    <link href="css/jquery.bxslider.css" rel="stylesheet"/>
    <link href="css/style.css" rel="stylesheet"/><!-- Theme skin -->
    <link href="color/default.css" rel="stylesheet"/><!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="192x192" href="ico/android-chrome-192x192.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="512x512" href="ico/android-chrome-512x512.png"/>
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon.png"/>
    <link rel="shortcut icon" href="ico/favicon.ico"/><!-- =======================================================
    Theme Name: Eterna
    Theme URL: https://bootstrapmade.com/eterna-free-multipurpose-bootstrap-template/
    Author: BootstrapMade.com
    Author URL: https://bootstrapmade.com
    Modified by Silviu Negoita
  ======================================================= -->
</head>
<body>
<div id="wrapper"><!-- start header -->
    <header>
        <div class="top">
            <div class="container">
                <div class="row">
                    <div class="span6"><!--p class="topcontact"><i class="icon-phone"></i> +62 088 999 123</p--></div>

                    <div class="span6">
                        <ul class="social-network">
                            <li></li>
                            <!--li><a href="#" data-placement="bottom" title="Twitter"><i class="icon-twitter icon-white"></i></a></li-->
                            <!--li><a href="#" data-placement="bottom" title="Linkedin"><i class="icon-linkedin icon-white"></i></a></li-->
                            <!--li><a href="#" data-placement="bottom" title="Pinterest"><i class="icon-pinterest  icon-white"></i></a></li-->
                            <!--li><a href="#" data-placement="bottom" title="Google +"><i class="icon-google-plus icon-white"></i></a></li-->
                            <!--li><a href="#" data-placement="bottom" title="Dribbble"><i class="icon-dribbble icon-white"></i></a></li-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row nomargin">
                <div class="span4">
                    <div class="logo"><a href="index.html"><img alt="" src="img/logo.png"/></a></div>
                </div>

                <div class="span8">
                    <div class="navbar navbar-static-top">
                        <div class="navigation">
                            <nav>
                                <ul class="nav topnav">
                                    <li class="dropdown active"><a href="index.html">Despre noi </a>

                                        <ul class="dropdown-menu">
                                            <li><a href="filiala.html">Filiala UK + Irlanda</a></li>
                                            <li><a href="comunitati.html">Comunitati locale</a></li>
                                            <li><a href="program.html">Program de dezvoltare</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown"><a href="#">Proiecte </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="proiecte-initiative.html">Initiative</a></li>
                                            <li><a href="proiecte-incurs.html">In curs</a></li>
                                            <li><a href="proiecte-incheiate.html">Incheiate</a></li>
                                            <li><a href="contact.php">Implica-te!</a></li>

                                        </ul>
                                    </li>
                                    <li class="dropdown"><a href="https://www.ro.plus/doneaza" target="_blank">Doneaza
                                            <!--i class="icon-angle-down"></i--> </a>
                                    <li class="dropdown"><a href="https://www.ro.plus/adeziune" target="_blank">Adeziune
                                            <!--i class="icon-angle-down"></i--></a>
                                    <li><a href="contact.php">Contact </a></li>
                                </ul>
                            </nav>
                        </div>
                        <!-- end navigation --></div>
                </div>
            </div>
        </div>
    </header>
    <!-- end header -->

    <section id="inner-headline">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="inner-heading">
                        <ul class="breadcrumb">
                            <li><a href="index.html">Home</a></li>
                            <li class="active">Contact</li>
                        </ul>

                        <h2>Contact</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- <section id="content"><iframe allowfullscreen="" frameborder="0" height="380" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d22864.11283411948!2d-73.96468908098944!3d40.630720240038435!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew+York%2C+NY%2C+USA!5e0!3m2!1sen!2sbg!4v1540447494452" style="border:0" width="100%"></iframe> -->

    <div class="container">
        <div class="row">
            <div class="span8">
                <?php


                use PHPMailer\PHPMailer\PHPMailer;
                use PHPMailer\PHPMailer\Exception;

                require "PHPMailer/src/Exception.php";
                require "PHPMailer/src/PHPMailer.php";
                require "PHPMailer/src/SMTP.php";




                if (array_key_exists('to', $_POST)) {
                    $err = false;
                    $msg = '';
                    $email = '';
                    //Apply some basic validation and filtering to the subject
                    if (array_key_exists('subject', $_POST)) {
                        $subject = substr(strip_tags($_POST['subject']), 0, 255);
                    } else {
                        $subject = 'No subject given';
                    }
                    //Apply some basic validation and filtering to the query
                    if (array_key_exists('query', $_POST)) {
                        //Limit length and strip HTML tags
                        $query = substr(strip_tags($_POST['query']), 0, 16384);
                    } else {
                        $query = '';
                        $msg = 'No query provided!';
                        $err = true;
                    }
                    //Apply some basic validation and filtering to the name
                    if (array_key_exists('name', $_POST)) {
                        //Limit length and strip HTML tags
                        $name = substr(strip_tags($_POST['name']), 0, 255);
                    } else {
                        $name = '';
                    }
                    //Validate to address
                    //Never allow arbitrary input for the 'to' address as it will turn your form into a spam gateway!
                    //Substitute appropriate addresses from your own domain, or simply use a single, fixed address
                    if (array_key_exists('to', $_POST) && in_array($_POST['to'], ['elizadascal', 'elizadascal', 'elizadascal'], true)) {
                        $to = $_POST['to'] . '@gmail.com';
                    } else {
                        $to = 'elizadascal@gmail.com';
                    }
                    //Make sure the address they provided is valid before trying to use it
                    if (array_key_exists('email', $_POST) && PHPMailer::validateAddress($_POST['email'])) {
                        $email = $_POST['email'];
                    } else {
                        $msg .= 'Error: invalid email address provided';
                        $err = true;
                    }
                    if (!$err) {


                        $mail = new PHPMailer;

                        $mail->isSMTP();
                        /* SMTP server address. */
                        $mail->Host = '51.83.76.62';
                        /* Use SMTP authentication. */
                        $mail->SMTPAuth = FALSE;
                        /* Set the encryption system. */
//                        $mail->SMTPSecure = 'tls';
//                        /* SMTP authentication username. */
//                        $mail->Username = 'contact_ddcontractors';
//                        /* SMTP authentication password. */
//                        $mail->Password = 'w<$oA93K';
                        /* Set the SMTP port. */
                        $mail->Port = 13784;

                        $mail->CharSet = PHPMailer::CHARSET_UTF8;
                        //It's important not to use the submitter's address as the from address as it's forgery,
                        //which will cause your messages to fail SPF checks.
                        //Use an address in your own domain as the from address, put the submitter's address in a reply-to
                        $mail->setFrom('hello@redphoenixsoftware.co.uk', (empty($name) ? 'Contact form' : $name));
                        $mail->addAddress($to);
                        $mail->addReplyTo($email, $name);
                        $mail->Subject = 'Contact form: ' . $subject;
                        $mail->Body = "Contact form submission\n\n" . $query;
                        if (!$mail->send()) {
                            $msg .= 'Mailer Error: '. $mail->ErrorInfo;
                        } else {
                            $msg .= 'Message sent!';
                        }
                    }
                } ?>
                <h4>Pentru a ne contacta completati formularul de mai jos</h4>

                <div id="sendmessage">Mesajul dvs. a fost trimis. Multumim!</div>

                <div id="errormessage"></div>

                <h1>Contact us</h1>
                <?php if (empty($msg)) { ?>
<!--                    <form method="post">-->
<!--                    <label for="to">Trimite la :</label>-->
<!--                    <select name="to" id="to">-->
<!--                        <option value="sales">Sales</option>-->
<!--                        <option value="support" selected="selected">Support</option>-->
<!--                        <option value="accounts">Accounts</option>-->
<!--                    </select><br>-->
<!--                    -->
<!--                        <label for="subject">Subiect: <input type="text" name="subject" id="subject" maxlength="255"></label><br>-->
<!--                        <label for="name">Nume: <input type="text" name="name" id="name" maxlength="255"></label><br>-->
<!--                        <label for="email">Email: <input type="email" name="email" id="email" maxlength="255"></label><br>-->
<!--                        <label for="query">Mesaj:</label><br>-->
<!--                        <textarea cols="30" rows="8" name="query" id="query" placeholder="Your question"></textarea><br>-->
<!--                        <input type="submit" value="Submit">-->
<!--                    </form>-->


                    <form action="" class="contactForm" method="post" role="form">
                        <div class="row">
                            <div class="span8">
                                <label for="to">Trimite la :</label>
                                <select name="to" id="to">
                                    <option value="sales">Sales</option>
                                    <option value="support" selected="selected">Support</option>
                                    <option value="accounts">Accounts</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="span4 form-group field">
                                <input data-msg="Please enter at least 4 chars"
                                     id="name" name="name"
                                       placeholder="Nume" type="text"/>

                            </div>

                            <div class="span4 form-group"><input data-msg="Please enter a valid email"
                                                                 id="email" name="email" placeholder="E-mail"
                                                                 type="email"/>

                            </div>

                            <div class="span8 form-group">
                                <input data-msg="Please enter at least 8 chars of subject"
                                      id="subject" name="subject"
                                       placeholder="Subiect" type="text"/>

                            </div>

                            <div class="span8 form-group">
				<textarea data-msg="Please write something for us"
                          name="query" id="query"

                          placeholder="Mesajul dvs." rows="5"></textarea>



                                <div class="text-center">
                                    <button class="btn btn-theme btn-medium margintop10" type="submit">Trimite</button>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php } else {
                    echo $msg;
                } ?>












            </div>

            <div class="span4">
                <div class="clearfix"></div>

                <aside class="right-sidebar">
                    <div class="widget">
                        <h5 class="widgetheading">Informatii de contact</h5>
                        <ul class="contact-info">
                            <li><label>Adresa :</label> Momentan doar online</li>
                            <li><label>Telefon :</label>(+44) 0755 316 0665</li>
                            <li><label>Email : </label> diaspora1@ro.plus</li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </div>
    </section>

    <footer>
        <div class="container">
            <div class="row">
                <div class="span4">
                    <div class="widget">
                        <h5 class="widgetheading">Harta site</h5>

                        <ul class="link-list">
                            <li><a href="index.html">Despre noi</a></li>
                            <li><a href="proiecte-incurs.html">Proiecte</a></li>
                            <li><a href="https://www.ro.plus/doneaza">Doneaza</a></li>
                            <li><a href="https://www.ro.plus/adeziune">Adeziune</a></li>
                            <li><a href="contact.php">Contact</a></li>
                        </ul>
                    </div>
                </div>

                <div class="span4">
                    <div class="widget">
                        <h5 class="widgetheading">Adresa</h5>
                        <address>
                            <strong>Doar online momentan</strong><br> Dar avem membri in tot<br>Regatul Unit
                        </address>
                        <p>
                            <i class="icon-phone"></i> (+44) 0755 316 0665<br>
                            <i class="icon-envelope-alt"></i> diaspora1@ro.plus
                        </p>
                    </div>
                </div>
                <div class="span4">
                    <div class="widget">
                        <h5 class="widgetheading">Newsletter</h5>

                        <p>Va tinem la curent cu ce mai facem pentru a schimba modul in care se face poitica..</p>

                        <form class="subscribe">
                            <div class="input-append"><input class="span2" id="appendedInputButton" type="text"/>
                                <button class="btn btn-theme" type="submit">Abonati-va</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="sub-footer">
            <div class="container">
                <div class="row">
                    <div class="span6">
                        <div class="copyright">
                            <p><span>&copy; PLUS UK. All right reserved</span></p>
                        </div>
                    </div>

                    <div class="span6"></div>
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- javascript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!--     <script src="js/jquery.js">
    	
    </script> -->
<!--     <script src="js/jquery.easing.1.3.js">
    	
    </script> -->
<script src="js/js/jquery-1.11.3.min.js"></script>

<!--<script src="js/js/angular.min.js"></script>-->
<!--<script src="js/js/app.js"></script>-->
<!--<script src="js/js/controllers.js"></script>-->
<!--<script src="js/js/notifyMe.js"></script>-->
<!--<script src="js/js/init.js"></script>-->


<script src="js/bootstrap.js">

</script>
<script src="js/modernizr.custom.js">

</script>
<script src="js/toucheffects.js"></script>
<script src="js/google-code-prettify/prettify.js"></script>
<script src="js/jquery.bxslider.min.js"></script>
<script src="js/jquery.prettyPhoto.js"></script>
<!--     <script src="js/portfolio/jquery.quicksand.js"></script> -->
<!--     <script src="js/portfolio/setting.js"></script> -->
<script src="js/jquery.flexslider.js"></script>
<script src="js/animate.js"></script>
<script src="js/inview.js"></script><!-- Contact Form JavaScript File -->
<!--     <script src="contactform/contactform.js"></script> -->
<!-- Template Custom JavaScript File -->
<script src="js/custom.js"></script>


</body>
</html>