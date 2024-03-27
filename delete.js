document.addEventListener('DOMContentLoaded', function () {
    form = document.querySelector('form');
    submitButton = document.getElementById('submitButton');
    errorElement = document.getElementById('error');
    submitButton.disabled = true;

    form.addEventListener('input', function () {
        if (validateForm()) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    });

    function validateForm() {
        index = document.getElementById('index').value.trim();
        numAnimes = parseInt(document.getElementById('index').getAttribute('data-num-animes'));
        errorElement.innerHTML = '';

        if (validator.isEmpty(index)) {
            showError('Input field required!');
            return false;
        } else if (numAnimes == 0) {
            showError("There is nothing to delete!");
            return false;
        }
        else if (!validator.isInt(index, { min: 1, max: numAnimes })) {
            if (numAnimes == 1) {
                showError("You only have 1 anime in your list therefore you have to enter 1");
            } else {
                showError("Index must be an integer between 1 and " + numAnimes + "!");
            }
            return false;
        } else {
            return true;
        }
    }

    function showError(errorMessage) {
        errorElement.innerHTML = errorMessage;
    }
});
