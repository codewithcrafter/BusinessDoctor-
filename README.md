# BusinessDoctor — Premier IT Solutions & Digital Services Company

> **"We Engineer Technology. We Accelerate Digital Growth."**

BusinessDoctor is a full-service IT solutions and digital services company delivering custom web and software development, performance-driven digital marketing, UI/UX brand architecture, and e-commerce marketplace scaling.

---

## 1. Core IT & Digital Practice Architecture

BusinessDoctor organizes its services into **Six Core Practice Areas**:

1. **Web & Custom Software Development (`01`)**
   - Custom Enterprise & Business Websites
   - Web Applications & Client Portals
   - E-Commerce & Multi-Vendor Storefronts
   - Sub-second Load Times (< 0.8s) & 100% Core Web Vitals
2. **Digital Marketing & Performance Ads (`02`)**
   - Search Engine Optimization (Technical, On-Page & Local SEO)
   - Google Search, Display & Performance Max Campaigns (PPC)
   - Social Media Marketing & Paid Social (Meta & LinkedIn B2B)
   - Conversion Rate Optimization (CRO) & Lead Generation
3. **UI/UX Design & Brand Identity (`03`)**
   - User Interface & User Experience Design (Wireframing & Prototyping)
   - Corporate Brand Identity & Logo Systems
   - Design Systems & Component Libraries
   - Marketing Collateral & Pitch Decks
4. **E-Commerce & Marketplace Management (`04`)**
   - Amazon & Flipkart Seller Account Management
   - Product Listing Optimization & Catalog SEO
   - A+ Content Modules & Brand Storefront Design
   - Marketplace Advertising (Sponsored Products & Brands)
5. **Creative Production & Video Marketing (`05`)**
   - Commercial & Studio Product Photography
   - Corporate Narrative Films & Brand Storytelling
   - Short-Form Video Production (Reels, TikTok, YouTube Shorts)
   - Motion Graphics & 3D Product Demos
6. **Cloud Solutions & IT Consulting (`06`)**
   - Cloud Architecture & Server Deployment (AWS, GCP, DigitalOcean)
   - Website Maintenance, Uptime & Performance Monitoring
   - Cybersecurity Audits & Vulnerability Patching
   - Business Workflow & CRM Automation

---

## 2. Technology Stack

- **Frontend:** Semantic HTML5, Modular CSS3 (Design Tokens, Grid, Flexbox, Micro-Borders), Clean Vanilla ES6+ JavaScript (Zero external framework bloat).
- **Backend:** Native PHP 8+ (Strict typing, Object-Oriented PDO database abstraction layer, CSRF protection, input sanitization).
- **Database Persistence:** Dual-Driver Support:
  - **Primary:** MySQL 8.0+ (Full production schema in `database/schema.sql`).
  - **Resilient Fallback:** Local SQLite (`database/businessdoctor.sqlite`), auto-seeded and zero-config for instant testing.

---

## 3. Directory & File Map

```text
businessdoctor/
│
├── index.php                         # Homepage (Hero, Challenge Comparison, Services Grid, Process, Estimator, Case Studies)
├── about.php                         # About BusinessDoctor (Mission, IT Philosophy, 4 Standards, Leadership Team)
├── services.php                      # Full IT & Digital Services Catalog (6 Disciplines)
├── service-detail.php                # Detailed View for Each IT Service (?slug=...)
├── audit.php                         # Free Website & Digital Growth Audit Tool (Interactive Intake)
├── diagnostic.php                    # Seamless alias / forwarder to audit.php
├── case-studies.php                  # Client Case Studies & Success Stories Directory
├── case-study-detail.php             # Individual Case Study Deep-Dive (?slug=...)
├── insights.php                      # Tech & Digital Growth Insights / Blog
├── insight-detail.php                # Individual Tech Article Reader (?slug=...)
├── contact.php                       # Contact & Project Proposal Intake Desk (2-Hour SLA)
│
├── api/
│   ├── submit-diagnostic.php         # AJAX endpoint: Digital audit scoring & request persistence
│   ├── submit-contact.php            # AJAX endpoint: Direct project inquiry handler
│   └── newsletter-subscribe.php      # AJAX endpoint: Monthly tech newsletter handler
│
├── admin/
│   ├── login.php                     # Client projects console authentication
│   ├── dashboard.php                 # Admin console: review incoming audits, inquiries, and update statuses
│   └── logout.php                    # Session termination
│
├── includes/
│   ├── config.php                    # App constants, environment detection, session hardening
│   ├── db.php                        # Resilient dual-driver PDO database layer (MySQL + SQLite fallback)
│   ├── functions.php                 # Escaping, CSRF helpers, navigation active states, digital readiness scoring
│   ├── header.php                    # HTML5 head, Google Fonts, OpenGraph metadata, CSS includes
│   ├── navbar.php                    # Sticky navigation with mobile drawer
│   └── footer.php                    # Institutional footer, newsletter intake, copyright
│
├── assets/
│   ├── css/
│   │   ├── variables.css             # Color palette tokens (#0B1320 obsidian, #0D9488 teal, #F8FAFC white)
│   │   ├── base.css                  # CSS reset, typography, containers, micro-borders, badges
│   │   ├── components.css            # Buttons, navbar, hero HUD, cards, gauge widget, tables
│   │   └── responsive.css            # Responsive breakpoints (1024px, 768px, 480px)
│   └── js/
│       ├── main.js                   # Header scroll backdrop, mobile drawer, animated metric counters
│       ├── diagnostic-calculator.js  # Real-time interactive digital readiness & project estimator
│       └── form-handler.js           # AJAX form submission, inline alerts, dynamic button loading states
│
└── database/
    ├── schema.sql                    # Production MySQL 8.0+ schema with tables, indexes, and initial seeds
    └── businessdoctor.sqlite         # Local resilient database auto-seeded and ready to run
```

---

## 4. How to Run Locally

### Start Built-in PHP Server:
```bash
php -S 127.0.0.1:8000
```
Then visit:
- **Homepage:** `http://127.0.0.1:8000/index.php`
- **Free Digital Audit:** `http://127.0.0.1:8000/audit.php`
- **IT Services:** `http://127.0.0.1:8000/services.php`
- **Admin Console:** `http://127.0.0.1:8000/admin/login.php`
  - **Username:** `admin`
  - **Password:** `Admin@BusinessDoctor2026`
