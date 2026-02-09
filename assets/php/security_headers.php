<?php
// Prevent Clickjacking
header('X-Frame-Options: DENY');

// Prevent MIME type sniffing
header('X-Content-Type-Options: nosniff');

// Enable XSS protection in older browsers
header('X-XSS-Protection: 1; mode=block');

// Enforce HTTPS (HSTS)
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');

// Content Security Policy
header("Content-Security-Policy: default-src 'self' https:; script-src 'self' 'unsafe-inline' https: unpkg.com; style-src 'self' 'unsafe-inline' https: unpkg.com cdn.jsdelivr.net; img-src 'self' data: https: ui-avatars.com; font-src 'self' https: cdn.jsdelivr.net;");

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