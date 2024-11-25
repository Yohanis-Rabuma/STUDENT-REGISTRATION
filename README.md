# WordPress Content Management System (CMS):

### 1. **WordPress.com**
   - This is a hosted version of WordPress. It's simpler to set up and manage, but it has some limitations unless you pay for a premium plan.
   - Go to [WordPress.com](https://wordpress.com/), sign up, and choose a plan that suits your needs.
   - Choose a domain name, and you'll be guided through the setup process.

### 2. **WordPress.org (Self-hosted)**
   - This version of WordPress gives you full control over your website. You need to have a web hosting provider and a domain name.
   - Download WordPress from [WordPress.org](https://wordpress.org/download/).
   - Here's a general step-by-step guide to install WordPress manually:
   
   **Step 1: Get Web Hosting & Domain Name**
   - Choose a web hosting provider (like Bluehost, SiteGround, or HostGator) that supports PHP and MySQL.
   - Register a domain name if you don’t already have one.

   **Step 2: Download WordPress**
   - Go to [WordPress.org](https://wordpress.org/download/) and download the latest version of WordPress.

   **Step 3: Upload WordPress Files to Your Server**
   - Use an FTP client (like FileZilla) or your web host’s file manager to upload the WordPress files to your web server.
   - Typically, files should be uploaded to the `public_html` folder (or similar).

   **Step 4: Create a MySQL Database**
   - Log in to your web hosting control panel (cPanel or equivalent).
   - Find the Database section and create a new MySQL database.
   - Create a database user and assign it to the database with all privileges.

   **Step 5: Configure the `wp-config.php` File**
   - Locate the `wp-config-sample.php` file in the WordPress folder you uploaded.
   - Rename it to `wp-config.php`.
   - Open it and enter your database name, username, and password.

   **Step 6: Run the Installation Script**
   - Open a web browser and go to `http://yourdomain.com/wp-admin/install.php`.
   - Follow the instructions to complete the installation. You'll need to set a website title, admin username, password, and email address.

   **Step 7: Log in to WordPress Dashboard**
   - Go to `http://yourdomain.com/wp-admin` and log in using the credentials you created.
   - Start building your website!

### 3. **One-Click Installation via Hosting Provider**
   - Many web hosting providers offer one-click WordPress installation, which simplifies the process.
   - Log in to your web hosting account and look for the WordPress installer in the control panel.
   - Follow the instructions to install WordPress automatically.

 
