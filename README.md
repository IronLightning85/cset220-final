#### <p align="center">Hello</p>


### Important Terminal Commands
# Step 1:

## Migrate the Roles table found in "database\migrations" under the name "2024_11_07_180517_create_roles_table.php"

## php artisan migrate --path= (Paste Path HERE)

# Step 2:

## You can now safely migrate the rest of the database in any order you please.

## php artisan migrate

# Step 3:

## The role's table needs its default values. In the terminal paste the following.

## php artisan db:seed --class=RoleSeeder

# Step 4:

## The User's table needs its default Admin values. In the terminal paste the following.

## php artisan db:seed --class=AdminSeeder

