import React, { Component } from 'react';
import PropTypes from 'prop-types';
import Checkbox from '../settings/Checkbox';
import Text from '../settings/Text';

export default class IntegrationsTab extends Component {

	render(){
		return (
			<div className="uuc--settings">
				<h3>Mailchimp Signup</h3>
				<Text 
					name="mc_api_key"
					id="mc_api_key"
					label="Mailchimp API key"
					value={ this.props.settings['mc_api_key'] }
					onUpdate={ this.props.onUpdate }
				/>
				<Text 
					name="mc_list_id"
					id="mc_list_id"
					label="Mailchimp List ID"
					value={ this.props.settings['mc_list_id'] }
					onUpdate={ this.props.onUpdate }
				/>

				<h3>Campaign Monitor Signup</h3>
				<Text 
					name="cm_api_key"
					id="cm_api_key"
					label="Campaign Monitor API Key"
					value={ this.props.settings['cm_api_key'] }
					onUpdate={ this.props.onUpdate }
				/>
				<Text 
					name="cm_list_id"
					id="cm_list_id"
					label="Campaign Monitor List ID"
					value={ this.props.settings['cm_list_id'] }
					onUpdate={ this.props.onUpdate }
				/>

				<h3>Social Media</h3>
				<Checkbox
					name="social_media"
					id="social_media"
					label="Enable Social Media Icons?"
					value="social_media"
					checked={ this.props.settings['social_media'] === true }
					onUpdate={ this.props.onUpdate }
				/>
				{
					this.props.settings['social_media'] === true ?
						<React.Fragment>
							<Text 
								name="social_media_twitter"
								id="social_media_twitter"
								label="Twitter Account Name"
								value={ this.props.settings['social_media_twitter'] }
								onUpdate={ this.props.onUpdate }
							/>
							<Text 
								name="social_media_facebook"
								id="social_media_facebook"
								label="Facebook Page"
								value={ this.props.settings['social_media_facebook'] }
								onUpdate={ this.props.onUpdate }
							/>
							<Text 
								name="social_media_pinterest"
								id="social_media_pinterest"
								label="Pinterest Link"
								value={ this.props.settings['social_media_pinterest'] }
								onUpdate={ this.props.onUpdate }
							/>
							<Text 
								name="social_media_google_plus"
								id="social_media_google_plus"
								label="Google Plus URL"
								value={ this.props.settings['social_media_google_plus'] }
								onUpdate={ this.props.onUpdate }
							/>
						</React.Fragment>
					: ''
				}
			</div>
		)
	}
}

IntegrationsTab.propTypes = {
    settings: PropTypes.object,
	onUpdate: PropTypes.func
};