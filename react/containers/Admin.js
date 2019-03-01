import React, { Component } from 'react';
import PropTypes from 'prop-types';
import fetchWP from '../utils/fetchWP';
import Menu from '../components/Menu';
import Settings from '../components/Settings';

export default class Admin extends Component {
    constructor(props) {
        super(props);

        this.state = {
            'section' : 'main',
            'setting_main-text': '',
        };

        this.fetchWP = new fetchWP({
            restURL: this.props.wpObject.api_url,
            restNonce: this.props.wpObject.api_nonce,
        });

        // this.getSetting();
    }

    getSetting = () => {
        this.fetchWP.get( 'example' )
            .then(
                (json) => this.setState({
                    exampleSetting: json.value,
                    savedExampleSetting: json.value
                }),
                (err) => console.log( 'error', err )
            );
    };

    updateSetting = () => {
        this.fetchWP.post( 'example', { exampleSetting: this.state.exampleSetting } )
            .then(
                (json) => this.processOkResponse( json, 'saved' ),
                (err) => console.log('error', err )
            );
    }

    deleteSetting = () => {
        this.fetchWP.delete( 'example' )
            .then(
                (json) => this.processOkResponse( json, 'deleted' ),
                (err) => console.log('error', err )
            );
    }

    processOkResponse = (json, action) => {
        if (json.success) {
            this.setState({
                exampleSetting: json.value,
                savedExampleSetting: json.value,
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

    handleSave = (event) => {
        event.preventDefault();
        if ( this.state.exampleSetting === this.state.savedExampleSetting ) {
            console.log('Setting unchanged');
        } else {
            this.updateSetting();
        }
    }

    handleDelete = (event) => {
        event.preventDefault();
        this.deleteSetting();
    }

    render() {
        return (
            <div className="wrap">
                <h1 id="uucMain--title">Under Construction Plugin Options</h1>
                <form>
                    <div id="uucMain">
                        <Menu active={ this.state.section } updateSection={ this.updateSection } />
                        <Settings section={ this.state.section } onUpdate={ this.updateInput } state={ this.state } />
                    </div>
                </form>
            </div>
        );
    }
}

Admin.propTypes = {
  wpObject: PropTypes.object
};