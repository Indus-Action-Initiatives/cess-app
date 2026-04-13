<!DOCTYPE html>
<html lang="en">

   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
      <title>Labour Cess | Login</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <?php echo $this->Html->meta('icon');?>
      <?Php echo $this->Html->css(array('plugins/fontawesome-free/css/all.min.css','plugins/icheck-bootstrap/icheck-bootstrap.min.css','adminlte.min.css'));?>
      <style type="text/css">
        .login-page{
          background-color: #E0E1E2;
          height: auto;
        }
        .header-wrapper {
            border-bottom: 1px solid #d0d0d0;
            background: #fff;
            width: 100%;
        }
        .navbar-brand img {
                width: auto;
              height: auto;
              max-width: 100%;
              vertical-align: middle;
              border: 0;
        }
        .navbar-toggle {
            margin-top: 8px;
        }
        .header-right img {
            width: auto;
              height: auto;
              max-width: 100%;
              vertical-align: middle;
              border: 0;
        }
        .logo {
            min-width: 345px;
        }

        .logo {
            background: none;
            padding: 0;
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
    text-align: left;
}
.logo a {
    color: #000;
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
.logo img {
    float: left;
    padding: 0 15px 0 5px;
}
.header-container {
    padding: 8px 0px 6px;
}
      </style>
   </head>
   <body class="hold-transition login-page">
    <!-- Header Section -->
<!-- <header class="header-wrapper header-container">
    <div class="container">
        <div class="row">
            <div class="col-4 logo">
                <a href="/" class="navbar-brand">
                    <img src="img/emblem-dark.png" alt="national emblem">
                    <strong>
        श्रम एवं रोजगार मंत्रालय    </strong>
            Government of India         
        <span>
             Ministry of Labour &amp;<br> Employment        </span>
                </a>
            </div>

            <div class="col-8 text-right header-right">
                <a class="sw-logo" href="https://www.g20.org/en/" target="_blank">
                    <img src="img/g20_2.png" alt="G20">
                </a>
                <a class="sw-logo" href="https://amritmahotsav.nic.in/" target="_blank">
                    <img src="img/azadi_0.jpg" alt="Azadi Ka Amrit Mahotsav">
                </a>
                <a class="sw-logo" href="https://swachhbharat.mygov.in/" target="_blank">
                    <img src="img/swach-bharat.png" alt="Swachh Bharat">
                </a>
            </div>
        </div>
    </div>
</header> -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Top Logo Bar -->
            <div class="text-center p-3 shadow-sm rounded bg-white mb-4">
                <p>State Logo</p>
                <h6 class="text-muted mb-0">Department of Labour, Government Of State Name</h6>
                <h5 class="font-weight-bold">
                    Building and Other Construction Workers Welfare Board
                </h5>
            </div>

            <!-- Login Card -->
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    
                    <h3 class="font-weight-bold mb-3">LOGIN</h3>
                    <p class="text-muted" style="margin-top:-10px;">
                        For availing various government services
                    </p>

                    <!-- CAKEPHP FORM -->
                    <?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'index']]) ?>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            </div>
                            <?php echo $this->Form->input('email',['type'=>'text','required'=>true,'autocomplete'=>'off','class'=>'form-control','placeholder'=>'Username'])?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-key"></i>
                                </span>
                            </div>
                            <?php echo $this->Form->input('password',['type'=>'password','required'=>true,'autocomplete'=>'off','class'=>'form-control','placeholder'=>'Password'])?>
                        </div>
                    </div>
                    <div class="input-group mb-3">
          <?php //echo '<img src="' . $this->Url->build(['controller' => 'Users', 'action' => 'captcha', '?' => ['t' => time()]]) . '" alt="CAPTCHA" />';?>
          <?php //echo $this->Form->control('captcha_answer', ['label' => 'Enter the CAPTCHA']); ?>

<div style="display: flex; align-items: center;">
    <?php echo '<img src="' . $this->Url->build(['controller' => 'Users', 'action' => 'captcha', '?' => ['t' => time()]]) . '" alt="CAPTCHA" />'; ?>
    <?php echo $this->Form->control('captcha_answer', [
        'label' => false, // Hide the label
        'placeholder' => 'Enter CAPTCHA',
        'style' => 'flex: 1;' // Optional to control width
    ]); ?>
</div>

        </div>

                    <a href="#" class="text-danger small d-block mb-3">
                        Forgot Password?
                    </a>

                    <button type="submit" class="btn btn-success btn-block py-2">
                        LOGIN <i class="fa fa-sign-in-alt ml-2"></i>
                    </button>

                    <?= $this->Form->end() ?>

                    <div class="text-center mt-4">
                        <span class="text-muted">Don't have an account?</span>
                        <a href="/register" class="text-danger font-weight-bold">Create an account</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

    <!-- /.login-box -->
    <?php echo $this->Html->script(array('plugins/jquery/jquery.min.js','plugins/bootstrap/js/bootstrap.bundle.min.js','adminlte.min.js'));?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/crypto-js.min.js"></script>
    <script>
      // Encrypt password before sending to the server
      function encryptPassword() {
        var password = document.querySelector('input[name="password"]');
        var originalPassword = password.value;
        var secretKeyHex  = '<?= h($secret_key) ?>';
        var secretKey = CryptoJS.enc.Hex.parse(secretKeyHex);

        // // Encrypt the password using AES
        var iv = CryptoJS.lib.WordArray.random(16);  // 16 bytes for AES
        var encrypted  = CryptoJS.AES.encrypt(originalPassword, secretKey, {
          iv: iv,
          mode: CryptoJS.mode.CBC,
          padding: CryptoJS.pad.Pkcs7
        });

        var ivBase64 = CryptoJS.enc.Base64.stringify(iv);
        var encryptedBase64 = encrypted.ciphertext.toString(CryptoJS.enc.Base64);

        // Combine IV and encrypted password
        var combined = ivBase64.concat(encryptedBase64);
        password.value = combined;
      }
      document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();  // Prevent form submission
        encryptPassword();
        this.submit();  // Submit the form manually after encryption
      });  
    </script>

    <div class="bhashini-plugin-container"></div>
    <script src="https://translation-plugin.bhashini.co.in/v2/website_translation_utility.js"></script>
</body>
</html>