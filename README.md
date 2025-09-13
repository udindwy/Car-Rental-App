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

* **Website Settings**

  * Admin can update basic website information such as Rental Name, Logo, Contact Info, and Social Media Links from the admin panel.

---

## 👥 User Roles

### 1. Admin

* Manage all website content and data (Fleet, Bookings, Users, Promotions, Pages, etc.).
* Configure general website settings.
* View all reports including revenue.
* Full access to all features in the admin panel.

### 2. Staff

* Focus on daily operations.
* Manage bookings (confirm, update rental status).
* Manage car availability (maintenance schedules).
* Verify manual payments.
* Moderate customer reviews.
* Limited access only to operational features.

### 3. Customer

* Browse car catalog and details.
* Make bookings and online payments.
* View booking history in personal dashboard.
* Submit reviews for completed rentals.

### 4. Visitor

* Browse homepage, catalog, and car details.
* Can register to become a customer.

---

## 📦 System Workflow

1. **Initial Setup**
   Admin configures basic website information (name, contact) and inputs master data (brands, categories, cars, extras, coupons) via the **Admin Panel**.

2. **Booking Process by Customer**
   Customer selects a car from the **Catalog**, chooses dates and extras on the **Car Detail Page**, then fills in personal details and selects payment method on the **Checkout Page**.

3. **Payment & Confirmation**

   * **Online Payment**: Customers pay via **Midtrans pop-up**. Once successful, booking status is automatically set to `confirmed`.
   * **Manual Bank Transfer**: Customers receive instructions. *Staff* verifies payment and updates booking status manually in **Admin/Staff Dashboard**.
   * **Pay on Delivery**: Booking is directly `confirmed`, and staff records payment when the car is picked up.

4. **Staff Management**
   *Staff* monitors new bookings, updates rental statuses (e.g., from `confirmed` to `on_rent`), and ensures car availability is accurate.

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

---
