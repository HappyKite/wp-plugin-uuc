import React, { Component } from 'react';
import PropTypes from 'prop-types';
import Icon from './icons/Icon';

export default class Tooltip extends Component {
    render() {              
        return (
			<div className="uucSettings--tooltip">
				<Icon id="cog"/>
				<span>{ this.props.title }</span>
			</div>
        );
    }
}

Tooltip.propTypes = {
	title: PropTypes.string
};