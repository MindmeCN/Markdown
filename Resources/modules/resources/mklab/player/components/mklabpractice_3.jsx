import React from 'react'
import {PropTypes as T} from 'prop-types'
import ReactDOM from 'react-dom';
import {connect} from 'react-redux'

import {trans} from '#/main/app/intl/translation'
import {Routes} from '#/main/app/router'
import {currentUser} from '#/main/core/user/current'
import {selectors as resourceSelectors} from '#/main/core/resource/store'
import {selectors} from '&/mindmecn/markdown-bundle/resources/mklab/store'
import {Mklab as MklabTypes} from '&/mindmecn/markdown-bundle/resources/mklab/prop-types'




const authenticatedUser = currentUser()
const pmhost = 'https://lms.mindme.com.cn:8000/api/1.0/workflow/opencase/OpenCase?username=' + authenticatedUser.username +'&password=Mdqh@1234!'



class MkLabPracticeComponent extends React.Component{
  constructor(props) {
        super(props);     
    }     


render(){
    
 
    
    let pmsrc='/mdqh/mklab/mklab-blank.html'
    
        if ( !this.props.mklab.mkmeta &&  this.props.mklab.mkmeta !== "undefine") {
            if ((typeof this.props.mklab.mkmeta.proUid !== "undefined") && (typeof this.props.mklab.mkmeta.tasUid !== "undefined"))
            {
                pmsrc = pmhost + '&proUid=' + this.props.mklab.mkmeta.proUid + '&tasUid=' + this.props.mklab.mkmeta.tasUid + '&resourceNodeid=' + this.props.resourceNodeid
            }
        }
      
   
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
