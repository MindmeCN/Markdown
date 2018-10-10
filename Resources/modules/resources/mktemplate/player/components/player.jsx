import React from 'react'
import {connect} from 'react-redux'
import {PropTypes as T} from 'prop-types'
import classes from 'classnames'

import {selectors} from '&/mindmecn/markdown-bundle/resources/mktemplate/store'
import {Mktemplate as MktemplateTypes} from '&/mindmecn/markdown-bundle/resources/mktemplate/prop-types'
import {MkView} from '&/mindmecn/markdown-bundle/resources/mktemplate/player/components/mkview'

const PlayerComponent = props =>
 <div className={classes('mktemplate_content')}>
 <MkView/>
 </div>

PlayerComponent.propTypes = {
  mktemplate: T.shape(MktemplateTypes.propTypes).isRequired
}

const Player = connect(
  state => ({
    mktemplate: selectors.mktemplate(state)
  })
)(PlayerComponent)

export {
  Player
}