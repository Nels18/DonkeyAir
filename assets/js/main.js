// function reqListener () {
//   console.log(this.responseText);
// }
let request = new XMLHttpRequest(); // New request object
const autocomplete = (object, element, field = null) => {
  let output = [];
  // console.log('object : ', object);

  if (field !== null) {
    output = convertObjectToArray(object, field);
  } else {
    output = object;
  }

  if (Array.isArray(output)) {
    element.innerHTML = "";
    output.forEach((item) => {
      let option = document.createElement("option");
      option.text = item;
      option.value = item;
      element.append(option);
    });
  }
};

const convertObjectToArray = (object, field) => {
  let arrayOutput = [];
  let recurseObject = (object, field) => {
    for (const property in object) {
      if (typeof object[property] == "object") {
        recurseObject(object[property], field);
      } else {
        if (property == field) {
          arrayOutput.push(object[property]);
        }
      }
    }
  };
  recurseObject(object, field);

  return arrayOutput;
};

const showReturn = () => {
  const tripType = document.querySelector('#trip-type');
  const returnFlight = document.querySelector('#return-flight');
  tripType.addEventListener('input', function (event) {
    if ('round-trip' == tripType.value) {
      returnFlight.classList.remove("hidden");
      console.log('returnFlight.classList :', returnFlight.classList);
    }
    if ('one-way' == tripType.value) {
      returnFlight.classList.add("hidden");
      console.log('returnFlight.classList :', returnFlight.classList);
    }
  })
  console.log(tripType.value);
}

const departureDate = document.querySelector('#departure-date');
const returnDate = document.querySelector('#return-date');

returnDate.setAttribute('min',departureDate.getAttribute('min'));
departureDate.addEventListener('change', function(event) {
  returnDate.setAttribute('min',departureDate.value);
})


window.onload = function () {
  console.log('request.response : ', request.response);
  let cityStartAutocompleteList = document.getElementById(
    "city-start-autocomplete-list"
  );
  const cityToAutocompleteList = document.getElementById(
    "city-to-autocomplete-list"
  );

  const processData = function (data) {
    data.map((item) => {
      item.identification = `${item["code"]}, ${item["airport_name"]} - ${item["country_name"]}`;
    });
    autocomplete(data, cityStartAutocompleteList, "identification");
    autocomplete(data, cityToAutocompleteList, "identification");
  };

  // La méthode onload attend une fct callback qui fera qqc avec les données reçues
  request.onload = function () {
    if (this.readyState == 4 && this.status == 200) {
      const airports = JSON.parse(this.responseText);
      processData(airports);
    }
  };

  // instancie une nouvelle requête ou réinitialise un déjà existante.
  request.open("get", "get-airports.php", true);

  // Envoie la requête. Si la requête est asynchrone (le comportement par défaut), la méthode renvoie un résultat dès que la requête est envoyée.
  request.send();

  // console.log(request);
  showReturn();
};

/* Carousel */

const date = document.querySelector("#date");
date.setAttribute("", "selected");
date.addEventListener("add", function(event){
  date.setAttribute("",date.value);
})