import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class Save extends Component {
    render(){
        return(
            <p className="uucSubmit"><button type="submit" className="button button-primary" onClick={ this.props.onSave }>Save</button></p>
        );
    }
}

Save.propTypes = {
    onSave: PropTypes.func
};