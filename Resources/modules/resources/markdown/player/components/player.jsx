import React from 'react'
import {connect} from 'react-redux'
import {PropTypes as T} from 'prop-types'
import classes from 'classnames'

import {selectors} from '&/mindmecn/markdown-bundle/resources/markdown/store'
import {Markdown as MarkdownTypes} from '&/mindmecn/markdown-bundle/resources/markdown/prop-types'
import {MkView} from '&/mindmecn/markdown-bundle/resources/markdown/player/components/mkview'

const PlayerComponent = props =>
 <div className={classes('markdown_content')}>
 <MkView/>
 </div>

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