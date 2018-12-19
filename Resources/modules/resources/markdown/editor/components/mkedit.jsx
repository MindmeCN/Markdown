import React, {Component} from 'react'
        import ReactDOM from 'react-dom';
        import $ from 'jquery'
        import {PropTypes as T} from 'prop-types'
        import {connect} from 'react-redux'
        import {trans} from '#/main/app/intl/translation'
        import ButtonToolbar from 'react-bootstrap/lib/ButtonToolbar'
        import {Button} from '#/main/app/action/components/button'
        
        import {actions as formActions} from '#/main/app/content/form/store/actions'
        import {CALLBACK_BUTTON, LINK_BUTTON} from '#/main/app/buttons'
        import {FormData} from '#/main/app/content/form/containers/data'
        import {Sections} from '#/main/core/layout/components/sections'
        
        import {selectors as resourceSelectors} from '#/main/core/resource/store'
        import {Markdown as MarkdownTypes} from '&/mindmecn/markdown-bundle/resources/markdown/prop-types'
        //import Editor from 'tui-editor/dist/tui-editor-Editor-all.min.js'
        import Editor from '&/mindmecn/markdown-bundle/../public/js/tuiedit/tui-editor-Editor-all.min.js'
        import {selectors} from '&/mindmecn/markdown-bundle/resources/markdown/editor/store'
        
             
class MkEditComponent extends React.Component{
   constructor(props){
           super(props);    
   }
   
 componentWillUnmount(){
         $(Editor.getInstances()).remove ;
     }
     
 componentDidMount(){ 
          let editor = new Editor({
                 el: document.querySelector('#editSection'),
                 previewStyle: 'vertical',
                 height: window.innerHeight - 40,
                 initialEditType: 'markdown',
                 initialValue: this.props.markdown.content,
                 useCommandShortcut: true,
                 exts: ['scrollSync', 'colorSyntax', 'uml', 'chart', 'mark', 'table']           
           }); 
            
     }
     
 
      
  render() {
  return (
   <FormData
    name={selectors.FORM_NAME}
    sections={[
      {
        title: trans('general11', {}, 'platform'),
        fields: [
          {
            name: 'content',
            type: 'string',
            label: trans('markdown'),
            hideLabel: true,
            required: true,
            displayed: false,
            options: {
              workspace: this.props.workspace,
              minRows: 1
            }
          }
        ]
      }
    ]}
  >
  <div id='editSection' />
     <ButtonToolbar>
         <Button
          primary={true}
          label={trans('save')}
          type={CALLBACK_BUTTON}
          className="btn"
             callback={() => {
              
               let  varContent= $(Editor.getInstances()).get(0).getValue();
               let  varHtmlcontent = $(Editor.getInstances()).get(0).getHtml();
               this.setState(preState => ({
                     markdown:Object.assign({}, preState.markdown, {content: 'varContent'}),
                     markdown:Object.assign({}, preState.markdown, {htmlcontent: 'varHtmlcontent'})
                 })) 
               
                   this.props.markdown.content=varContent ;
                   this.props.markdown.htmlcontent=varHtmlcontent;
                   this.props.saveForm(this.props.markdown.id)
               }} />
              <Button
               label={trans('cancle')}
                type={LINK_BUTTON}
                className="btn"
                target={'/'}
                exact={true}
                       />
       </ButtonToolbar>
  </FormData>
     )
   }
 }
        
 MkEditComponent.defaultProps = {
  saveForm: true
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
     updateProp(propName, propValue) {
      dispatch(formActions.updateProp(selectors.FORM_NAME, propName, propValue))
    },
    saveForm(id) {
      dispatch(formActions.saveForm(selectors.FORM_NAME, ['apiv2_resource_markdown_update', {id: id}]))
    }
  })
)(MkEditComponent)

export {
  MkEdit
}