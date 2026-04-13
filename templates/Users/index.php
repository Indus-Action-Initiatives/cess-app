<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
        <title>BOCW - Labour Cess Portal | Login</title>
        <?php echo $this->Html->meta('icon'); ?>
        <?php echo $this->Html->css(['plugins/fontawesome-free/css/all.min.css', 'plugins/icheck-bootstrap/icheck-bootstrap.min.css', 'adminlte.min.css']); ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            .login-page { background-color: #E0E1E2; }
            .header-wrapper {
                border-bottom: 1px solid #d0d0d0;
                background: #fff;
                width: 100%;
            }
            .navbar-brand img, .header-right img {
                max-width: 100%;
                height: auto;
                vertical-align: middle;
            }
            .logo {
                background: url(../img/emblem-dark.png) no-repeat 3px 0;
                float: left;
                font-size: 160%;
                line-height: 105%;
                min-height: 103px;
                padding: 14px 0 0 78px;
                text-transform: uppercase;
            }
            .logo a {
                display: block;
                color: #000;
                text-align: left;
            }
            .logo a strong {
                font-weight: 600;
                display: block;
                font-size: 80%;
            }
            .logo a span {
                display: block;
                font-weight: 900;
                font-size: 110%;
            }
            .header-container {
                padding: 8px 0px 6px;
            }
            .shadow-lg {
                box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.3) !important;
            }
            footer {
                background: #ce7328;
                color: #fff;
                padding: 15px 0;
                text-align: center;
                font-size: 16px;
                bottom: 0;
                width: 100%;
                border-top: 2px solid #ffffff;
            }
            footer a {
                color: #2743a3;
                text-decoration: none;
                font-weight: bold;
            }
            footer a:hover {
                text-decoration: underline;
            }
            .chatbot-btn {
                position: fixed;
                bottom: 125px;
                right: 25px;
                background: #007bff;
                color: #fff;
                border-radius: 50%;
                width: 60px;
                height: 60px;
                display: flex;
                justify-content: center;
                align-items: center;
                cursor: pointer;
                box-shadow: 0 4px 8px rgba(0,0,0,0.3);
                font-size: 28px;
                z-index: 999;
            }
            .chatbot-btn:hover {
                background: #0056b3;
            }
            .chatbot-popup {
                position: fixed;
                bottom: 125px;
                right: 25px;
                width: 350px;
                max-height: 500px;
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 0 15px rgba(0,0,0,0.2);
                display: none;
                flex-direction: column;
                overflow: hidden;
                z-index: 1000;
            }
            .chat-header {
                background: #007bff;
                color: #fff;
                padding: 10px;
                font-weight: bold;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .chat-header span {
                cursor: pointer;
                font-size: 20px;
            }
            .chat-body {
                flex: 1;
                overflow-y: auto;
                padding: 10px;
            }
            .message {
                margin-bottom: 10px;
                clear: both;
            }
            .bot-msg {
                background: #e9ecef;
                padding: 8px 12px;
                border-radius: 15px;
                display: inline-block;
                max-width: 80%;
            }
            .user-msg {
                background: #007bff;
                color: #fff;
                padding: 8px 12px;
                border-radius: 15px;
                display: inline-block;
                max-width: 80%;
                float: right;
            }
            .chat-footer {
                border-top: 1px solid #ddd;
                padding: 8px;
                display: flex;
            }
            .chat-footer input {
                flex: 1;
                border: none;
                padding: 8px;
                border-radius: 20px;
                background: #f1f1f1;
                outline: none;
            }
            .chat-footer button {
                background: #007bff;
                border: none;
                color: white;
                border-radius: 50%;
                width: 38px;
                height: 38px;
                margin-left: 8px;
            }
            header.header-wrapper .mid-side {
                padding: 5px 50px;
            }
            .top-nav {
                background-color: #ef8b3e;
                padding: 5px;
                width: 100%;
                color: #ffffff;
            }
            .chakra .chakra-img {
                position: absolute;
                top: 27%;
                left: 20%;
                z-index: 0;
                max-height: 650px;
                animation: spin 30s linear infinite;
                will-change: transform;
            }
            @keyframes spin {
                100% {
                    transform: rotate(1turn) translateZ(0);
                    -webkit-transform: rotate(1turn) translateZ(0);
                }
            }
            body { margin: 0; padding: 0; }
            h2, p { margin: 10px; }
            ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                background-color: #56321a;
                display: flex;
            }
            ul li a {
                display: block;
                color: white;
                padding: 8px 15px;
                text-decoration: none;
            }
            ul li a:hover:not(.active) {
                color: #fff;
                background-color: #e58433;
            }
            ul li a.active {
                color: #fff;
                background-color: #e88633;
            }
        </style>
    </head>
    <body class="hold-transition login-page">
        <section class="top-nav d-flex">
            <div class="col">
                <span>Ministry of Labour & Employment | Government of India</span>
            </div>
            <div class="col text-right">
                <span><i class="fa-brands fa-facebook"></i></span>
                <span><i class="fa-brands fa-instagram"></i></span>
                <span><i class="fa-brands fa-x-twitter"></i></span>
                <span><i class="fa-brands fa-linkedin"></i></span>
            </div>
        </section>
        <header class="header-wrapper">
            <div class="mid-side">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-5 site-logo p-0">
                            <div class="d-flex">
                                <img src="img/emblem-dark.png" alt="National Emblem" class="emblem mr-3">
                                <div class="govt-text">
                                    <p class="hindi mb-0">श्रम एवं रोजगार मंत्रालय</p>
                                    <p class="english mb-0">GOVERNMENT OF INDIA</p>
                                    <h5 class="ministry mb-0">MINISTRY OF LABOUR &amp; EMPLOYMENT</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-7 top-logo text-center p-0">
                            <div class="text-center p-3">
                                <p>[State Logo]</p>
                                <h6 class="text-muted mb-0" style="color: #d66a6aff;">Department of Labour, Government Of [State Name]</h6>
                                <h5 class="font-weight-bold" style="color: #d66a6aff;">Building and Other Construction Workers Welfare Board</h5>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 top-logo p-0" style="float: right; text-align: right;">
                            <a href="https://amritmahotsav.nic.in/" target="_blank" class="mx-2">
                                <img src="img/azadi_0.jpg" alt="Azadi Ka Amrit Mahotsav" class="header-logo">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <ul>
                <li><a class="active" href="<?= webURL ?? '#' ?>">Home</a></li>
                <li><a href="<?= (webURL ?? '#').'page/about-us' ?>">About Us</a></li>
                <li><a href="<?= (webURL ?? '#').'page/faqs' ?>">FAQs</a></li>
                <li><a href="<?= (webURL ?? '#').'page/contact-us' ?>">Contact Us</a></li>
                <li><a href="<?= (webURL ?? '#').'helpdesk/add' ?>">Help</a></li>
                <li><a href="<?= (webURL ?? '#').'helpdesk/track' ?>">Track Ticket</a></li>
            </ul>
        </header>

        <div style="background: url('<?= $this->Url->image("india-gate-mornings.jpg"); ?>') no-repeat center center / cover; width: 100%; height: 100vh; margin: 0; padding-top: 40px;">
            <div class="container mt-12">
                <div class="row justify-content-center">
                    <div class="chakra"><img class="chakra-img" alt="" src="img/chakra.svg"></div>
                    <div class="col-md-7 mt-5">
                        <div class="card shadow-lg" style="color: #d66a6aff; background-color: #ffffffd6; border-radius: 25px;">
                            <div class="card-body p-5">
                                <?= $this->Flash->render() ?>
                                <h3 class="font-weight-bold mb-3" id="form-title">LOGIN</h3>
                                <p class="text-muted" style="margin-top:-10px;" id="form-subtitle">For availing various government services</p>
                                
                                <?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'index'], 'id' => 'main-login-form']) ?>
                                
                                <div id="login-step-1">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                            </div>
                                            <?= $this->Form->input('email', ['type'=>'text','required'=>true,'autocomplete'=>'off','class'=>'form-control','placeholder'=>'Username']) ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <?= $this->Form->input('password', ['type'=>'password','required'=>true,'autocomplete'=>'off','class'=>'form-control','placeholder'=>'Password']) ?>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div style="display: flex; align-items: center;">
                                            <img src="<?= $this->Url->build(['controller' => 'Users', 'action' => 'captcha', '?' => ['t' => time()]]) ?>" alt="CAPTCHA" />
                                            <?= $this->Form->control('captcha_answer', ['label'=>false,'placeholder'=>'Enter CAPTCHA','style'=>'flex: 1; height: 50px; border: none; margin-left: 50px; padding: 10px', 'required' => true]) ?>
                                        </div>
                                    </div>
                                    <a href="#" class="text-danger small d-block mb-3">Forgot Password?</a>
                                    
                                    <button type="button" id="init-login-btn" class="btn btn-warning btn-block py-2">LOGIN <i class="fa fa-sign-in-alt ml-2"></i></button>
                                </div>

                                <div id="login-step-2" style="display: none;">
                                    <div class="alert alert-info" id="otp-message">An OTP has been sent to your device.</div>
                                    <div class="form-group">
                                        <label>Enter OTP Code</label>
                                        <input type="text" id="user-otp-input" class="form-control text-center" placeholder=" " maxlength="6" style="font-size: 1.5rem; letter-spacing: 5px;">
                                    </div>
                                    <button type="button" id="verify-otp-btn" class="btn btn-success btn-block py-2">Verify & Submit</button>
                                    <a href="#" onclick="cancelOtp()" class="btn btn-link btn-block text-muted">Go Back</a>
                                </div>

                                <?= $this->Form->end() ?>
                                
                                <div class="text-center mt-4">
                                    <span class="text-muted">Don't have an account?</span>
                                    <a href="<?php echo webURL ?? '#';?>register/register" class="text-danger font-weight-bold">Create an account</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <div class="container">
                <p class="mb-1">© <?= date('Y') ?> Department of Labour, Government of [State Name]. All Rights Reserved.</p>
                <p class="mb-0">Designed & Developed by <a href="#">Ministry of Labour & Employment</a></p>
            </div>
        </footer>

        <div class="chatbot-btn" id="chatbotToggle">💬</div>
        <div class="chatbot-popup" id="chatbotPopup">
            <div class="chat-header">🤖 Chatbot <span id="closeChat">&times;</span></div>
            <div class="chat-body" id="chatBody">
                <div class="message bot-msg">Hello! How can I help you today?</div>
            </div>
            <div class="chat-footer">
                <input type="text" id="userInput" placeholder="Type a message...">
                <button id="sendBtn">➤</button>
            </div>
        </div>

        <?php echo $this->Html->script(['plugins/jquery/jquery.min.js','plugins/bootstrap/js/bootstrap.bundle.min.js','adminlte.min.js']); ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/crypto-js.min.js"></script>
        
        <script>
            // CakePHP CSRF Token mapping
            const csrfToken = '<?= $this->request->getAttribute("csrfToken") ?>';
            
            // UPDATED: Point to the new consolidated endpoints
            const sendOtpUrl = '<?= $this->Url->build(["controller" => "Users", "action" => "sendOtp"]) ?>';
            const verifyOtpUrl = '<?= $this->Url->build(["controller" => "Users", "action" => "verifyOtp"]) ?>';

            // Existing Encryption function
            function encryptPassword() {
                var password = document.querySelector('input[name="password"]');
                var originalPassword = password.value;
                var secretKeyHex  = '<?= h($secret_key) ?>';
                var secretKey = CryptoJS.enc.Hex.parse(secretKeyHex);
                var iv = CryptoJS.lib.WordArray.random(16);
                var encrypted  = CryptoJS.AES.encrypt(originalPassword, secretKey, {
                    iv: iv,
                    mode: CryptoJS.mode.CBC,
                    padding: CryptoJS.pad.Pkcs7
                });
                var ivBase64 = CryptoJS.enc.Base64.stringify(iv);
                var encryptedBase64 = encrypted.ciphertext.toString(CryptoJS.enc.Base64);
                var combined = ivBase64.concat(encryptedBase64);
                password.value = combined;
            }

            // OTP Phase 1: Request OTP
            $('#init-login-btn').click(async function() {
                // Basic HTML5 validation check
                const form = document.getElementById('main-login-form');
                if(!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                // Change button state
                const btn = $(this);
                const originalText = btn.html();
                btn.html('Sending OTP... <i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);

                // Extract the email value from the form
                const userEmail = document.querySelector('input[name="email"]').value;

                try {
                    // UPDATED: Use sendOtpUrl
                    const response = await fetch(sendOtpUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-CSRF-Token': csrfToken,
                            'Accept': 'application/json'
                        },
                        // UPDATED: Send 'target' instead of 'email', and specify the 'context'
                        body: new URLSearchParams({ 'target': userEmail, 'context': 'login' }) 
                    });
                    
                    const data = await response.json();
                    
                    if (data.status === 'success') {
                        // Hide login fields, show OTP fields
                        $('#login-step-1').slideUp();
                        $('#login-step-2').slideDown();
                        $('#form-title').text('Verify Identity');
                        $('#form-subtitle').text('Please enter the OTP sent to your device');
                        $('#otp-message').text(data.message);
                    } else {
                        alert(data.message || "Failed to send OTP.");
                    }
                } catch (error) {
                    alert('Error connecting to server.');
                    console.error(error);
                } finally {
                    btn.html(originalText).prop('disabled', false);
                }
            });

            // OTP Phase 2: Verify OTP
            $('#verify-otp-btn').click(async function() {
                const otpValue = $('#user-otp-input').val();
                
                if(!otpValue || otpValue.length < 6) {
                    alert("Please enter a valid 6-digit OTP");
                    return;
                }

                const btn = $(this);
                const originalText = btn.html();
                btn.html('Verifying... <i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);

                try {
                    // UPDATED: Use verifyOtpUrl
                    const response = await fetch(verifyOtpUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-CSRF-Token': csrfToken,
                            'Accept': 'application/json'
                        },
                        // UPDATED: Append the 'context' to the verification payload
                        body: new URLSearchParams({ 'otp': otpValue, 'context': 'login' }) 
                    });
                    
                    const data = await response.json();
                    
                    if (data.status === 'success') {
                        // OTP is good! Encrypt the password and submit the main form to CakePHP
                        encryptPassword();
                        document.getElementById('main-login-form').submit();
                    } else {
                        alert(data.message); // Show error (Invalid OTP)
                    }
                } catch (error) {
                    console.error("Verification failed", error);
                    alert("Verification failed. Please try again.");
                } finally {
                    btn.html(originalText).prop('disabled', false);
                }
            });

            function cancelOtp() {
                $('#login-step-2').slideUp();
                $('#login-step-1').slideDown();
                $('#form-title').text('LOGIN');
                $('#form-subtitle').text('For availing various government services');
                $('#user-otp-input').val('');
            }
        </script>

        <script>
            $(document).ready(function() {
                $('#chatbotToggle').click(() => $('#chatbotPopup').toggle());
                $('#closeChat').click(() => $('#chatbotPopup').hide());
                $('#sendBtn').click(sendMessage);
                $('#userInput').keypress(e => { if (e.which == 13) sendMessage(); });
                function sendMessage() {
                    const text = $('#userInput').val().trim();
                    if (text === '') return;
                    $('#chatBody').append(`<div class="message user-msg">${text}</div>`);
                    $('#userInput').val('');
                    
                    let reply = "I'm not sure what you mean.";
                    const lower = text.toLowerCase();
                    if (lower.includes('hello')) reply = "Hi there 👋";
                    else if (lower.includes('how are you')) reply = "I'm doing great, thanks for asking!";
                    else if (lower.includes('bye')) reply = "Goodbye! 👋";
                    else if (lower.includes('your name')) reply = "I'm your friendly chatbot.";
            
                    setTimeout(() => {
                        $('#chatBody').append(`<div class="message bot-msg">${reply}</div>`);
                        $('#chatBody').scrollTop($('#chatBody')[0].scrollHeight);
                    }, 600);
                }
            });
        </script>
    </body>
</html>