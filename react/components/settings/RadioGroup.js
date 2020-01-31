import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class RadioGroup extends Component {

    render(){
        return(
			<fieldset className="uuc--setting_row uuc--radio_group">
				<legend className="uuc--label">{ this.props.title }</legend>
				{ this.props.options.map(( value, index ) => {
					return <label key={ index }>
						<input type="radio" 
							name={ this.props.name }
							id={ `${ this.props.id }_${ value.name }` }
							value={ value.name }
							checked={ ! this.props.selected && index === 0 ? true : this.props.selected === value.name }
							onChange={ this.props.onUpdate }
						/>
						{ value.label }
					</label>
				}) }
			</fieldset>
	);
    }
}

RadioGroup.propTypes = {
	onUpdate: PropTypes.func,
	options: PropTypes.array,
	name: PropTypes.string,
	selected: PropTypes.string,
	id: PropTypes.string,
	title: PropTypes.string
};