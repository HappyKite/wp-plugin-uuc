import React, { Component } from 'react';
import PropTypes from 'prop-types';
import Icon from '../icons/Icon.js';

export default class MenuItem extends Component {

    render(){
		let subtitle = this.props.subtitle ? <span className="uucMenu--subtitle">{ this.props.subtitle }</span> : "" ;
		
		let classes = ['uucMenu--item'];
		if( this.props.active ){
			classes.push( 'uucMenu--item_active' );
		}

        return(
            <div className={ classes.join(' ') } onClick={ this.props.updateSection }>
                <Icon id={ this.props.iconId } />
                <span className="uucMenu--itemTitle">
                    <span>{ this.props.title }</span>
                    { subtitle }
                </span>
            </div>
        );
    }
}

MenuItem.propTypes = {
    subtitle: PropTypes.string,
    title: PropTypes.string,
    iconClass: PropTypes.string,
    iconId: PropTypes.string,
	updateSection: PropTypes.func,
	active: PropTypes.bool
};