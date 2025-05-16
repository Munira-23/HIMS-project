🏥 Hospital Inventory Management System (HIMS)

A web-based application designed to streamline and automate the management of medical inventory in hospitals. This system helps track pharmaceuticals, medical equipment, and supplies — ensuring timely restocking and reducing losses due to expired or out-of-stock items.

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
