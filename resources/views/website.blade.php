<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Responsive Chat Box Design | CodingNepal</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body{
            overflow: hidden;
            background: #f2f2f2;
        }
        #click{
            display: none;
        }
        label{
            position: absolute;
            right: 30px;
            bottom: 20px;
            height: 55px;
            width: 55px;
            background: -webkit-linear-gradient(left, #a445b2, #fa4299);
            text-align: center;
            line-height: 55px;
            border-radius: 50px;
            font-size: 30px;
            color: #fff;
            cursor: pointer;
        }
        label i{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.4s ease;
        }
        label i.fas{
            opacity: 0;
            pointer-events: none;
        }
        #click:checked ~ label i.fas{
            opacity: 1;
            pointer-events: auto;
            transform: translate(-50%, -50%) rotate(180deg);
        }
        #click:checked ~ label i.fab{
            opacity: 0;
            pointer-events: none;
            transform: translate(-50%, -50%) rotate(180deg);
        }
        .wrapper{
            position: absolute;
            right: 30px;
            bottom: 0px;
            max-width: 400px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0px 15px 20px rgba(0,0,0,0.1);
            opacity: 0;
            pointer-events: none;
            transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
        }
        #click:checked ~ .wrapper{
            opacity: 1;
            bottom: 85px;
            pointer-events: auto;
        }
        .wrapper .head-text{
            line-height: 60px;
            color: #fff;
            border-radius: 15px 15px 0 0;
            padding: 0 20px;
            font-weight: 500;
            font-size: 20px;
            background: -webkit-linear-gradient(left, #a445b2, #fa4299);
        }
        .head-text{
            line-height: 60px;
            color: #fff;
            border-radius: 15px 15px 0 0;
            padding: 0 20px;
            font-weight: 500;
            font-size: 20px;
            background: -webkit-linear-gradient(left, #a445b2, #fa4299);
        }
        .wrapper .chat-box-1{
            padding: 20px;
            width: 100%;
        }
        .chat-box-1 .desc-text{
            color: #515365;
            text-align: center;
            line-height: 25px;
            font-size: 17px;
            font-weight: 500;
        }
        .chat-box-1 form{
            padding: 10px 15px;
            margin: 20px 0;
            border-radius: 25px;
            border: 1px solid lightgrey;
        }
        .chat-box-1 form .field{
            height: 50px;
            width: 100%;
            margin-top: 20px;
        }
        .chat-box-1 form .field:last-child{
            margin-bottom: 15px;
        }
        form .field input,
            form .field button,
                form .textarea textarea{
                    width: 100%;
                    height: 100%;
                    padding-left: 20px;
                    border: 1px solid lightgrey;
                    outline: none;
                    border-radius: 25px;
                    font-size: 16px;
                    transition: all 0.3s ease;
        }
        form .field input:focus,
            form .textarea textarea:focus{
                border-color: #fc83bb;
        }
        form .field input::placeholder,
            form .textarea textarea::placeholder{
                color: silver;
                transition: all 0.3s ease;
        }
        form .field input:focus::placeholder,
            form .textarea textarea:focus::placeholder{
                color: lightgrey;
        }
        .chat-box-1 form .textarea{
            height: 70px;
            width: 100%;
        }
        .chat-box-1 form .textarea textarea{
            height: 100%;
            border-radius: 50px;
            resize: none;
            padding: 15px 20px;
            font-size: 16px;
        }
        .chat-box-1 form .field button{
            border: none;
            outline: none;
            cursor: pointer;
            color: #fff;
            font-size: 18px;
            font-weight: 500;
            background: -webkit-linear-gradient(left, #a445b2, #fa4299);
            transition: all 0.3s ease;
        }
        .chat-box-1 form .field button:active{
            transform: scale(0.97);
        }
        .error-text{
            color: #721c24;
            padding: 8px 10px;
            text-align: center;
            border-radius: 5px;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            margin-bottom: 10px;
            display: none;
        }
        .desc-text{
            color: #515365;
            text-align: center;
            line-height: 25px;
            font-size: 17px;
            font-weight: 500;
        }
        
        /* Chat Area CSS Start */
        .chat-area header{
            display: flex;
            align-items: center;
            padding: 18px 30px;
        }
        .chat-area header .back-icon{
            color: #333;
            font-size: 18px;
        }
        .chat-area header img{
            height: 45px;
            width: 45px;
            margin: 0 15px;
        }
        .chat-area header .details span{
            font-size: 17px;
            font-weight: 500;
        }
        .chat-box{
            position: relative;
            min-height: 250px;
            max-height: 400px;
            overflow-y: auto;
            padding: 10px 30px 20px 30px;
            background: #f7f7f7;
            box-shadow: inset 0 32px 32px -32px rgb(0 0 0 / 5%),
                    inset 0 -32px 32px -32px rgb(0 0 0 / 5%);
        }
        .chat-box .text{
            position: absolute;
            top: 45%;
            left: 50%;
            width: calc(100% - 50px);
            text-align: center;
            transform: translate(-50%, -50%);
        }
        .chat-box .chat{
        margin: 15px 0;
        }
        .chat-box .chat p{
        word-wrap: break-word;
        padding: 8px 16px;
        box-shadow: 0 0 32px rgb(0 0 0 / 8%),
                    0rem 16px 16px -16px rgb(0 0 0 / 10%);
        }
        .chat-box .outgoing{
        display: flex;
        }
        .chat-box .outgoing .details{
        margin-left: auto;
        max-width: calc(100% - 130px);
        }
        .outgoing .details p{
        background: #333;
        color: #fff;
        border-radius: 18px 18px 0 18px;
        }
        .chat-box .incoming{
        display: flex;
        align-items: flex-end;
        }
        .chat-box .incoming img{
            height: 35px;
            width: 35px;
        }
        .chat-box .incoming .details{
        margin-right: auto;
        margin-left: 10px;
        max-width: calc(100% - 130px);
        }
        .incoming .details p{
        background: #fff;
        color: #333;
        border-radius: 18px 18px 18px 0;
        }
        .typing-area{
        padding: 18px 30px;
        display: flex;
        justify-content: space-between;
        }
        .typing-area input{
        height: 45px;
        width: calc(100% - 58px);
        font-size: 16px;
        padding: 0 13px;
        border: 1px solid #e6e6e6;
        outline: none;
        border-radius: 5px 0 0 5px;
        }
        .typing-area button{
        color: #fff;
        width: 55px;
        border: none;
        outline: none;
        background: #333;
        font-size: 19px;
        cursor: pointer;
        opacity: 0.7;
        pointer-events: none;
        border-radius: 0 5px 5px 0;
        transition: all 0.3s ease;
        }
        .typing-area button.active{
        opacity: 1;
        pointer-events: auto;
        }
      </style>
   </head>
    <body>
        <input type="checkbox" id="click">
        <label for="click">
        <i class="fab fa-facebook-messenger"></i>
        <i class="fas fa-times"></i>
        </label>
        <div class="wrapper" id="message_id_check" style="display:block;">
            <div class="head-text">
                Let's chat? - Online
            </div>
            <div class="chat-box-1">
                <div class="desc-text login">
                    Please fill out the form below to start chatting with the next available agent.
                </div>
                <form action="#" class="form_to_submit">
                    <div class="error-text"></div>
                <div class="field">
                    <input type="text" name="name" placeholder="Your Name" >
                </div>
                <div class="field">
                    <input type="email" name="email" placeholder="Email Address" >
                </div>
                <div class="field textarea">
                    <textarea cols="30" rows="10" name="text_msg" placeholder="Explain your queries.." ></textarea>
                </div>
                    <div class="field button">
                        <input type="submit" name="submit" class="button_to_submit" value="Continue to Chat">
                    </div>
                </form>
            </div>
        </div>
        <div class="wrapper cc" style="display:none;">
            <section class="chat-area">
                    <div class="head-text">
                        Let's chat? - Online <a align="right"  href="{{url('/forget-session')}}" class="logout">Leave</a>
                    </div>
                    <div class="desc-text login">
                        start chatting with the available agent.
                    </div>
                <div class="chat-box" style="height:100px !important;">
                    <?php
                        $user_id = 1171991996;
                    ?>
                </div>
                <form action="#" class="typing-area">
                    <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
                    <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
                    <button><i class="fab fa-telegram-plane"></i></button>
                </form>
                <input type="hidden" name="session_unique_id" id="session_unique_id" value="1">
            </section>
        </div>
    </body>
    <script>
            const form = document.querySelector(".form_to_submit"),
            continueBtn = document.querySelector(".button_to_submit"),
            errorText = document.querySelector(".error-text");
            show = document.querySelector(".cc");
            message_id_check = document.getElementById('message_id_check');

            form.onsubmit = (e)=>{
                e.preventDefault();
            }

            continueBtn.onclick = ()=>{
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "/signup1", true);
                xhr.onload = ()=>{
                    if(xhr.readyState === XMLHttpRequest.DONE){
                        if(xhr.status === 200){
                            let data = xhr.response;
                            if(data){
                                show.style.display = "block";
                                message_id_check.style.display = "none";
                                document.getElementById('session_unique_id').value = data;
                                name_cjheck(data);
                            }else{
                                errorText.style.display = "block";
                                errorText.textContent = data;
                            }
                        }
                    }
                }
                let formData = new FormData(form);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                xhr.send(formData);
            }

            //get messages

            const form_1 = document.querySelector(".typing-area"),
            incoming_id = form_1.querySelector(".incoming_id").value,
            inputField = form_1.querySelector(".input-field"),
            sendBtn = form_1.querySelector("button"),
            chatBox = document.querySelector(".chat-box");

            form_1.onsubmit = (e)=>{
                e.preventDefault();
            }

            inputField.focus();
            inputField.onkeyup = ()=>{
                if(inputField.value != ""){
                    sendBtn.classList.add("active");
                }else{
                    sendBtn.classList.remove("active");
                }
            }

            sendBtn.onclick = ()=>{
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "/insert-chats", true);
                xhr.onload = ()=>{
                    if(xhr.readyState === XMLHttpRequest.DONE){
                        if(xhr.status === 200){
                            inputField.value = "";
                            scrollToBottom();
                        }
                    }
                }
                let formData = new FormData(form_1);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                xhr.send(formData);
            }
            
            chatBox.onmouseenter = ()=>{
                chatBox.classList.add("active");
            }

            chatBox.onmouseleave = ()=>{
                chatBox.classList.remove("active");
            }

            function name_cjheck(data)
            {
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "/gets-chat", true);
                xhr.onload = ()=>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        chatBox.innerHTML = data;
                        if(!chatBox.classList.contains("active")){
                            scrollToBottom();
                        }
                    }
                }
                }
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("incoming_id="+incoming_id);
            }
              
            setInterval(() =>{
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "/gets-chat", true);
                xhr.onload = ()=>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        chatBox.innerHTML = data;
                        if(!chatBox.classList.contains("active")){
                            scrollToBottom();
                        }
                    }
                }
                }
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("incoming_id="+incoming_id);
            }, 20000);

            function scrollToBottom(){
                chatBox.scrollTop = chatBox.scrollHeight;
            }
  
    </script>
</html>
