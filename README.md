
# Laravel React Email Verification Project

A Laravel app with React frontend that sends 6-digit verification codes instead of email links.

##  Quick Start

### Install & Run
```bash
# Clone and install
git clone https://github.com/kelvinwambua/phpgroupproject
cd phpgroupproject
composer install
npm install

# Setup
cp .env.example .env
php artisan key:generate
npm run build

# Start servers on 2 different terminals
npm run dev
php artisan serve
```

Open `http://localhost:8000` - that's it!

### What You'll See
1. **Register** with name, email, password
2. **Check email** for a 6-digit code
3. **Enter code** on verification page
4. **You're in!** Email verified and logged in

##  How It Works

**The Flow:**
- User registers → System generates 6-digit code → Code stored in database → Email sent → User enters code → Email verified

**Key Files:**
```
app/Models/User.php                    # Custom email verification logic
app/Notifications/VerifyEmailWithCode.php    # Email with code (not link)
resources/js/Pages/Auth/VerifyEmail.jsx      # Code input form
```

**Database:**
- `users` table: Standard user data + email_verified_at
- `email_verifications` table: Stores codes with expiration (15 minutes)

## ⚙️ Configuration

**Using your own email?** Edit `.env`:
```env
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_FROM_ADDRESS=your_email@gmail.com
```

**Gmail users:** Need an "App Password" (enable 2FA first)

## 🛠️ Basic Customizations

**Change code length** (in `app/Models/User.php`):
```php
$code = rand(1000, 9999); // 4 digits instead of 6
```

**Change expiration time**:
```php
'expire_date' => now()->addMinutes(30) // 30 minutes instead of 15
```

**Customize email** (in `app/Notifications/VerifyEmailWithCode.php`):
```php
return (new MailMessage)
    ->subject('Your Custom Subject')
    ->line('Your verification code is: ' . $this->code);
```

##  Project Structure

```
app/
├── Models/User.php                     # User model + verification logic
├── Models/EmailVerification.php       # Stores verification codes  
├── Notifications/VerifyEmailWithCode.php  # Email notification
└── Http/Controllers/Auth/             # Registration & verification

resources/js/Pages/Auth/
├── Register.jsx                       # Registration form
└── VerifyEmail.jsx                    # Code verification form

database/
├── database.sqlite                    # Database (already set up)
└── migrations/                        # Table structures
```

##  Troubleshooting

**Emails not sending?** Check your `.env` email settings

**Frontend not updating?** Run `npm run build`

**Need to reset?** Run `php artisan migrate:fresh` (deletes all data)

##  Development Mode

For active development:
```bash
# Terminal 1
php artisan serve

# Terminal 2  
npm run dev
```



