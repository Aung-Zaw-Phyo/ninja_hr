

# Ninja HR

HR or Management System Project

## What Features include in this project

- Employee management system
- Employee login with fingerprint
- Employee role and permission
- Attendance system with pincode and QR Scan
- Payroll (salary) management system by employee attendance
- Project management system
- Sortable project's tasks
- Employee attendance pdf export 
- ....

## What plug-in and package include in this project

- Jquery Datatable (Serverside rendering)
- Laravel spatie permission
- Larapass (fingerprint)
- Select2
- Sweet alert1
- Sweet alert2
- Laravel Jsvalidation
- Daterangepicker
- Javascript image viewer
- SortableJS
- Datatable pdf export
- Mpdf export

## Build With
- Laravel (Laravel is a free, open-source PHP web framework.This framework is what i mainly use in this project)
- Html, Css, Javascript, PHP, Mysql, Laravel, Jquery, Ajax and  Bootstrap


## Installation

 - Clone this repo 
 - database setup

```bash
  DB_DATABASE=your_db_name
  DB_USERNAME=your_db_username
  DB_PASSWORD=your_db_password // if no password ,u can leave as blank
```

 - Run commands
  
```bash
  composer update
  npm install
  php artisan migrate 
  php artisan db:seed --class=CompanySettingSeeder
  php artisan db:seed --class=DataEntrySeeder
  php artisan storage:link
```
- Now u can test this project by run this command.
  
```bash
  php artisan serve
```
