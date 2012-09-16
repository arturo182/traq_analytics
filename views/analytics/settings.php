<div class="content">
	<h3>Plugin settings</h3>
	<form action="<?php echo Request::full_uri(); ?>" method="post">
		<div class="tabular box">
			<div class="group">
				<label>Tracking ID</label>
				<?php echo Form::text('settings[tracking_id]', array('value' => $settings['tracking_id'])); ?>
			</div>
			<div class="group">
				<label>Track subdomains</label>
				<?php echo Form::checkbox('settings[subdomains]', 1, array('checked' => $settings['subdomains'], 'onClick' => 'if(this.checked) { $(\'#domain\').removeAttr(\'disabled\'); } else { $(\'#domain\').attr(\'disabled\', \'disabled\'); }')); ?>
			</div>
			<div class="group">
				<label>Main domain</label>
				<?php echo Form::text('settings[domain]', array('value' => $settings['domain'], 'id' => 'domain')); ?>
			</div>
			<div class="group">
				<label>Multiple domains</label>
				<?php echo Form::checkbox('settings[multidomains]', 1, array('checked' => $settings['multidomains'])); ?>
			</div>
		</div>
		<div class="actions">
			<input type="submit" value="<?php echo l('save'); ?>" />
		</div>
	</form>
</div>