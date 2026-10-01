<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Full Screen Chat Application</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
        
        /* Base Styles */
        :root {
          --primary-color: #4285f4;
          --primary-dark: #357ae8;
          --secondary-color: #34a853;
          --danger-color: #ea4335;
          --light-color: #f8f9fa;
          --dark-color: #202124;
          --gray-color: #5f6368;
          --light-gray: #e8eaed;
          --white: #ffffff;
          --chat-bg: #f0f2f5;
          --outgoing-bg: #d9fdd3;
          --incoming-bg: #ffffff;
          --border-radius: 8px;
          --box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        
        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
          font-family: 'Roboto', 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        
        html, body {
          height: 100%;
          background-color: var(--light-color);
        }
        
        /* Chat Container */
        .chat-container {
          display: flex;
          flex-direction: column;
          height: 100vh;
          max-width: 100%;
          background-color: var(--white);
          margin: 0 auto;
          overflow: hidden;
        }
        
        /* Header Styles */
        .head-text {
          background-color: var(--primary-color);
          color: var(--white);
          padding: 16px 24px;
          font-size: 18px;
          font-weight: 500;
          display: flex;
          justify-content: space-between;
          align-items: center;
          box-shadow: 0 1px 3px rgba(0,0,0,0.1);
          z-index: 10;
        }
        
        .head-text .logout {
          color: var(--white);
          text-decoration: none;
          transition: opacity 0.2s;
        }
        
        .head-text .logout:hover {
          opacity: 0.9;
        }
        
        /* Initial Form Styles */
        .wrapper {
          display: flex;
          flex-direction: column;
          height: 100%;
          padding: 20px;
          background-color: var(--white);
        }
        
        .chat-box-1 {
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
          flex-grow: 1;
          max-width: 500px;
          width: 100%;
          margin: 0 auto;
          padding: 20px;
        }
        
        .desc-text {
          color: var(--gray-color);
          text-align: center;
          line-height: 1.6;
          font-size: 16px;
          font-weight: 400;
          margin-bottom: 32px;
        }
        
        .form_to_submit {
          width: 100%;
        }
        
        .error-text {
          color: var(--danger-color);
          padding: 12px;
          text-align: center;
          border-radius: var(--border-radius);
          background-color: rgba(234, 67, 53, 0.1);
          margin-bottom: 20px;
          font-size: 14px;
          display: none;
        }
        
        .field {
          margin-bottom: 16px;
        }
        
        .field input {
          width: 100%;
          padding: 14px 20px;
          border: 1px solid var(--light-gray);
          border-radius: 24px;
          font-size: 15px;
          outline: none;
          transition: all 0.3s ease;
          background-color: var(--light-color);
        }
        
        .field input:focus {
          border-color: var(--primary-color);
          box-shadow: 0 0 0 2px rgba(66, 133, 244, 0.2);
        }
        
        .field input::placeholder {
          color: #9aa0a6;
        }
        
        .field button {
          width: 100%;
          padding: 14px;
          background-color: var(--primary-color);
          color: var(--white);
          border: none;
          border-radius: 24px;
          font-size: 16px;
          font-weight: 500;
          cursor: pointer;
          transition: all 0.3s ease;
        }
        
        .field button:hover {
          background-color: #4285f4;
        }
        
        .field button:active {
          transform: scale(0.98);
        }
        
        /* Chat Area Styles */
        .chat-area {
          display: none;
          flex-direction: column;
          height: 100%;
        }
        
        .chat-box {
          flex-grow: 1;
          overflow-y: auto;
          padding: 16px;
          background-color: var(--chat-bg);
          background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBmaWxsPSJub25lIiBzdHJva2U9IiNlZGVkZWQiIHN0cm9rZS13aWR0aD0iMSI+CiAgPHBhdGggZD0iTTAgMEg0MFY0MEgweiIvPgogIDxwYXRoIGQ9Ik0yMCAxMEwxMCAyMEwyMCAzMEwzMCAyMHoiLz4KPC9zdmc+');
          background-size: 40px 40px;
        }
        
        .chat-box .text {
          text-align: center;
          color: var(--gray-color);
          margin-top: 40%;
          font-size: 15px;
          padding: 0 20px;
        }
        
        /* Message Styles */
        .chat {
          margin-bottom: 16px;
          display: flex;
          flex-direction: column;
        }
        
        .chat p {
          padding: 12px 16px;
          border-radius: var(--border-radius);
          max-width: 80%;
          word-wrap: break-word;
          line-height: 1.5;
          font-size: 15px;
          box-shadow: var(--box-shadow);
          position: relative;
        }
        
        .outgoing {
          align-items: flex-end;
        }
        
        .outgoing p {
          background-color: var(--outgoing-bg);
          color: var(--dark-color);
          border-radius: 18px 18px 0 18px;
          margin-left: auto;
        }
        
        .incoming {
          align-items: flex-start;
        }
        
        .incoming img {
          width: 32px;
          height: 32px;
          border-radius: 50%;
          margin-right: 12px;
          object-fit: cover;
          align-self: flex-start;
        }
        
        .incoming .details {
          display: flex;
          flex-direction: column;
        }
        
        /*.outgoing .details {*/
        /*  min-width: 100px;*/
        /*  max-width:350px !important;*/
        /*  height: 32px;*/
        /*  display: flex;*/
        /*  flex-direction: column;*/
        /*}*/
        .incoming p {
          background-color: var(--incoming-bg);
          color: var(--dark-color);
          border-radius: 18px 18px 18px 0;
        }
        
        .message-info {
          font-size: 11px;
          color: var(--gray-color);
          margin-top: 4px;
          display: flex;
          align-items: center;
        }
        
        .message-info .time {
          margin-left: 6px;
        }
        
        /* Typing Area Styles */
        .typing-area {
          display: flex;
          padding: 12px 16px;
          background-color: var(--white);
          border-top: 1px solid var(--light-gray);
          align-items: center;
        }
        
        .typing-area input {
          flex-grow: 1;
          padding: 12px 16px;
          border: 1px solid var(--light-gray);
          border-radius: 24px 0 0 24px;
          font-size: 15px;
          outline: none;
          background-color: var(--light-color);
          transition: all 0.3s ease;
        }
        
        .typing-area input:focus {
          border-color: var(--primary-color);
          box-shadow: 0 0 0 2px rgba(66, 133, 244, 0.2);
        }
        
        .typing-area button {
          width: 50px;
          height: 46px;
          background-color: var(--primary-color);
          color: var(--white);
          border: none;
          border-radius: 0 24px 24px 0;
          cursor: pointer;
          transition: all 0.3s ease;
          display: flex;
          align-items: center;
          justify-content: center;
        }
        
        .typing-area button:hover {
          background-color: #4285f4;
        }
        
        .typing-area button:disabled {
          background-color: var(--light-gray);
          cursor: not-allowed;
        }
        
        /* Spinner Styles */
        .spinner {
          display: none;
          text-align: center;
          padding: 16px;
        }
        
        .spinner i {
          color: var(--primary-color);
          font-size: 20px;
          animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }
        
        /* Timestamp Styles */
        .timestamp {
          font-size: 11px;
          color: var(--gray-color);
          margin-top: 4px;
          text-align: right;
        }
        
        /* Responsive Styles */
        @media (max-width: 768px) {
          .head-text {
            padding: 14px 16px;
            font-size: 16px;
          }
          
          .chat-box {
            padding: 12px;
          }
          
          .chat p {
            max-width: 85%;
            font-size: 14px;
            padding: 10px 14px;
          }
          
          .typing-area {
            padding: 10px 12px;
          }
          
          .typing-area input {
            padding: 10px 14px;
          }
          
          .typing-area button {
            width: 45px;
            height: 42px;
          }
        }
        
        @media (max-width: 480px) {
          .head-text {
            padding: 12px 14px;
            font-size: 15px;
          }
          
          .chat-box-1 {
            padding: 16px;
          }
          
          .desc-text {
            font-size: 15px;
            margin-bottom: 24px;
          }
          
          .field input {
            padding: 12px 16px;
            font-size: 14px;
          }
          
          .field button {
            padding: 12px;
            font-size: 15px;
          }
          
          .chat p {
            max-width: 90%;
          }
          
          .incoming img {
            width: 28px;
            height: 28px;
          }
        }
        
        /* Animation for new messages */
        @keyframes fadeIn {
          from { opacity: 0; transform: translateY(10px); }
          to { opacity: 1; transform: translateY(0); }
        }
        
        .chat {
          animation: fadeIn 0.3s ease-out;
        }
        
        /* Custom scrollbar */
        .chat-box::-webkit-scrollbar {
          width: 6px;
        }
        
        .chat-box::-webkit-scrollbar-track {
          background: rgba(0,0,0,0.05);
        }
        
        .chat-box::-webkit-scrollbar-thumb {
          background: rgba(0,0,0,0.1);
          border-radius: 3px;
        }
        
        .chat-box::-webkit-scrollbar-thumb:hover {
          background: rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="wrapper" id="message_id_check">
            <div class="head-text">
                Let's chat? - Online
            </div>
            <div class="chat-box-1">
                <div class="desc-text login">
                    Please fill out the form below to start chatting with the next available agent.
                </div>
                <form action="#" class="form_to_submit">
                    <div class="error-text"></div>
                    
                    @php
                        // List of expected parameters
                        $params = ['app_id', 'package_name', 'device_model', 'language', 'country_code', 'app_version', 'os_version', 'theme_mode'];
                    @endphp
                
                    @foreach ($params as $param)
                        <div class="form-group">
                            <input
                                type="hidden"
                                name="{{ $param }}"
                                id="{{ $param }}"
                                class="form-control"
                                value="{{ request()->has($param) ? request()->get($param) : '' }}"
                            >
                        </div>
                    @endforeach
                    
                    <div class="field">
                        <input type="text" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="field">
                        <input type="email" name="email" placeholder="Email Address">
                    </div>
                    <div class="field button">
                        <button type="submit" class="button_to_submit">Start Chatting</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="chat-area">
            <div class="head-text">
                Let's chat? - Online 
                <a href="{{url('/forget-session')}}" class="logout">End Chat</a>
            </div>
            <div class="chat-box">
                <div class="text">
                    No messages yet. Start the conversation!
                </div>
                <div class="spinner">
                    <i class="fas fa-spinner"></i>
                </div>
                <!-- Messages will be inserted here -->
            </div>
            <form action="#" class="typing-area">
                <input type="text" class="incoming_id" name="incoming_id" value="1171991996" hidden>
                <input type="text" name="message" class="input-field" placeholder="Type your message here..." autocomplete="off">
                <button type="submit" disabled><i class="fab fa-telegram-plane"></i></button>
            </form>
            <input type="hidden" name="session_unique_id" id="session_unique_id" value="{{session()->get('unique_id') ?? 1}}">
        </div>
    </div>

    <script>
        // DOM Elements
        const form = document.querySelector(".form_to_submit");
        const errorText = document.querySelector(".error-text");
        const wrapper = document.querySelector(".wrapper");
        const chatArea = document.querySelector(".chat-area");
        const chatBox = document.querySelector(".chat-box");
        const spinner = document.querySelector(".spinner");
        const typingForm = document.querySelector(".typing-area");
        const inputField = typingForm.querySelector(".input-field");
        const sendBtn = typingForm.querySelector("button");
        const incoming_id = typingForm.querySelector(".incoming_id").value;
        const sessionIdInput = document.getElementById("session_unique_id");
        let messageInterval;
        
        // Initialize chat
        initChat();
        
        function initChat() {
            // Form submission for starting chat
            form.onsubmit = (e) => {
                e.preventDefault();
                submitForm();
            };
        
            // Typing area functionality
            inputField.oninput = () => {
                sendBtn.disabled = inputField.value.trim() === "";
            };
        
            typingForm.onsubmit = (e) => {
                e.preventDefault();
                sendMessage();
            };
        
            // Check for existing session on page load
            const sessionId = sessionIdInput.value;
            if(sessionId > 1) {
                startChatSession();
            }
        }
        
        function submitForm() {
            showSpinner();
            errorText.style.display = "none";
            
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/signup1", true);
            xhr.onload = () => {
                hideSpinner();
                
                if(xhr.readyState === XMLHttpRequest.DONE) {
                    if(xhr.status === 200) {
                        const data = xhr.response;
                        
                        if(data && data !== "error") {
                            sessionIdInput.value = data;
                            startChatSession();
                        } else {
                            showError(data || "An error occurred. Please try again.");
                        }
                    } else {
                        showError("Server error. Please try again later.");
                    }
                }
            };
            
            xhr.onerror = () => {
                hideSpinner();
                showError("Network error. Please check your connection.");
            };
            
            const formData = new FormData(form);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            xhr.send(formData);
        }
        
        function startChatSession() {
            wrapper.style.display = "none";
            chatArea.style.display = "flex";
            
            // Initial fetch and start interval
            fetchMessages();
            messageInterval = setInterval(fetchMessages, 5000);
        }
        
        function sendMessage() {
            const message = inputField.value.trim();
            if(message === "") return;
            
            sendBtn.disabled = true;
            showSpinner();
            
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/insert-chats", true);
            xhr.onload = () => {
                hideSpinner();
                sendBtn.disabled = false;
                
                if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    inputField.value = "";
                    fetchMessages(); // Update messages immediately after sending
                }
            };
            
            const formData = new FormData(typingForm);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            xhr.send(formData);
        }
        
        function fetchMessages() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/gets-chat", true);
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    const data = xhr.response;
                    updateChatBox(data);
                }
            };
            
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("incoming_id=" + incoming_id);
        }
        
        function updateChatBox(data) {
            if(!data || typeof data !== "string") return;
            
            const noMessagesText = chatBox.querySelector(".text");
            const hasMessages = data.trim() !== "" && data !== "[]";
            
            if(hasMessages) {
                // Hide "no messages" text if it exists
                if(noMessagesText) {
                    noMessagesText.style.display = "none";
                }
                
                // Only update if we have new content
                if(chatBox.innerHTML !== data) {
                    chatBox.innerHTML = data;
                    scrollToBottom();
                }
            } else if(!chatBox.querySelector('.chat')) {
                // Show "no messages" text if there are no messages
                if(noMessagesText) {
                    noMessagesText.style.display = "block";
                }
            }
        }
        
        function scrollToBottom() {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
        
        function showSpinner() {
            spinner.style.display = "block";
        }
        
        function hideSpinner() {
            spinner.style.display = "none";
        }
        
        function showError(message) {
            errorText.textContent = message;
            errorText.style.display = "block";
        }
        
        // Clean up interval when leaving the page
        window.addEventListener('beforeunload', () => {
            if(messageInterval) {
                clearInterval(messageInterval);
            }
        });
    </script>
</body>
</html>