<div class="card mt-4 shadow-sm">
	<div class="card-header bg-info text-white">
		<strong>Ticket Details</strong>
	</div>
	<div class="card-body">
		<table class="table table-bordered">
			<tr>
				<th style="width: 30%;">Ticket Number</th>
				<td><?= h($ticket->ticket_no) ?></td>
			</tr>
			<tr>
				<th>Subject</th>
				<td><?= h($ticket->subject) ?></td>
			</tr>
			<tr>
				<th>Status</th>
				<td>
					<?php
						$statusClass = match($ticket->status) {
							'Open' => 'badge badge-warning',
							'In Progress' => 'badge badge-primary',
							'Closed' => 'badge badge-success',
							default => 'badge badge-secondary'
						};
					?>
					<span class="<?= $statusClass ?>">
						<?= h($ticket->status) ?>
					</span>
				</td>
			</tr>
			<tr>
				<th>Priority</th>
				<td><?= h($ticket->priority) ?></td>
			</tr>
			<tr>
				<th>Created On</th>
				<td><?= $ticket->created->format('d-m-Y | h:i A') ?></td>
			</tr>
			<tr>
				<th>Description</th>
				<td><?= nl2br(h($ticket->description)) ?></td>
			</tr>
			<tr>
				<th>Attachment</th>
				<td>
					<?php if (!empty($ticket->attachment)): ?>
						<a href="<?= $this->Url->build('/uploads/helpdesk/'.$ticket->attachment) ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
							<i class="fa fa-paperclip"></i> View Attachment
						</a>
					<?php else: ?>
						<span class="text-muted">No attachment</span>
					<?php endif; ?>
				</td>
			</tr>
		</table>
		<?php if (!empty($ticket->helpdesk_comments)): ?>
			<h5 class="mt-4">Conversation</h5>
			<?php foreach ($ticket->helpdesk_comments as $comment): ?>
				<div class="border p-3 mb-2">
					<strong>
						<?= $comment->sender_type === 'admin' ? 'Helpdesk' : 'Applicant' ?>
					</strong>
					<span class="text-muted float-right">
						<?= $comment->created->format('d-m-Y | h:i A') ?>
					</span>
					<p class="mb-1 mt-2">
						<?= nl2br(h($comment->message)) ?>
					</p>
					<?php if (!empty($comment->attachment)): ?>
						<a href="<?= $this->Url->build('/uploads/helpdesk/'.$comment->attachment) ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
							<i class="fa fa-paperclip"></i> View Attachment
						</a>
					<?php else: ?>
						<span class="text-muted">No attachment</span>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
		<?php if ($ticket->status !== 'Closed'): ?>
			<hr>
			<h5><?= $sender ?> Reply</h5>
			<?= $this->Form->create(null, ['type' => 'file']) ?>
				<input type="hidden" name="reply_ticket_id" value="<?= $ticket->id ?>">
				<div class="form-group">
					<?= $this->Form->control('message', [
						'type' => 'textarea',
						'label' => 'Message',
						'required' => true
					]) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('attachment', [
						'type' => 'file',
						'label' => 'Attachment (optional)'
					]) ?>
				</div>
				<?= $this->Form->button('Send Reply', ['class'=>'btn btn-primary', 'id'=>'publicReplyBtn']) ?>
			<?= $this->Form->end() ?>
			<?php else: ?>
			<div class="alert alert-success mt-3">This ticket is closed.</div>
		<?php endif; ?>
	</div>
</div>
<script>
$(document).on('submit', 'form', function () {
	const btn = $('#publicReplyBtn');
	btn.prop('disabled', true);
	btn.text('Sending...');
});
</script>