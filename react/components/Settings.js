import React, { Component } from 'react';
import PropTypes from 'prop-types';
import Text from './settings/SettingText';
import Number from './settings/SettingNumber';
import Editor from './settings/SettingEditor';

export default class Settings extends Component {

    components = {
        main: Text,
    };

    render(){

        if ( this.props.section === 'main' ) {
            return (
                <div className="uuc--settings">
                    <Text onUpdate={ this.props.onUpdate } name="page_title" value={ this.props.state['setting_page_title'] } label="Page Title" />
                    <Number onUpdate={ this.props.onUpdate } name="holding_message" value={ this.props.state['setting_holding_message'] } label="Holding Message" />
                    <Editor onUpdate={ this.props.onUpdate } name="countdown" value={ this.props.state['setting_countdown'] } label="Countdown" /> 
                    <Text onUpdate={ this.props.onUpdate } name="progress" value={ this.props.state['setting_progress'] } label="Progress" />
                </div>
            );
        } 

        if ( this.props.section === 'styling' ) {
            return (
                <div className="uuc--settings">
                    <Text onUpdate={ this.props.onUpdate } name="other-text" value={ this.props.state['setting_logo'] } label="Logo" />
                </div>
            );
        }
        
    }
}

Settings.propTypes = {
    state: PropTypes.object,
    section: PropTypes.string,
    onUpdate: PropTypes.func
};