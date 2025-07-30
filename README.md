# 💅 Nails Business Microservices Project

This is a **containerized microservices-based application** designed for a nail salon business. The system is composed of multiple independent services, each responsible for a specific business function, and is **orchestrated with Kubernetes**.

---

## 🧩 Architecture Overview

This project follows a **microservices architecture**, promoting scalability, maintainability, and modular development. Each service is built as an independent Docker container, orchestrated and deployed using Kubernetes.

---

## 🧱 Services

### 1. 🌐 Front Website (`frontend-service`)
- Public-facing website for the nail salon
- Displays services, promotions, and booking interface
- Built with modern frontend stack (e.g., React/Vue)

### 2. 📅 Client & Booking Management (`booking-service`)
- Manages customer profiles, appointments, and calendar availability
- Handles booking requests and updates

### 3. 🔔 Notification Service (`notification-service`)
- Sends SMS or email notifications for:
  - Booking confirmations
  - Appointment reminders
  - Promotions

### 4. 👤 User Account Management (`auth-service`)
- Handles authentication and user accounts (staff and customers)
- Supports registration, login, password reset, and role-based access

---

## ⚙️ Technology Stack

- **Backend**: Laravel / Node.js / Django (per service, as needed)
- **Frontend**: React / Vue.js
- **Database**: MySQL / PostgreSQL / Firebase (if needed)
- **Containerization**: Docker
- **Orchestration**: Kubernetes (Minikube or cloud-native)
- **Notifications**: Twilio / Firebase Cloud Messaging

---

📦 Directory Structure
```bash
nails-microservices/
│
├── frontend-service/
├── booking-service/
├── notification-service/
├── auth-service/
├── k8s/                 # Kubernetes manifests
└── README.md
```

---
## 🚀 Getting Started

### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/nails-microservices.git
cd nails-microservices
```

``` Start Network
docker network create nginx-proxy
```