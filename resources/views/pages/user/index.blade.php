<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($metatag) ? $metatag['title'] : env('APP_NAME') }}</title>
    <meta name="title" content="{{ isset($metatag) ? $metatag['title'] : env('APP_NAME') }}">
    <meta name="description" content="{{ isset($metatag) ? $metatag['desc'] : env('APP_DESC') }}">
    <meta name="keywords" content="{{ isset($metatag) ? $metatag['keyword'] : env('APP_KEYWORD') }}">
    <link rel="icon" type="image/png" href="{{ isset($settings['faviconImage']) ? $settings['faviconImage'] : $settings['faviconImageDefault'] }}">
    <link rel="canonical" href="{{ url()->full() }}">

    <link rel="stylesheet" href="/css/index.css?v=9">
    <link rel="stylesheet" href="/css/notify.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @php
        $colors = json_decode($settings['termsHeadColors'], true);

        $normalizeColor = function($c) {
            return strtolower($c) === 'white' ? '#ffffff' : $c;
        };

        $color1 = $normalizeColor($colors[0] ?? '#ff0000'); // default red if missing
        $color2 = $normalizeColor($colors[1] ?? '#ffffff'); // default white if missing
    @endphp

    <style>
        .modal-header {
            background: linear-gradient(180deg, {{ $color1 }}, {{ $color2 }});
        }
    </style>
</head>
<body>
    <div class="mobile-view-wrapper">
        <div class="container" style="background-image: url('{{ $settings['previewGameImage'] }}'); background-size: 100% 100%; background-repeat: no-repeat; background-position: center center;">
            <!-- All your original content is now inside this styled container -->
            <button class="terms-btn" onclick="showTerms()">
                <i class="fas fa-info-circle"></i>
                S&K
            </button>

            @if(isset($voucher))
                <div class="main-content prize-display">
                    <div class="prize-container">
                        <div class="main-prize-ring">
                            <img id="spin-wheel" src="{{ $settings['spinWheelImage'] }}" alt="Spinning Wheel" class="spin-wheel-image">
                        </div>

                        <div class="surrounding-gifts-container">
                            @foreach($gifts as $gift)
                                <img src="{{ $settings['giftImage'] }}" alt="Gift" class="surrounding-gift">
                            @endforeach
                        </div>
                    </div>

                    <p class="prize-message">kamu telah memanjat pinang nya, ambil hadiah mu</p>

                    <div class="action-buttons-group">
                        <a href="/" class="action-btn secondary" role="button">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali</span>
                        </a>
                        <button id="spin-button" class="action-btn primary">
                            <i class="fas fa-play"></i>
                            <span>Cabut Hadiah Mu</span>
                        </button>
                    </div>
                </div>

                <div id="prize-modal" class="modal-overlay">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Congratulations!</h3>
                            <button onclick="closePrizeModal()" class="close-btn">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body prize-details">
                            <img id="prize-image" src="" alt="Your Prize" class="prize-image">
                            <h4 id="prize-name"></h4>
                            <p id="prize-desc"></p>

                            <div class="claim-instruction">
                                <p>Silakan **screenshot halaman ini** dan kirimkan ke Admin untuk klaim hadiahmu!</p>
                                <a href="{{ $settings['adminLink'] }}" class="action-btn primary" target="_blank">
                                    <i class="fas fa-paper-plane"></i>
                                    <span>Kirim ke Admin</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="main-content">
                    <div class="logo-section">
                        <img src="{{ $settings['logoImage'] }}" alt="logo">
                    </div>

                    <div class="form-container">
                        <div class="card-form">
                            <p class="subtitle text-center">Masukkan kode ticket untuk claim hadiah</p>
                            <form method="GET" class="ticket-form" id="ticketForm">
                                <div class="input-group">
                                    <input
                                        type="text"
                                        name="code"
                                        id="ticketCode"
                                        placeholder="Masukkan kode ticket"
                                        maxlength="20"
                                        required
                                        autocomplete="off"
                                    >
                                    <button type="submit" class="submit-btn">
                                        <i class="fas fa-search"></i>
                                        <span>Claim</span>
                                    </button>
                                </div>
                            </form>

                            <div class="divider"></div>

                            <div class="action-buttons">
                                <a href="{{ $settings['adminLink'] }}" class="action-btn primary" target="_blank">
                                    <i class="fas fa-ticket-alt"></i>
                                    <span>Dapatkan Kode Ticket</span>
                                </a>
                                <button class="action-btn secondary" onclick="showPrizeList()">
                                    <i class="fas fa-gift"></i>
                                    <span>List Hadiah</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="loading-container">
                <div class="loading-bar">
                    <div class="progress"></div>
                </div>
                <div class="loading-message">
                    <p>0%</p>
                </div>
            </div>

            <div class="main-modal-overlay" id="termsModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Syarat & Ketentuan</h3>
                        <button onclick="closeTerms()" class="close-btn">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="terms-content">
                            {!! $settings['terms'] !!}
                        </div>
                    </div>
                </div>
            </div>

            <div id="prizeListModal" class="main-modal-overlay">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>List Hadiah</h3>
                        <button onclick="hidePrizeList()" class="close-btn">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        @foreach ($giftsGroupedCategory as $categoryName => $groupedGifts)
                            <div class="category-group">
                                <button class="category-header toggle-btn" data-category="{{ $categoryName }}">
                                    <h4>{{ $categoryName }}</h4>
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="collapsible-content active" data-category="{{ $categoryName }}">
                                    <div class="gift-grid">
                                        @foreach ($groupedGifts as $gift)
                                            <div class="gift-card">
                                                <img src="{{ $gift->image }}" alt="{{ $gift->name }}" class="gift-image">
                                                <p class="gift-name">{{ $gift->name }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
    <script src="/js/notify.min.js" integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var server_settings = {!! json_encode($settings) !!};
        var voucher = {!! isset($voucher) ? json_encode($voucher) : 'null' !!};
        // console.log('Voucher:', voucher.gift);
        // console.log('Voucher:', voucher.gift.image);
        var prizes = @json($gifts);
    </script>
    <script src="js/utils.js"></script>
    <script src="js/index.js?v=9"></script>

    @if(session()->has('success'))
        <script type="text/javascript">
            $(document).ready(function() {
                $.notify('{{ session('success') }}', 'success');
            });
        </script>
    @endif

    @if(session()->has('failed') || session()->has('error'))
        <script type="text/javascript">
            $(document).ready(function() {
                $.notify('{{ session('failed') ?? session('error') }}', 'error');
            });
        </script>
    @endif

</body>
</html>
