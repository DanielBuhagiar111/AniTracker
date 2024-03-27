document.addEventListener('DOMContentLoaded', function () {
  form = document.querySelector('form');
  submitButton = document.getElementById('submitButton');
  errorElement = document.getElementById('error');
  submitButton.disabled = true

  form.addEventListener('input', function () {
    if (validateForm()) {
      submitButton.disabled = false
    } else {
      submitButton.disabled = true
    }
  });
  
  function validateForm() {
    title = document.getElementById('title').value.trim();
    studio = document.getElementById('studio').value.trim();
    score = document.getElementById('score').value.trim();
    watchedEps = document.getElementById('watched_eps').value.trim();
    totalEps = document.getElementById('total_eps').value.trim();

    errorElement.innerHTML = '';

    if (validator.isEmpty(title) || validator.isEmpty(studio) || validator.isEmpty(score) || validator.isEmpty(watchedEps) || validator.isEmpty(totalEps)) {
      showError('All input fields are required!');
      return false;
    } else if (!validator.isInt(score, { min: 0, max: 10 })) {
      showError('Score must be an integer between 0 and 10!');
      return false;
    } else if (!validator.isInt(watchedEps, { min: 0 })) {
      showError('Episodes watched must be a positive integer!');
      return false;
    } else if (totalEps !== '?' && !validator.isInt(totalEps, { min: 0 })) {
      showError('Total number of episodes must be a positive integer!');
      return false;
    } else if (totalEps !== '?' && parseInt(watchedEps, 10) > parseInt(totalEps, 10)) {
      showError('Episodes watched cannot be larger than the total number of episodes!');
      return false;
    } else {
      return true;
    }
  }

  function showError(errorMessage) {
    errorElement.innerHTML = errorMessage;
  }
});
