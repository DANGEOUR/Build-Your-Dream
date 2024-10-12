<?php
include "shared/header.php";
include "shared/config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mesg = "";

if (isset($_POST['btn'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $msg = stripslashes($_POST['Message']);

    $sql = "INSERT INTO `contact`( `name`, `phone`, `email`, `message`) VALUES ('$name','$phone','$email','$msg')";
    $query = mysqli_query($conn, $sql);
    if (!$query) {
        die(mysqli_error($conn));
    } else {
        $mesg = "Thanks For Contacting us, Our Team will contact you soon.";
        
        $mail = new PHPMailer(true); // true enables exceptions
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'huzaifadx780@gmail.com'; // SMTP username
            $mail->Password = 'tmzj nmlt levm opwb'; // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587; // TCP port to connect to

            //Recipients
            $mail->setFrom('huzaifadx780@gmail.com', 'Mailer');
            $mail->addAddress($email, $name); // Send email to the user who submitted the form

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Thanks for Contacting Us';
			$mail->Body = 'Thanks for reaching out to us. Your message is "' . $msg . '". We will get back to you soon.';


            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>
<!-- Begin bread crumbs -->
<nav class="bread-crumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="bread-crumbs-list">
                    <li>
                        <a href="index.html">Home</a>
                        <i class="material-icons md-18">chevron_right</i>
                    </li>
                    <li>Contacts</li>
                </ul>
            </div>
        </div>
    </div>
</nav><!-- End bread crumbs -->

<div class="section">
    <div class="container">
        <div class="row content-items">
            <div class="col-12">
                <div class="section-heading">
                    <div class="section-subheading">We are always in touch</div>
                    <h1>Contacts</h1>
                </div>
            </div>
            <div class="col-xl-4 col-md-5 content-item">
                <div class="contact-info section-bgc">
                    <h3>Get in Touch</h3>
                    <ul class="contact-list">
                        <li>
                            <i class="material-icons material-icons-outlined md-22">location_on</i>
                            <div class="footer-contact-info">
                                <a href="https://goo.gl/maps/2Ygp5S2Ssm1G5o329">
                                    4730 Crystal Springs Dr, Los Angeles, CA
                                </a>
                            </div>
                        </li>
                        <li>
                            <i class="material-icons material-icons-outlined md-22">smartphone</i>
                            <div class="footer-contact-info">
                                <a href="tel:+13239134688" class="formingHrefTel">+1 323-913-4688</a>
                                <a href="tel:+13238884554" class="formingHrefTel">+1 323-888-4554</a>
                            </div>
                        </li>
                        <li>
                            <i class="material-icons material-icons-outlined md-22">email</i>
                            <div class="footer-contact-info">
                                <a href="mailto:mail@example.com">mail@example.com</a>
                                <a href="mailto:info@example.com">info@example.com</a>
                            </div>
                        </li>
                        <li>
                            <i class="material-icons material-icons-outlined md-22">schedule</i>
                            <div class="footer-contact-info"><p>Mon - Fri: 9:00 - 18:00</p></div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-8 col-md-7 content-item">
                <!-- Display the message at the top of the form -->
                <?php if ($mesg != ""): ?>
                    <div class="alert alert-success">
                        <?php echo $mesg; ?>
                    </div>
                <?php endif; ?>
                <form method="POST">
                    <input type="hidden" name="Subject" value="Contact form">
                    <div class="row gutters-default">
                        <div class="col-12">
                            <h3>Contact Form</h3>
                        </div>
                        <div class="col-xl-4 col-sm-6 col-12">
                            <div class="form-field">
                                <label for="contact-name" class="form-field-label">Full Name</label>
                                <input type="text" class="form-field-input" name="name" value="" autocomplete="off" id="contact-name" required data-pristine-required-message="This field is required.">
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6 col-12">
                            <div class="form-field">
                                <label for="contact-phone" class="form-field-label">Phone Number</label>
                                <input type="tel" class="form-field-input mask-phone" name="phone" value="" autocomplete="off" id="contact-phone" required data-pristine-required-message="This field is required.">
                            </div>
                        </div>
                        <div class="col-xl-4 col-12">
                            <div class="form-field">
                                <label for="contact-email" class="form-field-label">Email Address</label>
                                <input type="email" class="form-field-input" name="email" value="" autocomplete="off" id="contact-email" required data-pristine-required-message="This field is required." data-pristine-email-message="Please enter a valid email address.">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-field">
                                <label for="contact-message" class="form-field-label">Your Message</label>
                                <textarea name="Message" class="form-field-input" id="contact-message" cols="30" rows="6"></textarea>
                            </div>
                            <div class="form-btn">
                                <button type="submit" name="btn" class="btn btn-border btn-with-icon btn-small ripple">
                                    <span>Send Message</span>
                                    <svg  class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9"><use  xlink:href="assets/img/sprite.svg#arrow-right"></use></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Begin map -->
<div class="map">
    <iframe class="lazy" data-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3618.137712000749!2d67.03045847443208!3d24.92737814257843!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb33f90157042d3%3A0x93d609e8bec9a880!2sAptech%20Computer%20Education%20North%20Nazimabad%20Center!5e0!3m2!1sen!2s!4v1719675216546!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div><!-- End map -->

<?php
include "shared/footer.php";
?>
