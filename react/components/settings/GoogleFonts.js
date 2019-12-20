import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class GoogleFonts extends Component {
    render() {
        return (
			<React.Fragment>
				<label htmlFor={ this.props.id }>{ this.props.label }</label>
				<select id={ this.props.id } name={ this.props.name } onChange={ this.props.onUpdate } defaultValue={ this.props.selected }>
					<option>Please choose a font</option>
					{
						this.props.data && this.props.data.map( ( item, index ) => {
							return <option 
								key={ index }
								value={ item.family }
							>{ item.family }</option>
						})
					}
				</select>
			</React.Fragment>
        );
    }
}

GoogleFonts.propTypes = {
	id: PropTypes.string,
	name: PropTypes.string,
	selected: PropTypes.string,
	label: PropTypes.string,
	onUpdate: PropTypes.func,
	data: PropTypes.array
};