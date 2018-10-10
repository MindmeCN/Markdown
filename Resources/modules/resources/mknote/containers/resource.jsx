import {withReducer} from '#/main/app/store/components/withReducer'

import {MknoteResource as MknoteResourceComponent} from '&/mindmecn/markdown-bundle/resources/mknote/components/resource'
import {reducer, selectors} from '&/mindmecn/markdown-bundle/resources/mknote/store'

const MknoteResource = withReducer(selectors.STORE_NAME, reducer)(MknoteResourceComponent)

export {
  MknoteResource
}
