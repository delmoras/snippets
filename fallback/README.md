
# 🔁 Proxy File Fetcher for Static Assets

This PHP script acts as a **secure proxy** to fetch and serve static files (such as images, CSS, JS, fonts, and videos) from the **live site `https://yourwebsite.com`**.

## 📌 What It Does

- Accepts a `file` query parameter (e.g., `?file=assets/image.jpg`)
- **Validates the file extension** to prevent abuse or unauthorized access
- Forwards the request to `https://yourwebsite.com/{file path}`
- Returns the fetched file with the correct `Content-Type` header
- Returns a `403 Forbidden` for disallowed extensions
- Returns a `404 Not Found` if the remote resource doesn't exist

## ✅ Allowed File Types

The script will only allow and proxy the following file extensions:

```
jpg, jpeg, png, gif, webp, svg,
js, css,
woff, woff2, ttf, eot,
mp4, webm, ogg
```

## 🚫 Security Notes

- Requests for disallowed extensions (e.g., `.php`, `.txt`, `.env`) are blocked to **mitigate security risks**.
- It strips leading slashes to prevent malformed paths.

## 🔧 Usage Example

```bash
GET /proxy.php?file=images/logo.png
```

This will fetch the file from:

```bash
https://yourwebsite.com/images/logo.png
```

And return it as if it were local.

## 🛠 Requirements

- PHP with cURL enabled
- A web server (e.g., Apache, Nginx) to serve the script

## 💡 Use Case

Ideal for use in staging or preview environments where you want to serve production assets without duplicating them locally.

## 🔄 .htaccess Fallback Setup

If you'd like this script to act as a **fallback handler** for missing static/media files, you can add the following to your `.htaccess` file:

```apache
<IfModule mod_rewrite.c>
RewriteEngine On

# If file doesn't exist and is a media/static file, redirect to fallback
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*\.(jpg|jpeg|png|gif|webp|svg|js|css|woff|woff2|ttf|eot|mp4|webm|ogg))$ /fallback.php?file=$1 [L]
</IfModule>
```

This will automatically forward requests for missing media/static files to your fallback script.
