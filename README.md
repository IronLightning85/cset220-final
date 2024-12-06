# <p align="center">Hello</p>


# Important Terminal Commands
## Step 1:

### Migrate the Roles table found in "database\migrations" under the name "2024_11_07_180517_create_roles_table.php"

### php artisan migrate --path=database/migrations/2024_11_07_180517_create_roles_table.php

## Step 2:

### You can now safely migrate the rest of the database in any order you please.

### php artisan migrate

## Step 3:

### The role's table needs its default values. In the terminal paste the following.

### php artisan db:seed --class=RoleSeeder

## Step 4:

### The User's table needs its default Admin values. In the terminal paste the following.

### php artisan db:seed --class=AdminSeeder

## Step 5:

### This is only used to set predefined values to be used for TESTING PURPOSES ONLY

### php artisan db:seed --class=TotalSeeder

## Cheat Sheet

Admin

Email: Admin@shadyshoals.com

Password: Admin

Supervisor

Email: flats90@gmail.com

Password: password

Doctor

Email: Bubble@gmail.com

Password: password

Caregiver

Email: ManRay@gmail.com

Password: password

Patient
Needs approved

Email: pperkins@gmail.com

Password: password



Family

mrkrabs@gmail.com
password
