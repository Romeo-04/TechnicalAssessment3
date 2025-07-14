# Activity B - MySQL Authentication System

## 📋 Overview
A complete PHP authentication system with MySQL database integration featuring user registration, login, session management, and password change functionality.

## 🚀 Features Implemented

### 1. **Registration Module (`ActB.php`)**
- ✅ Complete form with First Name, Last Name, Email, Password, Confirm Password
- ✅ Password confirmation validation
- ✅ Email uniqueness validation
- ✅ Secure password hashing using `password_hash()`
- ✅ Data saved to MySQL database
- ✅ Instant feedback display after submission
- ✅ Modern responsive design with CSS

### 2. **Login System (`login.php`)**
- ✅ Email and password authentication
- ✅ Credentials verified against MySQL database
- ✅ Session creation upon successful login
- ✅ Secure password verification using `password_verify()`
- ✅ Error handling for invalid credentials
- ✅ Responsive design matching registration

### 3. **User Dashboard (`dashboard.php`)**
- ✅ User profile information display
- ✅ Session-protected access
- ✅ Password change functionality
- ✅ Current password verification
- ✅ New password confirmation validation
- ✅ Real-time validation messages
- ✅ Logout functionality

### 4. **Session Management**
- ✅ Complete session handling
- ✅ Automatic redirects for logged-in users
- ✅ Access control for protected pages
- ✅ Session destruction on logout
- ✅ Security measures implemented

## 🗄️ Database Structure

### Database: `sa3_activityb`
### Table: `users`

| Field | Type | Null | Key | Extra |
|-------|------|------|-----|-------|
| id | int | NO | PRI | auto_increment |
| firstname | varchar(50) | NO | | |
| lastname | varchar(50) | NO | | |
| email | varchar(100) | NO | UNI | |
| password | varchar(255) | NO | | |
| created_at | timestamp | YES | | DEFAULT CURRENT_TIMESTAMP |

## 📁 File Structure

```
Activity_B/
├── ActB.php           # Main registration module
├── login.php          # Login page
├── dashboard.php      # User dashboard (protected)
├── logout.php         # Logout with session destruction
├── index.php          # Landing page
├── config.php         # Database configuration
├── db_viewer.php      # Database viewer page
├── database_setup.sql # SQL setup script
└── README.md          # This file
```

## 🔧 Setup Instructions

### Prerequisites
- XAMPP installed and running
- Apache and MySQL services started

### Installation Steps

1. **Copy Files**
   ```
   Copy all files to: c:\xampp\htdocs\SA3\Activity_B\
   ```

2. **Start XAMPP**
   - Start Apache
   - Start MySQL

3. **Database Setup** (Automatic)
   - The system automatically creates the database and table
   - Visit any page and the database will be created

4. **Manual Database Setup** (Optional)
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Import `database_setup.sql` or run the SQL commands

5. **Access the System**
   - Main page: `http://localhost/SA3/Activity_B/`
   - Registration: `http://localhost/SA3/Activity_B/ActB.php`
   - Login: `http://localhost/SA3/Activity_B/login.php`
   - Database viewer: `http://localhost/SA3/Activity_B/db_viewer.php`

## 🔐 Security Features

- **Password Hashing**: Uses PHP's `password_hash()` with bcrypt
- **SQL Injection Protection**: Prepared statements used throughout
- **Input Sanitization**: All inputs sanitized and validated
- **Session Security**: Proper session management and cleanup
- **Access Control**: Protected pages check for valid sessions

## 📱 Responsive Design

- Modern CSS with gradient backgrounds
- Mobile-responsive layouts
- Consistent styling across all pages
- User-friendly form designs
- Visual feedback for all actions

## 🧪 Testing the System

### Test Registration
1. Go to `ActB.php`
2. Fill in all fields
3. Use different passwords to test validation
4. Check database for saved data

### Test Login
1. Go to `login.php`
2. Use registered email and password
3. Test with wrong credentials
4. Verify session creation

### Test Dashboard
1. Login successfully
2. View profile information
3. Test password change with wrong current password
4. Test password change with mismatched new passwords
5. Test successful password change

### Test Access Control
1. Try accessing `dashboard.php` without login
2. Try accessing `login.php` when already logged in
3. Test logout functionality

## 📊 Database Verification

### View in phpMyAdmin
1. Open: `http://localhost/phpmyadmin`
2. Select database: `sa3_activityb`
3. View table: `users`
4. Check data structure and entries

### View in Application
1. Go to: `http://localhost/SA3/Activity_B/db_viewer.php`
2. See database structure and user data
3. Real-time view of registered users

## 🎯 Validation Messages

### Registration
- ✅ "Password and confirm password are not the same"
- ✅ "Registration Successful!" with user details
- ✅ "Email already exists!"
- ✅ Field validation for empty inputs

### Login
- ✅ "Invalid email or password!"
- ✅ Successful redirect to dashboard

### Password Change
- ✅ "Current password is not the same with the old password"
- ✅ "New password and Re-Enter new password should be the same"
- ✅ "Password changed successfully!"

## 🔄 Session Flow

1. **Unregistered User**: Registration → Login → Dashboard
2. **Registered User**: Login → Dashboard
3. **Logged-in User**: Automatic redirect to dashboard
4. **Logout**: Session destroy → Redirect to login

## 📈 System Benefits

- **Complete CRUD Operations**: Create users, Read profiles, Update passwords
- **Secure Authentication**: Industry-standard security practices
- **User Experience**: Intuitive navigation and clear feedback
- **Scalable Design**: Easy to extend with additional features
- **Database Integration**: Proper MySQL integration with error handling

## 🛠️ Troubleshooting

### Common Issues
1. **Database Connection Error**: Ensure MySQL is running in XAMPP
2. **Permission Denied**: Check file permissions
3. **Session Issues**: Clear browser cookies/cache
4. **Database Not Created**: Visit any page to auto-create

### Debug Mode
- Check `config.php` for database connection
- Enable error reporting in PHP
- Check Apache/MySQL logs in XAMPP

---

**System Created**: July 2025  
**Technology Stack**: PHP, MySQL, HTML, CSS  
**Security Level**: Production-ready with proper validations
