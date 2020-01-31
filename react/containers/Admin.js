import React, { Component } from 'react';
import PropTypes, { array } from 'prop-types';
import fetchWP from '../utils/fetchWP';
import Menu from '../components/menu/Menu';
import Settings from './Settings';
import Activate from '../components/Activate';
import Save from '../components/settings/Save';
import { parseISO } from 'date-fns';

export default class Admin extends Component {

	state = {
		'section' : 'main',			
		'settings': {},
		'active' : true,
		'google': {
			fetching: false,
			data: [],
			'apiKey': 'AIzaSyAc2BbG1P949I0tZg40Ry6HgE6qlgvoarE',
		},
		loaded: false
	}

    constructor(props) {
        super(props);

        this.fetchWP = new fetchWP({
            restURL: this.props.wpObject.api_url,
            restNonce: this.props.wpObject.api_nonce,
        });        
	}

	componentDidMount(){
		this.loadSettings();
		this.getGoogleFonts();
	}

	componentWillUnmount() {
		if (this._asyncRequest) {
		  this._asyncRequest.cancel();
		}
	  }

	getGoogleFonts(){
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

    loadSettings = () => {
        this._asyncRequest = this.fetchWP.get( 'get_settings' )
            .then(
                (json) => {
					if ( json.success ){

						// format date as it's read in
						if( json.settings.date ){
							json.settings.date = parseISO( json.settings.date );
						}

						json.settings.percent_slider = parseInt( json.settings.percent_slider );

						this.setState({
							settings: json.settings,
							loaded: true
						});
					} else{
						console.warn(`Settings was not loaded.`, json)
					}
				},
                (err) => console.error( 'error', err )
            );
    };

    updateSettings = e => {
		e.preventDefault();
        this.fetchWP.post( 'update_settings', { settings: this.state } )
            .then(
                (json) => {
					console.log( json );
					! json.success ? console.warn(`Settings was not save.`, json) : ''
				},
                (err) => console.error('error', err )
            );
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
	
	handleDateChange = ( dateObject, name ) => {
		if( ! name || ! dateObject ){
			return;
		}

		this.setState({
			settings: {
				...this.state.settings,
				[name]: dateObject
			}
        });
	}

    render() {
		if( this.state.loaded ){
			return (
				<div className="wrap">
					<form id="uuc--settings">
						<h1 id="uucMain--title">Under Construction Plugin Options</h1>
						<Activate 
							active={ this.state.settings['enable'] } 
							activate={ this.updateInput }
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
								path={ this.props.wpObject.image_path }
								googleFonts={ this.state.google.data }
								handleDateChange={ this.handleDateChange }
							/>
						</div>
						<Save onSave={ this.updateSettings } />
					</form>
				</div>
			);
		} else{
			return ( 'loading' );
		}
        
    }
}

Admin.propTypes = {
	wpObject: PropTypes.object
};