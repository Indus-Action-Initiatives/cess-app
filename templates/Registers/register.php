<div class="container mt-4">
    <h5 class="font-weight-bold mb-3">Select registration Type:</h5>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <!-- STEP INDICATOR -->
            <div class="d-flex justify-content-center mb-4 align-items-center">
                <div class="text-center">
                    <div class="d-flex justify-content-center align-items-center mb-2">
                        <div class="step-circle bg-primary text-white">1</div>
                        <div class="step-line"></div>
                        <div class="step-circle text-muted border">2</div>
                        <div class="step-line"></div>
                        <div class="step-circle text-muted border">3</div>
                        <div class="step-line"></div>
                        <div class="step-circle text-muted border">4</div>
                    </div>
                    <div class="d-flex justify-content-between text-muted small px-3">
                        <span class="text-primary font-weight-bold">Get Started</span>
                        <span>Fill Detail</span>
                        <span>Verification</span>
                        <span>Document Upload</span>
                    </div>
                </div>
            </div>

            <div class="row align-items-center">
                <!-- Left Illustration -->
                <div class="col-md-5 d-none d-md-flex justify-content-center">
                    <img src="<?php echo webURL; ?>img/worker.jpg" alt="Workers" class="img-fluid" style="max-width: 80%;">
                </div>

                <!-- Right Form -->
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="font-weight-semibold text-center mb-3">Let's Get Started</h4>

                            <?= $this->Form->create(null, ['class' => 'needs-validation', 'novalidate']) ?>

                            <!-- Register as -->
                            <div class="mb-3 text-center">
                                <label class="form-label d-block font-weight-semibold mb-2">Register as</label>
                                <div class="btn-group" role="group" id="registrationTypeGroup">
                                    <input type="radio" class="btn-check" name="register_as" id="organization" value="organization" checked>
                                    <label class="btn btn-outline-primary active" for="organization">Organization</label>

                                    <input type="radio" class="btn-check" name="register_as" id="individual" value="individual">
                                    <label class="btn btn-outline-primary" for="individual">Individual</label>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <?= $this->Form->control('email', [
                                    'label' => 'Email Id',
                                    'required' => true,
                                    'type' => 'email',
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter your email',
                                ]) ?>

                                
                            </div>

                            <!-- Buttons -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-block">Continue</button>
                                <a href="#" class="btn btn-outline-secondary btn-block">Cancel</a>
                            </div>

                            <?= $this->Form->end() ?>

                            <div class="text-center mt-3">
                                <small>Have an account? <a href="#">Log in</a></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .step-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        border: 2px solid #dee2e6;
    }

    .step-line {
        width: 60px;
        height: 2px;
        background-color: #dee2e6;
    }

    .btn-outline-primary.active {
        background-color: #007bff;
        color: #fff;
    }
</style>

<!-- JavaScript for Active Toggle -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('#registrationTypeGroup .btn');
        buttons.forEach(btn => {
            btn.addEventListener('click', function() {
                buttons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });
</script>