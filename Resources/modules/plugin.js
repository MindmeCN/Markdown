/* eslint-disable */

import {registry} from '#/main/app/plugins/registry'

registry.add('markdown', {
  resources: {
    'markdown': () => { return import(/* webpackChunkName: "plugin-markdown-markdown-resource" */ '#/plugin/markdown/resources/markdown') }
    }
})
