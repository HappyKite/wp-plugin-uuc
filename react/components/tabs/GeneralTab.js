import React, { Component } from 'react';
import PropTypes from 'prop-types';
import Text from '../settings/Text';
import Checkbox from '../settings/Checkbox';
import Editor from '../settings/Editor';

export default class GeneralTab extends Component {

	render(){
		return (
			<div className="uuc--settings">
				<Text 
					name="page_title"
					id="page_title"
					label="Page Title"
					value={ this.props.settings['page_title'] }
					onUpdate={ this.props.onUpdate }
				/>
				<Editor
					name="holding_message"
					id="holding_message"
					label="Holding Message"
					editor={ this.props.settings['holding_message'] }
					onUpdate={ this.props.updateSetting }
				/>
				<Checkbox 
					name="countdown"
					id="countdown"
					label="Countdown"
					value="countdown"
					checked={ this.props.settings['countdown'] === true }
					onUpdate={ this.props.onUpdate }
				/> 
				<Checkbox
					name="progress"
					id="progress"
					label="Progress"
					value="progress"
					checked={ this.props.settings['progress'] === true }
					onUpdate={ this.props.onUpdate }
				/>
			</div>
		)
	}
}

GeneralTab.propTypes = {
    settings: PropTypes.object,
	onUpdate: PropTypes.func,
	updateSetting: PropTypes.func
};