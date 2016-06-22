<?php 

function uuc_options_page() {

	global $uuc_options, $wp_version, $wp_roles;

	ob_start(); ?>
	<div class="wrap">
		<div id="icon-tools" class="icon32"></div><h2>Under Construction Plugin Options</h2>

		<form method="post" action="options.php">

		<div class="enable_check">
			<p>
				<input class="enable_checkbox" id="uuc_settings[enable]" name="uuc_settings[enable]" type="checkbox" value="1" <?php checked($uuc_options['enable'], '1'); ?>/>
				<label class="description" for="uuc_settings[enable]"><?php _e('Enable the Under Construction Page','uuc_domain'); ?></label>
			</p>
		</div>

	    <h3><?php _e('Holding Page Type', 'uuc_domain'); ?> <span class="tooltip" title="The Custom Build allows you to build an Under Construction Page using a variety of choices, recommended for usual users. For more experienced users the HTML Block will allow you to create a bespoke Under Construction Page.">?</span></h3>
		<p>
			<label style="margin-right:15px;"><input onclick="checkPage()" type="radio" name="uuc_settings[holdingpage_type]" id="custom" value="custom"<?php if(!isset($uuc_options['holdingpage_type'])){ ?> checked <?php } else { checked( 'custom' == $uuc_options['holdingpage_type'] ); } ?> /> Prebuilt Themes</label>
			<label><input onclick="checkPage()" type="radio" name="uuc_settings[holdingpage_type]" id="htmlblock" value="htmlblock"<?php if( isset($uuc_options['holdingpage_type'])) { checked( 'htmlblock' == $uuc_options['holdingpage_type'] ); } ?> /> Custom HTML build</label>
		</p>

		<h2 class="nav-tab-wrapper">
	      <a class="nav-tab main-settings-tab nav-tab-active" id="main-settings-tab" href="<?php echo admin_url() ?>tools.php?page=uuc-options" onclick="changeActive(this)">General</a>
	      <a class="nav-tab design-tab" id="design-tab" href="<?php echo admin_url() ?>tools.php?page=uuc-design" onclick="changeActive(this)">Design</a>
	      <a <?php if ($uuc_options['holdingpage_type'] == "htmlblock"){ ?> style="visibility: hidden; display: none;"<?php }; ?> id="communication-tab" class="nav-tab communication-tab" href="<?php echo admin_url() ?>tools.php?page=uuc-options-communication" onclick="changeActive(this)">Integrations</a>
	      <a class="nav-tab advanced-settings-tab" id="advanced-settings-tab" href="<?php echo admin_url() ?>tools.php?page=uuc-options-advanced" onclick="changeActive(this)">Misc. Settings</a>
<!--	      <a class="nav-tab support-tab" id="support-tab" href="--><?php //echo admin_url() ?><!--tools.php?page=uuc-options-support" onclick="changeActive(this)">Help/Support</a>-->
	    </h2>

		<script type="text/javascript">
			jQuery( document).ready( function() {
				if( !jQuery('.enable_checkbox').is(':checked') ) {
					jQuery('.enable_check').addClass('deactivated');
				} else {
					jQuery('.enable_check').removeClass('deactivated');
				}

				if (document.getElementById("custom").checked) {
					document.getElementById("custombg").style.visibility = "visible";
					document.getElementById("custombg").style.display = "block";
					document.getElementById("communicationbg").style.visibility = "visible";
					document.getElementById("communicationbg").style.display = "block";
					document.getElementById("htmlblockbg").style.visibility = "hidden";
					document.getElementById("htmlblockbg").style.display = "none";
					document.getElementById("communication-tab").style.visibility = "visible";
					document.getElementById("communication-tab").style.display = "inline-block";
					document.getElementById("design-tab").style.visibility = "visible";
					document.getElementById("design-tab").style.display = "inline-block";
				}

				if (document.getElementById("htmlblock").checked) {
					document.getElementById("htmlblockbg").style.visibility = "visible";
					document.getElementById("htmlblockbg").style.display = "block";
					document.getElementById("custombg").style.visibility = "hidden";
					document.getElementById("custombg").style.display = "none";
					document.getElementById("communicationbg").style.visibility = "hidden";
					document.getElementById("communicationbg").style.display = "none";
					document.getElementById("communication-tab").style.visibility = "hidden";
					document.getElementById("communication-tab").style.display = "none";
					document.getElementById("design-tab").style.visibility = "hidden";
					document.getElementById("design-tab").style.display = "none";
				}
			});

			jQuery( '.enable_check').on( "click", function() {
				if( !jQuery('.enable_checkbox').is(':checked') ) {
					jQuery('.enable_check').addClass('deactivated');
				} else {
					jQuery('.enable_check').removeClass('deactivated');
				}
			});
		</script>

	    <div id='sections'>

				<?php
				//Current version of WP seems to fall over on unticked Checkboxes... This is to tidy it up and stop unwanted 'Notices'
				//Enable Checkbox Sanitization
				if ( ! isset( $uuc_options['enable'] ) || $uuc_options['enable'] != '1' )
				  $uuc_options['enable'] = 0;
				else
				  $uuc_options['enable'] = 1;

				if ( !isset( $uuc_optionsp['holdingpage_type'] ) )
					$uuc_options['holdingpage_type'] = 'custom';

				//Countdown Checkbox Sanitization
				if ( ! isset( $uuc_options['cdenable'] ) || $uuc_options['cdenable'] != '1' )
				  $uuc_options['cdenable'] = 0;
				else
				  $uuc_options['cdenable'] = 1;

				if ( !isset( $uuc_options['progressbar'] ) )
					$uuc_options['progressbar'] = 0;

				if ( !isset( $uuc_options['background_style'] ) )
					$uuc_options['background_style'] = 'solidcolor';

				$all_roles = $wp_roles->roles;
				foreach( $all_roles as $roles) {
					$rolename = $roles['name'];
					$settings_role[] = 'user_role_' . $rolename;
				}

				foreach( $settings_role as $role ) {
					$allowed_role = $uuc_options[$role];
					if ( $allowed_role == 1 ){
						$allowed[] = strtolower( str_replace( 'user_role_', '', $role ) );
					}

				}
				if ( !isset( $allowed ) )
					$uuc_options['user_role_Administrator'] = 1;

				settings_fields('uuc_settings_group'); ?>

				<section>

					<div id="htmlblockbg" <?php if ($uuc_options['holdingpage_type'] == "custom"){ ?> style="visibiliy: hidden; display: none;"<?php }; ?>>
						<div class="hpy_top_row">
							<label for="uuc_settings[html_block]"><?php _e('HTML Block', 'uuc_domain'); ?>
								<span class="tooltip" title="Enter the HTML - Advised for advanced users only! - Will display exactly as entered.">?</span>
							</label>
						</div>
						<textarea class="theEditor" name="uuc_settings[html_block]" id="uuc_settings[html_block]" rows="20"><?php if (isset($uuc_options['html_block'])) echo $uuc_options['html_block']; ?></textarea>
						</p>
					</div>

					<div id="custombg" <?php if ($uuc_options['holdingpage_type'] == "htmlblock"){ ?> style="visibility: hidden; display: none;"<?php }; ?>>
						<ul>
							<li>
								<label for="uuc_settings[website_name]"><?php _e('Page Title', 'uuc_domain'); ?>
									<span class="tooltip" title="This is the Title for your Under Construction page.">?</span>
								</label>
								<input class="regular-text" id="uuc_settings[website_name]" name="uuc_settings[website_name]" type="text" value="<?php if( isset($uuc_options['website_name']) ) { echo $uuc_options['website_name']; } ?>"/>
							</li>

							<li class="wysiwyg-wrap">
								<label for="uuc_settings_holding_message"><?php _e('Holding Message', 'uuc_domain'); ?>
									<span class="tooltip" title="This will appear underneath the Page Title on the Under Construction Page.">?</span>
								</label>

								<?php if ( isset($uuc_options['holding_message']) ) {
									$wysiwyg_content = $uuc_options['holding_message'];
								} else {
									$wysiwyg_content = '';
								}

								$wysiwyg_id = 'uuc_settings_holding_message';
								$wysiwyg_args = array( 'textarea_name' => 'uuc_settings[holding_message]');
								wp_editor( $wysiwyg_content, $wysiwyg_id, $wysiwyg_args );
								?>
							</li>
							<li class="sub_settings">
								<div class="option_toggle">
									<label><?php _e('Countdown Timer', 'uuc_domain'); ?></label>

									<input onclick="showflipClock()" id="flipclock_check" name="uuc_settings[cdenable]" type="checkbox" value="1" <?php checked($uuc_options['cdenable'], '1'); ?> />
									<label class="description" for="flipclock_check"><?php _e('Enable the Countdown Timer?','uuc_domain'); ?></label>
								</div>
								<div class="sub_setting" <?php if( $uuc_options['cdenable'] == false ) { ?> style="visibility: hidden; display: none;" <?php } ?> id="flipclock_settings">
									<div class="sub_options">
										<label><input type="radio" name="uuc_settings[cd_style]" id="flipclock" value="flipclock"<?php if(!isset($uuc_options['cd_style'])){ ?> checked <?php } else { checked( 'flipclock' == $uuc_options['cd_style'] ); } ?> /> Flip Clock / </label>
										<label><input type="radio" name="uuc_settings[cd_style]" id="textclock" value="textclock"<?php if(isset($uuc_options['cd_style'])) { checked( 'textclock' == $uuc_options['cd_style'] ); } ?> /> Text only.</label>
									</div>
									<div class="sub_option_settings">
										<div class="settings_line">
											<label class="description" for="uuc_settings[cdday]"><?php _e('Enter the Date', 'uuc_domain'); ?></label>
											<input class="regular-text" id="uuc_settings[cdday]" name="uuc_settings[cdday]" type="text" value="<?php if(isset($uuc_options['cdday'])) { echo $uuc_options['cdday']; } ?>"/>
											<span class="example_text"><?php _e('eg - 12', 'uuc_domain'); ?></span>
										</div>
										<div class="settings_line">
											<label class="description" for="uuc_settings[cdmonth]"><?php _e('Enter the Month', 'uuc_domain'); ?></label>
											<input class="regular-text" id="uuc_settings[cdmonth]" name="uuc_settings[cdmonth]" type="text" value="<?php if(isset($uuc_options['cdmonth'])) { echo $uuc_options['cdmonth']; } ?>"/>
											<span class="example_text"><?php _e('eg - 4', 'uuc_domain'); ?></span>
										</div>
										<div class="settings_line">
											<label class="description" for="uuc_settings[cdyear]"><?php _e('Enter the Year', 'uuc_domain'); ?></label>
											<input class="regular-text" id="uuc_settings[cdyear]" name="uuc_settings[cdyear]" type="text" value="<?php if(isset($uuc_options['cdyear'])) { echo $uuc_options['cdyear']; } ?>"/>
											<span class="example_text"><?php _e('eg - 2016', 'uuc_domain'); ?></span>
										</div>
										<div class="settings_line">
											<label class="description" for="uuc_settings[cdtext]"><?php _e('Enter the Countdown text', 'uuc_domain'); ?></label>
											<input class="regular-text" id="uuc_settings[cdtext]" name="uuc_settings[cdtext]" type="text" value="<?php if(isset($uuc_options['cdtext'])) { echo $uuc_options['cdtext']; } ?>"/>
											<span class="example_text"><?php _e('eg - Until the site goes live!', 'uuc_domain'); ?></span>
										</div>									
									</div>
								</div>
							</li>

							<li class="sub_settings">
								<div class="option_toggle">
									<label><?php _e('Progress Bar', 'uuc_domain'); ?>
										<span class="tooltip" title="Enables a progess bar on the Under Construction Page to show how far through construction the site is.">?</span>
									</label>
									<input onclick="showProgressBar()" id="progressbar_check" name="uuc_settings[progressbar]" type="checkbox" value="1" <?php checked($uuc_options['progressbar'], '1'); ?> />
									<label class="description" for="progressbar_check"><?php _e('Enable Progress Bar?','uuc_domain'); ?></label>
								</div>								
								
								<div class="sub_setting" <?php if( $uuc_options['progressbar'] == false ) { ?> style="visibility: hidden; display: none;" <?php } ?> id="progressbar_settings">
									<div class="setting_option">
										<label class="description" for="uuc_settings[progresspercent]"><?php _e('Percent Complete', 'uuc_domain'); ?></label>
										<div class="after_symbol after_percent">
											<input class="regular-text" id="uuc_settings[progresspercent]" name="uuc_settings[progresspercent]" type="text" value="<?php if(isset($uuc_options['progresspercent'])) { echo $uuc_options['progresspercent']; } ?>"/>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</section>

				<section style="display:none;">
					<ul>
						<li class="sub_settings">
							<div class="option_toggle">
								<label><?php _e('Background Style', 'uuc_domain'); ?> <span class="tooltip" title="You can choose between a solid colour, which will open a colour wheel, or choose from a selection of different backgrounds.">?</span></label>
							</div>
							<div class="uuc_settings">
								<label><input onclick="checkEm()" type="radio" name="uuc_settings[background_style]" id="solidcolor" value="solidcolor"<?php if(!isset($uuc_options['background_style'])){ ?> checked <?php } else { checked( 'solidcolor' == $uuc_options['background_style'] ); } ?> /> Solid Colour</label>
								<label><input onclick="checkEm()" type="radio" name="uuc_settings[background_style]" id="patterned" value="patterned"<?php if(isset($uuc_options['background_style'])) { checked( 'patterned' == $uuc_options['background_style'] ); } ?> /> Patterned Background</label>
							</div>
						</li>

						<li class="sub_settings">
							<?php if ( $wp_version >= 3.5 ){ ?>
							<div class="sub_setting" id="solidcolorbg" <?php if($uuc_options['background_style'] == "patterned"){ ?>style="visibility: hidden; display: none;"<?php }; ?>>
								<label><?php _e('Background Colour', 'uuc_domain'); ?> <span class="tooltip" title="Choose a background colour from the colour wheel below.">?</span></label>
								<p>
									<input name="uuc_settings[background_color]" id="background-color" type="text" value="<?php if ( isset( $uuc_options['background_color'] ) ) echo $uuc_options['background_color']; ?>" />
									<label class="description" for="uuc_settings[background_color]"><?php _e('Select the Background Colour', 'uuc_domain'); ?></label>
								</p>
							</div>
							<?php } else { ?>
							<div id="solidcolorbg" <?php if($uuc_options['background_style'] == "patterned"){ ?>style="visibility: hidden; display: none;"<?php }; ?>>
								<label><?php _e('Background Colour', 'uuc_domain'); ?> <span class="tooltip" title="Select a background colour from the colour wheel below.">?</span></label>
								<p>
								<div class="color-picker" style="position: relative;">
							        <input type="text" name="uuc_settings[background_color]" id="color" value="<?php if ( isset( $uuc_options['background_color'] ) ) echo $uuc_options['background_color']; ?>" />
							        <div style="position: absolute;" id="colorpicker"></div>
							    </div>
								</p>
							</div>
							<?php } ?>
						</li>

						<li class="sub_settings">
							<div class="sub_setting" id="patternedbg" <?php if($uuc_options['background_style'] == "solidcolor"){ ?>style="visibility: hidden; display: none;"<?php }; ?>>
								<label><?php _e('Background Choice', 'uuc_domain'); ?> <span class="tooltip" title="Choose your background from the choice below.">?</span></label>
								<ul class="uuc_patterns">
									<li>
										<input type="radio" name="uuc_settings[background_styling]" id="background_choice_squairylight" value="squairylight"<?php checked( 'squairylight' == isset($uuc_options['background_styling']) ); ?> />
										<label for="background_choice_squairylight" style="background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'images/squairylight.png'; ?>)">											
											<span class="tooltip" title="Squairy"> ?</span>
										</label>
									</li>
									<li>
										<input type="radio" id="background_choice_lightbind" name="uuc_settings[background_styling]" value="lightbind" <?php if(!isset($uuc_options['background_styling'])){ ?> checked <?php } else { checked( 'lightbind' == $uuc_options['background_styling'] ); } ?> />
										<label for="background_choice_lightbind" style="background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'images/lightbind.png'; ?>)">											
											<span class="tooltip" title="Light Binding"> ?</span>
										</label>
									</li>
									<li>
										<input type="radio" id="background_choice_darkbind" name="uuc_settings[background_styling]" value="darkbind"  <?php if(!isset($uuc_options['background_styling'])){ ?> checked <?php } else { checked( 'darkbind' == $uuc_options['background_styling'] ); } ?> />
										<label for="background_choice_darkbind" style="background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'images/darkbind.png'; ?>)">											
											<span class="tooltip" title="Dark Binding"> ?</span>
										</label>
									</li>
									<li>
										<input type="radio" id="background_choice_wavegrid" name="uuc_settings[background_styling]" value="wavegrid" <?php if(!isset($uuc_options['background_styling'])){ ?> checked <?php } else { checked( 'wavegrid' == $uuc_options['background_styling'] ); } ?> />
										<label for="background_choice_wavegrid" style="background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'images/wavegrid.png'; ?>)">											
											<span class="tooltip" title="Wavegrid"> ?</span>
										</label> 
									</li>
									<li>
										<input type="radio" id="background_choice_greywashwall" name="uuc_settings[background_styling]" value="greywashwall" <?php if(!isset($uuc_options['background_styling'])){ ?> checked <?php } else { checked( 'greywashwall' == $uuc_options['background_styling'] ); } ?> />
										<label for="background_choice_greywashwall" style="background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'images/greywashwall.png'; ?>)">											
											<span class="tooltip" title="Gray Wash Wall"> ?</span>
										</label>
									</li>
									<li>
										<input type="radio" id="background_choice_flatcardboard" name="uuc_settings[background_styling]" value="flatcardboard" <?php if(!isset($uuc_options['background_styling'])){ ?> checked <?php } else { checked( 'flatcardboard' == $uuc_options['background_styling'] ); } ?> />
										<label for="background_choice_flatcardboard" style="background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'images/flatcardboard.png'; ?>)">											
											<span class="tooltip" title="Cardboard Flat"> ?</span>
										</label> 
									</li>
									<li>
										<input type="radio" id="background_choice_pooltable" name="uuc_settings[background_styling]" value="pooltable" <?php if(!isset($uuc_options['background_styling'])){ ?> checked <?php } else { checked( 'pooltable' == $uuc_options['background_styling'] ); } ?> />
										<label for="background_choice_pooltable" style="background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'images/pooltable.png'; ?>)">											
											<span class="tooltip" title="Pool Table"> ?</span>
										</label>
									</li>
									<li>
										<input type="radio" id="background_choice_oldmaths" name="uuc_settings[background_styling]" value="oldmaths" <?php if(!isset($uuc_options['background_styling'])){ ?> checked <?php } else { checked( 'oldmaths' == $uuc_options['background_styling'] ); } ?> />
										<label for="background_choice_oldmaths" style="background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'images/oldmaths.png'; ?>)">											
											<span class="tooltip" title="Old Mathematics"> ?</span>
										</label>
									</li>
								</ul>
							</div>
						</li>
					<ul>
				</section>
				<section style="display:none;">
					<ul id="communicationbg">
						<li>
							<div class="hpy_top_row">
								<label><?php _e('Mailchimp Signup', 'uuc_domain'); ?>
									<span class="tooltip" title="If you have a MailChimp account, fill in the API KEY and the List ID below, this will enable an email sign up box on the Under Construction Page.">?</span>
								</label>
							</div>
							<div class="hpy_form_row">
								<label class="description" for="uuc_settingsms_mc_api"><?php _e('Mailchimp API Key', 'uuc_domain'); ?></label>
								<input class="regular-text" id="uuc_settings_mc_api" name="uuc_settings[mc_api_key]" type="text" value="<?php echo $uuc_options['mc_api_key']; ?>"/>
							</div>
							<div class="hpy_form_row">
								<label class="description" for="uuc_settings_mc_list"><?php _e('Mailchimp List ID', 'uuc_domain'); ?></label>
								<input class="regular-text" id="uuc_settings_mc_list" name="uuc_settings[mc_list_id]" type="text" value="<?php echo $uuc_options['mc_list_id']; ?>"/>								
							</div>
						</li>
						<li>
							<div class="hpy_top_row">
								<label><?php _e('Campaign Monitor Signup', 'uuc_domain'); ?>
									<span class="tooltip" title="If you have a Campaign Monitor account, fill in the API KEY and the List ID below, this will enable an email sign up box on the Under Construction Page.">?</span>
								</label>
							</div>
							<div class="hpy_form_row">
								<label class="description" for="uuc_settings_cm_api"><?php _e('Campaign Monitor API Key', 'uuc_domain'); ?></label>
								<input class="regular-text" id="uuc_settings_cm_api" name="uuc_settings[cm_api_key]" type="text" value="<?php echo $uuc_options['cm_api_key']; ?>"/>								
							</div>
							<div class="hpy_form_row">
								<label class="description" for="uuc_settings_cm_list"><?php _e('Campaign Monitor List ID', 'uuc_domain'); ?></label>
								<input class="regular-text" id="uuc_settings_cm_list" name="uuc_settings[cm_list_id]" type="text" value="<?php echo $uuc_options['cm_list_id']; ?>"/>								
							</div>
						</li>
						<li>
							<div class="hpy_top_row">
								<label><?php _e('Social Media', 'uuc_domain'); ?>
									<span class="tooltip" title="Only the filled out Social Media boxes below will show the on the Under Construction page.">?</span>
								</label>
								<input id="uuc_settings_sm_icons" onclick="showSocial()" name="uuc_settings[social_media]" type="checkbox" value="1" <?php checked($uuc_options['social_media'], '1'); ?>/>
								<label class="description regular-text" for="uuc_settings_sm_icons"><?php _e('Enable Social Media Icons?','uuc_domain'); ?></label>
							</div>
							<div id="hpy_social_icons" class="hpy_social_icons" <?php if( isset($uuc_options['social_media']) ) echo 'style="display:block;"';?>>
								<div class="hpy_form_row">
									<label class="description regular-text" for="uuc_settings_twitter"><?php _e('Twitter Account Name', 'uuc_domain'); ?></label>
									<input id="uuc_settings_twitter" name="uuc_settings[twitter]" type="text" value="<?php echo $uuc_options['twitter']; ?>"/>									
									</div>
								<div class="hpy_form_row">
									<label class="description regular-text" for="uuc_settings_facebook"><?php _e('Facebook Page', 'uuc_domain'); ?></label>
									<input id="uuc_settings_facebook" name="uuc_settings[facebook]" type="text" value="<?php echo $uuc_options['facebook']; ?>"/>									
								</div>
								<div class="hpy_form_row">
									<label class="description regular-text" for="uuc_settings_pinterest"><?php _e('Pinterest Link', 'uuc_domain'); ?></label>
									<input id="uuc_settings_pinterest" name="uuc_settings[pinterest]" type="text" value="<?php echo $uuc_options['pinterest']; ?>"/>									
								</div>
								<div class="hpy_form_row">
									<label class="description regular-text" for="uuc_settings_google_plus"><?php _e('Google Plus URL', 'uuc_domain'); ?></label>
									<input id="uuc_settings_google_plus" name="uuc_settings[googleplus]" type="text" value="<?php echo $uuc_options['googleplus']; ?>"/>									
								</div>
							</div>
						</li>
					</ul>
				</section>

				<section id="hpy_misc_settings" style="display:none;">
					<ul>
						<li>
							<div class="hpy_top_row">
								<label><?php _e('User Select', 'uuc_domain'); ?>
									<span class="tooltip" title="Select which user level you would like to be able to see the site whilst it is under construction.">?</span>
								</label>
							</div>
							<div class="role-options">
							<?php
								$all_roles = $wp_roles->roles;
								foreach( $all_roles as $roles ) {
									$rolename = $roles['name'];
									$role = 'user_role_' . $rolename;
									?>
										<div class="hpy_form_row">
											<input id="userrole_check_<?php echo $rolename; ?>" name="uuc_settings[<?php echo $role; ?>]" type="checkbox" value="1" <?php checked($uuc_options[ $role ], '1'); ?> />
											<label class="description" for="userrole_check_<?php echo $rolename; ?>"><?php _e( $rolename ,'uuc_domain'); ?></label>
										</div>
										
									<?php
								}
							?>
							<div>
						</li>
					</ul>
				</section>

			    <section style="display:none;">
				    <label><?php _e('Email Support', 'uuc_domain'); ?> <span class="tooltip" title="Complete the form below to contact support.">?</span></label>
				    <div class="email-form"><?php echo HPY_UUC_Email_Support::get_email_form(); ?></div>

				    <label><?php _e('Diagnostics', 'uuc_domain'); ?> <span class="tooltip" title="Useful information about your WordPress install.">?</span></label>
				    <textarea rows="20" cols="100" readonly class="diagnostics"><?php uuc_get_diagnostics(); ?></textarea>
			    </section>

				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Options', 'uuc_domain'); ?>" />
				</p>

				<script type="text/javascript">
				function checkPage() {
					if (document.getElementById("custom").checked) {
						document.getElementById("custombg").style.visibility = "visible";
						document.getElementById("custombg").style.display = "block";
						document.getElementById("communicationbg").style.visibility = "visible";
						document.getElementById("communicationbg").style.display = "block";
						document.getElementById("htmlblockbg").style.visibility = "hidden";
						document.getElementById("htmlblockbg").style.display = "none";
						document.getElementById("communication-tab").style.visibility = "visible";
						document.getElementById("communication-tab").style.display = "inline-block";
						document.getElementById("design-tab").style.visibility = "visible";
						document.getElementById("design-tab").style.display = "inline-block";
					};

					if (document.getElementById("htmlblock").checked) {
						document.getElementById("htmlblockbg").style.visibility = "visible";
						document.getElementById("htmlblockbg").style.display = "block";
						document.getElementById("custombg").style.visibility = "hidden";
						document.getElementById("custombg").style.display = "none";
						document.getElementById("communicationbg").style.visibility = "hidden";
						document.getElementById("communicationbg").style.display = "none";
						document.getElementById("communication-tab").style.visibility = "hidden";
						document.getElementById("communication-tab").style.display = "none";
						document.getElementById("design-tab").style.visibility = "hidden";
						document.getElementById("design-tab").style.display = "none";
					}

				};

				function checkEm() {
				    if (document.getElementById("solidcolor").checked) {
				  		document.getElementById("solidcolorbg").style.visibility = "visible";
				        document.getElementById("solidcolorbg").style.display = "block";
				        document.getElementById("patternedbg").style.visibility = "hidden";
				        document.getElementById("patternedbg").style.display = "none";
				    };

				    if (document.getElementById("patterned").checked) {
				        document.getElementById("patternedbg").style.visibility = "visible";
				        document.getElementById("patternedbg").style.display = "block";
						document.getElementById("solidcolorbg").style.visibility = "hidden";
				        document.getElementById("solidcolorbg").style.display = "none";
				    };
				};

				function showflipClock() {
					if (document.getElementById("flipclock_check").checked) {
						document.getElementById("flipclock_settings").style.visibility = "visible";
						document.getElementById("flipclock_settings").style.display = "block";
					} else {
						document.getElementById("flipclock_settings").style.visibility = "hidden";
						document.getElementById("flipclock_settings").style.display = "none";
					}
				}

				function showSocial(){
					if (document.getElementById("uuc_settings_sm_icons").checked) {
						document.getElementById("hpy_social_icons").style.visibility = "visible";
						document.getElementById("hpy_social_icons").style.display = "block";
					} else {
						document.getElementById("hpy_social_icons").style.visibility = "hidden";
						document.getElementById("hpy_social_icons").style.display = "none";
					}
				}

				function showProgressBar() {
					if (document.getElementById("progressbar_check").checked) {
						document.getElementById("progressbar_settings").style.visibility = "visible";
						document.getElementById("progressbar_settings").style.display = "block";
					} else {
						document.getElementById("progressbar_settings").style.visibility = "hidden";
						document.getElementById("progressbar_settings").style.display = "none";
					}
				}

				function changeActive(id) {
					document.getElementById("main-settings-tab").className = "nav-tab main-settings-tab";
					document.getElementById("design-tab").className = "nav-tab design-tab";
					document.getElementById("communication-tab").className = "nav-tab communication-tab";
					document.getElementById("advanced-settings-tab").className = "nav-tab advanced-settings-tab";
					//document.getElementById("support-tab").className = "nav-tab support-tab";
					document.getElementById(id.id).className += " nav-tab-active";
				}
	    		</script>

	    		<script>
				  jQuery(function() {
				    jQuery( document ).tooltip();
				  });
				</script>
				<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
				<script src="//code.jquery.com/jquery-1.10.2.js"></script>
				<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
			</form>

		</div>
	</div>
</div>
	<?php echo ob_get_clean();
}

function admin_register_head() {
    $siteurl = get_option('siteurl');
    $url = $siteurl . '/wp-content/plugins/ultimate-under-construction/includes/css/plugin_styles.css';
    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}
add_action('admin_head', 'admin_register_head');

function uuc_add_options_link() {
	//add_submenu_page('tools.php', 'Ultimate Under Construction Plugin Options', 'Under Construction', 'manage_options', 'uuc-options', 'uuc_options_page');
	$my_admin_page = add_submenu_page('tools.php', 'Ultimate Under Construction Plugin Options', 'Under Construction', 'manage_options', 'uuc-options', 'uuc_options_page');

	add_action('load-'.$my_admin_page, 'uuc_add_help_tab');
}
add_action('admin_menu', 'uuc_add_options_link');

function uuc_register_settings() {
	register_setting('uuc_settings_group', 'uuc_settings');
}
add_action('admin_init', 'uuc_register_settings');

function tip( $message, $title = '', $echo_tip = true ) {
	$tip = ' <a class="uuc_tolltip" title="' . $title . ' - ' . $message . '"><img src="' . pb_backupbuddy::plugin_url() . '/pluginbuddy/images/pluginbuddy_tip.png" alt="?" /></a>';
	if ( $echo_tip === true ) {
		echo $tip;
	} else {
		return $tip;
	}
}

function uuc_add_help_tab () {
    $screen = WP_Screen::get(__FILE__);

    $screen->add_help_tab( array(
        'id'	=> 'uuc_help_tab',
        'title'	=> __('Under Construction Help'),
        'content'	=> '<p>' . __( 'Descriptive content that will show in My Help Tab-body goes here.' ) . '</p>',
    ) );

    $screen->set_help_sidebar('<a href="#">Pro Version?!</a>');
}

function uuc_get_diagnostics() {
	global $wpdb;
	$theme_info = wp_get_theme();
	$active_plugins = (array) get_option( 'active_plugins', array() );


//	$url = 'https://api.wordpress.org/core/version-check/1.6/';
//	$request = array( 'timeout' => 15, 'request' => serialize( 'offers' ) );
//	$response = wp_remote_post( $url, array( 'body' => $request ) );
//	$response = json_decode( $response['body'] );

	echo 'Site Information: ';
	echo "\r\n\r\n";

	echo 'Site URL: ';
	echo esc_html( site_url() );
	echo "\r\n";

	echo 'WordPress Version: ';
	echo bloginfo( 'version' );
	if ( is_multisite() ) {
		echo ' Multisite';
	}
	echo "\r\n\r\n\r\n";

	echo 'Server Information: ';
	echo "\r\n\r\n";

	echo 'Web Server: ';
	echo esc_html( ! empty( $_SERVER['SERVER_SOFTWARE'] ) ? $_SERVER['SERVER_SOFTWARE'] : '' );
	echo "\r\n";

	echo 'PHP Version: ';
	if ( function_exists( 'phpversion' ) ) {
		echo esc_html( phpversion() );
	}
	echo "\r\n";

	echo 'MySQL Version: ';
	echo esc_html( empty( $wpdb->use_mysqli ) ? mysql_get_server_info() : mysqli_get_server_info( $wpdb->dbh ) );
	echo "\r\n";

	echo 'Debug Mode: ';
	echo esc_html( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? 'Yes' : 'No' );
	echo "\r\n\r\n\r\n";

	echo 'Theme & Plugin Information: ';
	echo "\r\n\r\n";

	echo 'Active Theme: ';
	echo esc_html( $theme_info->name );
	echo "\r\n";

	echo 'Active Plugins: ';
	echo "\r\n";
	foreach( $active_plugins as $plugin ) {
		echo uuc_get_plugin_information( WP_PLUGIN_DIR . '/' . $plugin );
	}

}

function uuc_get_plugin_information( $plugin_path ) {
	$plugin = get_plugin_data( $plugin_path );
	if ( empty( $plugin['Name'] ) ) {
		return;
	}

	printf( "%s (%s): %s \r\n", $plugin['Name'], $plugin['Version'], $plugin['AuthorName'] );
}