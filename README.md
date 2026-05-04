# FTLuma-Light

FTLuma-Light is a modern, premium blog and event management system built with PHP and MySQL. It features a clean, responsive design with a focus on high-performance and aesthetic excellence.

## 🌟 Features

- **Dynamic Blog Engine**: Create and manage blog posts with rich text editing.
- **Author Management**: Add contributors and attribute articles to specific authors with bio sections.
- **Event Management**: Schedule upcoming events and allow users to make reservations.
- **Premium Admin Panel**: A sophisticated dashboard for managing content, categories, and reservations.
- **Responsive Design**: Fully optimized for mobile, tablet, and desktop viewing.
- **SEO Optimized**: Built-in best practices for search engine visibility.

## 🛠️ Technology Stack

- **Backend**: PHP 8.2+
- **Database**: MySQL
- **Frontend**: Vanilla CSS, HTML5, JavaScript
- **Editor**: Quill.js for rich text content

## 🚀 Getting Started

### Prerequisites

- A local server environment like **XAMPP**, **WAMP**, or a built-in PHP server.
- MySQL Database.

### Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/[your-username]/FTLuma-light.git
   ```

2. **Database Setup**:
   - Create a database named `blog_db` in your MySQL server.
   - Import `schema.sql` and `seed_data.sql` from the root directory.

3. **Configuration**:
   - Open `config.php` and update your database credentials if necessary.

4. **Run the Project**:
   - If using XAMPP, move the folder to `htdocs` and access it via `localhost/FTLuma-light`.
   - Alternatively, run `php -S localhost:8000` from the root directory.

## 🔑 Admin Access

- **Login URL**: `/admin/login.php`
- **Default Username**: `admin`
- **Default Password**: `password123`

## 📄 License

This project is open source and available under the [MIT License](LICENSE).
