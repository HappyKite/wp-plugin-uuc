import React, { Component } from 'react';
import PropTypes from 'prop-types';
import Checkbox from '../settings/Checkbox';

export default class MiscTab extends Component {
	
	render(){
		return (
			<div className="uuc--settings">
				<Checkbox
					name="user_role_Administrator"
					id="user_role_Administrator"
					label="Administrator"
					value="administrator"
					checked={ this.props.settings['user_role_Administrator'] === true }
					onUpdate={ this.props.onUpdate }
				/>
				<Checkbox
					name="user_role_Editor"
					id="user_role_Editor"
					label="Editor"
					value="editor"
					checked={ this.props.settings['user_role_Editor'] === true }
					onUpdate={ this.props.onUpdate }
				/>
				<Checkbox
					name="user_role_Author"
					id="user_role_Author"
					label="Author"
					value="author"
					checked={ this.props.settings['user_role_Author'] === true }
					onUpdate={ this.props.onUpdate }
				/>
				<Checkbox
					name="user_role_Contributor"
					id="user_role_Contributor"
					label="Contributor"
					value="contributor"
					checked={ this.props.settings['user_role_Contributor'] === true }
					onUpdate={ this.props.onUpdate }
				/>
				<Checkbox
					name="user_role_Subscriber"
					id="user_role_Subscriber"
					label="Subscriber"
					value="subscriber"
					checked={ this.props.settings['user_role_Subscriber'] === true }
					onUpdate={ this.props.onUpdate }
				/>
			</div>
		)
	}
}

MiscTab.propTypes = {
    settings: PropTypes.object,
	onUpdate: PropTypes.func,
};