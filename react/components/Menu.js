import React, { Component } from 'react';
import MenuItem from './MenuItem.js';
import PropTypes from 'prop-types';

export default class Menu extends Component {
    render(){
        return(
            <div className="uucMenu">
                <MenuItem title="Main" data-section="main" iconId="cog" subtitle="Main settings" updateSection={ () => this.props.updateSection( 'main' ) } />
                <MenuItem title="Design" data-section="design" iconId="cog" subtitle="Design and layout" updateSection={ () => this.props.updateSection( 'design' ) }  />
                <MenuItem title="Integrations" data-section="integrations" iconId="cog" subtitle="External plugin setup" updateSection={ () => this.props.updateSection( 'integrations' ) }  />
				<MenuItem title="Misc" data-section="misc" iconId="cog" subtitle="" updateSection={ () => this.props.updateSection( 'misc' ) }  />
            </div>
        );
    }
}

Menu.propTypes = {
    updateSection: PropTypes.func,
};