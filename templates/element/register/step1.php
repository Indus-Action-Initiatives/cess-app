<?= $this->Form->create(null, [
    'type' => 'file',
    'class' => 'needs-validation mt-4',
    'id' => 'step1-form',
    'novalidate' => true
]) ?>

<h5 class="mb-3"><b>Personal Information</b></h5>

<div class="form-row">
    <div class="form-group col-md-4">
        <?= $this->Form->control('registration_type', [
            'label' => 'Registration Type <span class="required">*</span>',
            'options' => [
                'Private Organization' => 'Private Organization', 
                'Government Organization' => 'Government Organization', 
                'Individual' => 'Individual'
            ],
            'escape' => false,
            'class' => 'form-control',
            'id' => 'registration_type',
            'required' => true,
            'empty' => 'Select Registration Type'
        ]) ?>
    </div>

    <div class="form-group col-md-8" id="firm_name_group" style="display:none;">
        <?= $this->Form->control('firm_name', [
            'label' => 'Organization Name <span class="required">*</span>',
            'escape' => false,
            'class' => 'form-control',
            'id' => 'firm_name'
        ]) ?>
    </div>

    <div class="form-group col-md-4" id="first_name_group">
        <?= $this->Form->control('first_name', [
            'label' => 'First Name <span class="required">*</span>',
            'escape' => false,
            'class' => 'form-control',
            'id' => 'first_name'
        ]) ?>
    </div>

    <div class="form-group col-md-4" id="last_name_group">
        <?= $this->Form->control('last_name', [
            'label' => 'Last Name',
            'class' => 'form-control',
            'id' => 'last_name'
        ]) ?>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <?= $this->Form->label('phone', 'Phone <span class="required">*</span> <span id="mobile-verified-badge" class="badge badge-success ml-2" style="display:none;"><i class="fa fa-check"></i> Verified</span>', ['escape' => false]) ?>
        <div class="input-group">
            <?= $this->Form->text('phone', [
                'class' => 'form-control',
                'id' => 'phone',
                'required' => true,
                'maxlength' => 10,
                'placeholder' => 'Enter 10 digit mobile'
            ]) ?>
            <div class="input-group-append">
                <button type="button" id="send-mobile-btn" class="btn btn-info" onclick="handleSendOtp('mobile')">Send OTP</button>
            </div>
        </div>
        <div id="mobile-otp-group" class="mt-2 p-2 border rounded bg-light" style="display:none;">
            <div class="input-group input-group-sm">
                <input type="text" id="mobile-otp-input" class="form-control" placeholder="Enter Mobile OTP">
                <div class="input-group-append">
                    <button type="button" class="btn btn-success" onclick="handleVerifyOtp('mobile')">Verify</button>
                </div>
            </div>
        </div>
        <div class="invalid-feedback" id="phone-feedback">Please enter a valid phone number.</div>
    </div>
</div>

<h5 class="mb-3 mt-4"><b>Login Information</b></h5>

<div class="form-row">
    <div class="form-group col-md-6">
        <?= $this->Form->label('email', 'Email <span class="required">*</span> <span id="email-verified-badge" class="badge badge-success ml-2" style="display:none;"><i class="fa fa-check"></i> Verified</span>', ['escape' => false]) ?>
        <div class="input-group">
            <?= $this->Form->control('email', [
                'label' => false,
                'class' => 'form-control',
                'id' => 'email',
                'required' => true,
                'placeholder' => 'example@mail.com'
            ]) ?>
            <div class="input-group-append">
                <button type="button" id="send-email-btn" class="btn btn-info" onclick="handleSendOtp('email')">Send OTP</button>
            </div>
        </div>
        <div id="email-otp-group" class="mt-2 p-2 border rounded bg-light" style="display:none;">
            <div class="input-group input-group-sm">
                <input type="text" id="email-otp-input" class="form-control" placeholder="Enter Email OTP">
                <div class="input-group-append">
                    <button type="button" class="btn btn-success" onclick="handleVerifyOtp('email')">Verify</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <?= $this->Form->control('password', [
            'label' => 'Create Password <span class="required">*</span>',
            'escape' => false,
            'class' => 'form-control',
            'id' => 'password',
            'required' => true,
        ]) ?>
    </div>
    <div class="form-group col-md-6">
        <?= $this->Form->control('cpassword', [
            'label' => 'Confirm Password <span class="required">*</span>',
            'escape' => false,
            'class' => 'form-control',
            'id' => 'cpassword',
            'required' => true,
        ]) ?>
    </div>
</div>

<div class="text-right mt-4">
    <button type="submit" id="step1-next" class="btn btn-primary px-5 btn-lg shadow-sm">Next Step →</button>
</div>

<?= $this->Form->end() ?>

<script>
$(document).ready(function() {
    const csrfToken = '<?= $this->request->getAttribute("csrfToken") ?>';
    let isEmailVerified = false;
    let isMobileVerified = false;

    // ----- Registration Type Toggle -----
    $('#registration_type').on('change', function() {
        const type = $(this).val();
        if (type.includes('Organization')) {
            $('#firm_name_group').show();
            $('#firm_name').attr('required', true);
            $('#first_name_group, #last_name_group').hide();
        } else if (type === 'Individual') {
            $('#first_name_group, #last_name_group').show();
            $('#firm_name_group').hide();
        }
    });

    // ----- OTP SEND LOGIC -----
    window.handleSendOtp = async function(type) {
        const target = (type === 'mobile') ? $('#phone').val() : $('#email').val();
        if (!target) {
            alert(`Please enter a valid ${type} first.`);
            return;
        }

        const btn = (type === 'mobile') ? $('#send-mobile-btn') : $('#send-email-btn');
        btn.prop('disabled', true).text('Sending...');

        try {
            // UPDATED: Now hitting the unified sendOtp endpoint
            const response = await fetch('<?= $this->Url->build(["controller" => "Users", "action" => "sendOtp"]) ?>', {
                method: 'POST',
                headers: { 'X-CSRF-Token': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/x-www-form-urlencoded' },
                // UPDATED: Using 'context' instead of 'type'
                body: new URLSearchParams({ context: type, target: target })
            });
            const data = await response.json();
            if (data.status === 'success') {
                $(`#${type}-otp-group`).slideDown();
                alert(data.message);
            } else {
                alert(data.message || 'Failed to send OTP.');
            }
        } catch (e) { alert('Error sending OTP.'); }
        btn.prop('disabled', false).text('Resend');
    };

    // ----- OTP VERIFY LOGIC -----
    window.handleVerifyOtp = async function(type) {
        const otp = $(`#${type}-otp-input`).val();
        if (!otp) return alert('Enter the OTP code.');

        try {
            // UPDATED: Now hitting the unified verifyOtp endpoint
            const response = await fetch('<?= $this->Url->build(["controller" => "Users", "action" => "verifyOtp"]) ?>', {
                method: 'POST',
                headers: { 'X-CSRF-Token': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/x-www-form-urlencoded' },
                // UPDATED: Using 'context' instead of 'type'
                body: new URLSearchParams({ context: type, otp: otp })
            });
            const data = await response.json();
            if (data.status === 'success') {
                alert(data.message);
                $(`#${type}-otp-group`).slideUp();
                $(`#${(type === 'mobile') ? 'phone' : 'email'}`).prop('readonly', true);
                $(`#send-${type}-btn`).hide();
                $(`#${type}-verified-badge`).fadeIn();
                
                if (type === 'mobile') isMobileVerified = true;
                if (type === 'email') isEmailVerified = true;
            } else { alert(data.message || 'Invalid OTP.'); }
        } catch (e) { alert('Verification failed.'); }
    };

    // ----- Form Submission Check -----
    $('#step1-form').on('submit', function(e) {
        if (!isMobileVerified || !isEmailVerified) {
            e.preventDefault();
            alert("Please verify both your Mobile and Email via OTP before proceeding.");
            return false;
        }

        // Standard Password Check
        if ($('#password').val() !== $('#cpassword').val()) {
            e.preventDefault();
            alert("Passwords do not match!");
            return false;
        }
    });
});
</script>