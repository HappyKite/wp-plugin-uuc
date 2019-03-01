import React, { Component } from 'react';
import MenuItem from './MenuItem.js';
import PropTypes from 'prop-types';

export default class Menu extends Component {


    
    render(){
        return(
            <div className="uucMenu">
                <MenuItem title="Main" data-section="main" iconId="cog" subtitle="where the settings are" updateSection={ ( e ) => this.props.updateSection( 'main' ) } />
                <MenuItem title="Styling" data-section="styling" iconId="cog" subtitle="Make it pop yo!" updateSection={ ( e ) => this.props.updateSection( 'styling' ) }  />
                <MenuItem title="Other" data-section="other" iconId="cog" subtitle="bits and bobs" updateSection={ ( e ) => this.props.updateSection( 'other' ) }  />
            </div>
        );
    }
}

Menu.propTypes = {
    updateSection: PropTypes.func,
};