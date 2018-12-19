import React from 'react'
import {PropTypes as T} from 'prop-types'
import ReactDOM from 'react-dom';
import {connect} from 'react-redux'

import {trans} from '#/main/app/intl/translation'
import {Routes} from '#/main/app/router'
import {currentUser} from '#/main/core/user/current'
import {selectors as resourceSelectors} from '#/main/core/resource/store'
import {selectors} from '&/mindmecn/markdown-bundle/resources/mklab/store'
import {PMHOST as pmlabhost} from '&/mindmecn/markdown-bundle/resources/constants'
import {checkStatus,parseJSON} from '&/mindmecn/markdown-bundle/resources/mklab/util'
import {Mklab as MklabTypes} from '&/mindmecn/markdown-bundle/resources/mklab/prop-types'


const authenticatedUser = currentUser()

class MkLabPracticeComponent extends React.Component{
  constructor(props) {
        super(props);  
        this.state = {mdlabsrc : '/mdqh/mklab/mklab-blank.html'}
    }   
    


 fetchData(){  //请求数据函数 
     
   let  thiz = this;
   let  varmkmeta = null;
   
       
   /**
        调用PM api传值
         rootnode：实验根文件
         currnode: 当前实验文件
         lastnode：上一次实验文件(备用)
         prouid：工作流id
         username: 当前用户
         userid: 用户id
       **/
         
     
     if ( this.props.mklab.mkmeta !=null && JSON.stringify(this.props.mklab.mkmeta) !='{}' ) {
         varmkmeta = this.props.mklab.mkmeta
         varmkmeta['username']=authenticatedUser.username
         varmkmeta['userid']=authenticatedUser.id
         if (this.props.mklab.mkmeta.rootnode != null)
         {
             varmkmeta['rootnode']=this.props.mklab.mkmeta.rootnode
         }else{
             varmkmeta['rootnode'] = this.props.resourceNodeId
         }
         
         if (this.props.mklab.mkmeta.currnode != null)
         {
             varmkmeta['currnode']=this.props.mklab.mkmeta.currnode
         }else{
             varmkmeta['currnode'] = this.props.resourceNodeId
         }
   
      console.log(varmkmeta)
     
       //调用pm api取流程
   let  tmpUrl = pmlabhost + '/api/1.0/workflow/mdcases/apimdcases/postlabinfo/' + JSON.stringify(varmkmeta)
 
         fetch(tmpUrl, {
            method: 'post',
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(function (response) {
            return response.json();
        }).then(function (data) {
           let pmsrc = pmlabhost + '/sysworkflow/en/skybluetest03/cases/open?APP_UID=' + data.appuid + '&DEL_INDEX=' + data.delindex + '&action=draft&sid=' + data.sessionid;
           thiz.setState({ mdlabsrc: pmsrc });
         });
     }
 }
     
         
componentWillMount(){
    this.fetchData()
}


render(){
      return (
                <div>
                      <iframe src= { this.state.mdlabsrc } 
                              style={{position: 'absolute', left: '0', width: '100%', height: '100%'}}        
                              ref="iframePractice" 
                              frameborder="no" 
                              border="0" 
                              marginwidth="0" 
                              marginheight="0" 
                              scrolling="no" 
                              allowtransparency="yes">未定义实验</iframe>
                </div>)

    }
}

MkLabPracticeComponent.propTypes = {
  mklab: T.shape(MklabTypes.propTypes).isRequired
}

const MkLabPractice = connect(
  state => ({
    resourceNodeId: resourceSelectors.resourceNode(state).id,
    mklab: selectors.mklab(state)
  })
)(MkLabPracticeComponent)

export {
  MkLabPractice
}
