/* eslint-disable */

import {registry} from '#/main/app/plugins/registry'

registry.add('markdown', {
  resources: {
    'markdown': () => { return import(/* webpackChunkName: "mindmecn-markdown-markdown-resource" */ '&/mindmecn/markdown-bundle/resources/markdown') }
    }
})
