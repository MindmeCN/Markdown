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
        import {Mklab as MklabTypes} from '&/mindmecn/markdown-bundle/resources/mklab/prop-types' 
        import Editor from '&/mindmecn/markdown-bundle/../public/js/tuiedit/tui-editor-Editor-all.min.js'
        import {checkStatus,parseJSON,
                convertToContent,convertToHContent,
                convertContentToData,convertHcontentToData
                } from '&/mindmecn/markdown-bundle/resources/mklab/util'

        import {selectors} from '&/mindmecn/markdown-bundle/resources/mklab/editor/store'
        
             
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
                 previewStyle: 'tab',
                 height: window.innerHeight - 40,
                 initialEditType: 'markdown',
                 initialValue: this.props.mklab.content,
                 useCommandShortcut: true          
           }); 
           
              
     }
     
  
  render() {
  return (
   <FormData
    name={selectors.FORM_NAME}
    sections={[
      {
        title: trans('general', {}, 'platform'),
        fields: [
          {
            name: 'content',
            type: 'string',
            label: trans('mklab'),
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
                    
               let  varData=convertContentToData(varContent);

               let  varHtmlcontent = convertToHContent(varData);
               this.setState(preState => ({
                     mklab:Object.assign({}, preState.mklab, {content: 'varContent'}),
                     mklab:Object.assign({}, preState.mklab, {htmlcontent: 'varHtmlcontent'})
                 })) 
               
                   this.props.mklab.content=varContent ;
                   this.props.mklab.htmlcontent=varHtmlcontent;
                   this.props.saveForm(this.props.mklab.id)
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
  mklab: T.shape(
    MklabTypes.propTypes
  ).isRequired
}

const MkEdit = connect(
  state => ({
    workspace: resourceSelectors.workspace(state),
    mklab: selectors.mklab(state)
  }),
  (dispatch) => ({
     updateProp(propName, propValue) {
      dispatch(formActions.updateProp(selectors.FORM_NAME, propName, propValue))
    },
    saveForm(id) {
      dispatch(formActions.saveForm(selectors.FORM_NAME, ['apiv2_resource_mklab_update', {id: id}]))
    }
  })
)(MkEditComponent)

export {
  MkEdit
}