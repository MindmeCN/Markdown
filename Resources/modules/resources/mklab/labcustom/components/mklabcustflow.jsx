import React from 'react'
import {PropTypes as T} from 'prop-types'
import ReactDOM from 'react-dom';
import {connect} from 'react-redux'

import {trans} from '#/main/app/intl/translation'
import {Routes} from '#/main/app/router'
import {currentUser} from '#/main/core/user/current'
import {selectors} from '&/mindmecn/markdown-bundle/resources/mklab/store'
import {Mklab as MklabTypes} from '&/mindmecn/markdown-bundle/resources/mklab/prop-types'




const authenticatedUser = currentUser()
const pmsrc = "https://lms.mindme.com.cn:8000/sysworkflow/en/neoclassic/processes/main";


class MkLabCustFlowComponent extends React.Component{
  constructor(props) {
        super(props);     
    }     


 render() {
     
    
 return (
    
  <div>
 	<iframe src= { pmsrc }
                style={{ position: 'absolute', top: '0', left: '0', width: '100%',  height: '100%'}}        
                ref="iframeFlow" 
                frameborder="no"
                border="0" 
                marginwidth="0" 
                marginheight="0" 
                scrolling="no" 
                allowtransparency="yes"></iframe>
  </div>)
           }
}

MkLabCustFlowComponent.propTypes = {
  mklab: T.shape(MklabTypes.propTypes).isRequired
}

const MkLabCustFlow = connect(
  state => ({
    mklab: selectors.mklab(state)
  })
)(MkLabCustFlowComponent)


export {
  MkLabCustFlow
}
