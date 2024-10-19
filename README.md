# Burger Order Website

A secure web-based burger ordering platform where users can choose between two burger options, add items to their cart, and securely checkout using Stripe. The website ensures account creation with saved card information and a personalized order history. Admins can manage burger release drop dates and ensure order pickups at specified locations.

Link to live website: https://www.cmsc508.com/~24SP_zeamanuelz/brgrs/login2.php

TEST ACCOUNT (customer): 
- username: username
- password: password

TEST ACCOUNT (admin):
- username: test.admin
- password: password

## Features

- **Burger Selection & Cart**: Choose between two burgers and add them to your cart.
- **Checkout with Stripe**: Secure payment processing integrated with Stripe API.
- **Account Creation**: Users must create an account to access the site and store details like full name and payment info.
- **Order History**: View past orders after logging in.
- **Admin Functionality**: Admins can create and manage burger release dates and pickup locations.
- **Made-to-Order**: Burgers are only available until stock is depleted.

## Security Emphasis

- **Authentication**: Users must be logged in to access any part of the site.
- **Session Management**: User sessions are tracked to prevent unauthorized access.
- **SQL Injection Protection**: All form inputs are sanitized to prevent SQL injection attacks.
- **Password Hashing**: User passwords are securely hashed for storage.

## Admin Features

- **Drop Dates**: Admins can set burger release dates and manage order stock availability.
- **Pickup Locations**: Locations are pre-set for customers to pick up their orders.

## Technologies Used

- **HTML & CSS**: Frontend structure and styling.
- **Stripe API**: Integrated for secure checkout and payment processing.
- **PHP**: Server-side logic and functionality.
- **SQL**: Secure database handling for user details, orders, and admin tasks.

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/burger-order-website.git
2. Configure your Stripe API keys and database settings.
3. Run the project on a local server.
