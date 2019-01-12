import React, { Component } from 'react';
import MenuItem from './MenuItem.js';
// import PropTypes from 'prop-types';

export default class Menu extends Component {
    render(){
        return(
            <div className="uuc_menu">
                <MenuItem title="Main" iconId="cog" />
            </div>
        );
    }
}

// when passing props down declare propTypes eg. { name: propTypes.string }