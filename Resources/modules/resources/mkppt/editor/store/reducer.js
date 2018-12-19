import {makeReducer} from '#/main/app/store/reducer'
import {makeFormReducer} from '#/main/app/content/form/store/reducer'

import {RESOURCE_LOAD} from '#/main/core/resource/store/actions'

import {selectors} from '&/mindmecn/markdown-bundle/resources/mkppt/editor/store/selectors'


const reducer = {
  mkpptForm: makeFormReducer(selectors.FORM_NAME, {}, {
    data: makeReducer({}, {
      [RESOURCE_LOAD]: (state, action) => action.resourceData.mkppt || state
    }),
    originalData: makeReducer({}, {
      [RESOURCE_LOAD]: (state, action) => action.resourceData.mkppt || state
    })
  })
}

export {
  reducer
}