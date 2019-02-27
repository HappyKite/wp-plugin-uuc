import React, { Component } from 'react';
import PropTypes from 'prop-types';
import SettingMain from './settings/SettingMain';

export default class Settings extends Component {

    components = {
        main: SettingMain,
    };

    render(){
        const Setting = this.components[ this.props.id || 'main' ];
        return <Setting onUpdate={ this.props.onUpdate } />
    }
}

Settings.propTypes = {
    id: PropTypes.string,
    onUpdate: PropTypes.func
};