# TMS

TMS is a Timetable Management System

## Description

The system has three user types
- 1. Admin
- 2. Lecturer
- 3. Student

### Admin
The admin is responsible for most of the work in the system since they have the most access and privileges. They control all the content in the system and manage all the users.
The admin is the user to maintain the timetables that are viewed by the lecturers and the students.
They are also able to view statistics on the usage of the system from logs and reports.

### Lecturer
The lecturer is only able to see the timetable of the units he/she will be taking during a semester and the academic calendar.

### Student
A student is able to register for a new semester, view a timetable for units he/she is eligible to take and view the academic calendar.

## Using the system
The system is built using PHP and has a MySQL database. The email facility is implemented using Node JS.
You can access an admin account with the following credentials:

email: c@gmail.com
password: pass

Once you have access, you can create new users. Keep in mind that when a user is created, a random password is generated and sent to the email address that was entered. The password is hashed and hence cannot be retrieved from the database.