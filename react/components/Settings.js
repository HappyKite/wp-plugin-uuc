import React, { Component } from 'react';
import PropTypes from 'prop-types';
import Text from './settings/SettingText';

export default class Settings extends Component {

    components = {
        main: Text,
    };

    render(){

        if( this.props.section === 'main' ){
            return (
                <Text onUpdate={ this.props.onUpdate } name="main-text" value={ this.props.state['setting_main-text'] } />
            );
        } else{
            return (
                <Text onUpdate={ this.props.onUpdate } name="other-text" value={ this.props.state['setting_other-text'] } />
            );
        }
        
    }
}

Settings.propTypes = {
    state: PropTypes.object,
    section: PropTypes.string,
    onUpdate: PropTypes.func
};