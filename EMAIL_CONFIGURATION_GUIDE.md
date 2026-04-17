# Email Notification System Configuration Guide

## Overview
The gatepass system now includes a comprehensive email notification system that:
- Sends emails to all relevant authorities when a student creates a gatepass request
- Provides approve/reject links directly in emails
- Sends acknowledgment emails for every action
- Maintains a complete audit trail

## Email Workflow

### 1. Gatepass Submission
When a student submits a gatepass request:
- **Email sent to**: Staff, HOD, Warden, Security (all relevant authorities)
- **Email type**: Notification with approve/reject buttons
- **Student receives**: Acknowledgment email confirming submission

### 2. Approval/Rejection Actions
When an authority approves or rejects via email link:
- **Email sent to**: Student, next approver (if applicable), other authorities
- **Email type**: Acknowledgment of action taken
- **Process continues**: Through approval chain until final approval or rejection

### 3. Final Approval
When gatepass is fully approved:
- **Email sent to**: Student, Security, all previous approvers
- **Email type**: Final approval notification
- **Gatepass status**: Active and ready for use

## Configuration Required

### 1. Email Settings (.env file)
```env
# Gmail SMTP Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="College Outpass System"
```

### 2. Gmail App Password Setup
1. Go to: https://myaccount.google.com/apppasswords
2. Enable 2-factor authentication on your Gmail account
3. Generate a 16-character app password
4. Use this password in the MAIL_PASSWORD field

### 3. Test Configuration
Run: `php artisan config:clear`
Test with: `php artisan tinker` and try sending a test email

## Features

### Smart Recipient Selection
- **Staff**: Class teacher based on student's department
- **HOD**: Head of Department for student's department
- **Warden**: Warden for hosteller students
- **Security**: Security personnel for final approval

### Security Features
- **Secure Tokens**: SHA-256 hashed tokens with 7-day expiration
- **Permission Checks**: Only authorized users can approve/reject
- **Audit Trail**: Complete tracking of all actions and timestamps

### Email Templates
- **Professional Design**: Clean, responsive HTML emails
- **Mobile Friendly**: Works on all devices
- **Action Buttons**: Direct approve/reject links
- **Status Indicators**: Visual status badges and progress

## Troubleshooting

### Emails Not Sending
1. Check .env email configuration
2. Verify Gmail app password is correct
3. Ensure SMTP ports are not blocked
4. Check email logs in storage/logs/laravel.log

### Routes Not Working
1. Run: `php artisan route:clear`
2. Verify routes are properly registered in web.php
3. Check for any route conflicts

### Tokens Not Verifying
1. Ensure gatepass creation timestamp is consistent
2. Check token generation in mailable and verification in controller
3. Verify token expiration (7 days)

## Email Addresses Used
The system sends emails to users based on their roles and college/department assignments. Ensure all users have valid email addresses in the database.

## Testing
To test the email system:
1. Create a test gatepass as a student
2. Check email logs for sent notifications
3. Test approve/reject links from emails
4. Verify acknowledgment emails are sent

## Support
For issues with the email notification system:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify email configuration
3. Test with different user roles
4. Ensure all required users exist in the system
