<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Properti Merah Putih</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f8fafc;
            margin: 0;
            padding: 0;
        }

        a {
            text-decoration: none;
        }

        main {
            min-height: 100vh;
        }

        /* NAVBAR */
        .navbar-custom {
            background: #991b1b;
            padding: 16px 0;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
        }

        .navbar-brand {
            color: white !important;
            font-size: 30px;
            font-weight: 800;
        }

        .navbar-brand span {
            color: #ffe082;
        }

        .navbar-nav {
            gap: 10px;
        }

        .navbar-nav .nav-link {
            color: white;
            padding: 10px 15px !important;
            border-radius: 10px;
            transition: .3s;
        }

        .navbar-nav .nav-link:hover {
            background: rgba(255, 255, 255, .15);
        }

        /* FOOTER */
        .footer {
            background: #991b1b;
            color: white;
            padding: 70px 0 20px;
        }

        .footer-title {
            font-size: 30px;
            font-weight: 800;
        }

        .footer-description {
            opacity: .9;
            line-height: 1.8;
        }

        .footer-menu a {
            display: block;
            color: white;
            opacity: .85;
            margin-bottom: 10px;
        }

        .footer-menu a:hover {
            opacity: 1;
        }

        .footer-bottom {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, .15);
            text-align: center;
        }

        /* CHATBOT */
        #chatbotButton {
            position: fixed;
            right: 25px;
            bottom: 25px;
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background: #dc2626;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            cursor: pointer;
            z-index: 9999;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .25);
            border: none;
            transition: all 0.3s ease;
        }

        #chatbotButton:hover {
            transform: scale(1.1);
        }

        #chatbotBox {
            position: fixed;
            right: 25px;
            bottom: 100px;
            width: 350px;
            height: 500px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            display: none;
            z-index: 9999;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .2);
        }

        #chatbotHeader {
            background: #dc2626;
            color: white;
            padding: 15px;
            font-weight: 700;
        }

        #chatbotMessages {
            height: 380px;
            overflow-y: auto;
            padding: 15px;
            background: #f8fafc;
        }

        .bot-message {
            background: #e5e7eb;
            padding: 10px;
            border-radius: 12px;
            margin-bottom: 10px;
            max-width: 85%;
        }

        .user-message {
            background: #dc2626;
            color: white;
            padding: 10px;
            border-radius: 12px;
            margin-bottom: 10px;
            text-align: right;
            max-width: 85%;
            margin-left: auto;
        }

        /* Animasi Pulse untuk Heart */
        @keyframes heartPulse {
            0% { transform: scale(1); }
            30% { transform: scale(1.5); }
            60% { transform: scale(0.9); }
            100% { transform: scale(1); }
        }
    </style>

    @stack('styles')
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-house-heart-fill"></i>
                Properti <span>Merah Putih</span>
            </a>
            <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/properties">
                            <i class="bi bi-buildings"></i> Property
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/simulation">
                            <i class="bi bi-calculator"></i> Simulasi KPR
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/affordability">
                            <i class="bi bi-graph-up-arrow"></i> Analisis Finansial
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/recommendation">
                            <i class="bi bi-stars"></i> Rekomendasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/compare">
                            <i class="bi bi-columns-gap"></i> Compare
                        </a>
                    </li>
                    <li class="nav-item">
    <a class="nav-link" href="/favorites">
        <i class="bi bi-heart-fill"></i> Favorit
    </a>
</li>
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">
                            <i class="bi bi-bar-chart-fill"></i> Dashboard
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main style="padding-top:95px;">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <h3 class="footer-title">Properti Merah Putih</h3>
                    <p class="footer-description">
                        Sistem Pendukung Keputusan Pemilihan Properti
                        menggunakan metode SAW yang membantu
                        pengguna menemukan rumah terbaik berdasarkan
                        kondisi finansial.
                    </p>
                </div>
                <div class="col-lg-3">
                    <h5>Menu</h5>
                    <div class="footer-menu">
                        <a href="/">Home</a>
                        <a href="/properties">Property</a>
                        <a href="{{ route('simulation.general') }}">Simulasi KPR</a>
                        <a href="/favorites">Favorit</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h5>Fitur</h5>
                    <div class="footer-menu">
                        <a href="/affordability">Analisis Finansial</a>
                        <a href="/recommendation">Rekomendasi Properti</a>
                        <a href="/compare">Compare Properti</a>
                        <a href="/dashboard">Dashboard</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                © 2026 Properti Merah Putih
            </div>
        </div>
    </footer>

    <!-- AI PROPERTY ASSISTANT -->
    <button id="chatbotButton">
        <i class="bi bi-robot"></i>
    </button>

    <div id="chatbotBox">
        <div id="chatbotHeader">
            🤖 AI Property Assistant
        </div>
        <div id="chatbotMessages">
            <div class="bot-message">
                Halo 👋<br>
                Saya dapat membantu:<br>
                • Rekomendasi Properti<br>
                • Budget Rumah<br>
                • Informasi KPR<br>
                • DP dan Cicilan
            </div>
        </div>
        <div class="p-2">
            <div class="input-group">
                <input type="text" id="chatInput" class="form-control" placeholder="Tulis pertanyaan...">
                <button class="btn btn-danger" id="sendMessage">Kirim</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script Global -->
    <script>
        // Chatbot
        const chatbotButton = document.getElementById('chatbotButton');
        const chatbotBox = document.getElementById('chatbotBox');
        const sendButton = document.getElementById('sendMessage');
        const chatInput = document.getElementById('chatInput');
        const chatMessages = document.getElementById('chatbotMessages');

        chatbotButton.onclick = function() {
            if (chatbotBox.style.display === 'block') {
                chatbotBox.style.display = 'none';
            } else {
                chatbotBox.style.display = 'block';
            }
        };

        function addUserMessage(message) {
            chatMessages.innerHTML += `
                <div class="user-message">${message}</div>
            `;
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function addBotMessage(message) {
            chatMessages.innerHTML += `
                <div class="bot-message">${message}</div>
            `;
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        sendButton.addEventListener('click', sendMessage);
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        function sendMessage() {
            const message = chatInput.value.trim();
            if (message === '') return;

            addUserMessage(message);
            chatInput.value = '';

            fetch('/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => response.json())
            .then(data => {
                addBotMessage(data.reply);
            })
            .catch(error => {
                addBotMessage('Terjadi kesalahan. Silakan coba lagi.');
            });
        }

        // Fungsi Global untuk toggle favorite
        function toggleFavorite(propertyId, button) {
            const heartIcon = document.getElementById('heart-icon-' + propertyId);
            const isCurrentlyActive = button.classList.contains('active');
            
            // Loading
            heartIcon.className = 'bi bi-hourglass-split text-warning';
            button.disabled = true;
            
            fetch('/favorites/toggle/' + propertyId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.isFavorite) {
                        button.classList.add('active');
                        heartIcon.className = 'bi bi-heart-fill';
                        heartIcon.style.animation = 'none';
                        setTimeout(() => {
                            heartIcon.style.animation = 'heartPulse 0.4s ease';
                        }, 10);
                    } else {
                        button.classList.remove('active');
                        heartIcon.className = 'bi bi-heart';
                    }
                } else {
                    alert('Gagal: ' + data.message);
                    // Rollback
                    if (isCurrentlyActive) {
                        button.classList.add('active');
                        heartIcon.className = 'bi bi-heart-fill';
                    } else {
                        button.classList.remove('active');
                        heartIcon.className = 'bi bi-heart';
                    }
                }
                button.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                // Rollback
                if (isCurrentlyActive) {
                    button.classList.add('active');
                    heartIcon.className = 'bi bi-heart-fill';
                } else {
                    button.classList.remove('active');
                    heartIcon.className = 'bi bi-heart';
                }
                button.disabled = false;
            });
        }
    </script>

    @stack('scripts')
</body>

</html>