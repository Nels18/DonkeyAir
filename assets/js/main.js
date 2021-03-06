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

// returnDate.setAttribute('min',departureDate.getAttribute('min'));
// departureDate.addEventListener('change', function(event) {
//   returnDate.setAttribute('min',departureDate.value);
// })


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

  // La m??thode onload attend une fct callback qui fera qqc avec les donn??es re??ues
  request.onload = function () {
    if (this.readyState == 4 && this.status == 200) {
      const airports = JSON.parse(this.responseText);
      processData(airports);
    }
  };

  // instancie une nouvelle requ??te ou r??initialise un d??j?? existante.
  request.open("get", "get-airports.php", true);

  // Envoie la requ??te. Si la requ??te est asynchrone (le comportement par d??faut), la m??thode renvoie un r??sultat d??s que la requ??te est envoy??e.
  request.send();

  // console.log(request);
  showReturn();
};


function myFunction() {
var x = document.getElementById("exampleInputPassword1");
if (x.type === "password"){
  x.type = "text";
  document.getElementById('hide').style.display = "inline-block";
  document.getElementById('show').style.display  = "none";
}
else{
  x.type = "password";
  document.getElementById('hide').style.display = "none";
  document.getElementById('show').style.display = "inline-block";
}
};
/* Carousel */

// buttons left and right for carousel slider
document.getElementById("btn-select-outbound").addEventListener("click", function() {
  document.getElementById("selectedOutboundFlightInformations").style.visibility = "visible";
});

document.getElementById("btn-select-return").addEventListener("click", function() {
  document.getElementById("selectedReturnFlightInformations").style.visibility = "visible";
});
