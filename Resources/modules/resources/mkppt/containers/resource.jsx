import {withReducer} from '#/main/app/store/components/withReducer'

import {MkpptResource as MkpptResourceComponent} from '&/mindmecn/markdown-bundle/resources/mkppt/components/resource'
import {reducer, selectors} from '&/mindmecn/markdown-bundle/resources/mkppt/store'

const MkpptResource = withReducer(selectors.STORE_NAME, reducer)(MkpptResourceComponent)

export {
  MkpptResource
}
