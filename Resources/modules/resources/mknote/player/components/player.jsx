import React from 'react'
import {connect} from 'react-redux'
import {PropTypes as T} from 'prop-types'
import classes from 'classnames'

import {selectors} from '&/mindmecn/markdown-bundle/resources/mknote/store'
import {Mknote as MknoteTypes} from '&/mindmecn/markdown-bundle/resources/mknote/prop-types'
import {MkView} from '&/mindmecn/markdown-bundle/resources/mknote/player/components/mkview'

const PlayerComponent = props =>
 <div className={classes('mknote_content')}>
 <MkView/>
 </div>

PlayerComponent.propTypes = {
  mknote: T.shape(MknoteTypes.propTypes).isRequired
}

const Player = connect(
  state => ({
    mknote: selectors.mknote(state)
  })
)(PlayerComponent)

export {
  Player
}