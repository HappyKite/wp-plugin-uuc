import React, { Component } from 'react';
import PropTypes from 'prop-types';

import GeneralTab from '../components/tabs/GeneralTab';
import DesignTab from '../components/tabs/DesignTab';
import IntegrationsTab from '../components/tabs/IntegrationsTab';
import MiscTab from '../components/tabs/MiscTab';

export default class Settings extends Component {

    render(){
        if ( this.props.section === 'main' ) {
            return (
				<GeneralTab
					settings={ this.props.settings }
					onUpdate={ this.props.onUpdate }
					updateSetting={ this.props.updateSetting }
				/>
            );
        } else if ( this.props.section === 'design' ) {
            return (
                <DesignTab
					settings={ this.props.settings }
					onUpdate={ this.props.onUpdate }
					updateSetting={ this.props.updateSetting }
					path={ this.props.path }
					googleFonts={ this.props.googleFonts }
				/>
            );
        } else if ( this.props.section === 'integrations' ) {
            return (
				<IntegrationsTab
					settings={ this.props.settings }
					onUpdate={ this.props.onUpdate }
				/>
            );
        } else if ( this.props.section === 'misc' ) {
            return (
                <MiscTab
					settings={ this.props.settings }
					onUpdate={ this.props.onUpdate }
				/>
            );
        }
    }
}

Settings.propTypes = {
    settings: PropTypes.object,
    section: PropTypes.string,
	onUpdate: PropTypes.func,
	updateSetting: PropTypes.func,
	path: PropTypes.string,
	googleFonts: PropTypes.array
};