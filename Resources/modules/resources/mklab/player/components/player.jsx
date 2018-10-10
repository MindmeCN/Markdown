import React from 'react'
import {connect} from 'react-redux'
import {PropTypes as T} from 'prop-types'
import classes from 'classnames'

import {selectors} from '&/mindmecn/markdown-bundle/resources/mklab/store'
import {Mklab as MklabTypes} from '&/mindmecn/markdown-bundle/resources/mklab/prop-types'
import {MkView} from '&/mindmecn/markdown-bundle/resources/mklab/player/components/mkview'

const PlayerComponent = props =>
 <div className={classes('mklab_content')}>
 <MkView/>
 </div>

PlayerComponent.propTypes = {
  mklab: T.shape(MklabTypes.propTypes).isRequired
}

const Player = connect(
  state => ({
    mklab: selectors.mklab(state)
  })
)(PlayerComponent)

export {
  Player
}