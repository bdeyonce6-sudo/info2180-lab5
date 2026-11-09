document.addEventListener("DOMContentLoaded", function () {
  const countryInput = document.getElementById("country");
  const result = document.getElementById("result");

  document.getElementById("lookup").addEventListener("click", function () {
    const url = "world.php?country=" + encodeURIComponent(countryInput.value);

    fetch(url)
      .then(function (response) {
        if (!response.ok) {
          throw new Error("Request failed with status " + response.status);
        }
        return response.text();
      })
      .then(function (html) {
        result.innerHTML = html;
      })
      .catch(function (error) {
        result.textContent = "Something went wrong: " + error.message;
      });
  });
});
