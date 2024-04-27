<x-guest-layout title="Canjear código">
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2">
                    <img aria-hidden="true" class="object-cover w-full h-full dark:hidden"
                         src="{{ asset('img/login-office.jpeg') }}" alt="Office"/>
                    <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block"
                         src="{{ asset('img/login-office-dark.jpeg')}}" alt="Office"/>
                </div>
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                            Canjear código
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

                        <!-- Stream video via webcam -->
                        <div class="col d-flex justify-content-center">
                            <video id="video" playsinline autoplay width="640"></video>
                        </div>

                        <!-- Webcam video snapshot -->
                        <canvas id="canvas" width="640" height="360" hidden></canvas>


                        <button id="snap"
                                class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            {{ __('Capturar código') }}
                        </button>


                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="text-center mt-5 mb-5">
                                <img height="250" width="250" id="preview-image" alt="" hidden>
                            </div>


                            <input type="hidden" name="selfie" id="selfie">
                            <!-- You should use a button here, as the anchor is only used for the example  -->
                            <button
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
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snap = document.getElementById("snap");
        const errorMsgElement = document.querySelector('span#errorMsg');

        let constraints = {
            audio: false,
            video: {
                width: 640, height: 360
            }
        };

        // Access webcam
        async function init() {
            try {
                const cameras = await navigator.mediaDevices.enumerateDevices();
                cameras.forEach(function (camera) {
                    let rearCameraId = null;
                    if (camera.kind === 'videoinput' && camera.label.toLowerCase().includes('back')) {
                        rearCameraId = camera.deviceId;
                    }
                    if (rearCameraId) {
                        constraints = {
                            audio: false,
                            video: {
                                width: 640, height: 360,
                                deviceId: {
                                    exact: rearCameraId
                                }
                            },
                        }
                    }
                });
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                handleSuccess(stream);
            } catch (e) {
                errorMsgElement.innerHTML = `navigator.getUserMedia error:${e.toString()}`;
            }
        }

        // Success
        function handleSuccess(stream) {
            window.stream = stream;
            video.srcObject = stream;
        }

        // Load init
        init();

        // Draw image
        var context = canvas.getContext('2d');
        snap.addEventListener("click", function (event) {
            context.drawImage(video, 0, 0, 640, 360);
            img = document.getElementById('canvas').toDataURL('image/png');
            document.getElementById('selfie').value = img;


        });
    </script>

</x-guest-layout>
