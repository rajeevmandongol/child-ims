<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Child Information Management System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"
        integrity="sha512-t4GWSVZO1eC8BM339Xd7Uphw5s17a86tIZIj8qRxhnKub6WoyhnrxeCIMeAqBPgdZGlCcG2PrZjMc+Wr78+5Xg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        * {
            margin: 0 auto;
            padding: 0;
            box-sizing: border-box;
        }

        .container,
        .container-fluid {
            margin-top: 20px;
        }

        .add-button {
            color: white;
            background: blueviolet;
            padding: 8px 16px;
            border: 1px solid transparent;
        }

        .add-button:hover {
            background-color: teal;
        }

        .delete-button {
            color: white;
            background: red;
            padding: 8px 16px;
            border: 1px solid transparent;
        }

        table th {
            text-align: center;
        }

        table tr {
            box-shadow: 1px 1px 2px #808080;
        }

        td {
            padding: 8px;
            vertical-align: bottom;
        }

        .required {
            color: red;
            font-size: 1.2rem;
        }

        td input,
        td select,
        td option {
            padding: 4px 8px;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .of-scroll {
            overflow-x: scroll;
        }

        .error-text {
            font-size: 0.9rem;
            color: red;
            font-weight: 500;
        }

        .disabled {
            pointer-events: none
        }
    </style>
</head>

<body class="antialiased">

    <div class="container-fluid">
        @yield('content')
    </div>

    <script>
        /*
        Initialization of table-related variables and element selections.
        */

        // Select the table element
        const table = document.querySelector("table");

        // Select the table body element
        const inputTableBody = document.querySelector("table#table tbody");

        // Select all rows within the table body
        let allRows = document.querySelectorAll("#table tbody tr");

        // Select elements with the "child_different_address[]" name attribute
        let differentAddress = document.querySelectorAll("input[name='child_different_address[]']");

        /*
            Array to store input field names and attributes:

            Each subarray contains:
                - Element 1: Input type
                - Element 2: Name for the input field
                - Element 3: Boolean indicating if the input field is required (false means required, true means optional)
        */
        const inputFieldNames = [
            ["input", "child_first_name", false],
            ["input", "child_middle_name", false],
            ["input", "child_last_name", false],
            ["input", "child_age", false],
            ["select", "child_gender", false],
            ["checkbox", "child_different_address", false],
            ["input", "child_address", true],
            ["input", "child_city", true],
            ["input", "child_state", true],
            ["select", "child_country", true],
            ["input", "child_zip_code", true]

        ];

        /*
            Array to store input field placeholders:
            Each element represents the placeholder text for a corresponding input field.
        */

        const inputFieldPlaceholders = [
            "Child First Name",
            "Child Middle Name",
            "Child Last Name",
            "Child Age",
            "Gender",
            "Child Different Address?",
            "Child Address",
            "Child City",
            "Child State",
            "Country",
            "Child Zip"
        ];

        /*
            Array to store country data:
            Each subarray contains:
                - Element 1: Country code abbreviation
                - Element 2: Country name
        */

        const countries = [
            ["us", "United States"],
            ["np", "Nepal"],
        ];


        /*
            Function to toggle the address fields based on checkbox state.
            Parameters:
                - currentCheckbox: The checkbox element triggering the function.
        */


        function toggleChildAddress(currentCheckbox) {
            const currentRow = currentCheckbox.parentNode.parentNode;

            allRows = Array.from(document.querySelectorAll("#table tbody tr"));

            const tempChildAddress = currentRow.querySelector("input[name^='child_address']");
            tempChildAddress.toggleAttribute("disabled");

            const tempChildCity = currentRow.querySelector("input[name^='child_city']");
            tempChildCity.toggleAttribute("disabled");

            const tempChildState = currentRow.querySelector("input[name^='child_state']");
            tempChildState.toggleAttribute("disabled");

            const tempCountry = currentRow.querySelector("select[name^='child_country']");
            tempCountry.toggleAttribute("disabled");

            const tempChildZip = currentRow.querySelector("input[name^='child_zip_code']");
            tempChildZip.toggleAttribute("disabled");

        }

        /*
            Function to add a new row dynamically to the table.
            Parameters:
                - event: The event object triggering the function.
        */

        function addNewRow(event) {
            event.preventDefault();

            let rowCount = allRows.length;

            const tr = document.createElement("tr");
            let td = document.createElement("td");

            const button = createDeleteButton();

            tr.appendChild(td);

            td.appendChild(button);
            for (let index = 0; index < inputFieldNames.length; index++) {
                if (inputFieldNames[index][0] === "checkbox") {
                    td = createCheckbox(index, rowCount);
                }
                if (inputFieldNames[index][0] === "input") {
                    td = createInputField(index, rowCount);
                } else if (inputFieldNames[index][0] === "select") {
                    td = createSelectField(index, rowCount);
                }
                tr.appendChild(td);

            }

            inputTableBody.appendChild(tr);
            table.appendChild(inputTableBody);
            updateDifferentAddressList();
        }


        /*
            Function to create a delete button element with styling classes.
            Returns:
                - button: The newly created delete button element.
        */

        function createDeleteButton() {
            const button = document.createElement("button");

            button.classList.add("btn");
            button.classList.add("btn-secondary");
            button.classList.add("disabled");

            button.innerHTML = '<i class="fa-solid fa-trash"></i>';
            return button;
        }

        /*
            Function to create an input field element.
            Parameters:
                - index: The index of the input field in the inputFieldNames array.
                - rowCount: The current number of rows in the table.
            Returns:
                - td: The newly created table cell containing the input field.
        */

        function createInputField(index, rowCount) {
            const td = document.createElement("td");

            if (inputFieldNames[index][2] === false) {
                td.innerHTML = "<span class='required'>*</span>";
            }
            const tempInput = document.createElement("input");

            tempInput.name = inputFieldNames[index][1] + `[${rowCount}]`;
            tempInput.placeholder = inputFieldPlaceholders[index];

            if (inputFieldNames[index][2] === true) {
                tempInput.toggleAttribute("disabled");
            }

            td.appendChild(tempInput);

            return td;
        }

        /*
                Function to create an input field element type checkbox.
                Parameters:
                    - index: The index of the input field in the inputFieldNames array.
                    - rowCount: The current number of rows in the table.
                Returns:
                    - td: The newly created table cell containing the input field.
        */

        function createCheckbox(index, rowCount) {
            const td = document.createElement("td");

            const tempInput = document.createElement("input");
            tempInput.type = inputFieldNames[index][0];
            tempInput.name = inputFieldNames[index][1] + `[${rowCount}]`;
            tempInput.id = inputFieldNames[index][1] + (differentAddress.length);
            tempInput.addEventListener('click', function() {
                toggleChildAddress(this);
            });;

            const tempLabel = document.createElement("label");
            tempLabel.textContent = inputFieldPlaceholders[index];
            tempLabel.htmlFor = inputFieldNames[index][1] + (differentAddress.length);

            td.appendChild(tempInput);
            td.appendChild(tempLabel);
            return td;
        }


        /*
                Function to create an select input element.
                Parameters:
                    - index: The index of the input field in the inputFieldNames array.
                    - rowCount: The current number of rows in the table.
                Returns:
                    - td: The newly created table cell containing the input field.
        */

        function createSelectField(index, rowCount) {
            const td = document.createElement("td");

            const tempInput = document.createElement("select");
            tempInput.setAttribute("name", inputFieldNames[index][1] + `[${rowCount}]`)
            if (inputFieldNames[index][1] === "child_gender") {

                createSelectForGender(index, td, tempInput);
            } else if (inputFieldNames[index][1] === "child_country") {
                createSelectForCountry(index, tempInput);
            }

            td.appendChild(tempInput);

            return td;
        }


        /*
            Function to create a select field for gender options.
            Parameters:
                - index: The index of the select field in the inputFieldNames array.
                - td: The table cell element to append the select field.
                - tempInput: The select field element to populate with options.
        */

        function createSelectForGender(index, td, tempInput) {
            if (inputFieldNames[index][2] === false) {
                td.innerHTML = "<span class='required'>*</span>";
            }
            const female = document.createElement("option");
            female.textContent = "Female";
            female.value = "female";

            const male = document.createElement("option");
            male.textContent = "Male";
            male.value = "male";

            tempInput.appendChild(female);
            tempInput.appendChild(male);

        }

        /*
            Function to create a select field for country options.
            Parameters:
                - index: The index of the select field in the inputFieldNames array.
                - tempInput: The select field element to populate with options.
        */

        function createSelectForCountry(index, tempInput) {
            countries.forEach((countryData, index) => {
                const tempOption = document.createElement("option");
                tempOption.textContent = countryData[1];
                tempOption.value = countryData[0];

                tempInput.appendChild(tempOption);

            });
            tempInput.toggleAttribute("disabled");
        }

        /*
            Function to update the list of elements with the "child_different_address[]" name attribute.
            Updates the differentAddress and allRows variables accordingly.
        */

        function updateDifferentAddressList() {
            differentAddress = document.querySelectorAll("input[name='child_different_address[]']");
            allRows = Array.from(document.querySelectorAll("#table tbody tr"));
        }


        /*
            Function to delete a child record.
            Parameters:
                - event: The event object triggering the function.
                - rowId: The ID of the row containing the record to be deleted.
        */

        function deleteChildRecord(event, rowId) {
            event.preventDefault();
            if (confirm('Are you sure you want to delete this record?')) {

                // Submit the corresponding delete form
                document.getElementById('delete-form-' + rowId).submit();
            }
        }
    </script>
</body>

</html>
