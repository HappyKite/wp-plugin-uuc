import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class SettingMain extends Component {

    render(){
        return(
            <label>
                Text input
                <input
                    name="uuc-setting[text-input]"
                    type="text"
                    onChange={ this.props.onUpdate }
                />
            </label>
        );
    }
}

SettingMain.propTypes = {
    width:PropTypes.number,
    height: PropTypes.number,
    onUpdate: PropTypes.func
};