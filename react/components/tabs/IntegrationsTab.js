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
			</div>
		)
	}
}

IntegrationsTab.propTypes = {
    settings: PropTypes.object,
	onUpdate: PropTypes.func
};