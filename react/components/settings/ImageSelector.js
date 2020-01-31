import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class ImageSelector extends Component {
    render() {
        return (
            <ul className="uuc_patterns_wrap">
				{ this.props.images.map(( value, index ) => {
					return <li className="uuc_patterns" key={ index }>
						<input 
							type="radio"
							id={ `${ this.props.name }_${ value.id }` }
							name={ this.props.name }
							value={ value.value }
							onChange={ this.props.onUpdate }
							checked={ ! this.props.selected && index === 0 ? true : this.props.selected === value.value }
						/>
						<label htmlFor={ `${ this.props.name }_${value.id}` }>
							<img
								src={ value.src }
								alt={ value.alt }
							/>
						</label>
						<div className="uuc-pattern_title">{ value.title }</div>
					</li>
				}) }
			</ul>
        );
    }
}

ImageSelector.propTypes = {
	images: PropTypes.array,
	onUpdate: PropTypes.func,
	name: PropTypes.string,
	selected: PropTypes.string
};