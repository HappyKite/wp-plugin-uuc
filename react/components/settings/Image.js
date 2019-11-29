import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class Image extends Component { 
    render() { 
        return ( 
            <img src={ this.props.src } alt={ this.props.alt }/> 
        )  
    }
}

Image.propTypes = {
    src: PropTypes.string,
    alt: PropTypes.string,
};