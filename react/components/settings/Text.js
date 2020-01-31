import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class Text extends Component {

    render(){
        return(
            <p className="uuc--setting_row uuc--textbox">
                <label htmlFor={ this.props.name } className="uuc--label">{ this.props.label }</label>
                <input
                    name={ this.props.name }
                    id={ this.props.id }
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
	id: PropTypes.string,
    onUpdate: PropTypes.func
};