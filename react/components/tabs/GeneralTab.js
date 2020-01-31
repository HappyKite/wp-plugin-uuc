import React, { Component } from 'react';
import PropTypes from 'prop-types';
import Text from '../settings/Text';
import Checkbox from '../settings/Checkbox';
import Editor from '../settings/Editor';
import Range from '../settings/Range';
import ColorPicker from '../settings/ColorPicker';
import RadioGroup from '../settings/RadioGroup';
import Date from '../settings/Date';


export default class GeneralTab extends Component {

	render(){

		return (
			<div className="uuc--settings">
				<Text 
					name="page_title"
					id="page_title"
					label="Page Title"
					value={ this.props.settings['page_title'] }
					onUpdate={ this.props.onUpdate }
				/>
				<Editor
					name="holding_message"
					id="holding_message"
					label="Holding Message"
					editor={ this.props.settings['holding_message'] }
					onUpdate={ this.props.updateSetting }
				/>
				<Checkbox 
					name="countdown"
					id="countdown"
					label="Countdown"
					value="countdown"
					checked={ this.props.settings['countdown'] === true }
					onUpdate={ this.props.onUpdate }
				/> 
				{	
					
					this.props.settings['countdown'] === true ?
						<React.Fragment>
							<RadioGroup 
								options={ [
									{ name: 'flipclock', label: 'Flip Clock' },
									{ name: 'textclock', label: 'Text Only' }
								] }
								title="Countdown Style"
								name="countdown_style"
								id="countdown_style"
								selected={ this.props.settings['countdown_style'] }
								onUpdate={ this.props.onUpdate }
							/>
							
							
							{
								this.props.settings['countdown_style'] === 'textclock' ?
									<Text
										name="countdown_text"
										id="countdown_text"
										label="Enter the Countdown Text"
										value={ this.props.settings['countdown_text'] }
										onUpdate={ this.props.onUpdate }
									/>
								: ''
							}

							{
								this.props.settings['countdown_style'] === 'flipclock' ?
									<Date
										label="Flip Clock Date"
										date={  this.props.settings['date'] || '' }
										handleDateChange={ this.props.handleDateChange }
									/>
								: ''
							}
							
						</React.Fragment>
					: ''
				}
				<Checkbox
					name="progress"
					id="progress"
					label="Progress"
					value="progress"
					checked={ this.props.settings['progress'] === true }
					onUpdate={ this.props.onUpdate }
				/>
				{
					this.props.settings['progress'] === true ?
						<React.Fragment>
							<Range
								name="percent_slider"
								id="percent_slider"
								label="Percent Complete"
								value={ this.props.settings['percent_slider'] }
								onUpdate={ this.props.onUpdate }
								min={ 0 }
								max={ 100 }
								step={ 5 }
								preview={ true }
							/>
							<ColorPicker
								label="Progress Bar Colour"
								color={ this.props.settings['progressbar_color'] }
								name="progressbar_color"
								className="progressbar_color-picker"
								onUpdate={ this.props.updateSetting }
							/>
						</React.Fragment>
					: ''
				}
			</div>
		)
	}
}

GeneralTab.propTypes = {
    settings: PropTypes.object,
	onUpdate: PropTypes.func,
	updateSetting: PropTypes.func,
	handleDateChange: PropTypes.func
};