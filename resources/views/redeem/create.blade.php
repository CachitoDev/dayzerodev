<x-guest-layout title="Canjear código">
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                            Canjear código de promoción
                        </h1>
                        @if ($errors->any())
                            <div class="mb-4">
                                <div class="font-medium text-red-600">Whoops! Something went wrong.</div>

                                <ul class="mt-3 text-sm text-red-600 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Selector de cámaras -->
                        <label for="cameras">Selecciona la camara a utilizar:</label>
                        <select id="cameras"></select>

                        <!-- Vista previa de la cámara -->
                        <div id="cameraView"></div>

                        <div class="text-center mt-5 mb-5">
                            <img height="250" width="250" id="preview-image" alt="" hidden>
                            <img src="" id="show-image">
                        </div>

                        <!-- Botón de captura -->
                        <button
                            class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                            id="captureBtn">Capturar
                        </button>

                        <button
                            class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                            id="showRecapture">Volver a capturar
                        </button>

                        <form method="POST" action="{{ route('redeem.store') }}">
                            @csrf
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Folio</span>
                                <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Ingresa tu folio" name="folio" value="{{ old('folio') }}" required autofocus />
                            </label>
                            <!-- Input oculto para guardar la imagen en base64 -->
                            <input type="hidden" id="capturedImage" name="capturedImage">
                            <input hidden id="latitude" name="latitude">
                            <input hidden id="longitude" name="longitude">

                            <small id="showMessageLoading">Estamos validando los cupones</small>
                            <!-- You should use a button here, as the anchor is only used for the example  -->
                            <button id="changeCodeButton"
                                    class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                                    type="submit">
                                {{ __('Canjear código') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('changeCodeButton').style.display = 'None';
        document.getElementById('showRecapture').style.display = 'None';
        // Obtener el elemento select y el botón de captura
        const camerasSelect = document.getElementById('cameras');
        const captureBtn = document.getElementById('captureBtn');
        const cameraView = document.getElementById('cameraView');
        const capturedImageInput = document.getElementById('capturedImage');

        // Función para obtener las cámaras disponibles
        async function getCameras() {
            const devices = await navigator.mediaDevices.enumerateDevices();
            const cameras = devices.filter(device => device.kind === 'videoinput');
            return cameras;
        }

        // Función para cargar las cámaras en el selector
        async function loadCameras() {
            const cameras = await getCameras();
            cameras.forEach(camera => {
                const option = document.createElement('option');
                option.value = camera.deviceId;
                option.text = camera.label || `Cámara ${cameras.indexOf(camera) + 1}`;
                camerasSelect.appendChild(option);
            });
        }

        // Función para iniciar la cámara seleccionada
        async function startCamera() {
            const constraints = {
                video: {
                    facingMode: {
                        exact: 'environment' // 'environment' para la cámara trasera
                    },
                    // width: { ideal: 4096 },
                    // height: { ideal: 2160 }
                }
            };
            const stream = await navigator.mediaDevices.getUserMedia(constraints);
            cameraView.innerHTML = `<video id="camera" autoplay playsinline></video>`;
            const videoElement = document.getElementById('camera');
            videoElement.srcObject = stream;
        }

        // Cargar las cámaras al cargar la página
        window.addEventListener('DOMContentLoaded', async () => {
            await loadCameras();
            await startCamera();
        });

        // Cambiar la cámara al seleccionar una diferente
        camerasSelect.addEventListener('change', async () => {
            const videoElement = document.getElementById('camera');
            const stream = videoElement.srcObject;
            const tracks = stream.getTracks();
            tracks.forEach(track => track.stop());
            await startCamera();
        });

        // Capturar imagen al hacer clic en el botón
        captureBtn.addEventListener('click', () => {
            const videoElement = document.getElementById('camera');
            const canvas = document.createElement('canvas');
            canvas.width = videoElement.videoWidth;
            canvas.height = videoElement.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(videoElement, 0, 0, canvas.width, canvas.height);
            const capturedImage = canvas.toDataURL('image/png');
            capturedImageInput.value = capturedImage;
            document.getElementById('showRecapture').style.display = 'block';
            document.getElementById('changeCodeButton').style.display = 'block';
            document.getElementById('cameraView').style.display = 'none';
            document.getElementById('captureBtn').style.display = 'none';
            document.getElementById('show-image').src = capturedImage;
            document.getElementById('show-image').style.display = 'block';
        });

        document.getElementById('showRecapture').addEventListener('click', () => {
            document.getElementById('showRecapture').style.display = 'none';
            document.getElementById('changeCodeButton').style.display = 'none';
            document.getElementById('cameraView').style.display = 'block';
            document.getElementById('captureBtn').style.display = 'block';
            document.getElementById('show-image').style.display = 'none';
        });




        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                        const accuracy = position.coords.accuracy;
                        document.getElementById('latitude').value = latitude;
                        document.getElementById('longitude').value = longitude;
                        document.getElementById('showMessageLoading').innerText = 'Captura la imagen de tu cupón para canjearlo.';
                    },
                    (error) => {
                        console.error('Error al obtener la ubicación:', error);
                    }
                );
            } else {
                console.error('Tu navegador no soporta la API de geolocalización.');
            }
        }

        // Llamar a la función getLocation al cargar la página
        window.addEventListener('DOMContentLoaded', () => {
            getLocation();
        });
    </script>

</x-guest-layout>
