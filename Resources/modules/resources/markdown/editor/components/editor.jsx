import React from 'react'
import {connect} from 'react-redux'
import {PropTypes as T} from 'prop-types'

import {trans} from '#/main/core/translation'
import {LINK_BUTTON} from '#/main/app/buttons'
import {FormData} from '#/main/app/content/form/containers/data'

import {selectors as resourceSelectors} from '#/main/core/resource/store'
import {selectors} from '&/mindmecn/markdown-bundle/resources/markdown/editor/store'
import {Markdown as MarkdownTypes} from '&/mindmecn/markdown-bundle/resources/markdown/prop-types'
import {MkEdit} from '&/mindmecn/markdown-bundle/resources/markdown/editor/components/mkedit'


const EditorComponent = (props) =>
 <MkEdit/>
 
 
EditorComponent.propTypes = {
  workspace: T.object,
  markdown: T.shape(
    MarkdownTypes.propTypes
  ).isRequired
}

const Editor = connect(
  state => ({
    workspace: resourceSelectors.workspace(state)
    //markdown: selectors.markdown(state)
  })
)(EditorComponent)

export {
  Editor
}