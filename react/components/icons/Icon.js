import React, { Component } from 'react';
import PropTypes from 'prop-types';
import IconCog from './IconCog.js';

export default class Icon extends Component {

    components = {
        cog: IconCog,
    };

    render(){
        const IconImage = this.components[ this.props.id || 'cog' ];
        return <IconImage width={ this.props.width || 40 } height={ this.props.height || 40 } />;
    }
}

Icon.propTypes = {
    id: PropTypes.string,
    width:PropTypes.number,
    height: PropTypes.number
};