import React, {Component} from 'react'
        import ReactDOM from 'react-dom';
        import $ from 'jquery'
        import {PropTypes as T} from 'prop-types'
        import {connect} from 'react-redux'
        import {trans} from '#/main/core/translation'
        
        import {actions as formActions} from '#/main/app/content/form/store/actions'
        import {CALLBACK_BUTTON, LINK_BUTTON} from '#/main/app/buttons'
        import {FormData} from '#/main/app/content/form/containers/data'
        
        import {selectors as resourceSelectors} from '#/main/core/resource/store'
        import {Markdown as MarkdownTypes} from '&/mindmecn/markdown-bundle/resources/markdown/prop-types'
        import Editor from 'tui-editor/dist/tui-editor-Editor-all.min.js'
      
        import 'tui-editor/dist/codemirror.css'
        import 'tui-editor/dist/github.css'        
        import 'tui-editor/dist/tui-editor.css'
        import 'tui-editor/dist/tui-editor-contents.css'
        import 'tui-editor/dist/tui-color-picker.css'
        import 'tui-editor/dist/tui-chart.css'
        import {selectors} from '&/mindmecn/markdown-bundle/resources/markdown/editor/store'
        
             
class MkEditComponent extends React.Component{
   constructor(props){
           super(props);    
           this.state = {
            markdown: this.props.markdown,
            editor: null
        }; 
         this.DOMHandle = this.DOMHandle.bind(this);  
   }
     
 componentDidMount(){
     
         let editor = new Editor({
                 el: document.querySelector('#editSection'),
                 previewStyle: 'vertical',
                 height: window.innerHeight - 20,
                 initialEditType: 'markdown',
                 initialValue: this.props.markdown.content,
                 useCommandShortcut: true,
                 exts: ['scrollSync', 'colorSyntax', 'uml', 'chart', 'mark', 'table']           
           }); 
             
         this.setState({ editor }),()=>{
         this.props.markdown.content=this.state.editor.getValue(),
         updateProp(this.props.saveForm,true)
           }
           
         $("#editSection").on('DOMSubtreeModified', this.DOMHandle)       
         }
  
     DOMHandle(){       
       this.setState(preState => ({
        markdown: Object.assign({}, preState.markdown, {content: this.state.editor.getValue()})
       })) 
       this.props.markdown.content=this.state.editor.getValue()
   }
      
  render() {
  return (
   <div>
   <div id='editSection' />
   <FormData
    name={selectors.FORM_NAME}
    pendingChanges={this.props.pendingChanges}
    buttons={true}
     save={{
        type: CALLBACK_BUTTON,
        callback: () => this.props.saveForm(this.props.markdown.id)
      }}
    cancel={{
      type: LINK_BUTTON,
      target: '/',
      exact: true
    }}
    sections={[
        {
        title: trans('general', {}, 'platform'),
        primary: true,
        fields: [
          {
            name: 'content',
            type: 'string',
            label: trans('markdown'),
            hideLabel: true,
            required: true
          }
        ]
      } ,
      {
        title: trans('general', {}, 'platform'),
        primary: true,
        fields: [
          {
            name: 'content',
            type: 'html',
            label: trans('markdown'),
            hideLabel: true,
            required: true,
            options: {
              workspace: this.props.workspace,
              minRows: 1
            }
          }
        ]
      }
    ]}
  />
  </div>)
   }
 }
        
 MkEditComponent.defaultProps = {
  saveForm: true,
  active: true,
  isNew: true,
  pendingChanges: true
}

MkEditComponent.propTypes = {
  workspace: T.object,
  markdown: T.shape(
    MarkdownTypes.propTypes
  ).isRequired,
  saveForm: T.func.isRequired,
  active: T.func.isRequired,
  isNew: T.func.isRequired
}

const MkEdit = connect(
  state => ({
    workspace: resourceSelectors.workspace(state),
    markdown: selectors.markdown(state)
  }),
  (dispatch) => ({
    saveForm(id) {
        
       console.log('ddfaer')
       console.log(Editor.getValue())
      dispatch(formActions.saveForm(selectors.STORE_NAME+'.markdownForm', ['apiv2_resource_markdown_update', {markdown: id}]))
    }
  })
)(MkEditComponent)

export {
  MkEdit
}