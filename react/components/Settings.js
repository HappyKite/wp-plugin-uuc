import React, { Component } from 'react';
import PropTypes from 'prop-types';
import Text from './settings/Text';
// import Number from './settings/Number';
import Checkbox from './settings/Checkbox';
import Editor from './settings/Editor';
import Save from './settings/Save';

export default class Settings extends Component {
	

    render(){
        if ( this.props.section === 'main' ) {
            return (
                <div className="uuc--settings">
                    <Text 
						name="page_title"
						label="Page Title"
						value={ this.props.settings['page_title'] }
						onUpdate={ this.props.onUpdate }
						
					/>
                    <Editor
						name="holding_message"
						label="Holding Message"
						editor={ this.props.settings['holding_message'] }
						onUpdate={ this.props.updateEditor }
					/>
                    <Checkbox 
						name="countdown"
						label="Countdown"
						value={ this.props.settings['countdown'] }
						onUpdate={ this.props.onUpdate }
					/> 
                    <Checkbox
						name="progress"
						label="Progress"
						value={ this.props.settings['progress'] }
						onUpdate={ this.props.onUpdate }
					/>
                    <Save onSave={ this.onSave } />
                </div>
            );
        } else if ( this.props.section === 'design' ) {
            return (
                <div className="uuc--settings">
                    <Text
						onUpdate={ this.props.onUpdate }
						name="other-text"
						value={ this.props.settings['logo'] }
						label="Logo"
							
						/>
                    <Save onSave={ this.props.onSave } />
                </div>
            );
        } else if ( this.props.section === 'integrations' ) {
            return (
                <div className="uuc--settings">
                    <Save onSave={ this.props.onSave } />
                </div>
            );
        } else if ( this.props.section === 'misc' ) {
            return (
                <div className="uuc--settings">
                    <Save onSave={ this.props.onSave } />
                </div>
            );
        }
    }
}

Settings.propTypes = {
    settings: PropTypes.object,
    section: PropTypes.string,
	onUpdate: PropTypes.func,
	updateEditor: PropTypes.func,
    onSave: PropTypes.func
};