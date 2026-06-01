# Laravel Dynamic Approval System

An automated workflow and document approval application built with Laravel. This system is designed to handle complex, multi-stage approval processes where documents or requests need to be reviewed and authorized by various roles or individuals before being finalized.

## 🚀 About the Project

In many organizations, document approvals (such as leave requests, purchase orders, or project proposals) require a strict hierarchical sign-off process. This project provides a **Dynamic Approval System** where administrators can define custom workflows with multiple steps, assign specific users or roles to each step, and track the progress of any document in real-time.

## ✨ Key Features

- **Dynamic Workflows**: Administrators can create unlimited custom workflows. Each workflow can have multiple sequential steps (e.g., Step 1: Supervisor Review, Step 2: Manager Approval, Step 3: Director Sign-off).
- **Document Management**: Users can create documents and attach them to a specific workflow. The system automatically routes the document to the correct approver based on the workflow configuration.
- **Role-Based Approvals**: Workflow steps can be assigned to specific roles (e.g., "HR Manager") or specific users.
- **Real-time Notifications**: Approvers are notified when a document requires their attention. Users are notified when their document is approved, rejected, or returned for revision.
- **Comprehensive Audit Trail**: Every action (submission, approval, rejection, comment) is logged. This provides a full history of the document's lifecycle for accountability and compliance.
- **Ticketing System Interface**: The approval process is visualized similarly to a support ticketing system, making it easy to see pending tasks, track statuses, and communicate via comments on the approval request.

## 🔄 How the Workflow Operates

1. **Workflow Definition**: Admin creates a `Workflow` (e.g., "Annual Leave Request") and defines `Workflow Steps`.
2. **Document Submission**: A user creates a `Document`, selects the "Annual Leave Request" workflow, and submits it.
3. **Approval Routing**: The document's status becomes `pending`. The system identifies Step 1 of the workflow and notifies the assigned approver.
4. **Action Taken**: The approver reviews the document and can **Approve** or **Reject**. They can also leave comments.
5. **Progression**: 
   - If *Approved*, the system moves the document to the next step. If it was the final step, the document status becomes `approved`.
   - If *Rejected*, the workflow is halted, and the document status becomes `rejected`.

## 🛠️ Technology Stack

- **Framework**: [Laravel](https://laravel.com/) (PHP)
- **Frontend**: Blade Templates, Tailwind CSS (or similar styling framework), Alpine.js / Livewire (depending on interactivity requirements)
- **Database**: MySQL / MariaDB
- **Authentication**: Laravel Breeze / Jetstream (customized for Role-Based Access Control)

## 📋 Requirements

Before you begin, ensure you have met the following requirements:
- PHP >= 8.2
- Composer
- MySQL or MariaDB
- Node.js & NPM (for frontend asset compilation)

## ⚙️ Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone <your-repository-url>
   cd automasi-alur-kerja
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install NPM dependencies:**
   ```bash
   npm install
   ```

4. **Environment Setup:**
   Copy the example environment file and generate the application key.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Configuration:**
   Create a new database and update your `.env` file with the correct database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

6. **Run Migrations and Seeders:**
   This will create the necessary tables and populate the database with default roles, administrative users, and sample workflows.
   ```bash
   php artisan migrate --seed
   ```

7. **Compile Frontend Assets:**
   ```bash
   npm run build
   # Or for development: npm run dev
   ```

## 💻 Running Locally

To start the local development server, execute:
```bash
php artisan serve
```
You can then access the application in your browser at `http://localhost:8000`.

## 🧪 Testing

To run the automated test suite, use the following command:
```bash
php artisan test
```

## 📄 License

This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
