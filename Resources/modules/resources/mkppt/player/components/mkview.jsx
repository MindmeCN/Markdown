
import React, {Component} from 'react'
import ReactDOM from 'react-dom'
import $ from 'jquery'
import {PropTypes as T} from 'prop-types'
import {connect} from 'react-redux'
import {selectors as resourceSelectors} from '#/main/core/resource/store'

import {Mkppt as MkpptTypes} from '&/mindmecn/markdown-bundle/resources/mkppt/prop-types'

import {selectors} from '&/mindmecn/markdown-bundle/resources/mkppt/store'


class MkViewComponent extends React.Component {
    constructor(props) {
        super(props);
    }

 render() {
        
 let   iframeSrc = '/markdown/mkppt/slide/' + this.props.resourceNodeId + '/0'
  console.log(iframeSrc)
     
    
        return(
                <iframe id ="iframe-markdown-ppt" 
                        name ="iframe-markdown-ppt" 
                        src = { iframeSrc }
                        onLoad={() => {
                        const obj = ReactDOM.findDOMNode(this.refs.iframe);
                        var varIframe = window.frames['iframe-markdown-ppt'];
                      //  varIframe.document.open()
                      //  varIframe.document.write(iframeContent2)
                      //  varIframe.document.close()
                                    }}
                        style={{ position: 'absolute', top: '0', left: '0', width: '100%',  height: '100%'}}
                        marginwidth="0"
                        marginheight="0"
                        ref="iframe" 
                        frameborder="no" 
                        border="0"
                        scrolling="no" 
                        allowtransparency="yes" 
                        />)
    }
}


MkViewComponent.propTypes = {
  mkppt: T.shape(MkpptTypes.propTypes).isRequired
}

const MkView = connect(
        state => ({
       mkppt: selectors.mkppt(state),
       resourceNodeId: resourceSelectors.resourceNode(state).id,
            })
)(MkViewComponent)

export {
MkView
}
