<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6"></div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo webURL ?>admin/dashboard">Home</a></li>
					<li class="breadcrumb-item active">Helpdesk Tickets</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<section class="content">
	<div class="container-fluid">
		<?= $this->Flash->render() ?>
		<div class="d-flex justify-content-between align-items-center mb-3">
			<h3><?= __('Helpdesk Ticket Number - '.$ticket->ticket_no) ?></h3>
		</div>
		<?= $this->element('helpdesk/ticket_view', ['ticket' => $ticket, 'sender' => 'Admin']) ?>
		<hr>
	</div>
</section>