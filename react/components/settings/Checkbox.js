import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class Checkbox extends Component {

    render(){
        return(
            <p className="uuc--setting_row uuc--checkbox">
                <label htmlFor={ this.props.name }>
					<input
						name={ this.props.name }
						id={ this.props.id }
						type="checkbox"
						checked={ this.props.checked === true }
						onChange={ this.props.onUpdate }
						value={ this.props.value }
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
	id: PropTypes.string,
	onUpdate: PropTypes.func,
	value: PropTypes.string
};