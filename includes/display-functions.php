<?php

/* display functions for outputting data */
add_action( 'get_header', 'uuc_user_check', 1 );
function uuc_user_check(){
	//Using the new $uuc_options value for user_role_$rolename check the allowed user roles and let them see the site, otherwise load UUC.
	global $uuc_options, $wp_roles, $current_user;

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

	if ( is_user_logged_in() ) {
		$user_roles = $current_user->roles;
		$user_role = array_shift($user_roles);

		if ( is_null($allowed) ){
				return uuc_add_content();
		}

		if ( in_array( $user_role, $allowed ) ) {
			return;
		} else {
			return uuc_add_content();
		}

	} else {
		return uuc_add_content();
	}
}

function uuc_add_content() {
	global $uuc_options;
	
	//Current version of WP seems to fall over on unticked Checkboxes... This is to tidy it up and stop unwanted 'Notices'
	//Enable Checkbox Sanitization
	if ( ! isset( $uuc_options['enable'] ) || $uuc_options['enable'] != '1' )
	  $uuc_options['enable'] = 0;
	else
	  $uuc_options['enable'] = 1;

	//Countdown Checkbox Sanitization
	if ( ! isset( $uuc_options['cdenable'] ) || $uuc_options['cdenable'] != '1' )
	  $uuc_options['cdenable'] = 0;
	else
	  $uuc_options['cdenable'] = 1;

	if ($uuc_options['enable'] == 1) {

		?>
		<!DOCTYPE html>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script language="JavaScript">
		TargetDate = "<?php echo $uuc_options['cdmonth'], '/', $uuc_options['cdday'], '/', $uuc_options['cdyear']; ?>";
		CountActive = true;
		CountStepper = -1;
		LeadingZero = true;
		DisplayFormat = "%%D%% Days, %%H%% Hours, %%M%% Minutes, %%S%% Seconds ";
		FinishMessage = "It is finally here!";
		</script>

		<title><?php echo get_bloginfo(); ?></title>

		<script>
		function sendEmailAddress() {
			var customerEmail = document.getElementById('customer-email').value;
			var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
			if (re.test(customerEmail)) {
				console.log("correct email");
			} else {
				console.log("incorrect email");
			}
		}

		</script>

		<?php if ( isset( $uuc_options['gf_name'] ) ) {
			$font = ucwords( $uuc_options['gf_name'] );
			$font_css = str_replace( '+', ' ', $font );
			$font = str_replace( ' ', '+', $font );
			?>
			<link href="https://fonts.googleapis.com/css?family=<?php echo $font; ?>" rel="stylesheet">
			<style>
				html, * {
					font-family: '<?php echo $font_css; ?>', sans-serif !important;
				}
				.flip-clock-wrapper{ font: normal 11px '<?php echo $font_css; ?>', sans-serif !important; }
			</style>
		<?php } else { ?>
			<link href="https://fonts.googleapis.com/css?family=Verdana" rel="stylesheet">
			<style>
				body {
					font-family: Verdana, sans-serif;
				}
			</style>
		<?php } ?>

		<?php if ( isset( $uuc_options['font_color'] ) ) { ?>
			<style>
				body .uuc-holdingpage {
					color: <?php echo $uuc_options['font_color']; ?> !important;
				}
			</style>
		<?php } ?>

		<?php
		echo '<script src="' . plugin_dir_url(__FILE__) . 'js/base.js"></script>';
		echo '<script src="' . plugin_dir_url(__FILE__) . 'js/flipclock.js"></script>';
		echo '<script src="' . plugin_dir_url(__FILE__) . 'js/dailycounter.js"></script>';
		echo '<link rel="stylesheet" href="' . plugin_dir_url(__FILE__) . 'css/flipclock.css">';
		echo '<link rel="stylesheet" href="' . plugin_dir_url(__FILE__) . 'css/plugin_styles.css">';
		$html = '';
		?> 

		<script type="text/javascript">
			var clock;

			$(document).ready(function() {

				// Grab the current date
				var currentDate = new Date();

				// Set some date in the future.
				var selecteddate  = new Date("<?php echo $uuc_options['cdyear'], '/', $uuc_options['cdmonth'], '/', $uuc_options['cdday']; ?>");

				// Calculate the difference in seconds between the future and current date
				var diff1 = selecteddate.getTime() / 1000 - currentDate.getTime() / 1000;

				var diff = (diff1 <= 0) ? "0": diff1;

				// Instantiate a coutdown FlipClock

				clock = $('.clock').FlipClock(diff, {
					clockFace: 'DailyCounter',
					countdown: true
				});
			});	

			$(document).ready(function() {
			    $('#subscribe').submit(function() {
			        if (!valid_email_address($("#email").val()))
			        {
			            $(".message").html('The email address you entered was invalid. Please make sure you enter a valid email address to subscribe.');
			        }
			        else
			        {
			            
			            $(".message").html("<span style='color:green;'>Adding your email address...</span>");
			            post_email = $('#email').val();
			            $.ajax({
			                data: { "email":post_email, "api_key":'<?php echo $uuc_options["mc_api_key"]; ?>', "list_id":'<?php echo $uuc_options["mc_list_id"]; ?>' },
			                url: '<?php echo plugins_url(); ?>/ultimate-under-construction/includes/subscribe.php',
			                type: 'POST',
			                success: function(msg) {
			                    if(msg=="success")
			                    {
			                        $("#email").val("");
			                        $(".message").html('<span style="color:green;">You have successfully subscribed to our mailing list.</span>');
			                        
			                    }
			                    else
			                    {
			                      $(".message").html(msg);
			                    }
			                }
			            });
			        }

			        return false;
			    });
			});

			$(document).ready(function() {
			    $('#cm-subscribe').submit(function() {
			        if (!valid_email_address($("#cm-email").val()))
			        {
			            $(".cm-message").html('The email address you entered was invalid. Please make sure you enter a valid email address to subscribe.');
			        }
			        else
			        {
			            
			            $(".cm-message").html("<span style='color:green;'>Adding your email address...</span>");
			            cm_post_email = $('#cm-email').val();
			            cm_post_name = $('#cm-name').val();
			            $.ajax({
			                data: { "cm_email":cm_post_email, "cm_name":cm_post_name, "cm_api_key":'<?php echo $uuc_options["cm_api_key"]; ?>', "cm_list_id":'<?php echo $uuc_options["cm_list_id"]; ?>' },
			                url: '<?php echo plugins_url(); ?>/ultimate-under-construction/includes/CMSubscribe.php',
			                type: 'POST',
			                success: function(msg) {
			                    if(msg=="Success")
			                    {
			                        $("#cm-email").val("");
			                        $(".cm-message").html('<span style="color:green;">You have successfully subscribed to our mailing list.</span>');
			                        
			                    }
			                    else
			                    {
			                      $(".cm-message").html(msg);
			                    }
			                }
			            });
			        }

			        return false;
			    });
			});

			function valid_email_address(email)
			{
			    var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
			    return pattern.test(email);
			}
		</script>	
		<?php

		if(isset($uuc_options['cdday'])){
			$entereddate = ($uuc_options['cdyear'] . "-" . $uuc_options['cdmonth'] . "-" . $uuc_options['cdday'] . " " . "00:00:00");
			$cddates = strtotime($entereddate);
		}

		if( $uuc_options['enable'] == true && $uuc_options['holdingpage_type'] == "htmlblock" ){
			
			$html .= '<div class="uuc-holdingpage">';
			if(isset($uuc_options['html_block'])) {
				$html .= $uuc_options['html_block'];
			}
			$html .= '</div>';
			echo $html; exit;
		}
		elseif( $uuc_options['enable'] == true ){
			
			if (isset($uuc_options['background_style']) && $uuc_options['background_style'] == "solidcolor") {
				if (isset($uuc_options['background_color'])) {?>
					<style type="text/css">
						body { background-color: <?php echo $uuc_options['background_color']; ?> }
					</style>
				<?php }
			} else if (isset($uuc_options['background_style']) && $uuc_options['background_style'] == "patterned") {
				if (!isset($uuc_options['background_styling'])) {?>
					<style type="text/css">
						body { background: url(<?php echo plugin_dir_url(__FILE__) . '/images/oldmaths.png' ?>); }
					</style>
				<?php } elseif (isset($uuc_options['background_styling'])) {
					if ($uuc_options['background_styling'] == "darkbind") {?>	
					<style type="text/css">
						body { background: url(<?php echo plugin_dir_url(__FILE__) . 'images/' . $uuc_options['background_styling'].'.png' ?>); }
					</style>
					<?php } else { ?>			
					<style type="text/css">
						body { background: url(<?php echo plugin_dir_url(__FILE__) . 'images/' . $uuc_options['background_styling'].'.png' ?>); }
					</style>
					<?php }
				}
			}

			$html .= '<div class="uuc-holdingpage"><div class="uuc-inner">';
			$html .= '<img class="uuc-site-logo" src="' . $uuc_options['site_logo'] . '" alt="Logo">';
			$html .= '<h1>' . $uuc_options['website_name'] . '</h1>';
			if(isset($uuc_options['holding_message'])) {
				$html .= '<h2>' . $uuc_options['holding_message'] . '</h2>';
			}
			

			$htmlpart = '';

			if($uuc_options['cdenable'] == true){

				if($uuc_options['cd_style'] == "flipclock"){
					$html .= '<div class="cddiv"><div class="clock" style="margin:2em;"></div></div>';
				}
				elseif($uuc_options['cd_style'] == "textclock"){
					if($cddates > time()){
						$htmlpart = '<h3>' . '<script src="' . plugin_dir_url(__FILE__) . 'js/countdown.js" language="JavaScript" type="text/JavaScript"></script>';
						$htmlpart .= ' ' . $uuc_options['cdtext'] . '</h3>';
					}
					else{
						$htmlpart = '<h3>' . '<script src="' . plugin_dir_url(__FILE__) . 'js/countdown.js" language="JavaScript" type="text/JavaScript"></script>'; 
						$htmlpart .= '</h3>';
					}
				}
				$html .= $htmlpart;
			}

			if( $uuc_options['progressbar'] == true ){
				$html .= '<div id="hpy_progressbar">';

				$html .= '<div class="hpy_progress_inner" style=" width:' . $uuc_options['progresspercent'] . '%; background: '. $uuc_options['progressbar_color'] . '"></div>';
				
				$html .= '</div>';
			}

			if( !empty($uuc_options['mc_api_key']) && !empty($uuc_options['cm_api_key']) ){
				$mail_headings = true;
			}else{
				$mail_headings = false;
			}

			if( !empty($uuc_options['mc_api_key']) ) {
				// $html .= '<form action="" method="post">';
				// 	$html .= '<input type="text" id="customer-email" />';
				// 	$html .= '<input type="button" value="Add me to mailing list" />';
				// 	$html .= '<input type="hidden" name="button_pressed" value="1" />';
				// $html .= '</form>';

				$html .= '<div class="message"></div>';

				$html .= '<form role="form" method="post" id="subscribe" class="uuc_email_form">';
				    if( $mail_headings ) $html .= '<img src="' . plugin_dir_url(__FILE__) . 'images/mailchimp.png" alt="Campaign Monitor Logo" />';
				    $html .= '<input type="email"  id="email" name="email" placeholder="you@yourself.com" value="">';
				    $html .= '<button type="submit">SUBSCRIBE</button>';
				    
				$html .= '</form>';

			}

			if( !empty($uuc_options['cm_api_key']) ) {
				$html .= '<div class="cm-message"></div>';

				$html .= '<form role="form" method="post" id="cm-subscribe" class="uuc_email_form">';
				   if( $mail_headings ) $html .= '<img src="' . plugin_dir_url(__FILE__) . 'images/campaign.png" alt="Campaign Monitor Logo" />';
				    $html .= '<input type="email"  id="cm-email" name="cm-email" placeholder="you@yourself.com" value="">';
				    $html .= '<input type="name" id="cm-name" name="cm-name" placeholder="Your Name" value="" >';
				    $html .= '<button type="submit">SUBSCRIBE</button>';
				    
				$html .= '</form>';
			}

			// if(isset($_POST['button_pressed']))
			// {
			//     $to      = 'mike@happykite.co.uk';
			//     $subject = 'the subject';
			//     $message = $uuc_options['email'] . ' wants to be added to your mailing list';
			//     $headers = 'From: webmaster@example.com' . "\r\n" .
			//         'Reply-To: webmaster@example.com' . "\r\n" .
			//         'X-Mailer: PHP/' . phpversion();

			//     mail($to, $subject, $message, $headers);
			// }


			if($uuc_options['social_media'] == true ) {
				$html .= '<div class="social-media">';
				$html .= '<ul>';

					if( !empty( $uuc_options['twitter'] ) && '' !== $uuc_options['twitter'] ){
						$html .= '<li class="twitter"><a href="http://www.twitter.com/' . $uuc_options['twitter'] . '">Twitter</a></li>';
					}
					
					if( !empty( $uuc_options['facebook'] ) && '' !== $uuc_options['twitter'] ){
						$html .= '<li class="facebook"><a href="http://www.facebook.com/' . $uuc_options['facebook'] . '">Facebook</a></li>';
					}

					if( !empty( $uuc_options['pinterest'] ) && '' !== $uuc_options['twitter'] ){
						$html .= '<li class="pinterest"><a href="http://www.pinterest.com/' . $uuc_options['pinterest'] . '">Pinterest</a></li>';
					}

					if( !empty( $uuc_options['googleplus'] ) && '' !== $uuc_options['twitter'] ){
						$html .= '<li class="googleplus"><a href="http://plus.google.com/' . $uuc_options['googleplus'] . '">Google Plus</a></li>';
					}
					
				$html .= '</ul>';
				$html .= '</div>';
			}

			$html .= '</div></div>';
			echo $html; 
			?>
			<?php exit;
		}
	}
}