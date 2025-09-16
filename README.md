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

  * **Landing Page** with Hero Section, Highlights, and Featured Cars.
  * **Car Catalog** with filtering (brand, category, price, etc.) and sorting.
  * **Car Detail Page** with gallery, specifications, and optional *extras*.
  * Modern and responsive design with **Tailwind CSS**.
  * Smooth scroll animations using **AOS (Animate On Scroll)**.

* **Customer & Staff Dashboards**

  * Customers have personal dashboards to view their **booking history** and statuses.
  * Customers can leave reviews after rental completion.
  * *Staff* dashboard with limited access to manage bookings and car availability.

* **Comprehensive Admin Panel**

  * Interactive dashboard showing operational KPIs (total bookings, occupancy, etc.).
  * Fleet Management (CRUD for cars, brands, categories, features, and extras).
  * Order Management (update statuses, print invoices, etc.).
  * Availability Management (blackout schedules for maintenance).
  * Review Management (moderation).
  * **User authentication with Laravel Breeze**, providing secure login, registration, and password management.

* **Email & Notification System**

  * **Mailtrap integration** for testing email notifications (e.g., booking confirmation, invoice, password reset) safely in development mode.
  * Production-ready SMTP configuration for live deployment.

* **Website Settings**

  * Admin can update basic website information such as Rental Name, Logo, Contact Info, and Social Media Links from the admin panel.

---

## 👥 User Roles

(sama seperti sebelumnya)

---

## 📦 System Workflow

(sama seperti sebelumnya, dengan tambahan untuk email)

3. **Payment & Confirmation**

   * Once booking is confirmed (via Midtrans or manual verification), the system automatically sends a **booking confirmation email** to the customer.
   * During development, all outgoing emails are routed to **Mailtrap Inbox** for safe testing.

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
