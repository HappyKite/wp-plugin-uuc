import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class Range extends Component {

    render(){
        return(
            <p className="uuc--setting_row uuc--range">
                <label className="uuc--label" htmlFor={ this.props.name }>{ this.props.label }</label>
				<input 
					type="range"
					id={ this.props.id }
					name={ this.props.name }
					min={ this.props.min || 0 }
					max={ this.props.max || 100 }
					value={ this.props.value || 0 }
					step={ this.props.step || 10 }
					onChange={ this.props.onUpdate }
				/>
				{
					this.props.preview ?
						<span className="uuc--range_preview">{ this.props.value || 0 }%</span>
					: ''
				}
            </p>
        );
    }
}

Range.propTypes = {
    label: PropTypes.string,
    value: PropTypes.number,
	name: PropTypes.string,
	id: PropTypes.string,
	onUpdate: PropTypes.func,
	min:PropTypes.number,
	max:PropTypes.number,
	step:PropTypes.number,
	preview: PropTypes.bool
};