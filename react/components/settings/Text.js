import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class Text extends Component {

    render(){
        return(
            <p className="uuc--setting_row uuc--textbox">
                <label htmlFor={ this.props.name }>{ this.props.label }</label>
                <input
                    name={ "uuc-setting[" + this.props.name + "]" }
                    id={ this.props.name }
                    value={ this.props.value || '' }
                    type="text"
                    onChange={ this.props.onUpdate }
                />
            </p>
        );
    }
}

Text.propTypes = {
    label: PropTypes.string,
    value: PropTypes.string,
    name: PropTypes.string,
    onUpdate: PropTypes.func
};