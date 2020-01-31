
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import DatePicker from "react-datepicker";

export default class Date extends Component {

    render(){
		console.log( this.props );
        return(
			<div className="uuc--setting_row uuc--date_picker">
				<label className="uuc--label">{ this.props.label }</label>
				<DatePicker
					selected={ this.props.date }
					onChange={ date => this.props.handleDateChange( date, 'date' ) }
				/>
			</div>
        );
    }
}

Date.propTypes = {
    label: PropTypes.string,
	date: PropTypes.object,
	handleDateChange: PropTypes.func,
};
