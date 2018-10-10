import {withReducer} from '#/main/app/store/components/withReducer'

import {MktemplateResource as MktemplateResourceComponent} from '&/mindmecn/markdown-bundle/resources/mktemplate/components/resource'
import {reducer, selectors} from '&/mindmecn/markdown-bundle/resources/mktemplate/store'

const MktemplateResource = withReducer(selectors.STORE_NAME, reducer)(MktemplateResourceComponent)

export {
  MktemplateResource
}
