import React, { Component } from 'react';
import PropTypes from 'prop-types';
import Image from './Image';

export default class WpImageUpload extends Component {

	openMediaLibrary(){
		this.frame.open();
	}

	componentDidMount(){
		this.frame = wp.media({
            title: 'Select or Upload Media Of Your Chosen Persuasion',
            button: {
                text: 'Use this media'
            },
            multiple: false  // Set to true to allow multiple files to be selected
		});
		
		this.frame.on( 'select', this.selectImage.bind(this) );
	}

	selectImage(){
		let images = this.frame.state().get('selection').first().toJSON();
		this.props.onUpdate( { id: images.id, thumbnail: images.sizes.thumbnail }, this.props.name );
	}

    render(){
		let image;
		if( this.props.value && this.props.value.thumbnail && this.props.value.thumbnail.url ){
			image = <Image src={ this.props.value.thumbnail.url } alt={ 'Logo Image' } ></Image>
		}
        return(
            <p className="uuc--setting_row uuc--image_upload">
                <label className="uuc--label" htmlFor={ this.props.id }>{ this.props.label }</label>
				<span className="uuc--image_wrap">{ image }</span>
                <button
                    name={ "uuc-setting[" + this.props.name + "]" }
                    id={ this.props.id }
                    onClick={ this.openMediaLibrary.bind(this) }
					type="button"
					className="button button-primary"
                >{ 'Upload Image' }</button>
            </p>
        );
    }
}

WpImageUpload.propTypes = {
    label: PropTypes.string,
    value: PropTypes.object,
	name: PropTypes.string,
	id: PropTypes.string,
    onUpdate: PropTypes.func
};