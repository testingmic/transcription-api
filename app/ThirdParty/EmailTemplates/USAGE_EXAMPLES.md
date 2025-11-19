# Email Template Usage Examples

This document shows how to use the email templates with the `Emailing` class.

## Basic Usage

```php
use App\Libraries\Emailing;

$email = new Emailing();
$result = $email->send($recipientEmail, $messageData, $templateName);
```

## Available Templates

1. **default** - General purpose template
2. **verify.reset** - Password reset verification
3. **welcome** - Welcome email for new users
4. **notification** - General notifications

---

## 1. Using the `default` Template

```php
use App\Libraries\Emailing;

$email = new Emailing();

$message = [
    '__subject__' => 'Welcome to Our Platform',
    '__CONTENT_TITLE__' => 'Thank You for Joining!',
    '__CONTENT_BODY__' => '<p>We are excited to have you on board. Get started by exploring our features.</p>',
    '__BUTTON_URL__' => 'https://yourapp.com/dashboard',
    '__BUTTON_TEXT__' => 'Go to Dashboard',
    '__ADDITIONAL_CONTENT__' => '<p>If you have any questions, feel free to contact our support team.</p>'
];

$result = $email->send('user@example.com', $message, 'default');
```

---

## 2. Using the `verify.reset` Template (Password Reset)

```php
use App\Libraries\Emailing;

$email = new Emailing();

$message = [
    '__subject__' => 'Password Reset Request',
    '__fullname__' => 'John Doe',
    '__code__' => '123456'  // 6-digit verification code
];

$result = $email->send('user@example.com', $message, 'verify.reset');
```

**Example from your Auth controller:**
```php
$utilsObject = new \App\Libraries\Emailing();
$utilsObject->send($getUser['email'], [
    '__code__' => $ver_code,
    '__fullname__' => $getUser['name'],
    '__subject__' => 'Password Reset Request Confirmation'
], "verify.reset");
```

---

## 3. Using the `welcome` Template

```php
use App\Libraries\Emailing;

$email = new Emailing();

$message = [
    '__subject__' => 'Welcome to Transc.io!',
    '__fullname__' => 'Jane Smith',
    '__WELCOME_MESSAGE__' => 'Start by uploading your first audio file and let our AI transcribe it for you.',
    '__BUTTON_URL__' => 'https://yourapp.com/get-started',
    '__BUTTON_TEXT__' => 'Get Started'
];

$result = $email->send('user@example.com', $message, 'welcome');
```

---

## 4. Using the `notification` Template

```php
use App\Libraries\Emailing;

$email = new Emailing();

$message = [
    '__subject__' => 'New Transcription Ready',
    '__NOTIFICATION_TITLE__' => 'Your transcription is complete!',
    '__NOTIFICATION_MESSAGE__' => '<p>Your audio file "meeting_recording.mp3" has been successfully transcribed.</p><p>You can now view and download your transcription.</p>',
    '__BUTTON_SECTION__' => '<tr><td align="center" style="padding-bottom: 30px;"><table role="presentation" cellspacing="0" cellpadding="0" border="0"><tr><td align="center" style="background: linear-gradient(121.553deg, rgb(59, 130, 246), rgb(37, 99, 235), rgb(29, 78, 216)); border-radius: 8px;"><a href="https://yourapp.com/transcriptions/123" style="display: inline-block; padding: 14px 32px; font-size: 16px; font-weight: 600; color: #ffffff; text-decoration: none; border-radius: 8px; line-height: 1;">View Transcription</a></td></tr></table></td></tr>',
    '__ADDITIONAL_CONTENT__' => '<p>Thank you for using our service!</p>'
];

$result = $email->send('user@example.com', $message, 'notification');
```

**Simpler version without button:**
```php
$message = [
    '__subject__' => 'Account Update',
    '__NOTIFICATION_TITLE__' => 'Your account has been updated',
    '__NOTIFICATION_MESSAGE__' => '<p>Your account settings have been successfully updated.</p>',
    '__BUTTON_SECTION__' => '',  // Empty string removes button section
    '__ADDITIONAL_CONTENT__' => ''
];

$result = $email->send('user@example.com', $message, 'notification');
```

---

## Default Replacements

The following placeholders are automatically replaced from the `Emailing` class:

- `__APPLOGO__` - Logo URL (default: 'https://portal.mypharmacy.com/assets/images/logo.png')
- `__TITLE__` - App title (default: 'MyPharmacy.com')
- `__TEAM__` - Team signature (default: 'Team - MyPharmacy.com')
- `__INVITE_URL__` - Signup URL (default: app_url + '/auth/signup')
- `__YEAR__` - Current year (automatically set)

You can override these by including them in your `$message` array.

---

## Customizing Default Replacements

You can modify the default replacements by accessing the `replacements` property:

```php
$email = new Emailing();
$email->replacements['__TITLE__'] = 'Transc.io';
$email->replacements['__APPLOGO__'] = 'https://yourapp.com/logo.png';
$email->replacements['__TEAM__'] = 'Team - Transc.io';

$result = $email->send('user@example.com', $message, 'default');
```

---

## Using sendRaw() Method

The `sendRaw()` method allows you to send a pre-formatted HTML template directly:

```php
$email = new Emailing();

$htmlContent = '<html><body><h1>Custom Email</h1><p>This is a custom email body.</p></body></html>';

$data = [
    '__subject__' => 'Custom Email Subject'
];

$result = $email->sendRaw('user@example.com', $data, $htmlContent);
```

---

## Error Handling

Always check the return value:

```php
$email = new Emailing();
$result = $email->send('user@example.com', $message, 'default');

if ($result) {
    echo "Email sent successfully!";
} else {
    echo "Failed to send email.";
}
```

---

## Notes

- In local environment (`is_local` config is true), emails will return `true` without actually sending
- The template name should match the filename without the `.html` extension
- All templates are stored in `app/ThirdParty/EmailTemplates/`
- Placeholders are case-sensitive (use `__CONTENT_TITLE__` not `__content_title__`)

