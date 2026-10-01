<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Scripts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<main class="py-4">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        text-decoration: none;
        font-family: 'Inter', 'Poppins', sans-serif;
    }

    :root {
    --primary-color: #ec4899;      /* 🌸 Rose Pink */
    --primary-dark: #db2777;       /* Deep Pink */
    --primary-light: #f472b6;      /* Light Pink */
    --secondary-color: #a855f7;    /* Purple (online dot) */
    --bg-main: #fdf2f8;            /* Soft pink background */
    --text-primary: #1e293b;
    --text-secondary: #64748b;
    --text-muted: #94a3b8;
    --border-color: #fce7f3;       /* Pink border */
    --message-sent: #ec4899;
    --message-received: #fdf2f8;   /* Light pink received msg */
}

    body {
        min-height: 100vh;
        background: linear-gradient(135deg, #f9a8d4 0%, #c084fc 100%);
    }

    .wrapper {
        background: var(--bg-main) !important;
        min-height: 100%;
        border-radius: 24px;
        overflow: hidden;
        max-height: 88vh;
        box-shadow: var(--shadow-xl);
    }

    .gna {
        background: #fff;
        border-radius: 24px;
        box-shadow: var(--shadow-xl), 0 0 0 1px rgba(0, 0, 0, 0.05);
        width: 100%;
        min-height: 88vh;
        padding: 0;
        overflow: hidden;
    }

    /* =============== USERS LIST SIDEBAR =============== */
    .users {
        padding: 0;
        height: 88vh;
        display: flex;
        flex-direction: column;
        background: white;
    }

    .users header {
        display: flex;
        flex-direction: column;
        padding: 24px 20px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        border-bottom: none;
        gap: 16px;
    }

    .users header .content {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .wrapper img {
        object-fit: cover;
        border-radius: 50%;
    }

    .users header img {
        height: 56px;
        width: 56px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        position: relative;
    }

    .users header .content::after {
        content: '';
        position: absolute;
        width: 14px;
        height: 14px;
        background: var(--secondary-color);
        border: 3px solid var(--primary-color);
        border-radius: 50%;
        margin-left: -20px;
        margin-top: 35px;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }

    .users .content .details {
        color: white;
        margin-left: 0;
    }

    .users .details span {
        font-size: 18px;
        font-weight: 600;
    }

    .users .details p {
        font-size: 14px;
        opacity: 0.9;
        margin-top: 4px;
    }

    .users header .logout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        outline: none;
        border: none;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        width: 100%;
    }

    .users header .logout:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* =============== SEARCH SECTION =============== */
    .users .search {
        margin: 0;
        padding: 16px 20px;
        display: flex;
        position: relative;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--border-color);
        background: white;
    }

    .users .search .text {
        font-size: 14px;
        color: var(--text-secondary);
        font-weight: 500;
    }

    .users .search input {
        position: absolute;
        height: 42px;
        width: calc(100% - 90px);
        font-size: 14px;
        padding: 0 16px 0 44px;
        border: 2px solid var(--border-color);
        outline: none;
        border-radius: 12px;
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s ease;
        background: var(--bg-main);
        left: 20px;
    }

    .users .search input.show {
        opacity: 1;
        pointer-events: auto;
    }

    .users .search input.show:focus {
        border-color: var(--primary-color);
        background: white;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .users .search input.show::placeholder {
        color: var(--text-muted);
    }

    .users .search button {
        position: relative;
        z-index: 1;
        width: 42px;
        height: 42px;
        font-size: 16px;
        cursor: pointer;
        border: none;
        background: var(--bg-main);
        color: var(--text-secondary);
        outline: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        margin-left: auto;
    }

    .users .search button:hover {
        background: var(--border-color);
        color: var(--text-primary);
    }

    .users .search button.active {
        background: var(--primary-color);
        color: #fff;
    }

    .users .search button.active:hover {
        background: var(--primary-dark);
    }

    .search button.active i::before {
        content: '\f00d';
    }

    /* =============== USERS LIST =============== */
    .users-list {
        flex: 1;
        overflow-y: auto;
        padding: 12px;
        scroll-behavior: smooth;
        scroll-padding: 20px;
    }

    .users-list::-webkit-scrollbar {
        width: 6px;
    }

    .users-list::-webkit-scrollbar-track {
        background: transparent;
    }

    .users-list::-webkit-scrollbar-thumb {
        background: var(--border-color);
        border-radius: 10px;
    }

    .users-list::-webkit-scrollbar-thumb:hover {
        background: var(--text-muted);
    }

    .users-list a {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px;
        padding-bottom: 14px;
        font-size: 14px !important;
        margin-bottom: 6px;
        border-bottom: none;
        border-radius: 14px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        color: inherit;
        position: relative;
    }

    .users-list a:last-child {
        margin-bottom: 0;
    }

    .users-list a:hover {
        background: var(--bg-main);
        transform: translateX(4px);
    }

    .users-list a img {
        height: 48px;
        width: 48px;
        flex-shrink: 0;
    }

    .users-list a .details {
        flex: 1;
        min-width: 0;
    }

    .users-list a .details span {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-primary);
        display: block;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .users-list a .details p {
        color: var(--text-secondary);
        font-size: 13px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .users-list a .status-dot {
        font-size: 12px;
        color: var(--secondary-color);
        padding-right: 0;
        padding-left: 0;
        flex-shrink: 0;
    }

    .users-list a .status-dot.offline {
        color: var(--text-muted);
    }

    /* =============== ACTIVE USER STYLING =============== */
    .users-list a[class*="cdd_"] {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(99, 102, 241, 0.05) 100%) !important;
        border-radius: 14px !important;
        padding: 14px !important;
        margin-bottom: 6px !important;
        border-left: 4px solid var(--primary-color) !important;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.12), 0 4px 16px rgba(99, 102, 241, 0.08) !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateX(0);
        position: relative;
    }

    .users-list a[class*="cdd_"]:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.18), 0 6px 20px rgba(99, 102, 241, 0.12) !important;
    }

    .users-list a[class*="cdd_"] .details span {
        color: var(--primary-color) !important;
        font-weight: 600 !important;
    }

    .users-list a[class*="cdd_"] .details p {
        color: var(--text-primary) !important;
        font-weight: 500 !important;
    }

    .users-list a[class*="cdd_"] .status-dot {
        color: var(--primary-color) !important;
        font-weight: bold;
    }

    .users-list a[class*="cdd_"]::after {
        content: 'Active';
        position: absolute;
        right: 14px;
        top: 12px;
        font-size: 10px;
        font-weight: 600;
        color: var(--primary-color);
        background: rgba(99, 102, 241, 0.15);
        padding: 3px 8px;
        border-radius: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    @keyframes subtlePulse {
        0%, 100% {
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.12), 0 4px 16px rgba(99, 102, 241, 0.08);
        }
        50% {
            box-shadow: 0 3px 10px rgba(99, 102, 241, 0.15), 0 6px 20px rgba(99, 102, 241, 0.12);
        }
    }

    .users-list a[class*="cdd_"] {
        animation: subtlePulse 3s ease-in-out infinite;
    }

    /* =============== CHAT AREA =============== */
    .chat-area {
        display: flex;
        flex-direction: column;
        height: 88vh;
    }

    .chat-area header {
        display: flex;
        align-items: center;
        padding: 20px 28px;
        gap: 16px;
        background: white;
        border-bottom: 1px solid var(--border-color);
    }

    .chat-area header .back-icon {
        color: var(--text-primary);
        font-size: 18px;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--bg-main);
        transition: all 0.3s ease;
    }

    .chat-area header .back-icon:hover {
        background: var(--border-color);
        transform: scale(1.05);
    }

    .chat-area header img {
        height: 50px;
        width: 50px;
        margin: 0;
        flex-shrink: 0;
    }

    .chat-area header .details {
        flex: 1;
        min-width: 0;
    }

    .chat-area header .details span {
        font-size: 17px;
        font-weight: 600;
        color: var(--text-primary);
        display: block;
        margin-bottom: 4px;
    }

    .chat-area header .details p {
        font-size: 13px;
        color: var(--text-secondary);
        font-weight: 500;
        margin: 0;
    }

    .data-container {
        min-width: 100px;
        overflow-x: auto;
        white-space: nowrap;
        max-width: 700px;
        margin-top: 6px;
    }

    .data-container p {
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 400;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .data-container span {
        font-weight: 600;
        color: var(--text-primary);
    }

    /* =============== CHAT BOX =============== */
    .chat-box {
        position: relative;
        flex: 1;
        overflow-y: auto;
        padding: 24px 28px;
        background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
        scroll-behavior: smooth;
    }

    .chat-box::-webkit-scrollbar {
        width: 6px;
    }

    .chat-box::-webkit-scrollbar-track {
        background: transparent;
    }

    .chat-box::-webkit-scrollbar-thumb {
        background: var(--border-color);
        border-radius: 10px;
    }

    .chat-box::-webkit-scrollbar-thumb:hover {
        background: var(--text-muted);
    }

    .chat-box .text {
        position: absolute;
        top: 45%;
        left: 50%;
        width: calc(100% - 50px);
        text-align: center;
        transform: translate(-50%, -50%);
        color: var(--text-muted);
        font-size: 15px;
    }

    .chat-box .chat {
        margin: 15px 0;
        display: flex;
        gap: 12px;
    }
    .chat-box .chat .session {
        animation: messageSlide 0.3s ease;
    }

    @keyframes messageSlide {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .chat-box .chat p {
        word-wrap: break-word;
        padding: 12px 18px;
        border-radius: 18px;
        font-size: 14.5px;
        line-height: 1.5;
        box-shadow: var(--shadow-sm);
    }

    .chat-box .outgoing {
        justify-content: flex-end;
    }

    .chat-box .outgoing .details {
        margin-left: auto;
        max-width: 70%;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .outgoing .details p {
        background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%) !important;
        border-color: transparent;
        color: white;
        border-radius: 18px 18px 4px 18px;
        position: relative;
        padding: 12px 18px;
        margin-bottom: 0;
        border: none;
    }

    .outgoing .details .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        font-size: 11px;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .chat-box .incoming {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .chat-box .incoming img {
        height: 36px;
        width: 36px;
        flex-shrink: 0;
    }

    .chat-box .incoming .details {
        margin-right: auto;
        margin-left: 0;
        max-width: 70%;
    }

    .incoming .details p {
        background-color: var(--message-received);
        border-color: transparent;
        color: var(--text-primary);    
        border-radius: 18px 18px 18px 4px;
        position: relative;
        padding: 12px 18px;
        border: none;
        margin-bottom: 0;
    }

    .incoming .details span {
        font-size: 11px;
        color: var(--text-secondary);
        margin-top: 6px;
        display: inline-block;
    }

    /* =============== TYPING AREA =============== */
    .typing-area {
        padding: 20px 28px;
        display: flex;
        gap: 12px;
        background: white;
        border-top: 1px solid var(--border-color);
        align-items: flex-end;
    }

    .typing-area textarea {
        flex: 1;
        height: auto;
        min-height: 50px;
        max-height: 120px;
        width: auto;
        font-size: 14.5px;
        padding: 14px 18px;
        border: 2px solid var(--border-color);
        outline: none;    
        border-radius: 24px;
        resize: none;
        font-family: inherit;
        line-height: 1.5;
        transition: all 0.3s ease;
    }

    .typing-area textarea:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .typing-area button {
        color: #fff;
        width: 50px;
        height: 50px;
        border: none;
        outline: none;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        font-size: 18px;
        cursor: pointer;
        opacity: 0.5;
        pointer-events: none;
        border-radius: 50%;
        transition: all 0.3s ease;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-md);
    }

    .typing-area button.active {
        opacity: 1;
        pointer-events: auto;
    }

    .typing-area button.active:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-lg);
    }

    .typing-area button.active:active {
        transform: scale(0.95);
    }

    /* =============== RESPONSIVE =============== */
    @media screen and (max-width: 768px) {
        .users {
            padding: 0;
            height: 90vh;
        }

        .users header {
            padding: 20px 16px;
        }

        .users header img {
            height: 48px;
            width: 48px;
        }

        .users header .logout {
            padding: 8px 16px;
            font-size: 13px;
        }

        .users .details span {
            font-size: 16px;
        }

        .users .search {
            padding: 12px 16px;
        }

        .users-list {
            padding: 8px;
        }

        .users-list a {
            padding: 12px;
        }

        .users-list a img {
            height: 42px;
            width: 42px;
        }

        .users-list a[class*="cdd_"] {
            padding: 12px !important;
        }

        .users-list a[class*="cdd_"]::after {
            font-size: 9px;
            padding: 2px 6px;
            right: 10px;
            top: 10px;
        }

        .chat-area header {
            padding: 16px 20px;
        }

        .chat-area header img {
            height: 44px;
            width: 44px;
        }

        .chat-box {
            padding: 16px 20px;
            min-height: auto;
        }

        .chat-box .chat p {
            font-size: 14px;
        }

        .chat-box .outgoing .details,
        .chat-box .incoming .details {
            max-width: 80%;
        }

        .typing-area {
            padding: 16px;
        }

        .typing-area textarea {
            font-size: 14px;
            padding: 12px 16px;
        }

        .typing-area button {
            width: 45px;
            height: 45px;
            font-size: 16px;
        }
    }

</style>

<?php if(isset($user_id) && !empty($user_id)) : ?>
<style>
/* =============== ACTIVE USER BORDER (PHP Dynamic) =============== */
.cdd_<?php echo $user_id; ?> {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(99, 102, 241, 0.05) 100%) !important;
    border-left: 4px solid var(--primary-color) !important;
    border-radius: 14px !important;
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.12), 0 4px 16px rgba(99, 102, 241, 0.08) !important;
    position: relative;
    transition: all 0.3s ease-in-out;
}

/* Highlight name/text for active user */
.cdsd_<?php echo $user_id; ?> span {
    color: var(--primary-color) !important;
    font-weight: 600 !important;
}

.cdsd_<?php echo $user_id; ?> p {
    color: var(--text-primary) !important;
    font-weight: 500 !important;
}

/* Optional: Add a glowing border effect for better visual feedback */
.cdd_<?php echo $user_id; ?>::before {
    content: '';
    position: absolute;
    top: -2px;
    bottom: -2px;
    left: -2px;
    right: -2px;
    border-radius: 16px;
    border: 2px solid rgba(99, 102, 241, 0.3);
    box-shadow: 0 0 12px rgba(99, 102, 241, 0.3);
    pointer-events: none;
}
</style>
<?php endif; ?>


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                <!-- USER LIST SIDEBAR -->
                <div class="col-md-3">
                    <div class="name">
                        <div class="wrapper">
                            <section class="users">
                                <header>
                                    <div class="content">
                                        @foreach($sql as $collection)
                                            <img src="{{asset('php/images/'.$collection->img)}}" alt="">
                                            <div class="details">
                                                <span>{{$collection->name}}</span>
                                                <p>{{$collection->status}}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                
                                    <!-- Logout button -->
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="logout">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </header>

                                <div class="search">
                                    <span class="text">Select a user to start chat</span>
                                    <input type="text" placeholder="Search conversations...">
                                    <button><i class="fas fa-search"></i></button>
                                </div>

                                <div class="users-list">
                                    <p class="text-center text-danger mt-5">loading users.....</p>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

                <!-- CHAT AREA -->
                <div class="col-md-9">
                    <div class="gna">
                        <div class="ddd">
                            <section class="chat-area">
                                <header>
                                    <a href="/home" class="back-icon">
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                                    @if(isset($img))
                                        <img src="{{asset('php/images/'.$img)}}" alt="">
                                    @else
                                        <img src="{{asset('php/images/16831092541676468639881_DTHfsCKR4R8FNAUOoS6ZCVqhkMmQLbwW5wmLSIu7t0MgkUhQfYRY3z8PrxkZ14.png')}}">
                                    @endif
                                    <div class="details">
                                        <span>@if(isset($name)) {{$name}} @endif</span>
                                        <p>@if(isset($days)) {{"Last seen: ".$days}} @endif</p>
                                        <div class="data-container">
                                            <p>
                                                @if(isset($package_name)) <span><i class="fas fa-box"></i> {{$package_name}}</span> @endif
                                                @if(isset($device_model)) <span><i class="fas fa-mobile-alt"></i> {{$device_model}}</span> @endif
                                                @if(isset($app_version)) <span><i class="fas fa-cube"></i> v{{$app_version}}</span> @endif
                                                @if(isset($os_version)) <span><i class="fab fa-android"></i> {{$os_version}}</span> @endif
                                            </p>
                                        </div>
                                    </div>
                                </header>

                                <div class="chat-box "></div>

                                <form action="#" class="typing-area">
                                    <input type="hidden" class="incoming_id" name="incoming_id" value="@if(isset($user_id)) {{$user_id}} @endif">
                                    
                                    <textarea 
                                        name="message" 
                                        class="input-field" 
                                        placeholder="Type your message..." 
                                        autocomplete="off"
                                        rows="1"
                                    ></textarea>
                                    
                                    <button type="submit">
                                        <i class="fab fa-telegram-plane"></i>
                                    </button>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{asset('assests/javascript/users.js')}}"></script>
<script src="{{asset('assests/javascript/chat.js')}}"></script>
</main>
</body>
</html>