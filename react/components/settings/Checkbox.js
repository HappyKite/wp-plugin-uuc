import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class Checkbox extends Component {

    render(){
        return(
            <p className="uuc--setting_row uuc--checkbox">
                <label htmlFor={ this.props.name }>
					<input
						name={ "uuc-setting[" + this.props.name + "]" }
						id={ this.props.name }
						type="checkbox"
						checked={ this.props.checked }
						onChange={ this.props.onUpdate }
					/>
					{ this.props.label }
				</label>
            </p>
        );
    }
}

Checkbox.propTypes = {
    label: PropTypes.string,
    checked: PropTypes.bool,
    name: PropTypes.string,
    onUpdate: PropTypes.func
};