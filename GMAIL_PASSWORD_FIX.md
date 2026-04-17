# Gmail Password Issue - Solution Required

## Current Issue
The email system is failing because Gmail requires an **application-specific password**. The password "ldpprakash@123" is not being accepted.

## What You Need to Do

### 1. Generate Correct App Password
1. Go to: https://myaccount.google.com/apppasswords
2. Make sure 2-factor authentication is enabled on your Gmail account
3. Click "Select app" → Choose "Other (Custom name)"
4. Enter: `College Outpass System`
5. Click "Generate"
6. **Copy the 16-character password** (it will look like: `abcd efgh ijkl mnop`)

### 2. Update Configuration
The app password is **16 characters** with spaces. Remove spaces when using in .env file.

Example:
```
Generated: abcd efgh ijkl mnop
Use in .env: abcdefghijklmnop
```

### 3. Update Your Email Config
Run this command again with the correct 16-character password:

```bash
php configure_email.php
```

Then edit the `.env` file manually:
```
MAIL_PASSWORD=your-16-character-password-without-spaces
```

## Common Issues

### "Less secure apps" error
- Enable 2-factor authentication first
- Generate app password (not regular password)

### "Authentication failed" error
- Ensure you're using the 16-character app password
- Remove spaces from the password
- Check for typos in email address

## Testing
After fixing the password:
```bash
php artisan config:clear
php test_email_credentials.php
```

## Quick Fix Steps
1. Generate new app password at: https://myaccount.google.com/apppasswords
2. Use the 16-character password (without spaces)
3. Update .env file
4. Clear config: `php artisan config:clear`
5. Test again

The email system will work perfectly once you have the correct app password!
