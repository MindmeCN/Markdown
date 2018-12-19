import React from 'react'
import {connect} from 'react-redux'
import {PropTypes as T} from 'prop-types'
import classes from 'classnames'

import {trans} from '#/main/app/intl/translation'
import {LINK_BUTTON} from '#/main/app/buttons'
import {FormData} from '#/main/app/content/form/containers/data'

import {selectors as resourceSelectors} from '#/main/core/resource/store'
import {selectors} from '&/mindmecn/markdown-bundle/resources/mklab/editor/store'
import {Mklab as MklabTypes} from '&/mindmecn/markdown-bundle/resources/mklab/prop-types'
import {MkLabEditor} from '&/mindmecn/markdown-bundle/resources/mklab/editor/components/mklabeditor'
import {MkEdit} from '&/mindmecn/markdown-bundle/resources/mklab/editor/components/mklabeditor'


const EditorComponent = (props) =>
 <div className={classes('mklab_content')}>
           <MkLabEditor/>
  </div>
 
EditorComponent
EditorComponent.propTypes = {
  workspace: T.object,
  mklab: T.shape(
    MklabTypes.propTypes
  ).isRequired
}

const Editor = connect(
  state => ({
    workspace: resourceSelectors.workspace(state)
  })
)(EditorComponent)
EditorComponent
export {
  Editor
}