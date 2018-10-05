import React from 'react'

import {Routes} from '#/main/app/router'
import {ResourcePage} from '#/main/core/resource/containers/page'

import {Player} from '#/plugin/markdown/resources/markdown/player/components/player'
import {Editor} from '#/plugin/markdown/resources/markdown/editor/components/editor'

const MarkdownResource = () =>
  <ResourcePage>
    <Routes
      routes={[
        {
          path: '/',
          component: Player,
          exact: true
        }, {
          path: '/edit',
          component: Editor
        }
      ]}
    />
  </ResourcePage>

export {
  MarkdownResource
}
