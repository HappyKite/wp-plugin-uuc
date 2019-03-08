import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class SettingNumber extends Component {

    render(){
        return(
            <p className="uuc--setting_row uuc--textbox">
                <label htmlFor={ this.props.name }>{ this.props.label }</label>
                <input
                    name={ "uuc-setting[" + this.props.name + "]" }
                    id={ this.props.name }
                    value={ this.props.value || '' }
                    type="number"
                    onChange={ this.props.onUpdate }
                />
            </p>
        );
    }
}

SettingNumber.propTypes = {
    label: PropTypes.string,
    value: PropTypes.string,
    name: PropTypes.string,
    onUpdate: PropTypes.func
};