import React from 'react'
import {connect} from 'react-redux'
import {PropTypes as T} from 'prop-types'
import classes from 'classnames'

import {selectors} from '&/mindmecn/markdown-bundle/resources/mkppt/store'
import {Mkppt as MkpptTypes} from '&/mindmecn/markdown-bundle/resources/mkppt/prop-types'
import {MkView} from '&/mindmecn/markdown-bundle/resources/mkppt/player/components/mkview'

const PlayerComponent = props =>
 <div className={classes('mkppt_content')}>
 <MkView/>
 </div>

PlayerComponent.propTypes = {
  mkppt: T.shape(MkpptTypes.propTypes).isRequired
}

const Player = connect(
  state => ({
    mkppt: selectors.mkppt(state)
  })
)(PlayerComponent)

export {
  Player
}