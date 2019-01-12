import React, { Component } from 'react';
import PropTypes from 'prop-types';
import Icon from './Icon';

export default class MenuItem extends Component {

    render(){
        let subtitle = this.props.subtitle ? <span className="subtitle">{ this.props.subtitle }</span> : "" ;

        return(
            <div className="menu--item">
                <Icon id={ this.props.iconId } className={ this.props.iconClass } />
                <span>{ this.props.title }</span>
                { subtitle }
            </div>
        );
    }
}

MenuItem.propTypes = {
    subtitle: PropTypes.string,
    title: PropTypes.string,
    iconClass: PropTypes.string,
    iconId: PropTypes.string
};