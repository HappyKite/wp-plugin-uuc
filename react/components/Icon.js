import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class Icon extends Component {
    render(){
        return(
            <svg className={ ( this.props.class ? this.props.class : 'icon-' + this.props.id ) + ' uuc-icon' } aria-hidden="true">
                <use xlinkHref={ '#' + this.props.id } />
            </svg>
        );
    }
}

Icon.propTypes = {
    class: PropTypes.string,
    id: PropTypes.string
};