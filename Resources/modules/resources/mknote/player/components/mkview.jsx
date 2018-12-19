
import React, {Component} from 'react'
        import ReactDOM from 'react-dom';
        import $ from 'jquery'
        import {PropTypes as T} from 'prop-types'
        import {connect} from 'react-redux'

        //import Editor from 'tui-editor/dist/tui-editor-Editor-all.min.js'
        import Editor from '&/mindmecn/markdown-bundle/../public/js/tuiedit/tui-editor-Editor-all.min.js'

        //import 'tui-editor/dist/tui-editor.css'
        //import 'tui-editor/dist/tui-editor-contents.css'
        //  import 'tui-editor/dist/codemirror.css'
        //import 'tui-editor/dist/github.css'


        import {selectors} from '&/mindmecn/markdown-bundle/resources/mknote/store'

        class MkViewComponent extends React.Component{
        constructor(props){
        super(props);
        }

        componentDidMount(){
            
        let editor = new Editor.factory({
            el: document.querySelector('#editSection'),
            viewer: true,   
            initialValue: this.props.mknote.content,
            height: window.innerHeight - 20,
            });
        }
        
    render() {
        return (
                <div id="editSection"></div>
                )
    }
}

MkViewComponent.propTypes = {
content: T.string.isRequired
        }

const MkView = connect(
        state => ({
        mknote: selectors.mknote(state)
        })
        )(MkViewComponent)

        export {
        MkView
                }


