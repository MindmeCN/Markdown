import React from 'react'

import {Routes} from '#/main/app/router'
import {ResourcePage} from '#/main/core/resource/containers/page'


import {Player} from '&/mindmecn/markdown-bundle/resources/mktemplate/player/components/player'
import {Editor} from '&/mindmecn/markdown-bundle/resources/mktemplate/editor/components/editor'

const MktemplateResource = () =>
   <ResourcePage>
    <Routes
      routes={[
        {
          path: '/',
          component: Player,
          exact: true
        }, {
          path: '/edit',
          component: Editor,
          active: true,
        }
      ]}
    />
  </ResourcePage>
  
export {
  MktemplateResource
}
