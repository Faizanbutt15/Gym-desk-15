<div align="center">

<!-- LOGO / HEADER -->
<img src="https://img.shields.io/badge/GymDesk-Multi--Tenant%20SaaS-7C3AED?style=for-the-badge&logo=laravel&logoColor=white" alt="GymDesk" height="50"/>
<h1> Anyone who clone this project not sale this to anyone without my permission <h1>
<h1>🏋️ GymDesk — Gym Management SaaS Platform</h1>

<p><strong>A production-ready, multi-tenant SaaS application for gym owners.</strong><br/>
Manage members, staff, subscriptions, revenue & more — all from one powerful dashboard.</p>

<br/>


[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Livewire](https://img.shields.io/badge/Livewire-4.x-FB70A9?style=flat-square&logo=livewire&logoColor=white)](https://livewire.laravel.com)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-38BDF8?style=flat-square&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-22C55E?style=flat-square)](LICENSE)
[![Status](https://img.shields.io/badge/Status-Active%20Development-F59E0B?style=flat-square)]()

<br/>

> **"Built for gym owners. Powered by modern Laravel. Designed to scale."**

</div>

---

## 📋 Table of Contents

- [✨ Overview](#-overview)
- [🚀 Key Features](#-key-features)
- [🏗️ Architecture](#️-architecture)
- [📸 Screenshots](#-screenshots)
- [🛠️ Tech Stack](#️-tech-stack)
- [⚡ Quick Start](#-quick-start)
- [📂 Project Structure](#-project-structure)
- [🔐 Role & Permission System](#-role--permission-system)
- [💼 Use Cases & Business Value](#-use-cases--business-value)
- [🗺️ Roadmap](#️-roadmap)
- [🤝 Contributing](#-contributing)
- [📬 Contact](#-contact)

---

## ✨ Overview

**GymDesk** is a fully-featured **multi-tenant SaaS platform** built with **Laravel 11** that enables fitness businesses to manage their entire operation from a single, beautiful dashboard.

Whether you run a single gym or a chain of fitness centers, GymDesk gives **platform owners** complete oversight and gives **each gym** its own fully isolated management environment — without ever mixing data between tenants.

### Why GymDesk?

| Pain Point | GymDesk Solution |
|---|---|
| 📋 Scattered member records & spreadsheets | Centralized digital member management with profiles & history |
| 💸 Manual fee tracking & late payments | Automated subscription tracking with expiry alerts |
| 👥 No staff salary/payroll visibility | Dedicated staff module with payment records |
| 📊 Zero financial insight | Real-time revenue, expenses & net profit dashboard |
| 🔒 Single-gym tools that don't scale | True multi-tenancy — one platform, unlimited gyms |

---

## 🚀 Key Features

### 👑 Super Admin Panel
> *Full platform oversight for the SaaS owner*

- **Live Platform Dashboard** — Real-time KPIs: total gyms, daily/monthly/yearly revenue, active subscriptions
- **Multi-Gym Management** — Register, configure, and manage unlimited gym tenants from one place
- **Subscription Lifecycle Control** — Track active, expiring, and expired gym subscriptions with automated alerts
- **Payment Orchestration** — Record and manage payments from gym clients (B2B billing)
- **Dynamic Analytics** — Interactive revenue charts with custom date range filters
- **Gym Branding** — Upload custom logos per gym for white-label experience

### 🏢 Gym Admin Panel
> *Complete gym operations for individual gym owners/admins*

- **Smart Dashboard** — At-a-glance view of members, revenue, expenses, and net profit (monthly & all-time)
- **Member Management** — Full CRUD with photo uploads, membership fees, join dates & status tracking
- **Automated Status Engine** — Members unpaid for 60+ days are automatically marked inactive
- **Subscription Alerts** — See who's expiring in 3 days, already expired, or went inactive
- **Staff Management** — Manage employees with roles, salaries, and attendance records
- **Staff Payroll** — Record and track monthly salary disbursements
- **Revenue Module** — Complete payment history with filters by member and date
- **Expense Tracker** — Log and categorize gym operational expenses
- **Attendance System** — Track daily check-ins for both members and staff
- **Soft Deletes** — Deleted members/staff are archived, not permanently lost

---

## 🏗️ Architecture

GymDesk is built on a **shared-database, scoped-tenancy** multi-tenant architecture — a proven, scalable approach used in enterprise SaaS products.

```
┌─────────────────────────────────────────────────┐
│                  GymDesk Platform               │
│                                                 │
│  ┌─────────────────┐   ┌───────────────────┐   │
│  │  Super Admin    │   │  Auth Layer        │   │
│  │  (Platform HQ)  │   │  Laravel Breeze   │   │
│  └────────┬────────┘   └─────────┬─────────┘   │
│           │                      │              │
│           ▼                      ▼              │
│  ┌─────────────────────────────────────────┐   │
│  │           Middleware Guard              │   │
│  │    (Role Check → gym_id Scope)          │   │
│  └─────────────────────────────────────────┘   │
│           │                      │              │
│    ┌──────▼──────┐       ┌───────▼──────┐      │
│    │  Gym A Admin│       │  Gym B Admin │      │
│    │  Dashboard  │       │  Dashboard   │      │
│    └──────┬──────┘       └───────┬──────┘      │
│           │                      │              │
│    ┌──────▼──────────────────────▼──────┐      │
│    │       Shared MySQL Database        │      │
│    │   (Data isolated by gym_id FK)     │      │
│    └────────────────────────────────────┘      │
└─────────────────────────────────────────────────┘
```

### Core Technical Pillars

| Pillar | Implementation |
|--------|---------------|
| 🔒 **Multi-Tenancy** | `gym_id` foreign key on every tenant table. All queries automatically scoped to the authenticated user's gym |
| 🛡️ **RBAC** | Two distinct roles (`super_admin`, `gym_admin`) with dedicated middleware protecting each route group |
| 🗑️ **Soft Deletes** | Members and Staff use `SoftDeletes` trait — data is never truly lost, supporting audit trails |
| ⚡ **Reactive UI** | Livewire 4 components for real-time search, filtering, and data updates without full page reloads |
| 📧 **Email System** | Laravel Mailable for contact form handling and notification emails |

---

## 📸 Screenshots

> *A glimpse into the GymDesk experience*

| Super Admin Dashboard | Gym Admin Dashboard |
|:---:|:---:|
| Platform-wide KPIs & gym management | Real-time gym financials & member stats |

| Member Management | Revenue Analytics |
|:---:|:---:|
| Full member profiles with status tracking | Interactive charts with date filters |

*📸 Live demo screenshots coming soon — [request a demo](#-contact)*

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| **Backend Framework** | Laravel 11 (PHP 8.4) |
| **Frontend Reactivity** | Livewire 4 |
| **CSS Framework** | Tailwind CSS 3 |
| **Build Tool** | Vite |
| **Authentication** | Laravel Breeze |
| **Database** | MySQL (SQLite for local dev) |
| **ORM** | Eloquent ORM |
| **Email** | Laravel Mailable |
| **Code Quality** | Laravel Pint, PHPUnit |
| **Dev Tooling** | Laravel Sail, Tinker, Ignition |

---

## ⚡ Quick Start

### Prerequisites

Ensure you have the following installed:
- PHP `^8.4`
- Composer `^2.x`
- Node.js `^18.x` & npm
- MySQL `^8.x` (or use SQLite for quick setup)

### 1. Clone the Repository

```bash
git clone https://github.com/Faizanbutt15/Gym-desk-15.git
cd Gym-desk-15
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gymdesk
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Run Migrations & Seeders

```bash
php artisan migrate --seed
```

### 5. Build Assets & Serve

```bash
# Terminal 1 — compile assets
npm run dev

# Terminal 2 — start the server
php artisan serve
```

### 6. Access the App

| Role | URL | Default Credentials (after seeding) |
|------|-----|--------------------------------------|
| **Super Admin** | `http://localhost:8000/superadmin/dashboard` | Set in seeder |
| **Gym Admin** | `http://localhost:8000/gym/dashboard` | Set in seeder |

---

## 📂 Project Structure

```
gymdesk/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── SuperAdmin/          # Platform-level controllers
│   │   │   │   ├── DashboardController.php
│   │   │   │   └── GymController.php
│   │   │   └── GymAdmin/            # Tenant-level controllers
│   │   │       ├── DashboardController.php
│   │   │       ├── MemberController.php
│   │   │       ├── StaffController.php
│   │   │       ├── RevenueController.php
│   │   │       ├── ExpenseController.php
│   │   │       ├── AttendanceController.php
│   │   │       ├── ExpiredController.php
│   │   │       ├── ExpiringSoonController.php
│   │   │       └── InactiveMemberController.php
│   │   └── Middleware/              # Role-based route guards
│   ├── Livewire/                    # Real-time UI components
│   ├── Models/                      # Eloquent models
│   │   ├── Gym.php                  # Tenant model
│   │   ├── Member.php               # SoftDeletes ✓
│   │   ├── Staff.php                # SoftDeletes ✓
│   │   ├── Payment.php
│   │   ├── StaffPayment.php
│   │   ├── Expense.php
│   │   ├── Attendance.php
│   │   └── GymPayment.php           # B2B subscription billing
│   └── Mail/                        # Laravel Mailables
├── database/
│   ├── migrations/                  # 15 versioned migration files
│   └── seeders/
├── resources/
│   └── views/
│       ├── superadmin/              # Super admin templates
│       ├── gym/                     # Gym admin templates
│       ├── livewire/                # Livewire component views
│       └── welcome.blade.php        # Public landing page
└── routes/
    └── web.php                      # Role-protected route groups
```

---

## 🔐 Role & Permission System

GymDesk implements a clean **Role-Based Access Control (RBAC)** system:

```php
// Middleware protects each panel entirely
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    // Only platform owner can access these
    Route::get('/superadmin/dashboard', [SuperAdmin\DashboardController::class, 'index']);
    Route::resource('/superadmin/gyms', SuperAdmin\GymController::class);
});

Route::middleware(['auth', 'role:gym_admin'])->group(function () {
    // Each gym admin sees ONLY their own gym's data
    Route::get('/gym/dashboard', [GymAdmin\DashboardController::class, 'index']);
    Route::resource('/gym/members', GymAdmin\MemberController::class);
    // ... etc
});
```

**Data Isolation Guarantee:** Every query in a Gym Admin controller is scoped to `gym_id = auth()->user()->gym_id`, making it **impossible** for one gym to access another gym's data.

---

## 💼 Use Cases & Business Value

GymDesk is ideal for:

- **🏢 Fitness SaaS Startups** — License GymDesk as your backend and onboard multiple gym clients
- **🏋️ Individual Gym Owners** — Replace spreadsheets with a professional management system
- **📈 Gym Chains** — Manage all branches from one Super Admin account with isolated data per branch
- **👨‍💻 Laravel Developers** — A real-world multi-tenant SaaS reference implementation to learn from

### ROI for Gym Owners

- ⏱️ Save **5–10 hours/week** previously spent on manual record-keeping
- 💰 Reduce **revenue leakage** from forgotten or untracked membership renewals
- 📊 Make **data-driven decisions** with real-time financial reporting
- 🔔 Never miss a renewal with **automated expiry notifications**

---

## 🗺️ Roadmap

Here's what's planned for upcoming releases:

- [ ] 📱 **Mobile App** (React Native companion for gym check-ins)
- [ ] 💳 **Online Payment Gateway** (Stripe / PayFast integration)
- [ ] 📲 **WhatsApp / SMS Notifications** for membership renewals
- [ ] 📊 **Advanced Analytics** — Member retention rates, peak hours, revenue forecasting
- [ ] 🔑 **Member Self-Service Portal** — Members can view their own membership status
- [ ] 🌐 **Multi-Language Support** (Urdu, Arabic, French)
- [ ] 📄 **PDF Reports** — Monthly/yearly summaries exportable as PDF
- [ ] 🔔 **Push Notifications** for expiring memberships

---

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!

1. **Fork** the repository
2. Create your feature branch: `git checkout -b feature/amazing-feature`
3. Commit your changes: `git commit -m 'Add amazing feature'`
4. Push to the branch: `git push origin feature/amazing-feature`
5. Open a **Pull Request**

Please read the [Contributing Guidelines](CONTRIBUTING.md) before submitting.

---

## 📜 License

This project is licensed under the **MIT License** — see the [LICENSE](LICENSE) file for details.

---

## 📬 Contact

<div align="center">

**Built with ❤️ by [Muhammad Faizan Butt](https://github.com/Faizanbutt15)**

[![LinkedIn](https://img.shields.io/badge/LinkedIn-Connect-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://linkedin.com/in/Faizanbutt15)
[![GitHub](https://img.shields.io/badge/GitHub-Follow-181717?style=for-the-badge&logo=github&logoColor=white)](https://github.com/Faizanbutt15)

**Interested in a custom gym management solution or want to license GymDesk?**

📧 **[Open an Issue](https://github.com/Faizanbutt15/Gym-desk-15/issues)** or reach out on LinkedIn

</div>

---

<div align="center">

⭐ **If you find GymDesk useful, please consider giving it a star!** ⭐

*It helps others discover the project and motivates continued development.*

</div>
