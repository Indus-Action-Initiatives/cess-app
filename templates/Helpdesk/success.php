<div style="width: 100%; margin: 0;">
	<div class="container mt-12">
		<div class="row justify-content-center">
			<div class="col-md-12 mt-2">
				<div class="card shadow-sm">
					<div class="card-body">
						<h3 class="text-success mb-3"><i class="fa fa-check-circle"></i> Ticket Submitted Successfully</h3>
						<p>Your support ticket has been registered.</p>
						<p>
							<strong>Your Ticket Number:</strong><br>
							<span class="badge badge-primary p-2" style="font-size: 18px;">
								<?= h($ticketNo) ?>
							</span>
						</p>
						<p class="mt-3">Please keep this ticket number safe to track your issue.</p>
						<a href="<?= $this->Url->build(['action' => 'track']) ?>" class="btn btn-outline-primary mt-3">Track Your Ticket</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>