import React, { Component } from 'react';
import PropTypes from 'prop-types';
import fetchWP from '../utils/fetchWP';
import Menu from '../components/Menu';
import Settings from '../components/Settings';

export default class Admin extends Component {
    constructor(props) {
        super(props);

        this.state = {
            textInput: '',
            savedExampleSetting: ''
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
        const name = target.name;

        this.setState({
            [name]: value,
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
                <form>
                    <h1 id="uucMain--title">Under Construction Plugin Options</h1>
                    <div id="uucMain">
                        <Menu />
                        <Settings 
                            onUpdate={ this.updateInput }
                        />
                    </div>
                </form>
            </div>
        );
    }
}

Admin.propTypes = {
  wpObject: PropTypes.object
};