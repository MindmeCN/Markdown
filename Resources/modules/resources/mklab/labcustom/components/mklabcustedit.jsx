
import React, {Component} from 'react'
import ReactDOM from 'react-dom';


import $ from 'jquery'
import {PropTypes as T} from 'prop-types'
import {connect} from 'react-redux'
import classes from 'classnames'
import {trans} from '#/main/app/intl/translation'
import ButtonToolbar from 'react-bootstrap/lib/ButtonToolbar'
import {Button} from '#/main/app/action/components/button'
   
import {selectors as resourceSelectors} from '#/main/core/resource/store'
import {selectors} from '&/mindmecn/markdown-bundle/resources/mklab/editor/store'   
import {actions as formActions} from '#/main/app/content/form/store/actions'
import {CALLBACK_BUTTON, LINK_BUTTON} from '#/main/app/buttons'
import {FormData} from '#/main/app/content/form/containers/data'
import {Sections} from '#/main/core/layout/components/sections'
import {Mklab as MklabTypes} from '&/mindmecn/markdown-bundle/resources/mklab/prop-types'
import {BootstrapTable, TableHeaderColumn, ShowSelectedOnlyButton} from 'react-bootstrap-table';
import ReactMarkdown from 'react-markdown'
import {yaml} from  'js-yaml'

import {convertToContent,
  convertToHContent,
  convertContentToData,
  convertHcontentToData} from '&/mindmecn/markdown-bundle/resources/mklab/util'


class MkLabCustEditComponent extends React.Component{
  constructor(props) {
        super(props);     
    }     
    
   createCustomModalHeader(onClose, onSave) {
    const headerStyle = {
      fontWeight: 'bold',
      fontSize: 'large',
      textAlign: 'center',
      backgroundColor: '#eeeeee'
    };
    return (
      <div className='modal-header' style={ headerStyle }>
        <h3>增加</h3>
      </div>
    );
}   
   
   
      
  createCustomModalBody(columns, validateState, ignoreEditable){
    return (
      <MyCustomBody columns={ columns }
        validateState={ validateState }
        ignoreEditable={ ignoreEditable }/>
    );
}



createCustomModalFooter(onClose, onSave){
    const style = {
      backgroundColor: '#ffffff'
    };
    return (
      <div className='modal-footer' style={ style }>
        <button className='btn btn-xs btn-info' onClick={ onClose }>离开</button>
        <button className='btn btn-xs btn-danger' onClick={ onSave }>确认</button>
      </div>
    );
}


render() {
 
{/* 目标：content存储每个单元格拼接成的markdown文档，以换行后的<!-mdcell->为分格符
         htmlcontent以json串格式存付每个单元格内容，
         单元格ID:mdcellid为序列号，保存时需重新计算
            */};   

var products =convertHcontentToData(this.props.mklab.htmlcontent)
//if (!products){
//    products = convertContentToData(this.props.mklab.content)
//}

        
const options = {
      insertModalHeader: this.createCustomModalHeader,
      insertModalFooter: this.createCustomModalFooter,
      afterDeleteRow: this.onAfterDeleteRow,
      afterInsertRow: this.onAfterInsertRow,
      noDataText: '请定义实验内容',
      insertText: '增加',
      deleteText: '删除'    
}

const selectRowProp = {
  mode: 'checkbox',
  clickToSelect: true,
  bgColor: 'pink'
};

  

const cellEditProp = {
    mode: 'dbclick',
    blurToSave: true
};





function contentFormatter(cell, row) {
   
  return  <div className="ag-theme-fresh">
              <ReactMarkdown source={cell} />
          </div>
}

    return (
       <FormData
    name={selectors.FORM_NAME}
    sections={[
      {
        title: trans('genera', {}, 'platform'),
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
              minRows: 1    }
            },
            {
            name: 'htmlcontent',
            type: 'string',
            label: trans('mklab'),
            hideLabel: true,
            required: true,
            displayed: false,
            options: {
              workspace: this.props.workspace,
              minRows: 1
            },
          }
        ]
      }
    ]}
  >
   <BootstrapTable data={ products } 
                      options={ options }
                      scrollTop={ 'Bottom' } 
                      deleteRow={ true }
                      insertRow={ true }
                      selectRow={selectRowProp }
                      cellEdit={ cellEditProp }
                      ref="refbtmklab">
             <TableHeaderColumn dataField='cellid' isKey hiddenOnInsert  hidden autoValue={ true } >ID</TableHeaderColumn>
             <TableHeaderColumn dataField='content' dataFormat={contentFormatter} editable={ { type: 'textarea' } }>命令</TableHeaderColumn>
             <TableHeaderColumn dataField='desc' dataFormat={contentFormatter} editable={ { type: 'textarea' } }>描述</TableHeaderColumn> 
             <TableHeaderColumn dataField='syntax' dataFormat={contentFormatter} editable={ { type: 'textarea' } }>语法</TableHeaderColumn> 
             <TableHeaderColumn dataField='option' dataFormat={contentFormatter} editable={ { type: 'textarea' } }>选项</TableHeaderColumn> 
     </BootstrapTable>
     <ButtonToolbar>
         <Button
          primary={true}
          label={trans('save')}
          type={CALLBACK_BUTTON}
          className="btn"
             callback={() => {
                
               let  varContent = convertToContent(this.refs.refbtmklab.store.data);
               let  varHtmlcontent = convertToHContent(this.refs.refbtmklab.store.data);
               this.setState(preState => ({
                     mklab:Object.assign({}, preState.mklab, {content: 'varContent'}),
                     mklab:Object.assign({}, preState.mklab, {htmlcontent: 'varHtmlcontent'})                 })) 
               
                   this.props.mklab.content=varContent ;
                   this.props.mklab.htmlcontent=varHtmlcontent;
                   this.props.saveForm(this.props.mklab.id);
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



  
MkLabCustEditComponent.propTypes = {
    workspace: T.object,
    mklab: T.shape(
    MklabTypes.propTypes
  ).isRequired,
} 

const MkLabCustEdit = connect(
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
)(MkLabCustEditComponent)

export {
  MkLabCustEdit
}


