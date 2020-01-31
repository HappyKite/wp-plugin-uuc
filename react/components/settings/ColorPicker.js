import React, { Component } from 'react';
import PropTypes from 'prop-types';
import Pickr from '@simonwep/pickr';

export default class ColorPicker extends Component {

	componentDidMount(){
		this.picker = Pickr.create({
			el: `.${this.props.className }`,
			theme: 'nano',
			components: {
				preview: true,
				hue: true,
				interaction: {
					hex: true,
					rgba: true,
					input: true,
					clear: true,
					save: true
				}
			}
		}).on('init', pickr => {
			if( this.props.color ){
				pickr.setColor( this.props.color );
			}
			
			pickr
				.on('save', instance => {
					if( instance ){
						this.props.onUpdate( instance.toHEXA().toString(), this.props.name );
					}
					
				}).on('clear', () => {
					this.props.onUpdate( null, this.props.name );
				});
		});
	}

    render(){
        return(
            <p className="uuc--setting_row uuc--checkbox">
				<label className="uuc--label" htmlFor={ this.props.name }>{ this.props.label }</label>
                <span className={ this.props.className }></span>
            </p>
        );
    }
}

ColorPicker.propTypes = {
	label: PropTypes.string,
	color: PropTypes.string,
	name: PropTypes.string,
	className: PropTypes.string,
	onUpdate: PropTypes.func
};