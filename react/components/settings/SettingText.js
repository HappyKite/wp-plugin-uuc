import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class SettingText extends Component {

    render(){
        return(
            <label id={ this.props.name }>
                Text input
                <input
                    name={ "uuc-setting[" + this.props.name + "]" }
                    id={ this.props.name }
                    value={ this.props.value }
                    type="text"
                    onChange={ this.props.onUpdate }
                />
            </label>
        );
    }
}

SettingText.propTypes = {
    value: PropTypes.string,
    name: PropTypes.string,
    onUpdate: PropTypes.func
};