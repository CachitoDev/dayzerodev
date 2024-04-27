<x-app-layout title="Tiendas">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Tiendas
        </h2>
        <!-- With actions -->
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Crear nueva
        </h4>
        @include('common.errors')

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <form method="POST" action="{{ route('stores.store') }}">
                    @csrf
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Nombre</span>
                        <input required name="name" type="text"
                               class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"/>
                    </label>
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Radio</span>
                        <input id="radius" required name="radius" type="number" step="0.5"
                               class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"/>
                    </label>
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Latitud</span>
                        <input id="latitude" required name="latitude" type="number"
                               class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"/>
                    </label>
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Longitud</span>
                        <input id="longitude" required name="longitude" type="number"
                               class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"/>
                    </label>
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Canjes estimados</span>
                        <small>(este campo puede dejarse vacío)</small>
                        <input name="estimated" type="number"
                               class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"/>
                    </label>
                    <div class="mt-6" id="map" style="height: 400px;"></div>
                    <x-button> Guardar</x-button>
                </form>

            </div>
        </div>
    </div>
    <script>
        let radius = 50;
        let defaultLatLng = [20.643555, -100.994957];
        var map = L.map('map').setView(defaultLatLng, 15); // Coordenadas iniciales y nivel de zoom
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        var marker = L.marker(defaultLatLng, {
            draggable: true
        }).addTo(map);

        var mapRadius = L.circle(defaultLatLng, {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: radius
        }).addTo(map);

        function updateCoordinates(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            marker.setLatLng([lat, lng]);
            mapRadius.setLatLng([lat, lng]);


            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }

        function updateCoordinatesMarker(e) {
            var lat = marker.getLatLng().lat;
            var lng = marker.getLatLng().lng;
            marker.setLatLng([lat, lng]);
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }

        map.on('click', function (e) {
            updateCoordinates(e);
        });
        marker.on('dragend', function (e) {
            updateCoordinatesMarker(e);
        });

        let latitudeInput = document.getElementById('latitude');
        let longitudeInput = document.getElementById('longitude');
        let radiusInput = document.getElementById('radius');

        latitudeInput.addEventListener('input', (evt) => {
            let latValue = latitudeInput.value;
            let lngValue = longitudeInput.value;
            if (!isNaN(latValue) && latValue && lngValue && !isNaN(lngValue)) {
                marker.setLatLng([latValue, lngValue]);
            }
        });
        longitudeInput.addEventListener('input', (evt) => {
            let latValue = latitudeInput.value;
            let lngValue = longitudeInput.value;
            if (!isNaN(latValue) && latValue && lngValue && !isNaN(lngValue)) {
                marker.setLatLng([latValue, lngValue]);
            }
        });

        radiusInput.addEventListener('input', (evt) => {
            let radius = document.getElementById('radius').value;
            mapRadius.setRadius(radius);
        });

    </script>
</x-app-layout>
