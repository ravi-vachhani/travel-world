<?php
$rootPath      = './';
$pageTitle     = 'Contact Us — Travel World Luxury Travel Agency';
$pageDesc      = 'Plan your dream journey with Travel World. Reach out to our luxury travel experts for a personalised itinerary. WhatsApp, email, or enquiry form.';
$pageKeywords  = 'contact Travel World, travel enquiry, luxury travel consultation, book holiday, travel agent contact';
$pageCanonical = 'https://www.travelworld.com/contact.php';
$ogType        = 'website';

$jsonLd = json_encode([
  '@context' => 'https://schema.org',
  '@graph'   => [
    [
      '@type'       => 'ContactPage',
      '@id'         => 'https://www.travelworld.com/contact.php#webpage',
      'url'         => 'https://www.travelworld.com/contact.php',
      'name'        => 'Contact Travel World',
      'description' => $pageDesc,
      'isPartOf'    => ['@id' => 'https://www.travelworld.com/#website'],
    ],
    [
      '@type'           => 'BreadcrumbList',
      'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',       'item' => 'https://www.travelworld.com/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Contact Us', 'item' => 'https://www.travelworld.com/contact.php'],
      ],
    ],
  ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

include __DIR__ . '/includes/page-header.php';
?>

<!-- Hero -->
<section class="page-hero" style="height:50vh;">
  <div class="page-hero-bg" style="background-image:url('https://images.unsplash.com/photo-1488085061387-422e29b40080?w=1600&q=85')"></div>
  <div class="page-hero-overlay"></div>
  <div class="page-hero-content">
    <div class="page-hero-breadcrumb">
      <a href="./">Home</a><span>›</span><span>Contact</span>
    </div>
    <h1 class="page-hero-title">Let's Plan Your Journey</h1>
    <p class="page-hero-tagline">Our travel experts are ready to craft your perfect escape</p>
  </div>
</section>

<!-- Contact Section -->
<section class="inner-section">
  <div class="contact-grid">

    <!-- Info -->
    <div class="contact-info reveal">
      <div class="section-label">Get In Touch</div>
      <h2 class="section-title">We'd Love to Hear From You</h2>
      <p style="color:var(--gray);font-family:'Inter',sans-serif;font-size:0.9rem;line-height:1.8;margin-bottom:2.5rem;">
        Whether you have a destination in mind or simply a dream — our team of luxury travel specialists will listen, inspire and craft an itinerary that exceeds every expectation.
      </p>

      <div class="contact-info-item">
        <i class="fas fa-phone"></i>
        <div>
          <h6>Phone</h6>
          <a href="tel:+919904040001">+91 99040 40001</a>
        </div>
      </div>

      <div class="contact-info-item">
        <i class="fab fa-whatsapp"></i>
        <div>
          <h6>WhatsApp</h6>
          <a href="https://wa.me/919904040001" target="_blank">+91 99040 40001</a>
        </div>
      </div>

      <div class="contact-info-item">
        <i class="fas fa-envelope"></i>
        <div>
          <h6>Email</h6>
          <a href="mailto:travelworld012@gmail.com">travelworld012@gmail.com</a>
        </div>
      </div>

      <div class="contact-info-item">
        <i class="fas fa-map-marker-alt"></i>
        <div>
          <h6>Office</h6>
          <p>Travel World, Ghatlodia Road, CP Nagar 2, Ghatlodiya, Ahmedabad, Gujarat 380061</p>
        </div>
      </div>

      <div class="contact-info-item">
        <i class="fas fa-clock"></i>
        <div>
          <h6>Office Hours</h6>
          <p>Monday – Saturday: 9am – 7pm IST<br>Sunday: 10am – 7pm IST</p>
        </div>
      </div>

      <!-- Social -->
      <div style="margin-top:2rem;display:flex;gap:1rem;">
        <a href="#" style="color:var(--gold);font-size:1.3rem;"><i class="fab fa-instagram"></i></a>
        <a href="#" style="color:var(--gold);font-size:1.3rem;"><i class="fab fa-facebook-f"></i></a>
        <a href="#" style="color:var(--gold);font-size:1.3rem;"><i class="fab fa-youtube"></i></a>
        <a href="#" style="color:var(--gold);font-size:1.3rem;"><i class="fab fa-whatsapp"></i></a>
      </div>
    </div>

    <!-- Form -->
    <div class="reveal">
      <div class="section-label">Enquiry Form</div>
      <h2 class="section-title">Tell Us Your Dream</h2>
      <form class="enquiry-form" id="enquiryForm" style="margin-top:2rem;">
        <input type="text"  name="name"        placeholder="Your Full Name"          required>
        <input type="email" name="email"        placeholder="Email Address"           required>
        <input type="tel"   name="phone"        placeholder="Phone / WhatsApp Number" required>
        <input type="text"  name="destination"  placeholder="Dream Destination(s)">
        <input type="text"  name="dates"        placeholder="Preferred Travel Dates">
        <select name="travellers">
          <option value="" disabled selected>Number of Travellers</option>
          <option>Solo (1)</option>
          <option>Couple (2)</option>
          <option>Small Group (3–5)</option>
          <option>Large Group (6+)</option>
          <option>Family with Kids</option>
        </select>
        <select name="budget">
          <option value="" disabled selected>Budget Range (per person)</option>
          <option>Under ₹50,000</option>
          <option>₹50,000 – ₹1,00,000</option>
          <option>₹1,00,000 – ₹2,00,000</option>
          <option>₹2,00,000 – ₹5,00,000</option>
          <option>₹5,00,000+</option>
        </select>
        <select name="trip_type">
          <option value="" disabled selected>Type of Trip</option>
          <option>Honeymoon</option>
          <option>Family Holiday</option>
          <option>Adventure Travel</option>
          <option>Luxury Escape</option>
          <option>Corporate Travel</option>
          <option>Group Tour</option>
          <option>Solo Travel</option>
        </select>
        <textarea name="message" placeholder="Tell us about your dream trip — destinations, experiences, special occasions…" style="grid-column:1/-1;"></textarea>
        <button type="submit" class="btn-submit" style="grid-column:1/-1;">Send My Enquiry <i class="fas fa-arrow-right" style="margin-left:8px;"></i></button>
      </form>
    </div>

  </div>
</section>

<!-- Map Section -->
<section class="inner-section alt" style="padding-top:0;">
  <div class="reveal" style="border-radius:12px;overflow:hidden;border:1px solid rgba(255,255,255,0.06);">
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2258.5380480903696!2d72.53901223883861!3d23.05970731268148!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e835fa69374ed%3A0xe83a081dfc8a2026!2sTravel%20World!5e1!3m2!1sen!2sin!4v1788340465288!5m2!1sen!2sin"
      width="100%" height="400" style="border:0;display:block;" allowfullscreen="" loading="lazy">
    </iframe>
  </div>
</section>

<!-- FAQ -->
<section class="inner-section">
  <div class="section-label reveal">FAQ</div>
  <h2 class="section-title reveal">Common Questions</h2>
  <div class="tips-grid" style="margin-top:2rem;">
    <div class="tip-card reveal">
      <i class="fas fa-clock"></i>
      <h5>How quickly will you respond?</h5>
      <p>We respond to all enquiries within 4 business hours. For urgent requests, WhatsApp us directly.</p>
    </div>
    <div class="tip-card reveal">
      <i class="fas fa-rupee-sign"></i>
      <h5>Is there a consultation fee?</h5>
      <p>No — our initial consultation and itinerary planning is completely free. We earn our fee from the travel providers.</p>
    </div>
    <div class="tip-card reveal">
      <i class="fas fa-calendar-alt"></i>
      <h5>How far in advance should I book?</h5>
      <p>For peak season travel (Dec–Jan, summer), we recommend booking 3–6 months ahead. Off-season trips can be arranged in 2–4 weeks.</p>
    </div>
    <div class="tip-card reveal">
      <i class="fas fa-shield-alt"></i>
      <h5>Are my payments secure?</h5>
      <p>Yes — we use fully secured payment gateways and all bookings are protected by our travel insurance partnerships.</p>
    </div>
    <div class="tip-card reveal">
      <i class="fas fa-edit"></i>
      <h5>Can I customise my itinerary?</h5>
      <p>Absolutely — every itinerary we create is 100% bespoke. We don't do off-the-shelf packages.</p>
    </div>
    <div class="tip-card reveal">
      <i class="fas fa-headset"></i>
      <h5>Do you provide 24/7 support?</h5>
      <p>Yes — once you're travelling, our emergency support line is available 24/7 for any assistance you need.</p>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/page-footer.php'; ?>