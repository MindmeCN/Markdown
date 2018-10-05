import React from 'react'
import {connect} from 'react-redux'
import {PropTypes as T} from 'prop-types'

import {trans} from '#/main/core/translation'
import {LINK_BUTTON} from '#/main/app/buttons'
import {FormData} from '#/main/app/content/form/containers/data'

import {selectors as resourceSelectors} from '#/main/core/resource/store'
import {selectors} from '#/plugin/markdown/resources/markdown/editor/store'
import {Markdown as MarkdownTypes} from '#/plugin/markdown/resources/markdown/prop-types'

const EditorComponent = (props) =>
  <FormData
    name={selectors.FORM_NAME}
    target={['apiv2_resource_markdown_update', {id: props.markdown.id}]}
    buttons={true}
    cancel={{
      type: LINK_BUTTON,
      target: '/',
      exact: true
    }}
    sections={[
      {
        title: trans('general', {}, 'platform'),
        primary: true,
        fields: [
          {
            name: 'content',
            type: 'html',
            label: trans('markdown'),
            hideLabel: true,
            required: true,
            options: {
              workspace: props.workspace,
              minRows: 3
            }
          }
        ]
      }
    ]}
  />

EditorComponent.propTypes = {
  workspace: T.object,
  Markdown: T.shape(
    MarkdownTypes.propTypes
  ).isRequired
}

const Editor = connect(
  state => ({
    workspace: resourceSelectors.workspace(state),
    markdown: selectors.markdown(state)
  })
)(EditorComponent)

export {
  Editor
}