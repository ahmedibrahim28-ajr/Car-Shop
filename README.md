# 🚗 Porsche Car Shop

A full-stack **PHP & MySQL** web application for browsing, customizing, and purchasing Porsche vehicles. Built with a user-facing storefront and a complete admin dashboard.

---

## ✨ Features

### 👤 User Side
- **Authentication** — Register, log in, and log out with session management
- **Home Page** — Hero video background, featured models, special offers, gallery, and contact section
- **Car Categories** — Browse all available Porsche models with specs (top speed, horsepower, price, stock)
- **Car Customization** — Configure exterior color, interior color, and technology options
- **Compare Cars** — Side-by-side comparison of different models
- **Favorites** — Save and manage your favorite cars
- **News** — Read the latest Porsche news posted by admins

### 🛠️ Admin Panel
- **Dashboard** — View total users, cars in stock, total inventory value, and total sales
- **CRUD Operations** — Add, edit, and delete records for:
  - Car Models
  - Colors (Exterior & Interior)
  - Technology packages
  - Models & Extras
  - Favourite Lists
- **Image Upload** — Upload car images directly from the admin panel
- **News Management** — Post and manage news articles

---

## 🗂️ Project Structure

```
car shop/
├── db_connection.php          # Database connection helper
├── Admin/
│   ├── index.php              # Admin dashboard
│   ├── add.php                # Add new records
│   ├── add_news.php           # Add news articles
│   ├── edit.php               # Edit records
│   ├── edit_table.php         # Dynamic table editor
│   ├── delete.php             # Delete records
│   ├── add/
│   │   └── upload_image.php   # Image upload handler
│   └── css/                   # Admin stylesheets
└── porcshe/
    ├── index.php              # Home page
    ├── category.php           # Car listings
    ├── customize_car.php      # Car configurator
    ├── compare.php            # Car comparison
    ├── favorites.php          # User favorites
    ├── news.php               # News page
    ├── login.php              # Login page
    ├── sign_up.php            # Registration page
    ├── logout.php             # Logout handler
    ├── header.php             # Shared header component
    ├── img/                   # Car images & media
    └── images/                # Additional assets
```

---

## 🛠️ Tech Stack

| Layer      | Technology              |
|------------|-------------------------|
| Backend    | PHP (procedural)        |
| Database   | MySQL (`car_brand_shop`)|
| Frontend   | HTML5, CSS3, JavaScript |
| Icons      | Font Awesome 6          |
| Sessions   | PHP native sessions     |

---

## ⚙️ Setup & Installation

### Prerequisites
- PHP 7.4+
- MySQL 5.7+ or MariaDB
- Apache / XAMPP / WAMP / LAMP

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/ahmedibrahim28-ajr/car-shop.git
   cd car-shop
   ```

2. **Set up the database**
   - Create a MySQL database named `car_brand_shop`
   - Import the SQL schema (if provided) or create tables manually based on the queries used in the PHP files
   - Tables include: `users`, `car_model`, `car_model_image`, `color`, `exterior`, `interior_color`, `technology`, `models`, `favourite_list`, `receipt`

3. **Configure the database connection**

   Open `db_connection.php` and update the credentials:
   ```php
   $connection = mysqli_connect("127.0.0.1", "your_host", "your_password", "car_brand_shop");
   ```

4. **Move files to your server**
   - Place the project folder inside your web root (e.g., `htdocs/` for XAMPP)

5. **Run the app**
   - Open your browser and go to: `http://localhost/car shop/porcshe/login.php`

---

## 📸 Pages Overview

| Page               | URL                        |
|--------------------|----------------------------|
| Login              | `porcshe/login.php`        |
| Register           | `porcshe/sign_up.php`      |
| Home               | `porcshe/index.php`        |
| Car Categories     | `porcshe/category.php`     |
| Customize Car      | `porcshe/customize_car.php`|
| Compare Cars       | `porcshe/compare.php`      |
| Favorites          | `porcshe/favorites.php`    |
| News               | `porcshe/news.php`         |
| Admin Dashboard    | `Admin/index.php`          |

---

## 🔒 Notes

- The app uses **PHP sessions** for authentication. All pages are protected and redirect to the login page if no session exists.
- The admin panel is accessible directly — consider adding admin-role authentication for production use.
- Car images are stored locally in the `porcshe/img/` directory.

---

## 👨‍💻 Author

**Ahmed Ibrahim**  
GitHub: [@ahmedibrahim28-ajr](https://github.com/ahmedibrahim28-ajr)

---

## 📄 License

This project is open source and available under the [MIT License](LICENSE).
