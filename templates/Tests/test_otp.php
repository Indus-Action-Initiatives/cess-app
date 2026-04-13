<div class="container" style="padding: 50px;">
    <h3>OTP System Test</h3>
    <p>Target Email: <strong><?= h($testEmail) ?></strong></p>
    <p>Generated OTP: <strong><?= h($otp) ?></strong></p>
    
    <?= $this->Form->create() ?>
    <?= $this->Form->button('Send Test Email OTP', ['class' => 'button']) ?>
    <?= $this->Form->end() ?>

    <hr>
    <p><small>Check <code>logs/debug.log</code> if you are in debug mode, as it won't send a real email!</small></p>
</div>