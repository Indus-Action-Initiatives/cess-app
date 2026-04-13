<div class="container" style="padding: 50px; text-align: center;">
    <h2>OTP Manual Trigger</h2>
    <p>Target Number: <strong>9258553079</strong></p>

    <?= $this->Form->create(null, ['url' => ['action' => 'sendManual']]) ?>
        <?= $this->Form->button('Send OTP Now', [
            'type' => 'submit',
            'style' => 'background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;'
        ]) ?>
    <?= $this->Form->end() ?>
</div>