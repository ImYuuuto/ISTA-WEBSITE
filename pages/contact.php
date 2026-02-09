<?php
session_start();
$page_title = "Contact | Établissement";
$current_page = "contact";
$base_path = "../";
$extra_css = ["contact.css"];
$extra_js = ["contact_form.js"];
$extra_head = '
<script>
(() => {
  "use strict"
  window.addEventListener("load", () => {
    const forms = document.querySelectorAll(".needs-validation")
    Array.from(forms).forEach(form => {
      form.addEventListener("submit", event => {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add("was-validated")
      }, false)
    })
  })
})()
</script>';
require_once '../layout/header.php';
?>

<!-- HEADER SECTION -->
<header class="video-header">
    <div class="header-content">
        <h1 class="header-title">Contact US</h1>
    </div>
</header>

<section class="contact-section">
    <div class="container">

        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold">Get In Touch</h2>
            <p class="text-muted">We are here to help you</p>
        </div>

        <!-- CARDS -->
        <div class="row g-4 mb-5">

            <div class="col-md-4" data-aos="zoom-in">
                <div class="card contact-card text-center p-4 border-0">
                    <div class="icon-circle mx-auto mb-3"><i class="bi bi-geo-alt"></i></div>
                    <h5>Our Address</h5>
                    <p class="text-muted">Avenue Brahim Roudani, El Jadida, Maroc</p>
                </div>
            </div>

            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="card contact-card text-center p-4 border-0">
                    <div class="icon-circle mx-auto mb-3"><i class="bi bi-telephone"></i></div>
                    <h5>Contact</h5>
                    <p class="text-muted">05233-41269<br>info@ofppt.ma</p>
                </div>
            </div>

            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="card contact-card text-center p-4 border-0">
                    <div class="icon-circle mx-auto mb-3"><i class="bi bi-clock"></i></div>
                    <h5>Opening Hours</h5>
                    <p class="text-muted">Mon–Sat: 8h–22h</p>
                </div>
            </div>

        </div>

        <!-- FORM -->
        <div class="card p-4 border-0 shadow" data-aos="fade-up">
            <form class="row g-3 needs-validation" novalidate id="contactForm">

                <!-- Feedback Container -->
                <div id="formFeedback" class="col-12" style="display: none;"></div>

                <?php require_once '../assets/php/csrf.php';
                echo csrf_field(); ?>

                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" required>
                        <label for="name">Full Name *</label>
                        <div class="invalid-feedback">Please enter your name</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"
                            required>
                        <label for="email">Email Address *</label>
                        <div class="invalid-feedback">Please enter a valid email</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone Number"
                            required>
                        <label for="phone">Phone *</label>
                        <div class="invalid-feedback">Phone number is required</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" id="service" name="service" required>
                            <option value="" selected disabled>Choose...</option>
                            <option value="Orientation">Orientation</option>
                            <option value="Inscription">Inscription</option>
                        </select>
                        <label for="service">Service *</label>
                        <div class="invalid-feedback">Please select a service</div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control" id="message" name="message" placeholder="Leave a message here"
                            style="height: 150px" required></textarea>
                        <label for="message">Message *</label>
                        <div class="invalid-feedback">Message is required</div>
                    </div>
                </div>

                <div class="col-12 text-end">
                    <button class="btn btn-secondary px-4 py-2" type="submit" id="submitBtn">
                        <span class="spinner-border spinner-border-sm d-none me-2" role="status"
                            aria-hidden="true"></span>
                        <span class="btn-text">Send Message</span>
                    </button>
                </div>

            </form>

        </div>

    </div>
</section>

<div class="container my-5">
    <div class="card border-0 shadow rounded-4 overflow-hidden" data-aos="fade-up">
        <iframe src="https://www.google.com/maps?q=OFPPT%20El%20Jadida&output=embed" width="100%" height="400"
            style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</div>

<?php require_once '../layout/footer.php'; ?>