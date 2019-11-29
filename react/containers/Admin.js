import React, { Component } from 'react';
import PropTypes from 'prop-types';
import fetchWP from '../utils/fetchWP';
import Menu from '../components/menu/Menu';
import Settings from './Settings';
import Activate from '../components/Activate';
import Save from '../components/settings/Save';

export default class Admin extends Component {
    constructor(props) {
        super(props);

        this.state = {
            'section' : 'main',			
			'settings': {
				'page_title' : '',
				'holding_message': '',
				'countdown': false,
				'progress': false,
				'logo': {},
			},
			'active' : true,
			'google': {
				fetching: false,
				data: false,
				'apiKey': 'AIzaSyAc2BbG1P949I0tZg40Ry6HgE6qlgvoarE',
			}
        };

        this.fetchWP = new fetchWP({
            restURL: this.props.wpObject.api_url,
            restNonce: this.props.wpObject.api_nonce,
        });

        this.getSettings();
	}
	
	

	componentDidMount(){
		this.setState({
			goggle: {
				...this.state.google,
				fetching: true
			}
		});

		fetch(`https://www.googleapis.com/webfonts/v1/webfonts?key=${ this.state.google.apiKey }`)
			.then( response => response.json() )
			.then( json => {
				this.setState({
					google: {
						...this.state.google,
						data: json.items || [],
						fetching: false
					}
				});
			});
		
	}

    getSettings = () => {
        this.fetchWP.get( 'get_settings' )
            .then(
                (json) => this.processOkResponse( json, 'saved' ),
                (err) => console.log( 'error', err )
            );
    };

    updateSettings = () => {
        this.fetchWP.post( 'update_settings', { settings: this.state } )
            .then(
                (json) => this.processOkResponse( json, 'saved' ),
                (err) => console.log('error', err )
            );
    }

    processOkResponse = (json, action) => {
        if (json.success) {
            this.setState({
				settings: {
					page_title: json.setting.page_title,
					holding_message: json.setting.holding_message,
					countdown: json.setting.countdown,
					progress: json.setting.progress,
				}
            });
        } else {
            console.log(`Setting was not ${action}.`, json);
        }
    }

    updateInput = event => {
        const target = event.target;
        const value = target.type === 'checkbox' ? target.checked : target.value;
		const name = target.name;

        this.setState({
			settings: {
				...this.state.settings,
				[ name ]: value
			}
        });
	}

	updateSetting = ( contentState, name ) => {
		this.setState({
			settings: {
				...this.state.settings,
				[name]: contentState
			}
        });
	}

    updateSection = ( section ) => {
        this.setState({
            section: section,
        });
    }

    activate = (event) => {
		this.setState({
            active: event.target.checked,
        });
    }

    render() {
        return (
            <div className="wrap">
				<form id="uuc--settings">
					<h1 id="uucMain--title">Under Construction Plugin Options</h1>
					<Activate 
						active={ this.state.active } 
						activate={ this.activate }
					/>
					<div id="uucMain">
						<Menu
							active={ this.state.section }
							updateSection={ this.updateSection }
						/>
						<Settings 
							section={ this.state.section } 
							onUpdate={ this.updateInput } 
							updateSetting={ this.updateSetting }
							settings={ this.state.settings } 
							onSave={ this.updateSettings }
							path={ this.props.wpObject.image_path }
							googleFonts={ this.state.google.data }
						/>
					</div>
					<Save onSave={ this.onSave } />
				</form>
            </div>
        );
    }
}

Admin.propTypes = {
	wpObject: PropTypes.object
};