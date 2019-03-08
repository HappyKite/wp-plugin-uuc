import React, { Component } from 'react';
import PropTypes from 'prop-types';
import fetchWP from '../utils/fetchWP';
import Menu from '../components/Menu';
import Settings from '../components/Settings';
import Activate from '../components/Activate';

export default class Admin extends Component {
    constructor(props) {
        super(props);

        this.state = {
            'section' : 'main',
            // main
            'setting_page_title': '',
            'setting_holding_message': '',
            'setting_progress': '',
            //styling
            'setting_logo': '',



            'active' : true,
        };

        this.fetchWP = new fetchWP({
            restURL: this.props.wpObject.api_url,
            restNonce: this.props.wpObject.api_nonce,
        });

        this.getSettings();
    }

    getSettings = () => {
        this.fetchWP.get( 'get_settings' )
            .then(
                (json) => this.processOkResponse( json, 'saved' ),
                (err) => console.log( 'error', err )
            );
    };

    updateSettings = () => {
        console.log('update')
        this.fetchWP.post( 'update_settings', { settings: this.state } )
            .then(
                (json) => this.processOkResponse( json, 'saved' ),
                (err) => console.log('error', err )
            );
    }

    processOkResponse = (json, action) => {
        console.log( json );
        if (json.success) {
            this.setState({
                setting_page_title: json.setting.page_title,
                setting_holding_message: json.setting.holding_message,
                setting_countdown: json.setting.countdown,
                setting_progress: json.setting.progress,
            });
        } else {
            console.log(`Setting was not ${action}.`, json);
        }
    }

    updateInput = (event) => {
 
        const target = event.target;
        const value = target.type === 'checkbox' ? target.checked : target.value;
        const name = 'setting_' + target.name.match(/\[(.*?)\]/)[1];

        this.setState({
            [ name ]: value,
        });
    }

    updateSection = ( section ) => {
        this.setState({
            section: section,
        });
    }

    activate = () => {
        console.log('activate');
    }

    render() {
        return (
            <div className="wrap">
                <h1 id="uucMain--title">Under Construction Plugin Options</h1>
                <Activate active={ this.state.active } activate={ this.activate }/>
                <div id="uucMain">
                    <Menu active={ this.state.section } updateSection={ this.updateSection } />
                    <Settings section={ this.state.section } onUpdate={ this.updateInput } state={ this.state } onSave={ this.updateSettings } />
                </div>
            </div>
        );
    }
}

Admin.propTypes = {
  wpObject: PropTypes.object
};