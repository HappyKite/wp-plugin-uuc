import React, { Component } from 'react';
import MenuItem from './MenuItem.js';
// import PropTypes from 'prop-types';

export default class Menu extends Component {
    render(){
        return(
            <div className="uucMenu">
                <MenuItem title="Main" iconId="cog" subtitle="where the settings are" />
                <MenuItem title="Styling" iconId="cog" subtitle="Make it pop yo!" />
                <MenuItem title="Other" iconId="cog" subtitle="bits and bobs" />
            </div>
        );
    }
}

// when passing props down declare propTypes eg. { name: propTypes.string }