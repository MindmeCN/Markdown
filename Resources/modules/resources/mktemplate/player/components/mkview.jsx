
import React, {Component} from 'react'
        import ReactDOM from 'react-dom';
        import $ from 'jquery'
        import {PropTypes as T} from 'prop-types'
        import {connect} from 'react-redux'
        import { Box } from 'grid-styled'
        import {selectors} from '&/mindmecn/markdown-bundle/resources/mktemplate/store'

 class MkViewComponent extends React.Component{
        constructor(props){
        super(props);
        }

        
    render() {
        return (
                <Box color='tomato'>
                    Hello
                </Box>
                )
    }
}

MkViewComponent.propTypes = {
content: T.string.isRequired
        }

const MkView = connect(
        state => ({
        mktemplate: selectors.mktemplate(state)
        })
        )(MkViewComponent)

        export {
        MkView
                }


