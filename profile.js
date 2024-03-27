document.addEventListener('DOMContentLoaded', function () {
    form = document.querySelector('form');
    editButton = document.getElementById('editButton');
    deleteButton = document.getElementById('deleteButton');
    errorElement = document.getElementById('error');
    editButton.disabled = true
    deleteButton.disabled = true

    form.addEventListener('input', function () {
        if (validateForm()) {
            editButton.disabled = false
        } else {
            editButton.disabled = true
        }
    });

    form.addEventListener('input', function () {
        if (validatePassword()) {
            deleteButton.disabled = false
        } else {
            deleteButton.disabled = true
        }
    });


    function validateForm() {
        currentpassword = document.getElementById('currentpassword').value.trim();
        usersname = document.getElementById('name').value.trim();
        surname = document.getElementById('surname').value.trim();
        email = document.getElementById('email').value.trim();
        password = document.getElementById('password').value.trim();
        number = document.getElementById('number').value.trim();

        errorElement.innerHTML = '';

        if (validator.isEmpty(currentpassword) || validator.isEmpty(usersname) || validator.isEmpty(surname) || validator.isEmpty(email) || validator.isEmpty(password) || validator.isEmpty(number)) {
            showError('All input fields are required except the choose file input!');
            return false;
        } else if (!validator.isLength(usersname, { min: 1, max: 15 }) || !validator.isLength(surname, { min: 1, max: 15 })) {
            showError('Name and surname should be strings with a length between 1 and 15 characters!');
            return false;
        } else if (!validator.isLength(password, { min: 3 })) {
            showError('Password has to be 3 or more characters long!');
            return false;
        } else if (!validator.isEmail(email)) {
            showError('Invalid email address!');
            return false;
        } else {
            return true;
        }
    }

    function validatePassword() {
        currentpassword = document.getElementById('currentpassword').value.trim();
        if (validator.isEmpty(currentpassword)) {
            return false;
        }
        return true;
    }


    function showError(errorMessage) {
        errorElement.innerHTML = errorMessage;
    }
})