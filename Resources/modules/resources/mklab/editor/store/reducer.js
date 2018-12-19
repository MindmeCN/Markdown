import {makeReducer} from '#/main/app/store/reducer'
import {makeFormReducer} from '#/main/app/content/form/store/reducer'

import {RESOURCE_LOAD} from '#/main/core/resource/store/actions'

import {selectors} from '&/mindmecn/markdown-bundle/resources/mklab/editor/store/selectors'


const reducer = {
  mklabForm: makeFormReducer(selectors.FORM_NAME, {}, {
    data: makeReducer({}, {
      [RESOURCE_LOAD]: (state, action) => action.resourceData.mklab || state
    }),
    originalData: makeReducer({}, {
      [RESOURCE_LOAD]: (state, action) => action.resourceData.mklab || state
    })
  })
}

export {
  reducer
}