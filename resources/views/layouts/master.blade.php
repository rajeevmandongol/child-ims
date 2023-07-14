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
    </style>
</head>

<body class="antialiased">

    @yield('content')

    <script>
        const table = document.querySelector("table");
        const inputTableBody = document.querySelector("table#table tbody");
        let allRows = document.querySelectorAll("#table tbody tr");

        let differentAddress = document.querySelectorAll("input[name='child_different_address[]']");

        const childAddress = document.querySelectorAll("input[name='child_address[]']");
        const childCity = document.querySelectorAll("input[name='child_city[]']");
        const childState = document.querySelectorAll("input[name='child_state[]']");
        const country = document.querySelectorAll("select[name='country[]']");
        const childZip = document.querySelectorAll("input[name='child_zip[]']");

        console.log("CHILD : ", childAddress);

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

        const countries = [
            ["us", "United States"],
            ["np", "Nepal"],
        ];

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


        function addNewRow(event) {
            event.preventDefault();

            let rowCount = allRows.length;

            const tr = document.createElement("tr");
            let td = document.createElement("td");
            const button = document.createElement("button");

            button.classList.add("btn");
            button.classList.add("btn-danger");

            button.innerHTML = '<i class="fa-solid fa-trash"></i>';
            tr.appendChild(td);

            td.appendChild(button);
            for (let index = 0; index < inputFieldNames.length; index++) {
                console.log(inputFieldNames[0][0]);
                if (inputFieldNames[index][0] === "checkbox") {
                    td = document.createElement("td");

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
                    tr.appendChild(td);
                }
                if (inputFieldNames[index][0] === "input") {
                    td = document.createElement("td");

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
                    tr.appendChild(td);
                } else if (inputFieldNames[index][0] === "select") {
                    td = document.createElement("td");

                    const tempInput = document.createElement("select");
                    tempInput.setAttribute("name", inputFieldNames[index][1] + `[${rowCount}]`)
                    if (inputFieldNames[index][1] === "child_gender") {

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
                    } else if (inputFieldNames[index][1] === "child_country") {
                        countries.forEach((countryData, index) => {
                            const tempOption = document.createElement("option");
                            tempOption.textContent = countryData[1];
                            tempOption.value = countryData[0];

                            tempInput.appendChild(tempOption);

                        });
                        tempInput.toggleAttribute("disabled");
                    }

                    td.appendChild(tempInput);
                    tr.appendChild(td);
                }

            }

            inputTableBody.appendChild(tr);
            table.appendChild(inputTableBody);
            updateDifferentAddressList();
        }

        function updateDifferentAddressList() {
            differentAddress = document.querySelectorAll("input[name='child_different_address[]']");
            allRows = Array.from(document.querySelectorAll("#table tbody tr"));
        }

        function deleteChildRecord(event, rowId) {
            event.preventDefault();
            if (confirm('Are you sure you want to delete this record?')) {
                document.getElementById('delete-form-' + rowId).submit();
            }
        }
    </script>
</body>

</html>
