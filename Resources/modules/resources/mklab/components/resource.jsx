import React from 'react'

import {Routes} from '#/main/app/router'
import {ResourcePage} from '#/main/core/resource/containers/page'


import {Player} from '&/mindmecn/markdown-bundle/resources/mklab/player/components/player'
import {Editor} from '&/mindmecn/markdown-bundle/resources/markdown/editor/components/editor'

const MklabResource = () =>
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
  MklabResource
}
