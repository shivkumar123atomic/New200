QUIET PAGES — PHP + MySQL writing website
==========================================

WHAT'S INCLUDED
- Public homepage and article pages
- Admin login using PHP password_hash/password_verify
- Admin dashboard: list, edit, publish, draft and delete stories
- Writing editor with title, excerpt, category, cover image URL and content
- MySQL database, prepared statements, CSRF protection and session hardening
- Responsive Medium-inspired layout

REQUIREMENTS
- PHP 8.0+ (PDO MySQL enabled)
- MySQL 5.7+ or MariaDB
- Web hosting with HTTPS recommended

INSTALL
1. Create a MySQL database and database user in your hosting control panel.
2. Import schema.sql using phpMyAdmin.
3. Edit config.php and set DB_HOST, DB_NAME, DB_USER and DB_PASS.
4. Change INSTALL_KEY in config.php to a long random private value.
5. Upload all files/folders to your website's document root (often public_html).
6. Visit https://your-domain.com/install.php
7. Enter your INSTALL_KEY, choose an admin username and a strong password (12+ characters).
8. DELETE install.php from the server immediately after the admin is created.
9. Visit https://your-domain.com/admin/login.php and sign in.
10. Publish your first story from the dashboard.

SECURITY NOTES
- Use HTTPS on the live site.
- Never share config.php or your database credentials.
- Delete install.php after setup.
- Use a unique, long admin password.
- Keep PHP and hosting software updated.
- This starter does not include public user accounts, comments, file uploads, analytics or password reset.
- Cover images are entered as HTTPS/HTTP image URLs; images are not uploaded to the server.
- The editor stores plain text and preserves line breaks. This avoids unsafe raw HTML rendering.
- Back up the MySQL database regularly.

CUSTOMIZE
- Change SITE_NAME in config.php.
- Edit assets/style.css to change colors and typography.
- Change the introductory copy in index.php.
