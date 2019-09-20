# TMS

TMS is a Timetable Management System

## Description

The system has three user types
1. Admin
2. Lecturer
3. Student

### Admin
The admin is responsible for most of the work in the system since they have the most access and privileges. They control all the content in the system and manage all the users.
The admin is the user to maintain the timetables that are viewed by the lecturers and the students.
They are also able to view statistics on the usage of the system from logs and reports.

### Lecturer
The lecturer is only able to see the timetable of the units he/she will be taking during a semester and the academic calendar.

### Student
A student is able to register for a new semester, view a timetable for units he/she is eligible to take and view the academic calendar.

## Using the system
The system is built using PHP and has a MySQL database and runs on an Apache server. The email facility is implemented using Node JS.
Once you have all the above set up, import the portal.sql in the database folder into you MySQL database and put the files in the server folder on you machine.
Ensure that the credentials in `controllers/db.php` match those on your machine otherwise you will get database errors.
For the system to be able to send emails, you need to give it your credentials. You can enter those in the `controllers/email/cred.json` file.
The cred variable in `contrillers/email/index.js` has to be given the absolute path to the `cred.js` file.
You can access an admin account with the following credentials:

email: c@gmail.com
password: pass

Once you have access, you can create new users. Keep in mind that when a user is created, a random password is generated and sent to the email address that was entered. The password is hashed and hence cannot be retrieved from the database.