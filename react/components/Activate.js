import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class Activate extends Component {
    render() {              
        return (
            <div className={ 'enable_check ' + ( this.props.active ? 'activated' : 'deactivated' ) }>
                <p>
                    <input className="enable_checkbox" id="uuc_settings[enable]" name="uuc_settings[enable]" type="checkbox" value={ this.props.active ? '1' : '0' } onChange={ this.props.activate }/>
                    <label className="description" htmlFor="uuc_settings[enable]">Enable the Under Construction Page</label>
                </p>
            </div>
        );
    }
}

Activate.propTypes = {
    active: PropTypes.bool,
    activate: PropTypes.func
};