<?php
// Prevent Clickjacking
header('X-Frame-Options: DENY');

// Prevent MIME type sniffing
header('X-Content-Type-Options: nosniff');

// Enable XSS protection in older browsers
header('X-XSS-Protection: 1; mode=block');

// Enforce HTTPS (HSTS) - Uncomment if SSL is enabled
// header('Strict-Transport-Security: max-age=31536000; includeSubDomains');

// Content Security Policy - Basic start, can be tightened later
// header("Content-Security-Policy: default-src 'self' https:; script-src 'self' 'unsafe-inline' https:; style-src 'self' 'unsafe-inline' https:; img-src 'self' data: https:;");

// Secure Session Cookie Settings
if (session_status() === PHP_SESSION_NONE) {
    // Set secure params before starting session
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '', // Set to your domain
        'secure' => isset($_SERVER['HTTPS']), // Only send over HTTPS if enabled
        'httponly' => true, // Javascript cannot access cookie
        'samesite' => 'Strict' // CSRF protection
    ]);
}
?>