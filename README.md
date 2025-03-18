# **Questionnaire App**

## **Overview**
This project is a web-based questionnaire application built using CodeIgniter 4. The application allows users to answer questionnaires, with each question having multiple options (each with a label and value). The submissions can then be exported and imported back into the application.

## **Features**
- **Web UI** for users to interact with the questionnaire.
- **Import/export submissions** for users to easily import/export assessment questions
- **Dockerized** for ease of installation.
- **Makefile** for automation of common development tasks.
- **MVC Architecture** using CodeIgniter 4.
- **Bootstrap** for frontend styling.

## **User stories**
- As a user, I should be able to create a questionnaire
- As a user, I should be able to add questions to a questionnaire
- As a user, I should be able to add answers to a question
- As a user, I should be able to submit answers to a questionnaire
- As a user, I should be able to export submitted answers to a CSV file
- As a user, I should be able to import a CSV file of previously submitted answers

## **Setup Instructions**

### **Prerequisites**
Ensure you have the following installed:
- Docker
- Docker Compose
- Make

### **Installation Steps**

1. **Clone the repository:**
   ```sh
   git clone <repository-url>
   cd <repository-folder>
   ```
2. **Copy `env` file to `.env` file and update the following variables:**
   ```
   CI_ENVIRONMENT = development

   database.default.hostname = <your-database-host> (eg. database)
   database.default.database = <your-database-name> (eg. questionnaire)
   database.default.username = <your-database-use> (eg. user)
   database.default.password = <your-database-password> (eg. root)
   database.default.DBDriver = MySQLi
   database.default.DBPrefix =
   database.default.port = <your-database-port> (eg. 3306)

   DB_HOST=<your-database-host> (eg. database)
   DB_NAME=<your-database-name> (eg. questionnaire)
   DB_USER=<your-database-use> (eg. user)
   DB_PASS=<your-database-password> (eg. root)
   ```
3. **Build and start the application**
   ```sh
   make setup
   ```
4. **Install dependencies**
   ```sh
   make composer-install && make composer-dump
   ```
5. **Check logs to see if MySQL is ready to accept connections** (_It takes a while_)
   ```
   make logs
   ```
6. **When you see the following logs, you can proceed to the next step**
   ```
   questionnaire_db | 2025-03-18T01:58:31.082046Z 0 [System] [MY-010931] [Server] /usr/sbin/mysqld: ready for connections. Version: '8.4.4'  socket: '/var/run/mysqld/mysqld.sock'  port: 3306  MySQL Community Server - GPL.
   ```
7. **Run database migrations:**
   ```sh
   make migrate
   ```
8. **Access the application:**
   ```
   http://localhost:8000/
   ```
9. **Run tests:**
   ```
   make test
   ```

## **Assumptions**
1. The project was implemented as a web-based application rather than a command-line tool
2. The questions in a questionnare are multiple-choice
3. Users are able to populate previously answered assessment questions by importing data from a CSV file
4. Users are able to export data to a CSV file for convenience of importing data back into the application