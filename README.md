# Child IMS

Child IMS a web application developed for managing child information that utilizes Laravel framework with MySQL database for data storage.

## Features

- Add, edit, and delete child records
- Dynamic table with multiple input fields for child data
- Checkbox for different addresses
- Input validation and error handling
- Store and retrieve data from the database

## Installation

Clone Child IMS:

```bash
  git clone https://github.com/rajeevmandongol/child-ims.git
```

Navigate to the project directory:

```bash
  cd child-ims
```

Run the database migrations

```bash
  php artisan migrate
```
## Deployment

To deploy this project run

```bash
  php artisan serve
```

Access the application in your web browser at http://localhost:8000

## Usage

- Add child information by filling out the form input fields in the table and store the data in the database using "Save" button.
- Click the "Add New" button to dynamically add a new row with input fields.
- Use the "Different Address?" checkbox to add additional address fields for the child.
- Click the "Delete" icon to remove a row from the table and the database.
- Edit or delete existing child records by clicking the respective buttons in the table.