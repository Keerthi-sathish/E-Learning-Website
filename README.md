# E-Learning Website

## Introduction
The **E-Learning Website** is a free and user-friendly online learning platform designed for students and professionals who want to enhance their knowledge and skills. The platform offers a variety of courses, including programming, web development, and data science, all accessible without any cost.

## Features
- User registration and login system
- Secure access to courses (only for enrolled users)
- Course videos embedded from YouTube
- Feedback submission system
- Admin control for user and course management
- Fully responsive user interface

## Technologies Used
### Frontend:
- HTML
- CSS
- JavaScript

### Backend:
- PHP
- MySQL (Database)
- XAMPP (Local Server for development)

## System Requirements
### Hardware:
- Processor: Intel Core i5 or higher
- RAM: 8GB recommended
- Storage: 512GB or more

### Software:
- XAMPP (Apache & MySQL)
- Web browser (Chrome, Firefox, Edge, etc.)
- Code editor (VS Code, Sublime Text, etc.)

## Installation
1. Clone this repository:
   ```bash
   git clone https://github.com/your-username/e-learning-website.git
   ```
2. Install XAMPP and start Apache & MySQL services.
3. Import the `database.sql` file into MySQL.
4. Update the database connection settings in `server.php`:
   ```php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $database = "user_auth";
   ```
5. Start the project by running it on a local server (XAMPP or WAMP).
6. Open the browser and go to `http://localhost/e-learning-website`

## Usage
1. **Sign up/Login:** Users must register and log in to access courses.
2. **Enroll in Courses:** Users can browse and enroll in available courses.
3. **Watch Course Videos:** Once enrolled, users can watch video content directly.
4. **Give Feedback:** Users can submit feedback to improve the platform.

## Contributing
Contributions are welcome! If you would like to improve this project:
- Fork the repository
- Create a new branch (`feature-branch`)
- Commit your changes
- Push to the branch and open a pull request

## License
This project is licensed under the MIT License.

## Contact
For any queries, please contact:
- **Email:** learning@lmc.com
- **Website:** [E-Learning Platform](http://localhost/e-learning-website)

