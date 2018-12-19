import React from 'react'
import {connect} from 'react-redux'
import {PropTypes as T} from 'prop-types'

import {trans} from '#/main/app/intl/translation'
import {LINK_BUTTON} from '#/main/app/buttons'
import {FormData} from '#/main/app/content/form/containers/data'

import {selectors as resourceSelectors} from '#/main/core/resource/store'
import {selectors} from '&/mindmecn/markdown-bundle/resources/mknote/editor/store'
import {Mknote as MknoteTypes} from '&/mindmecn/markdown-bundle/resources/mknote/prop-types'
import {MkEdit} from '&/mindmecn/markdown-bundle/resources/mknote/editor/components/mkedit'


const EditorComponent = (props) =>
 <MkEdit/>
 
 
EditorComponent.propTypes = {
  workspace: T.object,
  mknote: T.shape(
    MknoteTypes.propTypes
  ).isRequired
}

const Editor = connect(
  state => ({
    workspace: resourceSelectors.workspace(state)
  })
)(EditorComponent)

export {
  Editor
}