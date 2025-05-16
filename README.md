🏥 Hospital Inventory Management System (HIMS)

A comprehensive web-based solution for managing hospital medical inventory. HIMS streamlines the tracking of pharmaceuticals, medical equipment, and supplies while ensuring optimal stock levels and minimizing losses from expired items.

## 📋 Overview

HIMS helps healthcare facilities:
- Maintain accurate inventory records
- Prevent stockouts of critical supplies
- Reduce waste from expired items
- Make data-driven inventory decisions
- Ensure compliance with medical storage requirements

🚀 Features
👥 User Roles: Admin and Inventory Manager with different access levels

📦 Inventory Tracking: Add, update, and manage stock levels of medical supplies

📊 Stock Usage Recording: Track usage and consumption of inventory items

⏰ Expiry & Out-of-Stock Alerts: Notifications for critical inventory status

📈 Reports & Analytics: Generate inventory and usage reports for better decisions

🔒 Secure Login: Role-based authentication to restrict unauthorized access

🛠️ Installation
Follow these steps to set up and run the project locally:

Clone the repository
Open your terminal and run:
git clone https://github.com/Munira-23/HIMS-project.git
Then navigate into the folder:
cd HIMS-project

Install dependencies
Make sure PHP and Composer are installed, then run:
composer install

Set up environment variables

Copy the example environment file:
cp .env.example .env
Edit the .env file and update your database and app settings.

Generate application key
Run:
php artisan key:generate

Run database migrations
Run:
php artisan migrate

Start the application
Run:
php artisan serve
Then open your browser and go to:
http://localhost:8000

📖 Usage

Use the dashboard to monitor inventory health

Add and manage stock in the Inventory section

Record how inventory is consumed using the Stock Usage feature

Monitor Alerts for low-stock or expired items

Generate and review Reports for inventory and usage analysis

🧰 Technologies Used

🖥️ Backend: PHP (Laravel Framework)

🎨 Frontend: Blade Templates, Bootstrap CSS

🗄️ Database: MySQL

🛠️ Version Control: Git & GitHub

🤝 Contributing
Contributions are welcome! Here’s how you can contribute:

Fork the repository

Create a new branch: git checkout -b feature/YourFeature

Make your changes and commit: git commit -m "Add new feature"

Push to your branch: git push origin feature/YourFeature

Open a Pull Request

Please ensure your code follows the project’s coding standards and is well-documented.

📄 License
This project is licensed under the MIT License.


🚀 Future Enhancements
some features that could be added in future versions of the system:
	•	Pharmacy Staff Role: Add a specific role for pharmacy personnel with custom access.
	•	Email Notifications: Automatically notify relevant staff when stock is low or about to expire.
	•	Barcode Scanning: Enable quick check-in/check-out of inventory items via barcode.
	•	Mobile Responsiveness: Improve interface usability on mobile and tablet devices.
	•	Automated Reordering: Trigger automatic purchase orders when stock reaches minimum thresholds.
