<?php

class HPY_UUC_Email_Support {

	public function __construct() {
		$this->get_email_form();
	}

	public static function get_email_form() {
		?>
		<form method="post" name="emailsupportform">

			<p>
				<label for="name-field"><?php _e('Name', 'uuc_domain'); ?></label>
				<input type="text" name="name-field" placeholder="Name">
			</p>
			<p>
				<label for="email-field"><?php _e('Email Address', 'uuc_domain'); ?>
					<span class="tooltip" title="Replies will be sent to this email address.">?</span>
				</label>
				<input type="email" name="email-field" placeholder="you@email.co.uk">
			</p>
			<div class="email-body">
				<p>
					<label for="subject-field"><?php _e('Subject', 'uuc_domain'); ?></label>
					<input type="text" name="subject-field" placeholder="Subject">
				</p>
				<p>
					<label for="message-field"><?php _e('Message', 'uuc_domain'); ?></label>
					<textarea type="textarea" name="message-field" placeholder="Message"></textarea>
				</p>
			</div>

			<div class="submit">
				<input type="submit" name="submit" value="<?php _e('Send Email', 'uuc_domain'); ?>" class="button" >
				<!--<button type="submit" name="submit" class="button"><?php //_e('Send Email', 'uuc_domain'); ?></button> -->
			</div>

		</form>
		<?php
	}

}

