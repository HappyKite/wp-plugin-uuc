import React, { Component } from 'react';
import PropTypes from 'prop-types';
import WpImageUpload from '../settings/WpImageUpload';
import RadioGroup from '../settings/RadioGroup';
import ColorPicker from '../settings/ColorPicker';
import ImageSelector from '../settings/ImageSelector';
import GoogleFonts from '../settings/GoogleFonts';

export default class DesignTab extends Component {

	render(){
		let background;

		if( ! this.props.settings['background_style'] || this.props.settings['background_style'] === 'solidcolor' ){
			background = <ColorPicker
				color={ this.props.settings['background-color'] }
				name="background-color"
				className="color-picker"
				onUpdate={ this.props.updateSetting }
			/>
		}else{
			background = <ImageSelector
				images={ [
					{ src: `${ this.props.path }squairylight.png`, alt:'Squairy', title: 'Squairy', id: 'squairylight', value: 'squairylight' },
					{ src: `${ this.props.path }lightbind.png`, alt:'Light Binding', title: 'Light Binding', id: 'lightbind', value: 'lightbind' },
					{ src: `${ this.props.path }darkbind.png`, alt:'Dark Binding', title: 'Dark Binding', id: 'darkbind', value: 'darkbind' },
				] }
				name="background_pattern"
				selected={ this.props.settings['background_pattern'] }
				onUpdate={ this.props.onUpdate }
			/>
		}

		return (
			<div className="uuc--settings">
				<WpImageUpload
					onUpdate={ this.props.updateSetting }
					name="logo"
					id="logo"
					value={ this.props.settings['logo'] }
					label="Logo"
				/>
				<RadioGroup 
					options={ [
						{ name: 'solidcolor', label: 'Solid Colour' },
						{ name: 'patterned', label: 'Patterend Background' }
					] }
					name="background_style"
					id="background_style"
					selected={ this.props.settings['background_style'] }
					onUpdate={ this.props.onUpdate }
				/>
				{ background }
				<GoogleFonts
					id="google_fonts"
					name="google_fonts"
					label="Google Font Name"
					selected={ this.props.settings['google_fonts'] }
					data={ this.props.googleFonts }
					onUpdate={ this.props.onUpdate }
				/>
				<ColorPicker
					color={ this.props.settings['font_color'] }
					name="font_color"
					className="font-color-picker"
					onUpdate={ this.props.updateSetting }
				/>
			</div>
		)
	}
}

DesignTab.propTypes = {
    settings: PropTypes.object,
	onUpdate: PropTypes.func,
	updateSetting: PropTypes.func,
	path: PropTypes.string,
	googleFonts: PropTypes.array
};