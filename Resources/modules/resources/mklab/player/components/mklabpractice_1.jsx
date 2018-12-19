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

//实验室ID
let pmhost = pmlabhost + '/api/1.0/workflow/opencase/OpenCase?username=' + authenticatedUser.username +'&password=Mdqh@1234!'


class MkLabPracticeComponent extends React.Component{
  constructor(props) {
        super(props);     
    }     


render(){
     
     /**
         调用PM api传值
         rootnode：实验根文件
         currnode: 当前实验文件
         lastnode：上一次实验文件
         prouid：工作流id
         tasuid: 任务Id
       **/
      
     let varmkmeta ={rootnode: this.props.resourceNodeId,
                     currnode: this.props.resourceNodeId,
                     lastnode: this.props.resourceNodeId,
                     prouid: "1",
                     tasuid: "2",
                     username: authenticatedUser.username,
                     userid: authenticatedUser.id
                }
     
     
     if ( this.props.mklab.mkmeta !=null && JSON.stringify(this.props.mklab.mkmeta) !='{}' ) {
         varmkmeta = this.props.mklab.mkmeta
         varmkmeta['username']=authenticatedUser.username
         varmkmeta['userid']=authenticatedUser.id
     }
     
     let pmsrc='/mdqh/mklab/mklab-blank.html'
     
     
     //调用pm api取流程
     let tmpUrl = pmlabhost + '/api/1.0/workflow/mdcases/apimdcases/postlabinfo/' + JSON.stringify(varmkmeta)
    
        fetch(tmpUrl, {
            method: 'post',
            headers: {
                'Content-Type': 'application/json'
            }
        })
                .then(checkStatus)
                .then(function (data) {
                    console.log('request succeeded with JSON response', data)
                }).catch(function (error) {
                     console.log('request failed', error)
        }) 
       

      if ( (this.props.mklab.mkmeta) !=null && (typeof this.props.mklab.mkmeta.proUid !== "undefine") && (typeof this.props.mklab.mkmeta.tasUid !== "undefine"))
       {
          pmsrc = pmhost + '&proUid=' + this.props.mklab.mkmeta.proUid + '&tasUid=' + this.props.mklab.mkmeta.tasUid + '&resourceNodeid=' + this.props.resourceNodeid
       }
        
      console.log(pmsrc)
   
 return ( 
  <div>
 	<iframe src= { pmsrc } 
                style={{ position: 'absolute', left: '0', width: '100%',  height: '100%'}}        
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
