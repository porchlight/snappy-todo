# snappy-todo

## Site setup
- clone project
- create a database and add your database configuration to your settings.php or in a settings.local.php
- import the included database (complete.sql.gz)
- `drush uli` to login

## Steps to test

- In an incognito window, open the site, this will always redirect to the login page
- Go to "Create new account" tab to create new user and login
- Click "Create new todo" to add some todo's
- Click "Mark as done" to complete the todo
- Click "Mark as not done" to make the todo active again
- Click "Edit" to edit the todo
- Click "Delete" to delete the todo
- Click "All", "Active" or "Complete" to filter the list to show all todos, only active, or only completed todos
- Make sure you have marked one as "done", this will expose the "Clear completed" link, click that to clear all completed todos.

## Contrib modules used

### Admin Toolbar
- Just to make things easier to navigate on the admin side.

### Flag
- This module is used for the "mark as done/mark as not done" functionality. Saves which nodes the user has marked as complete.

### Node view redirect
- This module keeps users from seeing the individual node view, we just want to keep them on the todos page at all times, so this helps with that.

### Require login
- Forces users to login or register in order to see anything on the site.

## Custom module functionality

### Snappy Common
- controller and service to handle the "Clear completed" functionality
- .module to do a couple form alter functions and add a library to inject some css and js
- js to hide/show things and update the todo counter
- css to add a little bit of styling
