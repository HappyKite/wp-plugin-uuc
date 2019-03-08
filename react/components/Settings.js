import React, { Component } from 'react';
import PropTypes from 'prop-types';
import Text from './settings/Text';
import Number from './settings/Number';
import Editor from './settings/Editor';
import Save from './settings/Save';

export default class Settings extends Component {

    render(){
        if ( this.props.section === 'main' ) {
            return (
                <div className="uuc--settings">
                    <Text onUpdate={ this.props.onUpdate } name="page_title" value={ this.props.state['setting_page_title'] } label="Page Title" />
                    <Number onUpdate={ this.props.onUpdate } name="holding_message" value={ this.props.state['setting_holding_message'] } label="Holding Message" />
                    <Editor onUpdate={ this.props.onUpdate } name="countdown" value={ this.props.state['setting_countdown'] } label="Countdown" /> 
                    <Text onUpdate={ this.props.onUpdate } name="progress" value={ this.props.state['setting_progress'] } label="Progress" />
                    <Save onSave={ this.onSave } />
                </div>
            );
        } else if ( this.props.section === 'styling' ) {
            return (
                <div className="uuc--settings">
                    <Text onUpdate={ this.props.onUpdate } name="other-text" value={ this.props.state['setting_logo'] } label="Logo" />
                    <Save onSave={ this.props.onSave } />
                </div>
            );
        } else{
            return (
                <div className="uuc--settings">
                    <Save onSave={ this.props.onSave } />
                </div>
            );
        }
    }
}

Settings.propTypes = {
    state: PropTypes.object,
    section: PropTypes.string,
    onUpdate: PropTypes.func,
    onSave: PropTypes.func
};