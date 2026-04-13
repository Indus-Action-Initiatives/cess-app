<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
		<title><?= $title ?></title>
		<?php echo $this->Html->meta('icon'); ?>
		<?php echo $this->Html->css(['plugins/fontawesome-free/css/all.min.css', 'plugins/icheck-bootstrap/icheck-bootstrap.min.css', 'adminlte.min.css']); ?>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
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
				/*position: fixed;*/
				bottom: 0;
				width: 100%;
				border-top: 2px solid #ffffff;
			}
			footer a {
				color: #2743a3;
				text-decoration: none;
				font-weight: bold;
				/*font-size: 16px;*/
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
				/*height: 25px;*/
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
				% {
					transform: rotate(0deg) translateZ(0);
					-webkit-transform: rotate(0deg) translateZ(0);
				}
				100% {
					transform: rotate(1turn) translateZ(0);
					-webkit-transform: rotate(1turn) translateZ(0);
				}
			}
		</style>
		<style>
			body {
				margin: 0;
				padding: 0;
			}
			h2, p {
				margin: 10px;
			}
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
				<span>
					<i class="fa-brands fa-facebook"></i>
				</span>
				<span>
					<i class="fa-brands fa-instagram"></i>
				</span>
				<span>
					<i class="fa-brands fa-x-twitter"></i>
				</span>
				<span>
					<i class="fa-brands fa-linkedin"></i>
				</span>
			</div>
		</section>
		<header class="header-wrapper">
			<div class="mid-side">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-lg-3 col-md-5 site-logo p-0">
							<div class="d-flex">
								<img src="<?= $this->Url->image('emblem-dark.png'); ?>" alt="National Emblem" class="emblem mr-3">
								<div class="govt-text">
									<p class="hindi mb-0">श्रम एवं रोजगार मंत्रालय</p>
									<p class="english mb-0">GOVERNMENT OF INDIA</p>
									<h5 class="ministry mb-0">MINISTRY OF LABOUR &amp; EMPLOYMENT</h5>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-7 top-logo text-center p-0">
							<div class="text-center p-3">
								<!-- <img src="<?= $this->Url->image("bihar.jpg"); ?>" alt="State Logo" style="width:150px; height:auto; margin-right:20px;" class="state-logo mr-3"> -->
								<p>[State Logo]</p>
								<h6 class="text-muted mb-0" style="color: #d66a6aff;">Department of Labour, Government Of [State Name]</h6>
								<h5 class="font-weight-bold" style="color: #d66a6aff;">Building and Other Construction Workers Welfare Board</h5>
							</div>
						</div>
						<div class="col-lg-3 col-md-12 top-logo p-0" style="float: right; text-align: right;">
							<!-- <a href="https://www.g20.org/en/" target="_blank" class="mx-2">
								<img src="img/g20_2.png" alt="G20" class="header-logo">
								</a> -->
							<a href="https://amritmahotsav.nic.in/" target="_blank" class="mx-2">
								<img src="<?= $this->Url->image('azadi_0.jpg'); ?>" alt="Azadi Ka Amrit Mahotsav" class="header-logo">
							</a>
						</div>
					</div>
				</div>
			</div>
			<ul>
				<li><a href="<?= webURL ?>">Home</a></li>
				<li><a class="<?= ($active=='about')?'active':'' ?>" href="<?= webURL.'page/about-us' ?>">About Us</a></li>
				<li><a class="<?= ($active=='faqs')?'active':'' ?>" href="<?= webURL.'page/faqs' ?>">FAQs</a></li>
				<li><a class="<?= ($active=='contact')?'active':'' ?>" href="<?= webURL.'page/contact-us' ?>">Contact Us</a></li>
				<li><a class="<?= ($active=='help')?'active':'' ?>" href="<?= webURL.'helpdesk/add' ?>">Help</a></li>
				<li><a class="<?= ($active=='track')?'active':'' ?>" href="<?= webURL.'helpdesk/track' ?>">Track Ticket</a></li>
			</ul>
		</header>
		<?php echo $this->fetch('content');?>
		<footer>
			<div class="container">
				<p class="mb-1">© <?= date('Y') ?> Department of Labour, Government of [State Name]. All Rights Reserved.</p>
				<p class="mb-0">Designed & Developed by <a href="javascript:void(0)">Ministry of Labour & Employment</a></p>
			</div>
		</footer>
		<div class="chatbot-btn" id="chatbotToggle">💬</div>
		<div class="chatbot-popup" id="chatbotPopup">
			<div class="chat-header">
				🤖 Chatbot
				<span id="closeChat">&times;</span>
			</div>
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
		<div class="bhashini-plugin-container"></div>
		<script src="https://translation-plugin.bhashini.co.in/v2/website_translation_utility.js"></script>
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
					// Simple reply logic
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