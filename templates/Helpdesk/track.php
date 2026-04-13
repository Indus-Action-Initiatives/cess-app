<div style="width: 100%; height: auto; margin: 0;">
	<div class="container mt-12">
		<div class="row justify-content-center">
			<?= $this->Flash->render() ?>
			<div class="col-md-12 mt-2">
				<div class="container mt-5">
					<h3 class="mb-4"><i class="fa fa-search"></i> Track Your Support Ticket</h3>
					<?= $this->Form->create() ?>
						<div class="form-row">
							<div class="form-group col-md-6">
								<?= $this->Form->control('ticket_no', [
									'label' => 'Enter Ticket Number',
									'required' => true,
									'class' => 'form-control'
								]) ?>
							</div>
						</div>
						<?= $this->Form->button('Track Ticket', ['class' => 'btn btn-primary']) ?>
					<?= $this->Form->end() ?>
					<hr>
					<?php if (!empty($ticket)): ?>
						<?= $this->element('helpdesk/ticket_view', ['ticket' => $ticket, 'sender' => 'Your']) ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>