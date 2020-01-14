// This example uses the autocomplete feature of the Google Places API.
// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

var map, places, infoWindow;
var markers = [];
var autocomplete;
var numSearch = 0;
var countryRestrict = {
	country: 'us'
};
var MARKER_PATH = 'https://developers.google.com/maps/documentation/javascript/images/marker_green';

var countries = {
	au: {
		center: {
			lat: -25.3,
			lng: 133.8
		},
		zoom: 4
	},
	br: {
		center: {
			lat: -14.2,
			lng: -51.9
		},
		zoom: 3
	},
	ca: {
		center: {
			lat: 62,
			lng: -110.0
		},
		zoom: 3
	},
	fr: {
		center: {
			lat: 46.2,
			lng: 2.2
		},
		zoom: 5
	},
	de: {
		center: {
			lat: 51.2,
			lng: 10.4
		},
		zoom: 5
	},
	mx: {
		center: {
			lat: 23.6,
			lng: -102.5
		},
		zoom: 4
	},
	nz: {
		center: {
			lat: -40.9,
			lng: 174.9
		},
		zoom: 5
	},
	it: {
		center: {
			lat: 41.9,
			lng: 12.6
		},
		zoom: 5
	},
	za: {
		center: {
			lat: -30.6,
			lng: 22.9
		},
		zoom: 5
	},
	es: {
		center: {
			lat: 40.5,
			lng: -3.7
		},
		zoom: 5
	},
	pt: {
		center: {
			lat: 39.4,
			lng: -8.2
		},
		zoom: 6
	},
	us: {
		center: {
			lat: 37.1,
			lng: -95.7
		},
		zoom: 4
	},
	uk: {
		center: {
			lat: 54.8,
			lng: -4.6
		},
		zoom: 5
	}
};

function initMap() {
	map = new google.maps.Map(document.getElementById('map'), {
		zoom: countries['us'].zoom,
		center: countries['us'].center,
		mapTypeControl: true,
		panControl: false,
		zoomControl: true,
		streetViewControl: true
	});

	infoWindow = new google.maps.InfoWindow({
		content: document.getElementById('info-content')
	});

	// Create the autocomplete object and associate it with the UI input control.
	// Restrict the search to the default country, and to place type "cities".
	autocomplete = new google.maps.places.Autocomplete(
		/** @type {!HTMLInputElement} */
		document.getElementById('autocomplete'),
		{
			types: [ '(cities)' ],
			componentRestrictions: countryRestrict
		}
	);
	places = new google.maps.places.PlacesService(map);

	autocomplete.addListener('place_changed', onPlaceChanged);

	// Add a DOM event listener to react when the user selects a country.
	document.getElementById('country').addEventListener('change', setAutocompleteCountry);
	document.getElementById('query-input').addEventListener('change', onPlaceChanged);
}

// When the user selects a city, get the place details for the city and
// zoom the map in on the city.
function onPlaceChanged() {
	var query = document.getElementById('query-input').value;
	var place = autocomplete.getPlace();
	if (!query.trim().length) {
		console.log('Empty Query');
		document.getElementById('query-input').focus();
		document.getElementById('query-input').style.backgroundColor = 'lightblue';
		document.getElementById('query-input').placeholder = 'Enter an Activity';
	} else {
		// console.log('Ready to search', query);
		document.getElementById('query-input').style.backgroundColor = 'white';
		document.getElementById('autocomplete').focus();

		if (typeof place === 'undefined') {
			document.getElementById('autocomplete').focus();
		} else if (place === null) {
			document.getElementById('autocomplete').focus();
		} else if (place.geometry) {
			numSearch += 1;
			console.log('Number fo Search', numSearch);
			map.panTo(place.geometry.location);
			map.setZoom(12);
			search();
		} else {
			document.getElementById('autocomplete').placeholder = 'Enter a city';
		}
	}
}

// Search for places in the selected city using the query input, within the viewport of the map.
function search() {
	if (numSearch >= 3) {
		document.getElementById('query-input').value = 'ONLY two searches allowed';
		document.getElementById('autocomplete').value = 'ONLY two searches allowed';
		clearResults();
		clearMarkers();
	} else {
		var search = {
			bounds: map.getBounds(),
			query: document.getElementById('query-input').value,
			types: [ 'establishment' ]
		};

		//form search_activity
		document.getElementById('search_activity').value = search.query;

		places.textSearch(search, function(results, status) {
			if (status === google.maps.places.PlacesServiceStatus.OK) {
				clearResults();
				clearMarkers();
				// Create a marker for each place found, and
				// assign a letter of the alphabetic to each marker icon.
				for (var i = 0; i < results.length; i++) {
					var markerLetter = String.fromCharCode('A'.charCodeAt(0) + i % 26);
					var markerIcon = MARKER_PATH + markerLetter + '.png';
					// Use marker animation to drop the icons incrementally on the map.
					markers[i] = new google.maps.Marker({
						position: results[i].geometry.location,
						animation: google.maps.Animation.DROP,
						icon: markerIcon
					});
					// If the user clicks a place marker, show the details of that place
					// in an info window.
					markers[i].placeResult = results[i];
					google.maps.event.addListener(markers[i], 'click', showInfoWindow);
					setTimeout(dropMarker(i), i * 100);
					addResult(results[i], i);
				}
			}
		});
	}
}

function clearMarkers() {
	for (var i = 0; i < markers.length; i++) {
		if (markers[i]) {
			markers[i].setMap(null);
		}
	}
	markers = [];
}

// Set the country restriction based on user input.
// Also center and zoom the map on the given country.
function setAutocompleteCountry() {
	var country = document.getElementById('country').value;
	if (country == 'all') {
		autocomplete.setComponentRestrictions({
			country: []
		});
		map.setCenter({
			lat: 15,
			lng: 0
		});
		map.setZoom(2);
	} else {
		autocomplete.setComponentRestrictions({
			country: country
		});
		map.setCenter(countries[country].center);
		map.setZoom(countries[country].zoom);
	}
	clearResults();
	clearMarkers();
	//document.getElementById("query-input").value ="";
	document.getElementById('autocomplete').value = '';
}

function dropMarker(i) {
	return function() {
		markers[i].setMap(map);
	};
}

function addResult(result, i) {
	var results = document.getElementById('results');
	var markerLetter = String.fromCharCode('A'.charCodeAt(0) + i % 26);
	var markerIcon = MARKER_PATH + markerLetter + '.png';

	var tr = document.createElement('tr');
	tr.style.backgroundColor = i % 2 === 0 ? '#F0F0F0' : '#FFFFFF';
	tr.onclick = function() {
		google.maps.event.trigger(markers[i], 'click');
	};

	var iconTd = document.createElement('td');
	var nameTd = document.createElement('td');
	var icon = document.createElement('img');
	icon.src = markerIcon;
	icon.setAttribute('class', 'placeIcon');
	icon.setAttribute('className', 'placeIcon');
	var name = document.createTextNode(result.name);
	iconTd.appendChild(icon);
	nameTd.appendChild(name);
	tr.appendChild(iconTd);
	tr.appendChild(nameTd);
	results.appendChild(tr);
}

function clearResults() {
	var results = document.getElementById('results');
	while (results.childNodes[0]) {
		results.removeChild(results.childNodes[0]);
	}
}

// Get the place details. Show the information in an info window,
// anchored on the marker for the place that the user selected.
function showInfoWindow() {
	var marker = this;
	places.getDetails(
		{
			placeId: marker.placeResult.place_id
		},
		function(place, status) {
			if (status !== google.maps.places.PlacesServiceStatus.OK) {
				return;
			}
			infoWindow.open(map, marker);
			buildIWContent(place);
		}
	);
}

// Load the place information into the HTML elements used by the info window.
function buildIWContent(place) {
	document.getElementById('iw-icon').innerHTML = '<img class="placesIcon" ' + 'src="' + place.icon + '"/>';
	document.getElementById('iw-url').innerHTML = '<b><a href="' + place.url + '">' + place.name + '</a></b>';

	//form place_name
	document.getElementById('place_name').value = place.name;

	document.getElementById('iw-address').textContent = place.formatted_address;
	//form address
	document.getElementById('address-to-save').value = place.formatted_address;

	if (place.formatted_phone_number) {
		document.getElementById('iw-phone-row').style.display = '';
		document.getElementById('iw-phone').textContent = place.formatted_phone_number;
	} else {
		document.getElementById('iw-phone-row').style.display = 'none';
	}

	// Assign a five-star rating to the place, using a black star ('&#10029;')
	// to indicate the rating the place has earned, and a white star ('&#10025;')
	// for the rating points not achieved.
	if (place.rating) {
		var ratingHtml = '';
		for (var i = 0; i < 5; i++) {
			if (place.rating < i + 0.5) {
				ratingHtml += '&#10025;';
			} else {
				ratingHtml += '&#10029;';
			}
			document.getElementById('iw-rating-row').style.display = '';
			document.getElementById('iw-rating').innerHTML = ratingHtml;
		}
	} else {
		document.getElementById('iw-rating-row').style.display = 'none';
	}
}
