<?php
/**
 * csrf.php
 * Simple CSRF protection helper.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Generates a CSRF token if one doesn't exist for the session.
 */
function generate_csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validates the provided CSRF token against the session token.
 */
function validate_csrf_token($token)
{
    if (!isset($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Returns an HTML hidden input field with the CSRF token.
 */
function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . generate_csrf_token() . '">';
}
?>