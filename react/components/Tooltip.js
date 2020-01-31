import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class Tooltip extends Component {
    render() {              
        return (
			<span className="uucSettings--tooltip">
				<span>{ this.props.title }</span>
			</span>
        );
    }
}

Tooltip.propTypes = {
	title: PropTypes.string
};