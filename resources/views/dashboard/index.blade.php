
<x-app-layout title="Dashboard">
    <div class="container grid px-6 mx-auto">
        <div style="height: 700px;width: auto" id="map"></div>
    </div>
</x-app-layout>

<script>
    let coordinates = @json($coordinates);
    // Crear el mapa
    var mymap = L.map('map').setView([20.642098, -100.993550], 14);

    // Añadir la capa de azulejos (tiles)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        maxZoom: 18,
    }).addTo(mymap);

    // Datos de ejemplo para el mapa de calor
    var data = coordinates;

    // Configurar la capa de calor y añadirla al mapa
    var heat = L.heatLayer(data, { radius: 25 }).addTo(mymap);

</script>
