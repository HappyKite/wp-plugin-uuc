import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class RadioGroup extends Component {

    render(){
        return(
            <p className="uuc--setting_row uuc--radio_group">
                { this.props.options.map(( value, index ) => {
					return <label key={ index }>
						<input type="radio" 
							name={ this.props.name }
							id={ this.props.id }
							value={ value.name }
							checked={ this.props.selected === value.name }
							onChange={ this.props.onUpdate }
						/>
						{ value.label }
					</label>
				}) }
            </p>
        );
    }
}

RadioGroup.propTypes = {
	onUpdate: PropTypes.func,
	options: PropTypes.array,
	name: PropTypes.string,
	selected: PropTypes.string,
	id: PropTypes.string
};