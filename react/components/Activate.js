import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class Activate extends Component {

    render() {
		let classes = [ 'enable_check'];
		classes.push( this.props.active ? 'activated' : 'deactivated' );

        return (
            <div className={ classes.join(' ') }>
                <p>
                    <input 
						className="enable_checkbox"
						id="enable" 
						name="enable"
						type="checkbox"
						value="1"
						checked={ this.props.active ? 'checked' : '' }
						onChange={ this.props.activate }
					/>
                    <label 
						className="description" 
						htmlFor="uuc_settings[enable]"
					>Enable the Under Construction Page</label>
                </p>
            </div>
        );
    }
}

Activate.propTypes = {
    active: PropTypes.bool,
    activate: PropTypes.func
};