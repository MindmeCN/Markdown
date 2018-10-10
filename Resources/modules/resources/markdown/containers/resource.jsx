import {withReducer} from '#/main/app/store/components/withReducer'

import {MarkdownResource as MarkdownResourceComponent} from '&/mindmecn/markdown-bundle/resources/markdown/components/resource'
import {reducer, selectors} from '&/mindmecn/markdown-bundle/resources/markdown/store'

const MarkdownResource = withReducer(selectors.STORE_NAME, reducer)(MarkdownResourceComponent)

export {
  MarkdownResource
}
