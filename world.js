document.addEventListener("DOMContentLoaded", function () {
  const countryInput = document.getElementById("country");
  const result = document.getElementById("result");

  function search(lookup) {
    // encodeURIComponent keeps spaces and symbols in the search valid in a URL.
    let url = "world.php?country=" + encodeURIComponent(countryInput.value);
    if (lookup) {
      url += "&lookup=" + lookup;
    }

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
  }

  document.getElementById("lookup").addEventListener("click", function () {
    search();
  });

  document.getElementById("lookup-cities").addEventListener("click", function () {
    search("cities");
  });
});
