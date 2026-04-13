<div class="container mt-5 mb-5">
    <div class="card shadow-lg p-4 border-0">
        <h2 class="text-center mb-4 font-weight-bold">Begin Your Journey!!</h2>

        <!-- Progress Bar -->
        <div class="progress mb-5" style="height: 25px;">
            <div class="progress-bar bg-success" role="progressbar"
                style="width: <?= $step * 33 ?>%;"
                aria-valuenow="<?= $step * 33 ?>" aria-valuemin="0" aria-valuemax="100">
                Step <?= $step ?> of 3
            </div>
        </div>

        <!-- Step Navigation Header -->
        <div class="d-flex justify-content-around mb-4">
            <div class="text-center">
                <div class="circle <?= $step >= 1 ? 'active' : '' ?>">1</div>
                <p class="small mt-2 mb-0">Personal Info</p>
            </div>
            <div class="text-center">
                <div class="circle <?= $step >= 2 ? 'active' : '' ?>">2</div>
                <p class="small mt-2 mb-0">Details</p>
            </div>
            <div class="text-center">
                <div class="circle <?= $step >= 3 ? 'active' : '' ?>">3</div>
                <p class="small mt-2 mb-0">Attachments</p>
            </div>
        </div>

        <hr>

        <!-- Step Content -->
        <?= $this->element('register/step' . $step, ['formData' => $formData]) ?>
    </div>
</div>

<!-- Custom Step Styles -->
<style>
    .circle {
        width: 40px;
        height: 40px;
        line-height: 38px;
        border-radius: 50%;
        background: #ddd;
        color: #333;
        display: inline-block;
        font-weight: bold;
    }

    .circle.active {
        background: #28a745;
        color: #fff;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    }
</style>