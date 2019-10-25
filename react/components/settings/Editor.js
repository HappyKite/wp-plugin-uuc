import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { Editor } from 'react-draft-wysiwyg';
import { EditorState, convertToRaw, convertFromRaw } from 'draft-js';
import 'react-draft-wysiwyg/dist/react-draft-wysiwyg.css';
export default class SettingEditor extends Component {
	constructor(props) {
		super(props);
		let editorState;
		if( this.props.editor !== '' ){
			const contentState = convertFromRaw( JSON.parse( this.props.editor ) );
            editorState = EditorState.createWithContent(contentState);
            editorState = EditorState.moveFocusToEnd(editorState);
		}else{
			editorState = EditorState.createEmpty();
		}
		
		this.state = {
			editorState,
		}
	}

	onEditorStateChange = editorState => {
		const content = JSON.stringify( convertToRaw(editorState.getCurrentContent()) );
		this.props.onUpdate( content, this.props.name );
		this.setState({
			editorState,
		});
	}

    render(){
		const { editorState } = this.state;
        return(
            <Editor
				editorState={ editorState }
				name={ this.props.name }
                toolbarClassName="toolbarClassName"
                wrapperClassName="wrapperClassName"
                editorClassName="editorClassName"
				onEditorStateChange={ this.onEditorStateChange }
            />
        );
    }
}

SettingEditor.propTypes = {
    label: PropTypes.string,
    editor: PropTypes.string,
    name: PropTypes.string,
	onUpdate: PropTypes.func
};