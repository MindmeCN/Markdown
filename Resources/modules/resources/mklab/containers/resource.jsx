import {withReducer} from '#/main/app/store/components/withReducer'

import {MklabResource as MklabResourceComponent} from '&/mindmecn/markdown-bundle/resources/mklab/components/resource'
import {reducer, selectors} from '&/mindmecn/markdown-bundle/resources/mklab/store'

const MklabResource = withReducer(selectors.STORE_NAME, reducer)(MklabResourceComponent)

export {
  MklabResource
}
