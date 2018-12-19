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
        import {Mkppt as MkpptTypes} from '&/mindmecn/markdown-bundle/resources/mkppt/prop-types'
        import Editor from '&/mindmecn/markdown-bundle/../public/js/tuiedit/tui-editor-Editor-all.min.js'

        import {selectors} from '&/mindmecn/markdown-bundle/resources/mkppt/editor/store'
        import {MkView} from '&/mindmecn/markdown-bundle/resources/mkppt/player/components/mkview'
             
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
                 initialValue: this.props.mkppt.content,
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
        title: trans('general', {}, 'platform'),
        fields: [
          {
            name: 'content',
            type: 'string',
            label: trans('mkppt'),
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
                     mkppt:Object.assign({}, preState.mkppt, {content: 'varContent'}),
                     mkppt:Object.assign({}, preState.mkppt, {htmlcontent: 'varHtmlcontent'})
                 })) 
               
                   this.props.mkppt.content=varContent ;
                   this.props.mkppt.htmlcontent=varHtmlcontent;
                   this.props.saveForm(this.props.mkppt.id)
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
  mkppt: T.shape(
    MkpptTypes.propTypes
  ).isRequired,
  saveForm: T.func.isRequired,
  active: T.func.isRequired,
  isNew: T.func.isRequired
}

const MkEdit = connect(
  state => ({
    workspace: resourceSelectors.workspace(state),
    mkppt: selectors.mkppt(state)
  }),
  (dispatch) => ({
     updateProp(propName, propValue) {
      dispatch(formActions.updateProp(selectors.FORM_NAME, propName, propValue))
    },
    saveForm(id) {
      dispatch(formActions.saveForm(selectors.FORM_NAME, ['apiv2_resource_mkppt_update', {id: id}]))
    }
  })
)(MkEditComponent)

export {
  MkEdit
}