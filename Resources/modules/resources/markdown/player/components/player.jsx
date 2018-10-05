import React from 'react'
import {connect} from 'react-redux'
import {PropTypes as T} from 'prop-types'

import {HtmlText} from '#/main/core/layout/components/html-text'

import {selectors} from '#/plugin/markdown/resources/markdown/store'
import {Markdown as MarkdownTypes} from '#/plugin/markdown/resources/markdown/prop-types'

const PlayerComponent = props =>
  <HtmlText>
    {props.text.content}
  </HtmlText>

PlayerComponent.propTypes = {
  markdown: T.shape(MarkdownTypes.propTypes).isRequired
}

const Player = connect(
  state => ({
    markdown: selectors.markdown(state)
  })
)(PlayerComponent)

export {
  Player
}