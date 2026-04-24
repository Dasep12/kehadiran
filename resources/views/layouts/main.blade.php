<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kehadiran</title>

    <link href="https://unpkg.com/tabulator-tables@6.4.0/dist/css/tabulator.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    @vite(['resources/js/app.js'])
</head>

<body>
    <div class="page">
        @include('layouts.header')
        @include('layouts.navbar')
        <div class="page-wrapper">
            <!-- BEGIN PAGE BODY  -->
            @yield('content')
            <!-- END PAGE BODY  -->

            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-lg-auto ms-lg-auto">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item"><a href="https://docs.tabler.io" target="_blank" class="link-secondary" rel="noopener">Documentation</a></li>
                                <li class="list-inline-item"><a href="./license.html" class="link-secondary">License</a></li>
                                <li class="list-inline-item">
                                    <a href="https://github.com/tabler/tabler" target="_blank" class="link-secondary" rel="noopener">Source code</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="https://github.com/sponsors/codecalm" target="_blank" class="link-secondary" rel="noopener">
                                        <!-- Download SVG icon from http://tabler.io/icons/icon/heart -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon text-pink icon-inline icon-4">
                                            <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"></path>
                                        </svg>
                                        Sponsor
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Copyright © 2025
                                    <a href="." class="link-secondary">Tabler</a>. All rights reserved.
                                </li>
                                <li class="list-inline-item">
                                    <a href="./changelog.html" class="link-secondary" rel="noopener"> v1.4.0 </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/tabulator-tables@6.4.0/dist/js/tabulator.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/luxon@3/build/global/luxon.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
    // Fungsi Global untuk Toast
    window.showAlert = function(message, type = 'success') {
        let bgColor;

        // Tentukan warna berdasarkan tipe (Linear Gradient khas Tabler/SaaS)
        switch (type) {
            case 'success':
                bgColor = "linear-gradient(to right, #2fb344, #4299e1)"; // Hijau ke Biru
                break;
            case 'error':
            case 'danger':
                bgColor = "linear-gradient(to right, #d63939, #f76707)"; // Merah ke Oranye
                break;
            case 'warning':
                bgColor = "linear-gradient(to right, #f59f00, #fcc419)"; // Kuning
                break;
            default:
                bgColor = "linear-gradient(to right, #00b09b, #96c93d)";
        }

        Toastify({
            text: message,
            duration: 5000,
            close: true,
            style: {
                background: bgColor,
                padding: "12px 24px",
                fontSize: "16px",
                fontWeight: "500",
                borderRadius: "8px",
                minWidth: "250px",
                display: "flex", // Gunakan Flexbox
                alignItems: "center", // Center vertikal konten
                justifyContent: "space-between", // Beri jarak antara teks dan icon X
                boxShadow: "0 10px 15px -3px rgba(0, 0, 0, 0.1)",
            },
            gravity: "top",
            position: "center", // Biasanya kanan atas lebih standar untuk web app
            stopOnFocus: true,
        }).showToast();
    }

    flatpickr(".time_picker", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        allowInput: true // ⬅️ ini yang bikin bisa diketik
    });

    flatpickr(".date_picker", {
        enableTime: false,
        noCalendar: false, // ⬅️ ini yang bikin hanya jam
        dateFormat: "Y-m-d", // format 24 jam (contoh: 14:30)
        clickOpens: true,
        allowInput: true
    });
</script>
@stack('scripts')

</html>