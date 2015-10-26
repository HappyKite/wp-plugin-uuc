<?php

/* display functions for outputting data */

add_filter('get_header', 'uuc_add_content');

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
		<script language="JavaScript">
		TargetDate = "<?php echo $uuc_options['cdmonth'], '/', $uuc_options['cdday'], '/', $uuc_options['cdyear']; ?>";
		CountActive = true;
		CountStepper = -1;
		LeadingZero = true;
		DisplayFormat = "%%D%% Days, %%H%% Hours, %%M%% Minutes, %%S%% Seconds ";
		FinishMessage = "It is finally here!";
		</script>

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

		<script src="http://code.jquery.com/jquery-latest.min.js"></script>

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

		if(!is_admin() && !is_user_logged_in() && $uuc_options['enable'] == true && $uuc_options['holdingpage_type'] == "htmlblock"){
			
			$html .= '<div class="uuc-holdingpage">';
			if(isset($uuc_options['html_block'])) {
				$html .= $uuc_options['html_block'];
			}
			$html .= '</div>';
			echo $html; exit;
		}
		elseif(!is_admin() && !is_user_logged_in() && $uuc_options['enable'] == true){
			
			if (isset($uuc_options['background_style']) && $uuc_options['background_style'] == "solidcolor") {
				if (isset($uuc_options['background_color'])) {?>
					<style type="text/css">
						body { background-color: <?php echo $uuc_options['background_color']; ?> }
						.uuc-holdingpage { text-align: center; padding-top: 250px; }
					</style>
				<?php }
			} else if (isset($uuc_options['background_style']) && $uuc_options['background_style'] == "patterned") {
				if (!isset($uuc_options['background_styling'])) {?>
					<style type="text/css">
						body { background: url(<?php echo plugin_dir_url(__FILE__) . '/images/oldmaths.png' ?>); }
						.uuc-holdingpage { text-align: center; padding-top: 250px; }
					</style>
				<?php } elseif (isset($uuc_options['background_styling'])) {
					if ($uuc_options['background_styling'] == "darkbind") {?>	
					<style type="text/css">
						body { background: url(<?php echo plugin_dir_url(__FILE__) . 'images/' . $uuc_options['background_styling'].'.png' ?>); }
						.uuc-holdingpage { text-align: center; color: #909090; padding-top: 250px; }
					</style>
					<?php } else { ?>			
					<style type="text/css">
						body { background: url(<?php echo plugin_dir_url(__FILE__) . 'images/' . $uuc_options['background_styling'].'.png' ?>); }
						.uuc-holdingpage { text-align: center; padding-top: 250px; }
					</style>
					<?php }
				}
			}

			$html .= '<div class="uuc-holdingpage">';
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
				echo "Insert Code for Progress Bar!";
			}

			if(isset($uuc_options['mc_api_key'])) {
				// $html .= '<form action="" method="post">';
				// 	$html .= '<input type="text" id="customer-email" />';
				// 	$html .= '<input type="button" value="Add me to mailing list" />';
				// 	$html .= '<input type="hidden" name="button_pressed" value="1" />';
				// $html .= '</form>';

				$html .= '<div class="message"></div>';

				$html .= '<form  role="form" method="post" id="subscribe">';
				    
				    $html .= '<input type="email"  id="email" name="email" placeholder="you@yourself.com" value="">';
				    $html .= '<button type="submit">SUBSCRIBE</button>';
				    
				$html .= '</form>';

			}

			if(isset($uuc_options['cm_api_key'])) {
				$html .= '<div class="cm-message"></div>';

				$html .= '<form  role="form" method="post" id="cm-subscribe">';
				    
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
					$html .= '<li class="twitter"><a href="http://www.twitter.com/' . $uuc_options['twitter'] . '">Twitter</a> | </li>';
					$html .= '<li class="facebook"><a href="http://www.facebook.com/' . $uuc_options['facebook'] . '">Facebook</a> | </li>';
					$html .= '<li class="pinterest"><a href="http://www.pinterest.com/' . $uuc_options['pinterest'] . '">Pinterest</a> | </li>';
					$html .= '<li class="googleplus"><a href="http://plus.google.com/' . $uuc_options['googleplus'] . '">Google Plus</a></li>';
				$html .= '</ul>';
				$html .= '</div>';
			}

			$html .= '</div>';
			echo $html; 
			?>
			<?php exit;
		}
	}
}