import React from 'react'
import {PropTypes as T} from 'prop-types'
import ReactDOM from 'react-dom';
import {connect} from 'react-redux'

import {trans} from '#/main/app/intl/translation'
import {Routes} from '#/main/app/router'
import {currentUser} from '#/main/core/user/current'
import {selectors} from '&/mindmecn/markdown-bundle/resources/mklab/store'



const authenticatedUser = currentUser()

const MkLabStudy = props => {
    
 //orcale 12c rac
//let pmsrc = "https://lms.mindme.com.cn:8000/api/1.0/workflow/opencase/OpenCase?username=admin&password=Mdqh@1234!&proUid=3037696395b20718fa65142006042115&tasUid=6758954555b8fc22d9c2170070909502";
//oracle 11g
let pmsrc = "https://lms.mindme.com.cn:8000/api/1.0/workflow/opencase/OpenCase?username=admin&password=Mdqh@1234!&proUid=7891607985b1f6f70cfee36011539329&tasUid=6796493185b1f6f7151a900066572909";
//let pmsrc = "https://lms.mindme.com.cn:8000/gotoprocessmaker.php?user="+authenticatedUser.id;

 return (
    
  <div>
 	<iframe src= { pmsrc } height="700px" width="100%" frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="no" allowtransparency="yes"></iframe>
  </div>)
}

export {
  MkLabStudy
}
