
# CakePHP Application Skeleton

![Build Status](https://github.com/cakephp/app/actions/workflows/ci.yml/badge.svg?branch=5.x)
[![Total Downloads](https://img.shields.io/packagist/dt/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%208-brightgreen.svg?style=flat-square)](https://github.com/phpstan/phpstan)

A skeleton for creating applications with [CakePHP](https://cakephp.org) 5.x.

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Installation

1. Download [Composer](https://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist cakephp/app [app_name]`.

If Composer is installed globally, run

```bash
composer create-project --prefer-dist cakephp/app
```

In case you want to use a custom app dir name (e.g. `/myapp/`):

```bash
composer create-project --prefer-dist cakephp/app myapp
```

You can now either use your machine's webserver to view the default home page, or start
up the built-in webserver with:

```bash
bin/cake server -p 8765
```

Then visit `http://localhost:8765` to see the welcome page.

## Update

Since this skeleton is a starting point for your application and various files
would have been modified as per your needs, there isn't a way to provide
automated upgrades, so you have to do any updates manually.

## Configuration

Read and edit the environment specific `config/app_local.php` and set up the
`'Datasources'` and any other configuration relevant for your application.
Other environment agnostic settings can be changed in `config/app.php`.

### Services Setup (Email & SMS OTP)

To enable authentication and notification features, you must configure the following variables in your .env file located at the project root.

#### 1. Email Configuration (SMTP)
The application uses SMTP for sending system emails and verification codes. Update your .env with your mail provider details:
```
# Application Debug Mode (true for dev, false for production)
DEBUG=false

# Security Salts and Keys
SECURITY_SALT="cbb99b60aac4db4deebfb00252fc9ee6c863f1b237c424b86724836fc4ff4366"
APP_SECRET_KEY="c5452404eb46b4dbfb669165c61efa20c7f1074705c7fa01ab74e1a80c9490c8"

# Database Configuration
DB_HOST="localhost"
DB_USERNAME="postgres"
DB_PASSWORD="postgres"
DB_DATABASE="cess"
DB_LOG=false

# Test Database Configuration
TEST_DB_HOST="localhost"
TEST_DB_USERNAME="postgres"
TEST_DB_PASSWORD="postgres"
TEST_DB_DATABASE="test_myapp"

# Email Configuration (SMTP)
EMAIL_HOST="smtp.gmail.com"
EMAIL_PORT=587
EMAIL_USERNAME="rudransh@impactyaan.com"
EMAIL_APP_PASSWORD="eszcdcdmyueiobqn"
EMAIL_TLS=true
EMAIL_FROM_ADDRESS="rudransh@impactyaan.com"
EMAIL_FROM_NAME="Cess Portal"

# MSG91 Configuration
MSG91_AUTH_KEY="212223Ap6yiNtk5ae06695"
MSG91_TEMPLATE_ID="699ee0708f7b04fb170b5653"
MSG91_BASE_URL="https://api.msg91.com/api/v5/otp"

```
If you have to change your message provider form msg91 to twilio all you have to do is create a new class and implement it in the code. Then change `app_local.php`

`From: 'SMSProvider' => 'App\Providers\Msg91Provider'`

`To: 'SMSProvider' => 'App\Providers\TwilioProvider'`

## Layout

The app skeleton uses [Milligram](https://milligram.io/) (v1.3) minimalist CSS
framework by default. You can, however, replace it with any other library or
custom styles.

## Usage/Examples

```javascript
import Component from 'my-project'

function App() {
  return <Component />
}
```

