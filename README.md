# Car Rental Website with Admin Panel & Booking System

This is a web-based information system for a **Car Rental Business**, designed to showcase the car catalog, facilitate online bookings, and provide a complete admin panel for operational management.

---

## 🎯 Key Features

* **Online Booking & Payment System**
    * Customers can check car availability in *real-time* based on selected dates.
    * Full *checkout* process with document upload (ID/Driver’s License).
    * Payment integration with **Midtrans (Payment Gateway)**, supporting multiple payment methods.
    * Promo coupon system for discounts.

* **Dynamic & Responsive Public Pages**
    * **Landing Page** with a Hero Section, Key Advantages, and Featured Cars.
    * **Car Catalog** with filtering (by brand, category, price, etc.) and sorting.
    * **Car Detail Page** with a gallery, specifications, and optional *extras*.
    * Modern and responsive design using **Tailwind CSS**.
    * Smooth scroll animations using **AOS (Animate On Scroll)**.

* **Customer & Staff Dashboards**
    * Customers have a personal dashboard to view their **booking history** and statuses.
    * Customers can leave reviews after the rental period is complete.
    * A *Staff* dashboard with limited access to manage bookings and car availability.

* **Comprehensive Admin Panel**
    * Interactive dashboard showing operational KPIs (total bookings, occupancy rate, etc.).
    * Fleet Management (CRUD for cars, brands, categories, features, and extras).
    * Order Management (updating statuses, printing invoices, etc.).
    * Availability Management (blackout schedules for maintenance).
    * Review Management (moderation).
    * User authentication with **Laravel Breeze**, providing secure login, registration, and password management.

* **Email & Notification System**
    * **Mailtrap integration** for testing email notifications (e.g., booking confirmation, invoice, password reset) safely in development mode.
    * Production-ready SMTP configuration for live deployment.

* **Website Settings**
    * The admin can update basic website information such as Rental Name, Logo, Contact Info, and Social Media Links from the admin panel.

---

## 👥 User Roles

The system features three primary user roles with distinct permissions:

1.  **Admin**
    * Has full access to the entire system.
    * Can manage all master data (cars, brands, categories), transactions, users (admins, staff, customers), and website settings.
    * Can view all reports, including revenue reports.

2.  **Staff**
    * An operational role with limited access.
    * Can manage bookings, vehicle availability, and moderate reviews.
    * **Cannot** access revenue reports, user management, or website settings.

3.  **Customer**
    * Registered users who can make bookings.
    * Have a personal dashboard to view their transaction history and booking statuses.
    * Can provide reviews for cars they have rented.

---

## 📦 System Workflow

1.  **Browsing & Selection**
    * A customer visits the website, browses the car catalog, and uses filters to find a suitable vehicle.
    * The customer selects a car and proceeds to the detail page to view specifications and pricing.

2.  **Calculation & Booking**
    * The customer selects the pickup and drop-off dates and times. The system automatically calculates the total rental cost.
    * The customer proceeds to the checkout page, where they are prompted to log in or register if they don't have an account.

3.  **Payment & Confirmation**
    * The customer fills in their personal details, uploads documents, and chooses a payment method (Midtrans, Manual Transfer, or Pay on Site).
    * Once the booking is confirmed (either automatically by Midtrans or via manual verification by staff), the system sends a **booking confirmation email** to the customer.
    * During development, all outgoing emails are routed to a **Mailtrap Inbox** for safe testing.

4.  **Management by Staff/Admin**
    * The staff receives a notification for the new booking.
    * The staff verifies the payment (if manual) and updates the booking status to "Confirmed".
    * The staff updates the status of the booked vehicle to "Rented" for the specified period.

5.  **Rental & Return Process**
    * The customer picks up and returns the vehicle according to the schedule.
    * Upon completion, the staff updates the booking status to "Completed" and the vehicle's status back to "Available".

6.  **Customer Reviews**
    * After a booking is completed, the customer can provide a rating and review for the rented car through their dashboard.
    * Reviews are moderated by staff/admins before being displayed on the public pages.

---

## 🛠️ Tech Stack

* **Backend:** Laravel 12 + **Breeze (Authentication)**
* **Frontend:**
    * *Blade* (Laravel templating engine)
    * **Tailwind CSS**
    * **Alpine.js** (for interactivity)
    * **AOS (Animate On Scroll)** (for animations)
* **Database:** MySQL
* **Payment:** Midtrans (Snap.js)
* **Email:** Mailtrap (development), SMTP (production)
