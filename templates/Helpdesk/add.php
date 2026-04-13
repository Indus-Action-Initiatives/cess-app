<div style="width: 100%; margin: 0; padding-top: 40px;">
	<div class="container mt-12">
		<div class="row justify-content-center">
			<div class="col-md-12 mt-2">
				<h3>Raise a Support Ticket</h3>
				<?= $this->Form->create(null, ['type' => 'file']) ?>
					<div class="form-group">
						<?= $this->Form->control('name', ['required' => true]) ?>
					</div>
					<div class="form-group">
						<?= $this->Form->control('email', ['required' => true]) ?>
					</div>
					<div class="form-group">
						<?= $this->Form->control('mobile') ?>
					</div>
					<div class="form-group">
						<?= $this->Form->control('subject', ['required' => true]) ?>
					</div>
					<div class="form-group">
						<?= $this->Form->control('priority', [
							'type' => 'select',
							'options' => ['Low'=>'Low', 'Normal'=>'Normal', 'High'=>'High']
						]) ?>
					</div>
					<div class="form-group">
						<?= $this->Form->control('description', ['type'=>'textarea', 'rows'=>4]) ?>
					</div>
					<div class="form-group">
						<?= $this->Form->control('attachment', [
							'type' => 'file',
							'label' => 'Attachment (PDF / JPG / PNG)'
						]) ?>
					</div>
					<?= $this->Form->button('Submit Ticket', ['class'=>'btn btn-primary']) ?>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>