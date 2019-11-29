import React, { Component } from 'react';
import MenuItem from './MenuItem.js';
import PropTypes from 'prop-types';

export default class Menu extends Component { background
    render(){
        return(
            <div className="uucMenu">
                <MenuItem 
					title="Main"
					iconId="cog"
					subtitle="Main settings"
					active={ 'main' === this.props.active }
					updateSection={ () => this.props.updateSection( 'main' ) }
				/>
                <MenuItem
					title="Design"
					iconId="cog"
					subtitle="Design and layout"
					active={ 'design' === this.props.active }
					updateSection={ () => this.props.updateSection( 'design' ) }
				/>
                <MenuItem
					title="Integrations"
					iconId="cog"
					subtitle="External plugin setup"
					active={ 'integrations' === this.props.active }
					updateSection={ () => this.props.updateSection( 'integrations' ) }
				/>
				<MenuItem
					title="Misc"
					data-section="misc"
					iconId="cog"
					subtitle=""
					active={ 'misc' === this.props.active }
					updateSection={ () => this.props.updateSection( 'misc' ) }
				/>
            </div>
        );
    }
}

Menu.propTypes = {
	active: PropTypes.string,
    updateSection: PropTypes.func,
};