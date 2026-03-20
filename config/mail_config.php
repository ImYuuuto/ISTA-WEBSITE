<?php
/**
 * Gmail SMTP configuration for password reset emails.
 *
 * To use Gmail SMTP:
 * 1. Enable 2-Factor Authentication on your Google account
 * 2. Go to: https://myaccount.google.com/apppasswords
 * 3. Create an "App Password" for "Mail"
 * 4. Use that 16-character password below (not your regular Gmail password)
 */
return [
    'smtp_host'     => 'smtp.gmail.com',
    'smtp_port'     => 587,
    'smtp_username' => 'yuutoace5@gmail.com',
    'smtp_password' => 'jypyuqfbjsnudfqn',
    'from_email'    => 'your-email@gmail.com',
    'from_name'     => 'Établissement OFPPT',
];
